<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class DatatableSSP {
    /**
     * Global container variables for chained argument results
     */
    private $ci;
    private $select;
    private $where;
    private $order;
    private $default_order;
    private $limit;
    private $columns = array();
    private $not_columns = array();
    private $tableid;
    private $tableclass;
    private $multisearch;
    private $headers = array();
    /**
     * Copies an instance of CI
     */
    public function __construct() {
        $this->ci =& get_instance();
    }
    /**
     * If you establish multiple databases in config/database.php this will allow you to
     * set the database (other than $active_group) - more info: http://ellislab.com/forums/viewthread/145901/#712942
     */
    public function database($dbname) {
        $dbdata = $this->ci->load->database($dbname, TRUE);
        $this->ci->db = $dbdata;
    }
    /**
     * Set columns to show
     *
     * @param string or array $columns
     * @return $this
     */
    public function columns($columns) {
        foreach(is_array($columns) ? $columns : $this->explode(',', $columns) as $key => $value) {
            $column = trim(preg_replace('/(.*)\s+as\s+(\w*)/i', '$2', $value));
            $column = preg_replace('/.*\.(.*)/i', '$1', $column); // get name after `.`
            $this->columns[$key] =  $column;
        }
        return $this;
    }
    /**
     * Set basic query
     *
     * @param string $query
     * @return $this
     */
    public function querystring($query) {
        $this->select = $query;
        return $this;
    }
    /**
     * Sets additional column variables for adding custom columns
     *
     * @param string $column
     * @param string $content
     * @param string $match_replacement
     * @return $this
     */
    public function addcolumn($column, $content, $replacement = null, $json = false) {
        $this->not_columns[$column] = array(
                'content' => $content,
                'replacement' => is_array($replacement)
                        ? $replacement
                        : $this->explode(',', $replacement),
                'json' => $json);
        return $this;
    }
    /**
     * Initial datatable id with multisearch
     *
     * @param string $tableid
     * @param bool $multisearch
     * @return $this
     */
    public function datatable($tableid = 'table', $tableclass = 'table', $multisearch = false) {
        if($tableid != '' && $tableid != 'table') { /* not */ }
        else $tableid .= date('YmdHis');
        if($tableclass != '' && $tableclass != 'table') { /* not */ }
        else $tableclass .= 'table table-striped table-bordered table-hover';
        $this->columns = array();
        $this->not_columns = array();
        $this->tableid = $tableid;
        $this->tableclass = $tableclass;
        $this->multisearch = $multisearch;
        $this->headers = array();
        return $this;
    }
    /**
     * Initial default order
     *
     * @param string $tableid
     * @param bool $multisearch
     * @return $this
     */
    public function defaultorder($column, $direction = 'asc') {
        $this->default_order = array($column => $direction);
        return $this;
    }
    /**
     * Set header table and bind columns
     *
     * @param $header
     * @param $bind
     * @param $orderable
     * @param $searchable
     * @param $visible
     * @return $this
     */
    public function header($header, $bind, $orderable, $searchable, $visible, $merge = false) {
        array_push($this->headers, array(
                'header' => $header,
                'column' => $bind,
                'merge' => $merge,
                'orderable' => $orderable,
                'searchable' => $searchable,
                'visible' => $visible
        ));
        return $this;
    }
    /**
     * Builds all the necessary query segments and performs the main query based on results set from chained statements
     */
    public function generatetable($id=null, $echo=true) {
        $tableid = ($id == null ? $this->tableid : $id);
        $html = '<table class=\''.$this->tableclass.'\' id=\''.$tableid.'\'>';
        $html .= '<thead>';
        $html .= '<tr role=\'row\' class=\'heading tr tr-outline dark\'>';
        foreach ($this->headers as $key => $value) {
            $html .= '<th>'.$value['header'].'</th>';
        }
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tfoot>';
        $html .= '<tr>';
        foreach ($this->headers as $key => $value) {
            if ($this->multisearch) {
                if ($value['searchable']) {
                    $html .= '<th><input type=\'text\' placeholder=\'Cari ' . strip_tags($value['header']) . '\' class=\'form-control form-filter input-sm\' id=\'search' . $key . '\'></th>';
                } else {
                    $html .= '<th>' . $value['header'] . '</th>';
                }
            } else {
                $html .= '<th>' . $value['header'] . '</th>';
            }
        }
        $html .= '</tr>';
        $html .= '</tfoot>';
        $html .= '<tbody>';
        $html .= '</tbody>';
        $html .= '</table>';
        if ($echo) echo $html;
        else return $html;
    }
    /**
     * Builds all the necessary query segments and performs the main query based on results set from chained statements
     */
    public function jquery($defaultorder=1, $id=null, $echo=true) {
        $tableid = ($id == null ? $this->tableid : $id);
        $columns = array();
        $order = array();
        $search = array();
        $visible = array();
        foreach ($this->headers as $key => $value) {
            $column = '{';
            $column .= '\'data\': \''.$value['column'].'\' ';
            if ($value['merge'] != false) {
                $column .= ', ';
                $column .= 'render: function ( data, type, row ) { return ';
                foreach ($value['merge'] as $keyI => $valueI) {
                    if ($keyI == 0) $column .= '\'<div class=nowrap>\' + row.'.$valueI.' ';
                    else $column .= ' + \'&nbsp\' + row.'.$valueI.' ';
                    if ($keyI == count($value['merge']) -1) $column .= ' + \'</div>\'';
                }
                $column .= '}';
            }
            $column .= '}';
            array_push($columns, $column);
            if (! $value['orderable']) array_push($order, $key);
            if (! $value['searchable']) array_push($search, $key);
            if (! $value['visible']) array_push($visible, $key);
        }
        $jquery = preg_replace('/\s\s+/', ' ', '<script>
$(document).ready(function() {
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
        return {
            \'iStart\': oSettings._iDisplayStart,
            \'iEnd\': oSettings.fnDisplayEnd(),
            \'iLength\': oSettings._iDisplayLength,
            \'iTotal\': oSettings.fnRecordsTotal(),
            \'iFilteredTotal\': oSettings.fnRecordsDisplay(),
            \'iPage\': Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            \'iTotalPages\': Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };
    var delay = function (callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
                callback.apply(context, args);
            }, ms || 0);
        };
    };
    var table = $(\'#'.$tableid.'\').DataTable({
        initComplete: function() {
            var api = this.api();
            $(\'#data-table_filter input\')
            .off(\'.DT\')
            .on(\'input.DT\', function() {
                api.search(this.value).draw();
            });
            api.columns().every(function() {
            var that = this;
            $(\'input\', this.footer()).on(\'keyup change\', delay(function() {
              if (that.search() !== this.value) {
                that.search(this.value).draw();
              }
            }, 1000));
          });
        },
        language: {
            aria: {
                sortAscending: \': activate to sort column ascending\',
                    sortDescending: \': activate to sort column descending\',
                },
            emptyTable: \'Tidak ada data yang dapat ditampilkan dari tabel ini...\',
                info: \'Menampilkan _START_ sampai _END_ dari _TOTAL_ baris data...\',
                infoEmpty: \'Tidak ada baris data...\',
                infoFiltered: \'(terfilter dari _MAX_ total baris data)\',
                lengthMenu: \'_MENU_ baris...\',
                search: \'Pencarian:\',
                zeroRecords: \'Tidak ada baris data yang cocok...\',
                buttons: {
                copyTitle: \'Menyalin ke clipboard\',
                    copySuccess: {
                    _: \'Disalin %d baris ke clipboard...\',
                    1: \'Disalin 1 baris ke clipboard...\'
                    }
                },
                paginate: {
                first: \'<i class=\\\''.'fa fa-angle-double-left'.'\\\'></i>\',
                    previous: \'<i class=\\\''.'fa fa-angle-left'.'\\\'></i>\',
                    next: \'<i class=\\\''.'fa fa-angle-right'.'\\\'></i>\',
                    last: \'<i class=\\\''.'fa fa-angle-double-right'.'\\\'></i>\'
                },
            processing: \'<p style=\\\''.'color: green'.'\\\'><i class=\\\''.'fa fa-cog fa-spin fa-3x fa-fw'.'\\\'></i></p><span class=\\\''.'sr-only'.'\\\'>Loading…</span>\'
        },
        processing: true,
        serverSide: true,
        ajax: {
            \'url\': \''.current_url().'?'.$_SERVER['QUERY_STRING'].'\', 
            \'type\': \'POST\',
            \'data\': {
                \'tableid\': \''.$tableid.'\'
            }
        },
        searchDelay: 1000,
        columns: ['.implode(',', $columns).'],
        orderCellsTop: true,
        stateSave: true,
        stateDuration: 60 * 60 * 2,
        responsive: false,
        select: false,
        pagingType: \'full_numbers\',
        order: [
                ['.$defaultorder.', \'desc\']
        ],
        lengthMenu: [
                [5, 15, 20, 50, 100, 500, 1000, -1],
                [5, 15, 20, 50, 100, 500, 1000, \'Semua\']
        ],
        pageLength: 15,
        columnDefs: [{
            orderable: false,
            targets: ['.implode(', ', $order).']
        }, {
            searchable: false,
            targets: ['.implode(', ', $search).']
        },{
            visible: false,
            targets: ['.implode(', ', $visible).']
        }],
        rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $(\'td:eq(0)\', row).html(index);
            }
    });
    var state = table.state.loaded();
    if (state) {
        $(\'#'.$tableid.' tfoot th\').each(function(idx) {
            $(\'input#search\' + idx).val(state.columns[idx].search.search);
        });
    }
});
</script>');
        if ($echo) echo $jquery;
        else return $jquery;
    }
    /**
     * Builds all the necessary query segments and performs the main query based on results set from chained statements
     *
     * @param string $output
     * @param string $charset
     */
    public function generateajax($output = 'json', $charset = 'UTF-8') {
        $tableid = $this->ci->input->post('tableid');
        if($tableid != '' && $tableid != '0') {
            echo $this->generate($output, $charset);
            exit;
        }
    }
    /**
     * Builds all the necessary query segments and performs the main query based on results set from chained statements
     *
     * @param string $output
     * @param string $charset
     * @return string
     */
    public function generate($output = 'json', $charset = 'UTF-8') {
        if(strtolower($output) == 'json') {
            $this->get_paging();
        }
        $this->get_ordering();
        $this->get_filtering();
        return $this->produce_output(strtolower($output), strtolower($charset));
    }
    /**
     * Generates the limit offset portion of the query
     *
     * @return mixed
     */
    private function get_paging() {
        $start = $this->ci->input->post('start');
        $length = $this->ci->input->post('length');
        if($length != '' && $length != '-1') {
            $this->limit .= ' limit ' . $length . ' offset ' . $start;
        }
    }
    /**
     * Generates the order by portion of the query
     */
    private function get_ordering() {
        $columns = $this->ci->input->post('columns');
        if ($this->ci->input->post('order')) {
            foreach ($this->ci->input->post('order') as $key => $value) {
                if ($columns[$value['column']]['orderable'] == 'true' && !array_key_exists($columns[$value['column']]['data'], $this->not_columns)) {
                    if ($this->check_cType()) {
                        $this->order .= ' order by ' . $columns[$value['column']]['data'] . ' ' . $value['dir'];
                    } else {
                        $this->order .= ' order by ' . $this->columns[$value['column']] . ' ' . $value['dir'];
                    }
                }
            }
        }
    }
    /**
     * Generates a %like% portion of the query
     */
    private function get_filtering() {
        $columns = $this->ci->input->post('columns');
        $where = array();
        $wherec = array();
        $search = $this->ci->input->post('search');
        $values = $this->ci->db->escape_like_str(trim($search['value']));
        if($values != '') {
            foreach ($columns as $key => $value) {
                if ($columns[$key]['searchable'] == 'true' && !array_key_exists($columns[$key]['data'], $this->not_columns)) {
                    if ($this->check_cType()) {
                        array_push($where, $columns[$key]['data'] . '::varchar ilike \'%' . $values . '%\' ');
                    } else {
                        array_push($where, $this->columns[$key] . '::varchar ilike \'%' . $values . '%\' ');
                    }
                }
            }
            if (count($where) > 0) $this->where .= ' and ( ' . implode(' or ', $where) . ' ) ';
        }
        if ($this->multisearch) {
            foreach ($columns as $key => $value) {
                if ($columns[$key]['searchable'] == 'true' && !array_key_exists($columns[$key]['data'], $this->not_columns)) {
                    if ($this->check_cType()) {
                        if ($columns[$key]['search']['value'] != '') {
                            array_push($wherec, $columns[$key]['data'] . '::varchar ilike \'%' . $this->ci->db->escape_like_str(trim($columns[$key]['search']['value'])) . '%\' ');
                        }
                    } else {
                        if ($columns[$key]['search']['value'] != '') {
                            array_push($wherec, $this->columns[$key] . '::varchar ilike \'%' . $this->ci->db->escape_like_str(trim($columns[$key]['search']['value'])) . '%\' ');
                        }
                    }
                }
            }
            if (count($wherec) > 0) $this->where .= ' and ( ' . implode(' and ', $wherec) . ' ) ';
        }
    }
    /**
     * Compiles the select statement based on the other functions called and runs the query
     *
     * @return mixed
     */
    private function get_display_result() {
        return $this->ci->db->query($this->select.$this->where.$this->order.$this->limit);
    }
    /**
     * Get the filter is searchable
     *
     * @return boolean
     */
    private function issearchable() {
        $columns = $this->ci->input->post('columns');
        $search = $this->ci->input->post('search');
        $value = $this->ci->db->escape_like_str(trim($search['value']));
        if ($value != '') return true;
        if ($this->multisearch) {
            foreach ($columns as $key => $value) {
                if ($columns[$key]['searchable'] == 'true' && !array_key_exists($columns[$key]['data'], $this->not_columns)) {
                    if ($this->ci->db->escape_like_str(trim($columns[$key]['search']['value'])) != '') return true;
                }
            }
        }
        return false;
    }
    /**
     * Builds an encoded string data. Returns JSON by default, and an array of aaData if output is set to raw.
     *
     * @param string $output
     * @param string $charset
     * @return array|false|string
     */
    private function produce_output($output, $charset) {
        $data = array();
        if($output == 'json') {
            $total = $this->get_total_results();
            $filteredTotal = $this->get_total_results($this->issearchable());
        }
        foreach($this->get_display_result()->result_array() as $key => $value) {
            $data[$key] = ($this->check_cType()) ? $value : array_values($value);
            foreach($this->not_columns as $keyI => $valueI) {
                if ($this->check_cType()) {
                    $data[$key][$keyI] = $this->exec_replace($valueI, $data[$key]);
                } else {
                    $data[$key][] = $this->exec_replace($valueI, $data[$key]);
                }
            }
            if (! $this->check_cType()) {
                $data[$key] = array_values($data[$key]);
            }

        }
        if($output == 'json') {
            $json = array (
                    'draw' => intval($this->ci->input->post('draw')),
                    'recordsTotal' => $total,
                    'recordsFiltered' => $filteredTotal,
                    'data' => $data
            );

            if($charset == 'utf-8') {
                return json_encode($json);
            } else {
                return $this->jsonify($json);
            }
        }
        else return array('aaData' => $data);
    }
    /**
     * Get result count
     *
     * @return integer
     */
    private function get_total_results($filtering = FALSE) {
        $query = $this->ci->db->query('select count(1) as total from (' . $this->select.($filtering ? $this->where : '') . ') as aa ');
        $result = $query->row();
        $count = $result->total;
        return $count;
    }
    /**
     * Runs callback functions and makes replacements as json url
     *
     * @param mixed $customvalue
     * @param mixed $rowdata
     * @return string $customvalue['content']
     */
    private function exec_replace_json($customvalue, $rowdata) {
        $replace_json = array();
        //Added this line because when the replacement has over 10 elements replaced the variable "$1" first by the "$10"
        $customvalue['replacement'] = array_reverse($customvalue['replacement'], true);
        foreach($customvalue['replacement'] as $key => $value) {
            if (in_array($value, $this->columns)) {
                $replace_json[$value] = $rowdata[$value];
            }
        }
        if (is_string($customvalue['json']) && strtolower($customvalue['json']) == 'json') {
            $customvalue['content'] = str_ireplace('$1', json_encode($replace_json), $customvalue['content']);
        } else if (is_string($customvalue['json']) && strtolower($customvalue['json']) == 'hex') {
            $customvalue['content'] = str_ireplace('$1', bin2hex(json_encode($replace_json)), $customvalue['content']);
        } else if (is_string($customvalue['json']) && strtolower($customvalue['json']) == 'base64') {
            $customvalue['content'] = str_ireplace('$1', base64_encode(json_encode($replace_json)), $customvalue['content']);
        } else {
            $customvalue['content'] = str_ireplace('$1', bin2hex(json_encode($replace_json)), $customvalue['content']);
        }
        return $customvalue['content'];
    }
    /**
     * Runs callback functions and makes replacements
     *
     * support sprintf('scheduleid=%s,routename=%s,username=%s', scheduleid, routename, username), date format and other
     * @param mixed $customvalue
     * @param mixed $rowdata
     * @return string $customvalue['content']
     */
    private function exec_replace($customvalue, $rowdata) {
        $replace_string = '';
        // go through our array backwards, else $1 (foo) will replace $11, $12 etc with foo1, foo2 etc
        $customvalue['replacement'] = array_reverse($customvalue['replacement'], true);
        if(isset($customvalue['replacement']) && is_array($customvalue['replacement'])) {
            if (is_string($customvalue['json']) or $customvalue['json']) return $this->exec_replace_json($customvalue, $rowdata);
            //Added this line because when the replacement has over 10 elements replaced the variable "$1" first by the "$10"
            $customvalue['replacement'] = array_reverse($customvalue['replacement'], true);
            foreach($customvalue['replacement'] as $key => $value) {
                $sprintvalue = preg_replace("/(?<!\w)([\'\"])(.*)\\1(?!\w)/i", '$2', trim($value));
                if(preg_match("/(\w+::\w+|\w+)\((.*)\)/i", $value, $matches) && is_callable($matches[1])) {
                    $function = $matches[1];
                    $args = preg_split("/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[,]+/", $matches[2], 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
                    foreach($args as $argskey => $argsvalue) {
                        $argsvalue = preg_replace("/(?<!\w)([\'\"])(.*)\\1(?!\w)/i", '$2', trim($argsvalue));
                        $args[$argskey] = (in_array($argsvalue, $this->columns))? ($rowdata[($this->check_cType())? $argsvalue : array_search($argsvalue, $this->columns)]) : $argsvalue;
                    }
                    $replace_string = call_user_func_array($function, $args);
                } elseif(in_array($sprintvalue, $this->columns)) {
                    $replace_string = $rowdata[($this->check_cType()) ?  $sprintvalue : array_search($sprintvalue, $this->columns)];
                } else {
                    $replace_string = $sprintvalue;
                }
                $customvalue['content'] = str_ireplace('$' . ($key + 1), $replace_string, $customvalue['content']);
            }
        }
        return $customvalue['content'];
    }
    /**
     * Check column type -numeric or column name
     *
     * @return bool
     */
    private function check_cType() {
        $column = $this->ci->input->post('columns');
        if(is_numeric($column[0]['data'])) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Return the difference of open and close characters
     *
     * @param string $str
     * @param string $open
     * @param string $close
     * @return string $retval
     */
    private function balanceChars($str, $open, $close) {
        $openCount = substr_count($str, $open);
        $closeCount = substr_count($str, $close);
        $retval = $openCount - $closeCount;
        return $retval;
    }
    /**
     * Explode, but ignore delimiter until closing characters are found
     *
     * @param string $delimiter
     * @param string $str
     * @param string $open
     * @param string $close
     * @return mixed $retval
     */
    private function explode($delimiter, $str, $open = '(', $close=')') {
        $retval = array();
        $hold = array();
        $balance = 0;
        $parts = explode($delimiter, $str);
        foreach($parts as $part) {
            $hold[] = trim($part);
            $balance += $this->balanceChars($part, $open, $close);
            if($balance < 1) {
                $retval[] = implode($delimiter, $hold);
                $hold = array();
                $balance = 0;
            }
        }
        if(count($hold) > 0)
            $retval[] = implode($delimiter, $hold);
        return $retval;
    }
    /**
     * Workaround for json_encode's UTF-8 encoding if a different charset needs to be used
     *
     * @param mixed $result
     * @return string
     */
    private function jsonify($result = false) {
        if(is_null($result)) return 'null';
        if($result === false) return 'false';
        if($result === true) return 'true';
        if(is_scalar($result)) {
            if(is_float($result)) {
                return floatval(str_replace(',', '.', strval($result)));
            }
            if(is_string($result)) {
                static $jsonReplaces = array(array('\\', '/', '\n', '\t', '\r', '\b', '\f', '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $result) . '"';
            } else {
                return $result;
            }
        }
        $isList = true;
        for($i = 0, reset($result); $i < count($result); $i++, next($result)) {
            if(key($result) !== $i) {
                $isList = false;
                break;
            }
        }
        $json = array();
        if($isList) {
            foreach($result as $value) {
                $json[] = $this->jsonify($value);
            }
            return '[' . join(',', $json) . ']';
        } else {
            foreach($result as $key => $value) {
                $json[] = $this->jsonify($key) . ':' . $this->jsonify($value);
            }
            return '{' . join(',', $json) . '}';
        }
    }
    /**
     * returns the sql statement of the last query run
     *
     * @return mixed
     */
    public function last_query() {
        return  $this->ci->db->last_query();
    }
}
/* End of file Datatables.php */
/* Location: ./application/libraries/Datatables.php */
