<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\Calendar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CalendarDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'type', 'is_holiday', 'created_at'])
            ->addColumn('action', function ($row) {
                $editUrl = '#edit-' . $row->id;
                $deleteUrl = '#delete-' . $row->id;
                $data = '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editCalendarEvent(\'' . $row->id . '\')" title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm" onclick="deleteCalendarEvent(\'' . $row->id . '\')" title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
                ';
                return $data;
            })
            ->addColumn('date_range', function ($row) {
                $startDate = Carbon::parse($row->start_date)->translatedFormat('d M Y');
                $endDate = $row->end_date ? Carbon::parse($row->end_date)->translatedFormat('d M Y') : $startDate;
                return $startDate . ' - ' . $endDate;
            })
            ->addColumn('type', function ($row) {
                $typeMap = [
                    'event' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200"><i class="ti ti-calendar-event mr-2"></i>Event</span>',
                    'holiday' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200"><i class="ti ti-holiday mr-2"></i>Libur</span>',
                    'note' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200"><i class="ti ti-note mr-2"></i>Catatan</span>',
                ];
                return $typeMap[$row->type] ?? $row->type;
            })
            ->addColumn('is_holiday', function ($row) {
                return $row->is_holiday
                    ? '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200"><i class="ti ti-circle-check mr-2"></i>Ya</span>'
                    : '<span style="white-space: nowrap;" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200"><i class="ti ti-circle-x mr-2"></i>Tidak</span>';
            })
            ->addColumn('created_at', function ($row) {
                Carbon::setLocale('id');
                return Carbon::parse($row->created_at)->translatedFormat('d F Y');
            })

            // ✅ Kolom yang bisa diurut
            ->orderColumn('title', function ($query, $direction) {
                $query->orderBy('title', $direction);
            })
            ->orderColumn('type', function ($query, $direction) {
                $query->orderBy('type', $direction);
            })
            ->orderColumn('start_date', function ($query, $direction) {
                $query->orderBy('start_date', $direction);
            })
            ->orderColumn('is_holiday', function ($query, $direction) {
                $query->orderBy('is_holiday', $direction);
            })
            ->orderColumn('created_at', function ($query, $direction) {
                $query->orderBy('created_at', $direction);
            })

            // filterable
            ->filterColumn('title', function ($query, $keyword) {
                $query->where('title', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('type', function ($query, $keyword) {
                if ($keyword !== '') {
                    $query->where('type', $keyword);
                }
            })
            ->filterColumn('is_holiday', function ($query, $keyword) {
                if ($keyword !== '') {
                    $isHoliday = strtolower($keyword) === 'true' ? true : (strtolower($keyword) === 'false' ? false : null);
                    if ($isHoliday !== null) {
                        $query->where('is_holiday', $isHoliday);
                    }
                }
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                if ($keyword) {
                    $query->whereDate('created_at', 'ILIKE', "%{$keyword}%");
                }
            })

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Calendar $model): QueryBuilder
    {
        return $model->newQuery()->with('scopes');
    }

    /**
     * Optional method if you want to use the html builder.
     */
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

    private function getTypeOptions()
    {
        $options = [
            ['label' => 'Filter Semua', 'value' => '']
        ];
        $typeMap = [
            'event' => 'Event',
            'holiday' => 'Hari Libur',
            'note' => 'Catatan',
        ];
        foreach ($typeMap as $value => $label) {
            $options[] = ['label' => $label, 'value' => $value];
        }
        return json_encode($options);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $json = json_encode([
            ['label' => 'Filter Semua', 'value' => ''],
            ['label' => 'Ya', 'value' => 'true'],
            ['label' => 'Tidak', 'value' => 'false'],
        ]);
        $column[] = Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center')->attributes(['data-type' => 'select', 'data-name' => 'action', 'data-label' => 'Action', 'data-value' => GlobalConfigDatatable::lines()]);
        $column[] = Column::make('title')->name('title')->title('Judul Event')->attributes(['data-type' => 'text', 'data-name' => 'title', 'data-label' => 'Judul Event', 'data-value' => null]);
        $column[] = Column::make('date_range')->name('start_date')->title('Rentang Tanggal')->attributes(['data-type' => 'date', 'data-name' => 'date_range', 'data-label' => 'Rentang Tanggal', 'data-value' => null]);
        $column[] = Column::make('type')->name('type')->title('Tipe Event')->attributes(['data-type' => 'select', 'data-name' => 'type', 'data-label' => 'Tipe Event', 'data-value' => $this->getTypeOptions()]);
        $column[] = Column::make('is_holiday')->name('is_holiday')->title('Hari Libur')->attributes(['data-type' => 'select', 'data-name' => 'is_holiday', 'data-label' => 'Hari Libur', 'data-value' => $json]);
        $column[] = Column::make('created_at')->name('created_at')->title('Dibuat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Dibuat']);
        return $column;
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Calendars_' . date('YmdHis');
    }
}
