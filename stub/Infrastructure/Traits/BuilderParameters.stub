<?php

namespace App\Infrastructure\Traits;
use Yajra\DataTables\Html\Button;

trait BuilderParameters
{
    /**
     * $buttons
     * @var array
     */
    private $buttons = [];


    /**
     * $custom_buttons
     * @var array
     */
    private $custom_buttons = [];

    /**
     * Get Title Checkbox Html.
     *
     * @return string
     */
    public function getTitleCheckboxHtml() : string
    {
        return '<label class="kt-checkbox kt-checkbox--single kt-checkbox--all kt-checkbox--solid">
                    <input type="checkbox" class="select-all" onclick="select_all()">
                    <span></span>
                </label>';
    }

    /**
     * Get Column Checkbox Html.
     *
     * @return string
     */
    public function getColumnCheckboxHtml() : string
    {
        return '<label class="kt-checkbox kt-checkbox--single kt-checkbox--all kt-checkbox--solid">
                    <input type="checkbox" class="selected_data" name="selected_data[]" value="{{ $id }}">
                    <span></span>
                </label>';
    }

    /**
     * Get "dom" format
     *
     * @return string
     */
    public function getDomFormat() : string
    {
        return "
            <'row'<'col-12 text-right'B>>
            <'row'<'col-4 text-left'l><'col-8 text-right'f>>
            <'row'<'col-12'tr>>
            <'row'<'col-5'i><'col-7 dataTables_pager'p>>";
    }

    // /**
    //  * Get "dom" format
    //  *
    //  * @return string
    //  */
    // public function getDomFormat() : string
    // {
    //     return "<'row'<'col-2'f><'col-2' l><'col-8 text-right'B>>
    //         <'row'<'col-12'tr>>
    //         <'row'<'col-5'i><'col-7 dataTables_pager'p>>";
    // }

    /**
     * getCustomBuilderParameters
     * @param  array   $columns
     * @param $selectColumns describtion
     * Select columns is a multi dimensional array
     * structure
     * [
     *      [
     *          'index_num' => the datatable column number ex: 1,2,3
     *          'selectValues' => [
     *               'key' => 'val' // <option value="'.$key.'">'.$val.'</option>
     *           ],
     *           'serverSide' => [
     *               'serverSideUrl' => route('example.index'), For Filteration In Server Side
     *               'serverSideUrlParam' => 'example_url_param', this parameters you will use in the query ex: where('ex_col', request()->get('example_url_param'))
     *           ]
     *      ]
     * ]
     * @param  array   $selectColumns
     * @param  boolean $enableArabic
     * @param  boolean $enableScrollX
     * @param  string  $enableScrollY
     * @param  boolean $hasDatePicker
     * @return array
     */
    protected function getCustomBuilderParameters(array $columns = [], array $selectColumns = [], bool $enableArabic = false, bool $enableScrollX = false, string $enableScrollY = null, bool $hasDatePicker = false) : array
    {
        $parameters = [
            'dom' => $this->getDomFormat(),
            "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, trans('main.all_records')]],
            'scrollX' => $enableScrollX,
            'initComplete' => "function () { ". $this->getJsStr($columns, $selectColumns, $hasDatePicker) ." }",
        ];

        if (checkVar($enableScrollY)) {
            $parameters['scrollY'] = $enableScrollY;
            $parameters['scrollCollapse'] = true;
        }

        if ($enableArabic) {
            $parameters['language'] = [
                'url' => asset('backend/datatables/arabic.json')
            ];
        }

        return $parameters;
    }


    /**
     * Get Js Str.
     *
     * @param  array  $columns
     * @param  array  $selectColumns
     * @param  bool   $hasDatePicker
     * @return string
     */
    public function getJsStr(array $columns, array $selectColumns, bool $hasDatePicker) : string
    {
        $str = '';
        $str .= $this->getNormalColumns($columns);
        $str .= $this->getSelectColumns($selectColumns);
        return $str;
    }

    /**
     * Get Select Columns.
     *
     * @param  array  $selectColumns
     * @return string
     */
    protected function getSelectColumns(array $selectColumns) : string
    {
        $jqCode = '';
        if (count($selectColumns)) {
            foreach ($selectColumns as $column) {
                if (array_key_exists('index_num', $column) && array_key_exists('selectValues', $column) && is_array($column['selectValues'])) {
                    $options = '<option value="empty">'.trans('main.select').'</option>';
                    foreach ($column['selectValues'] as $key => $val) {
                        $options .= '<option value="'.$key.'">'.$val.'</option>';
                    }
                    $jqCode .= $this->getSelectJqCode($column, $options);
                } else {
                    throw new \Exception("Error In Datatable Trait By Mohamed Zayed :)", 1);
                }
            }
        }
        return $jqCode;
    }

    /**
     * Get Select Jq Code.
     *
     * @param  array  $column
     * @param  string $options
     * @return string
     */
    protected function getSelectJqCode(array $column, string $options) : string
    {
        $bool = array_key_exists('serverSide', $column) ? "'yes'" : "'no'";
        if ($bool == '\'yes\'') {
            $trigger_code = "window.location = '{$column['serverSide']['serverSideUrl']}?{$column['serverSide']['serverSideUrlParam']}='+$(this).val();";
        } else {
            $trigger_code = "";
        }
        return "this.api().columns([".$column['index_num']."]).every(function () {
            var column = this;
            var select = document.createElement(\"select\");
            $(select).attr( 'style', 'width: 100%');
            $(select).attr( 'class', 'form-control');
            $(select).html('".$options."');
            $(select).appendTo($(column.footer()).empty()).on('change', function () {
                if($bool == 'yes'){
                    ".$trigger_code."
                    return;
                }
                if($(this).val() != 'empty'){
                    column.search($(this).val()).draw();
                } else {
                    column.search('').draw();
                }
            });
        });";
    }

    /**
     * Get Normal Columns
     *
     * @param  array  $columns
     * @return string
     */
    protected function getNormalColumns(array $columns) : string
    {
        return "this.api().columns([".implode(', ', $columns)."]).every(function () {
            var column = this;
            var input = document.createElement(\"input\");
            $(input).attr( 'style', 'width: 100%');
            $(input).attr( 'class', 'form-control');
            $(input).appendTo($(column.footer()).empty()).on('keyup', function () {
                column.search($(this).val()).draw();
            });
        });";
    }

    /**
     * Get Buttons.
     *
     * @return array
     */
    protected function getButtons() : array
    {
        $this->buttons = [
            Button::make('export'),
            Button::make('print'),
            Button::make('reload'),
        ];
        return count($this->custom_buttons) ? array_merge($this->custom_buttons, $this->buttons) : $this->buttons;
    }

    /**
     * Add Button.
     *
     * @param Column $button
     * @return $this
     */
    public function addButton(Button $button)
    {
        array_unshift($this->custom_buttons, $button);
        return $this;
    }

    /**
     * Add Buttons.
     *
     * @param array $buttons
     * @return $this
     */
    public function addButtons(array $buttons)
    {
        foreach ($buttons as $button) {
            array_unshift($this->custom_buttons, $button);
        }
        return $this;
    }

    /**
     * Merge Array Keys.
     *
     * @param array $arr : example User::all()->map(function ($item) { return [$item->id => $item->name]; })->toArray() Gives You A Dynamic Select In The Datatable.
     * @return $this
     */
    public function mergeArrayKeys(array $arr) : array
    {
        $return = [];
        foreach ($arr as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $return[$key2] = $value2;
            }
        }
        return $return;
    }

    /**
     * Get decorated data as defined in datatables ajax response.
     *
     * @return array
     */
    protected function getAjaxResponseData()
    {
        $this->request()->merge([]);

        $response = app()->call([$this, 'ajax']);

        $data     = $response->getData(true);

        return $data['data'];
    }
}
