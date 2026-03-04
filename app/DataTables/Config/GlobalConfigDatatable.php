<?php
namespace App\DataTables\Config;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GlobalConfigDatatable
{
    static function dom()
    {
        return '<"top"B><"table-responsive"t><"grid mt-3 grid-cols-12"<"col-span-12 lg:col-span-6 xl:col-span-6"p><"col-span-12 lg:justify-end lg:mt-5 flex items-center lg:col-span-6 xl:col-span-6"i>>';
    }

    static function lines(){
        return json_encode([
            ['label' => '10 Lines', 'value' => 10],
            ['label' => '25 Lines', 'value' => 25],
            ['label' => '50 Lines', 'value' => 50],
            ['label' => '100 Lines', 'value' => 100],
            ['label' => '250 Lines', 'value' => 250],
            ['label' => '500 Lines', 'value' => 500],
        ]);
    }

    static function getByDb($table, $lable, $value){
        $data = $table->newQuery()->get();
        $result[] = [
            'label' => 'Filter Semua',
            'value' => '',
        ];
        foreach ($data as $item) {
            $result[] = [
                'label' => $item->$lable,
                'value' => $item->$value,
            ];
        }
        return json_encode($result);
    }

    static function boolvalue(){
        return json_encode([
            ['label' => 'Filter Semua', 'value' => ''],
            ['label' => 'Inactive', 'value' => 0],
            ['label' => 'Active', 'value' => 1],
        ]);
    }

    static function parameters($params)
    {
        $columns = [];
        foreach ($params as $key => $column) {
            if ($key != 0) {
                $columns[] = $key;
            }
        }

        $dataButtons = [
            'copy'  => ['icon'  => 'fa fa-copy','color' => 'primary'],
            'print' => ['icon'  => 'fa fa-print','color' => 'warning'],
            'excel' => ['icon'  => 'fa fa-file-excel','color' => 'success'],
            'pdf'   => ['icon'  => 'fa fa-file-pdf','color' => 'danger']
        ];
        
        $buttons = [];
        
        // Membuat child buttons untuk dropdown
        foreach ($dataButtons as $key => $icon) {
            $buttons[] = [
                'extend' => $key,
                'text' => '<i class="' . $icon['icon'] . '"></i> ' . ucfirst($key),
                'className' => 'btn mt-2 btn-rounded btn-' . $icon['color'] . '-soft mr-2',
                'exportOptions' => ['columns' => $columns]
            ];
        }
        
        
        return [
            'buttons' => $buttons,
            'searching' => true,
            'lengthChange' => true,
            'info' => true,

            'language' => [
                'paginate' => [
                    'next' => '<i class="ti ti-arrow-right"></i>',
                    'previous' => '<i class="ti ti-arrow-left"></i>',
                    'first' => '<i class="ti ti-chevrons-left"></i>',
                    'last' => '<i class="ti ti-chevrons-right"></i>',
                ]
            ],
        ];
    }

    static function formatCreatedAt($createdAt){
        Carbon::setLocale('id');
        // return Carbon::parse($createdAt)->translatedFormat('Y/m/d H:i:s');
        return Carbon::parse($createdAt)->translatedFormat('d F Y');
    }

    static function getInitColumnSearchScript($columns)
    {
        $columnMap = [];
        foreach ($columns as $key => $value) {
            $columnMap[$key] = $value->getAttributes()['attributes'];
        }

        $columnMapJson = json_encode($columnMap);
        return 'function() { 
            $("#loading").addClass("hide");
            var columnMap = ' . $columnMapJson . ';
            var table = $("#datatable");
                        
            if (table.find("thead .filters").length > 0) {
                return;
            }
            
            table.find("thead tr:first").clone(true).addClass("filters").appendTo("table thead");
            
            table.find("thead .filters th").each(function(i) {
                var filedTitle = columnMap[i][\'data-label\'];
                var fieldName = columnMap[i][\'data-name\'];
                var fieldType = columnMap[i][\'data-type\'];
                
                if (fieldType == "select") {
                    if (fieldName == "action") {
                        var selectHtml = "<div class=\'flex\'><button class=\'btn btn-rounded w-8 h-8 bg-white text-error border border-error hover:bg-error hover:text-white p-0 btn-sm px-2 me-1 btn-reset hidden\'> <i class=\'ti ti-x\'></i> </button>";
                        selectHtml += "<select data-name=\'" + fieldName + "\' class=\'form-control filter-pagination px-2 py-1 form-control-sm\'>";
                    } else {
                        var selectHtml = "<select data-name=\'" + fieldName + "\' class=\'form-control filter-select px-2 py-1 form-control-sm\'>";
                    }

                    $.each(JSON.parse(columnMap[i][\'data-value\']), function(index, option) {
                        selectHtml += "<option value=\'" + option[\'value\'] + "\'>" + option[\'label\'] + "</option>";
                    });

                    if (fieldName == "action") {
                        selectHtml += "</select></div>";
                    } else {
                        selectHtml += "</select>";
                    }
                    $(this).html(selectHtml);

                    
                    return;
                } else if(fieldType == "date") {
                    $(this).html("<input type=\'date\' data-name=\'" + fieldName + "\' placeholder=\'Cari " + filedTitle + "\' class=\'form-control filter-date px-2 py-1 form-control-sm\' />");
                } else {
                    $(this).html("<input type=\'text\' data-name=\'" + fieldName + "\' placeholder=\'Cari " + filedTitle + "\' class=\'form-control filter-text px-2 py-1 form-control-sm\' />");
                }
            });
            
            table.find("thead .filters").on("click", function(e) {
                e.stopPropagation();
                return false;
            });
            
            table.find("thead").on("keyup change", ".filters input", function(e) {
                e.stopPropagation();
                if (e.key === "Enter") {
                    checkIfAnyFilterFilled();
                    var colIdx = $(this).parent().index();
                    table.DataTable().column(colIdx).search($(this).val()).draw();
                }
            });

            $(".filter-select").change(function() {
                checkIfAnyFilterFilled();
                var colIdx = $(this).parent().index();
                table.DataTable().column(colIdx).search($(this).val()).draw();
            });

            $(".filter-pagination").change(function() {
                table.DataTable().page.len($(this).val()).draw();
            });
            
            function checkIfAnyFilterFilled() {
                var hasFilter = false;
                table.find("thead .filters input, thead .filters select").each(function() {
                    if ($(this).val() && $(this).val() !== "" && $(this).attr("data-name") !== "action") {
                        hasFilter = true;
                        return false;
                    }
                });
                
                if (hasFilter) {
                    table.find("thead .filters .btn-reset").removeClass("hidden");
                } else {
                    table.find("thead .filters .btn-reset").addClass("hidden");
                }
            }
            
            table.find("thead .filters").on("click", ".btn-reset", function() {
                table.find("thead .filters input, thead .filters select").each(function() {
                    if ($(this).attr("data-name") !== "action") {
                        $(this).val("").change();
                    }
                });
                table.DataTable().search("").columns().search("").draw();
                checkIfAnyFilterFilled();
                return false;
            });
        }';
    }

}