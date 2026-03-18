<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'scope', 'is_active', 'created_at'])
            ->addColumn('application_id', function ($row) {
                return $row->application ? $row->application->name : '-';
            })
            ->addColumn('scope', function($row){
                $scopeLabels = [
                    'global' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800"><i class="ti ti-world mr-2"></i>Global</span>',
                    'institution' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800"><i class="ti ti-building mr-2"></i>Institution</span>',
                    'school' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800"><i class="ti ti-school mr-2"></i>School</span>',
                ];
                return $scopeLabels[$row->scope] ?? '-';
            })
            ->addColumn('is_active', function($row){
                return $row->is_active ? '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="ti ti-circle-check mr-2"></i>Aktif
                        </span>' : '<span style="white-space: nowrap;" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                            <i class="ti ti-circle-x mr-2"></i>Non Aktif
                        </span>';
            })
            ->addColumn('created_at', function ($row) {
                Carbon::setLocale('id');
                return Carbon::parse($row->created_at)->translatedFormat('d F Y');
            })
            ->addColumn('action', function ($row) {
                $showUrl = route('roles.show', $row->id);
                $editUrl = route('roles.edit', $row->id);
                return '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-info text-info hover:bg-info hover:text-white p-0 btn-sm" onclick="window.location.href=\''.$showUrl.'\'" title="Lihat"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                </div>
                ';
            })
            
            // Sortable columns
            ->orderColumn('application_id', function($query, $direction) {
                $query->orderBy('application_id', $direction);
            })
            ->orderColumn('name', function($query, $direction) {
                $query->orderBy('name', $direction);
            })
            ->orderColumn('slug', function($query, $direction) {
                $query->orderBy('slug', $direction);
            })
            ->orderColumn('scope', function($query, $direction) {
                $query->orderBy('scope', $direction);
            })
            ->orderColumn('is_active', function($query, $direction) {
                $query->orderBy('is_active', $direction);
            })
            ->orderColumn('created_at', function($query, $direction) {
                $query->orderBy('created_at', $direction);
            })
            
            // Filterable columns
            ->filterColumn('application_id', function($query, $keyword) {
                $query->where('application_id', $keyword);
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('slug', function($query, $keyword) {
                $query->where('slug', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('scope', function($query, $keyword) {
                if ($keyword) {
                    $query->where('scope', $keyword);
                }
            })
            ->filterColumn('is_active', function($query, $keyword) {
                if ($keyword !== '') {
                    $isActive = strtolower($keyword) === 'true' ? true : (strtolower($keyword) === 'false' ? false : null);
                    if ($isActive !== null) {
                        $query->where('is_active', $isActive);
                    }
                }
            });
    }

    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery()->with('application');
    }

    public function html(): HtmlBuilder
    {
        $getColumns = $this->getColumns();
        $parameters = GlobalConfigDatatable::parameters($getColumns);
        return $this->builder()
            ->setTableId('datatable')
            ->columns($getColumns)
            ->minifiedAjax()
            ->ajax([
                'type' => 'GET',
                'beforeSend' => 'function() { $("#loading").removeClass("hide"); }',
                'complete' => GlobalConfigDatatable::getInitColumnSearchScript($getColumns)
            ])
            ->dom(GlobalConfigDatatable::dom())
            ->orderBy(count($getColumns) - 1, 'desc')
            ->parameters($parameters);
    }

    private function getApplicationOptions()
    {
        $applications = \App\Models\Application::orderBy('name')->get();
        $options = [['label' => 'Filter Semua', 'value' => '']];
        foreach ($applications as $app) {
            $options[] = ['label' => $app->name, 'value' => $app->id];
        }
        return json_encode($options);
    }

    public function getColumns(): array
    {
        $json = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Aktif', 'value' => 'true'],
            ['label'=>'Non Aktif', 'value' => 'false'],
        ]);
        $scopes = json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Global', 'value' => 'global'],
            ['label'=>'Institution', 'value' => 'institution'],
            ['label'=>'School', 'value' => 'school'],
        ]);
        $column[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->attributes(['data-type' => 'select', 'data-name' => 'action', 'data-label' => 'Action', 'data-value' => GlobalConfigDatatable::lines()]);
        $column[] = Column::make('name')->name('name')->title('Nama Role')->attributes(['data-type' => 'text', 'data-name' => 'name', 'data-label' => 'Nama Role', 'data-value' => null]);
        $column[] = Column::make('slug')->name('slug')->title('Slug')->attributes(['data-type' => 'text', 'data-name' => 'slug', 'data-label' => 'Slug', 'data-value' => null]);
        $column[] = Column::make('application_id')->name('application_id')->title('Aplikasi')->attributes(['data-type' => 'select', 'data-name' => 'application_id', 'data-label' => 'Aplikasi', 'data-value' => $this->getApplicationOptions()]);
        $column[] = Column::make('scope')->name('scope')->title('Scope')->attributes(['data-type' => 'select', 'data-name' => 'scope', 'data-label' => 'Scope', 'data-value' => $scopes]);
        $column[] = Column::make('is_active')->name('is_active')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'is_active', 'data-label' => 'Status', 'data-value' => $json]);
        $column[] = Column::make('created_at')->name('created_at')->title('Dibuat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Dibuat']);
        return $column;
    }

    protected function filename(): string
    {
        return 'roles_' . date('Y-m-d_H-i-s');
    }
}
