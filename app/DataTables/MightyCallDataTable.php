<?php

namespace App\DataTables;

use App\Models\MightyCall;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MightyCallDataTable extends DataTable
{
    /**
     * Fields the global search box should match against.
     */
    protected array $searchableFields = [
        'caller_name',
        'caller_phone',
        'caller_extension',
        'called_name',
        'called_phone',
        'business_number',
    ];

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<MightyCall> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('received_at', function (MightyCall $call) {
                return optional($call->call_started_at ?? $call->created_at)
                    ->copy()
                    ->timezone('America/Chicago')
                    ->format('d M Y, h:i A');
            })
            ->addColumn('direction', function (MightyCall $call) {
                $color = $call->direction === 'Incoming' ? 'info' : 'secondary';

                return "<span class='badge badge-{$color}'>" . e($call->direction ?? '-') . '</span>';
            })
            ->addColumn('caller', function (MightyCall $call) {
                $name = e($call->caller_name ?: ($call->caller_phone ?: '-'));
                $extension = $call->caller_extension
                    ? '<br><small class="text-muted">Ext. ' . e($call->caller_extension) . '</small>'
                    : '';

                return $name . $extension;
            })
            ->addColumn('called', function (MightyCall $call) {
                $name = e($call->called_name ?? $call->called_phone ?? '-');
                $phone = ($call->called_phone && $call->called_phone !== $call->called_name)
                    ? '<br><small class="text-muted">' . e($call->called_phone) . '</small>'
                    : '';

                return $name . $phone;
            })
            ->addColumn('duration', function (MightyCall $call) {
                if (! $call->duration_ms) {
                    return '-';
                }

                $seconds = (int) round($call->duration_ms / 1000);

                return sprintf('%02d:%02d', intdiv($seconds, 60), $seconds % 60);
            })
            ->addColumn('call_status', function (MightyCall $call) {
                $colors = [
                    'Connected' => 'success',
                    'Missed' => 'danger',
                    'VoiceMail' => 'info',
                    'Dropped' => 'warning',
                ];
                $color = $colors[$call->call_status] ?? 'secondary';

                return "<span class='badge badge-{$color}'>" . e($call->call_status ?? '-') . '</span>';
            })
            ->addColumn('recording', function (MightyCall $call) {
                if (! $call->recording_url) {
                    return '<span class="text-muted">No recording</span>';
                }

                return '<a href="#" class="btn btn-sm btn-primary play-recording" data-url="' . e($call->recording_url) . '">
                    <i class="fas fa-play"></i> Play
                </a>';
            })
            ->addColumn('summary', function (MightyCall $call) {
                $eligible = $call->recording_url && $call->duration_ms && $call->duration_ms >= 60000;

                if (! $eligible) {
                    return '<span class="text-muted">-</span>';
                }

                return '<a href="#" class="btn btn-sm btn-outline-primary view-summary" data-call-id="' . e($call->mightycall_call_id) . '">
                    <i class="fas fa-robot"></i> AI Summary
                </a>';
            })
            ->orderColumn('received_at', 'call_started_at $1')
            ->orderColumn('duration', 'duration_ms $1')

            
            ->filter(function (QueryBuilder $query) {
                $search = request()->input('search.value');

                if (! empty($search)) {
                    $query->where(function ($q) use ($search) {
                        foreach ($this->searchableFields as $field) {
                            $q->orWhere($field, 'like', "%{$search}%");
                        }
                    });
                }
            })
            ->rawColumns(['direction', 'caller', 'called', 'call_status', 'recording', 'summary'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<MightyCall>
     */
    public function query(MightyCall $model): QueryBuilder
    {
        return $model->newQuery()
            ->orderByDesc('call_started_at')
            ->when(request()->filled('direction'), function (QueryBuilder $query) {
                $query->where('direction', request()->input('direction'));
            })
            ->when(request()->filled('agent'), function (QueryBuilder $query) {
                $query->where('agent_extension', request()->input('agent'));
            })
            ->when(request()->filled('date_from'), function (QueryBuilder $query) {
                $query->where('call_started_at', '>=', Carbon::parse(request()->input('date_from'), 'America/Chicago')->startOfDay()->utc());
            })
            ->when(request()->filled('date_to'), function (QueryBuilder $query) {
                $query->where('call_started_at', '<=', Carbon::parse(request()->input('date_to'), 'America/Chicago')->endOfDay()->utc());
            })
            ->when(request()->filled('duration'), function (QueryBuilder $query) {
                $query->where('duration_ms', '>=', (int) request()->input('duration') * 1000);
            });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('mighty-calls-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('received_at')->title('Received')->orderable(true),
            Column::computed('direction')->title('Direction'),
            Column::computed('caller')->title('Caller'),
            Column::computed('called')->title('Called'),
            Column::computed('duration')->title('Duration')->orderable(true),
            Column::computed('call_status')->title('Status'),
            Column::computed('recording')->title('Recording'),
            Column::computed('summary')->title('AI Summary'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'MightyCalls_' . date('YmdHis');
    }
}
