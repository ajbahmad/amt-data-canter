<?php

namespace App\DataTables;

use App\DataTables\Config\GlobalConfigDatatable;
use App\Models\IdCard;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class IdCardDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'person_name', 'status', 'created_at'])
            ->addColumn('action', function ($row) {
                $showUrl = route('id_cards.show', $row->id);
                $editUrl = route('id_cards.edit', $row->id);
                $deleteUrl = route('id_cards.destroy', $row->id);
                $data = '
                <div class="flex justify-center items-center gap-2">
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white p-0 btn-sm" onclick="window.location.href = \''.$showUrl.'\'" title="Lihat"><i class="ti ti-eye"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white border border-warning text-warning hover:bg-warning hover:text-white p-0 btn-sm" onclick="editData(\''.$row->id.'\', \''.$editUrl.'\')" title="Edit"><i class="ti ti-edit"></i></button>
                    <button class="btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm" onclick="deleteData(\''.$row->id.'\', \''.$deleteUrl.'\')" title="Hapus"><i class="ti ti-trash"></i></button>
                </div>
                ';
                return $data;
            })
            ->addColumn('person_name', function($row){
                if ($row->person->photo) {
                    $urlPhoto = '<img src="'.asset('storage/'.$row->person->photo).'" alt="'.$row->person->full_name.'" class="w-10 h-10 rounded-full object-cover">';
                } else {
                    $urlPhoto = '<img src="https://ui-avatars.com/api/?name='.urlencode($row->person->full_name).'" alt="'.$row->person->full_name.'" class="w-10 h-10 rounded-full object-cover">';
                }
                return '
                <div class="flex items-center gap-2">
                    '.$urlPhoto.'
                    <div>
                        <div class="font-medium text-gray-900">'. $row->person->full_name .'</div>
                        <div class="text-sm text-gray-500">'. $row->person->email .'</div>
                    </div>
                </div>
                ';
            })
            ->addColumn('status', function($row){
                $statusMap = [
                    'active' => ['label' => 'Aktif', 'color' => 'green'],
                    'lost' => ['label' => 'Hilang', 'color' => 'red'],
                    'blocked' => ['label' => 'Diblokir', 'color' => 'yellow'],
                    'expired' => ['label' => 'Expired', 'color' => 'gray'],
                ];
                $data = $statusMap[$row->status] ?? ['label' => $row->status, 'color' => 'gray'];
                $colorMap = [
                    'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                    'red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                    'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                    'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200',
                ];
                return '<span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold ' . $colorMap[$data['color']] . '">
                    <i class="ti ti-circle-check mr-2"></i>' . $data['label'] . '
                </span>';
            })
            ->addColumn('issued_at_formatted', function ($row) {
                return $row->issued_at ? $row->issued_at->format('d/m/Y') : '-';
            })
            ->addColumn('expired_at_formatted', function ($row) {
                return $row->expired_at ? $row->expired_at->format('d/m/Y') : '-';
            })
            ->addColumn('created_at', function ($row) {
                Carbon::setLocale('id');
                return Carbon::parse($row->created_at)->translatedFormat('d F Y');
            })

            // ✅ Kolom yang bisa diurut
            ->orderColumn('card_uid', function($query, $direction) {
                $query->orderBy('card_uid', $direction);
            })
            ->orderColumn('person_name', function($query, $direction) {
                $query->orderBy('person_id', $direction);
            })
            ->orderColumn('status', function($query, $direction) {
                $query->orderBy('status', $direction);
            })
            ->orderColumn('issued_at_formatted', function($query, $direction) {
                $query->orderBy('issued_at', $direction);
            })
            ->orderColumn('expired_at_formatted', function($query, $direction) {
                $query->orderBy('expired_at', $direction);
            })
            ->orderColumn('created_at', function($query, $direction) {
                $query->orderBy('created_at', $direction);
            })

            // filterable
            ->filterColumn('card_uid', function($query, $keyword) {
                $query->where('card_uid', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('card_number', function($query, $keyword) {
                $query->where('card_number', 'ILIKE', "%{$keyword}%");
            })
            ->filterColumn('person_name', function($query, $keyword) {
                $query->whereHas('person', function($q) use ($keyword) {
                    $q->where('full_name', 'ILIKE', "%{$keyword}%");
                });
            })
            ->filterColumn('status', function($query, $keyword) {
                if ($keyword !== '') {
                    $query->where('status', $keyword);
                }
            })
            ->filterColumn('created_at', function($query, $keyword){
                if ($keyword) {
                    $query->whereDate('created_at', 'ILIKE', "%{$keyword}%");
                }
            })
            
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(IdCard $model): QueryBuilder
    {
        return $model->newQuery()->with('person');
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

    private function getStatusOptions()
    {
        return json_encode([
            ['label'=>'Filter Semua', 'value' => ''],
            ['label'=>'Aktif', 'value' => 'active'],
            ['label'=>'Hilang', 'value' => 'lost'],
            ['label'=>'Diblokir', 'value' => 'blocked'],
            ['label'=>'Expired', 'value' => 'expired'],
        ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $column[] = Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')->attributes(['data-type' => 'select', 'data-name' => 'action', 'data-label' => 'Action', 'data-value' => GlobalConfigDatatable::lines()]);
        $column[] = Column::make('person_name')->name('person_name')->title('Person')->attributes(['data-type' => 'text', 'data-name' => 'person_name', 'data-label' => 'Person', 'data-value' => null]);
        $column[] = Column::make('card_uid')->name('card_uid')->title('UID Kartu')->attributes(['data-type' => 'text', 'data-name' => 'card_uid', 'data-label' => 'UID Kartu', 'data-value' => null]);
        $column[] = Column::make('card_number')->name('card_number')->title('Nomor Kartu')->attributes(['data-type' => 'text', 'data-name' => 'card_number', 'data-label' => 'Nomor Kartu', 'data-value' => null]);
        $column[] = Column::make('status')->name('status')->title('Status')->attributes(['data-type' => 'select', 'data-name' => 'status', 'data-label' => 'Status', 'data-value' => $this->getStatusOptions()]);
        $column[] = Column::make('issued_at_formatted')->name('issued_at_formatted')->title('Tgl Keluaran')->searchable(false)->attributes(['data-type' => 'date', 'data-name' => 'issued_at_formatted', 'data-label' => 'Tgl Keluaran']);
        $column[] = Column::make('expired_at_formatted')->name('expired_at_formatted')->title('Tgl Expired')->searchable(false)->attributes(['data-type' => 'date', 'data-name' => 'expired_at_formatted', 'data-label' => 'Tgl Expired']);
        $column[] = Column::make('created_at')->name('created_at')->title('Dibuat')->attributes(['data-type' => 'date', 'data-name' => 'created_at', 'data-label' => 'Dibuat']);
        return $column;
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'IdCards_' . date('YmdHis');
    }
}
