<?php

namespace App\DataTables;

use App\Models\Broker;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BrokerDataTable extends DataTable
{
    /**
     * Fields the global search box should match against, beyond what's visible in the table.
     */
    protected array $searchableFields = [
        'company_name',
        'dispatcher_name',
        'mc_number',
        'dot_number',
        'name',
        'email',
        'phone',
        'city',
        'state',
        'zip_code',
        'status',
    ];

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Broker> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('city_state', function (Broker $broker) {
                return trim($broker->city . ', ' . $broker->state, ', ');
            })
            ->addColumn('status', function (Broker $broker) {
                $colors = [
                    'active' => 'primary',
                    'inactive' => 'secondary',
                    'pending' => 'warning',
                    'blacklisted' => 'danger',
                ];
                $color = $colors[$broker->status] ?? 'secondary';

                return "<span class='badge badge-{$color}'>" . ucfirst($broker->status) . '</span>';
            })
            ->addColumn('action', function (Broker $broker) {
                $view = '<a href="#"
                data-url="' . route('admin.brokers.show', $broker->id) . '"
                class="view-item btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </a>';
                $edit = '<a href="' . route('admin.brokers.edit', $broker->id) . '" class="btn btn-sm btn-primary ml-2"><i class="fas fa-edit"></i></a>';
                $delete = '<a href="#"
                data-url="' . route('admin.brokers.destroy', $broker->id) . '"
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
     * @return QueryBuilder<Broker>
     */
    public function query(Broker $model): QueryBuilder
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
                    ->setTableId('brokers-table')
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
            Column::make('company_name'),
            Column::make('mc_number'),
            Column::make('name')->title('Contact Name'),
            Column::make('phone'),
            Column::make('email'),
            Column::computed('city_state')->title('City/State'),
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
        return 'Broker_' . date('YmdHis');
    }
}
