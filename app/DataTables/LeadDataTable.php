<?php

namespace App\DataTables;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LeadDataTable extends DataTable
{
    /**
     * Fields the global search box should match against.
     */
    protected array $searchableFields = [
        'sender_name',
        'sender_phone',
        'group_name',
        'message',
    ];

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Lead> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('received_at', function (Lead $lead) {
                return optional($lead->sent_at ?? $lead->created_at)
                    ->copy()
                    ->timezone('Asia/Karachi')
                    ->format('d M Y, h:i A');
            })
            ->addColumn('sender', function (Lead $lead) {
                $name = e($lead->sender_name ?? '-');
                $phone = $lead->sender_phone
                    ? '<br><small class="text-muted">' . e($lead->sender_phone) . '</small>'
                    : '';

                return $name . $phone;
            })
            ->editColumn('group_name', fn (Lead $lead) => e($lead->group_name ?? '-'))
            ->editColumn('message', function (Lead $lead) {
                $limit = 80;

                if (mb_strlen($lead->message) <= $limit) {
                    return e($lead->message);
                }

                $short = e(Str::limit($lead->message, $limit));

                return $short . ' <a href="#" class="read-more-message" data-message="' . e($lead->message) . '">Read more</a>';
            })
            ->orderColumn('received_at', 'sent_at $1')
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
            ->rawColumns(['sender', 'message'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Lead>
     */
    public function query(Lead $model): QueryBuilder
    {
        return $model->newQuery()->orderByDesc('sent_at');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('leads-table')
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
            Column::computed('sender')->title('Sender'),
            Column::make('group_name')->title('Group'),
            Column::make('message'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Leads_' . date('YmdHis');
    }
}
