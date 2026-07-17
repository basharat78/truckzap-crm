<?php

namespace App\DataTables;

use App\Models\HR;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HRDataTable extends DataTable
{
    /**
     * Fields the global search box should match against, beyond what's visible in the table.
     */
    protected array $searchableFields = [
        'candidate_name',
        'phone',
        'email',
        'position',
        'department',
        'interviewer',
        'city',
        'recommendation',
        'status',
    ];

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<HR> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('status', function (HR $hr) {
                $colors = [
                    'pending' => 'warning',
                    'selected' => 'success',
                    'rejected' => 'danger',
                    'on_hold' => 'secondary',
                ];
                $color = $colors[$hr->status] ?? 'secondary';

                return "<span class='badge badge-{$color}'>" . ucwords(str_replace('_', ' ', $hr->status)) . '</span>';
            })
            ->addColumn('action', function (HR $hr) {
                $view = '<a href="#"
                data-url="' . route('admin.hr.show', $hr->id) . '"
                class="view-item btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </a>';
                $edit = '<a href="' . route('admin.hr.edit', $hr->id) . '" class="btn btn-sm btn-primary ml-2"><i class="fas fa-edit"></i></a>';
                $delete = '<a href="#"
                data-url="' . route('admin.hr.destroy', $hr->id) . '"
                class="delete-item btn btn-sm btn-danger ml-2">
                <i class="fas fa-trash"></i>
            </a>';

                return $view . $edit . $delete;
            })
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
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<HR>
     */
    public function query(HR $model): QueryBuilder
    {
        return $model->newQuery()
            ->when(request()->filled('status'), function ($query) {
                $query->where('status', request()->input('status'));
            });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('hr-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload'),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('candidate_name')->title('Candidate Name'),
            Column::make('position'),
            Column::make('department'),
            Column::make('interviewer'),
            Column::make('interview_date')->title('Interview Date'),
            Column::make('total_score')->title('Total Score'),
            Column::computed('status'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(140)
                ->addClass('text-center text-nowrap'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'HR_' . date('YmdHis');
    }
}
