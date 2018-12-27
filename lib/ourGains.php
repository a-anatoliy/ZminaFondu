<?php
/**
 * Created by PhpStorm.
 * User: Anatol
 * Date: 17.12.2018
 * Time: 16:36
 */

require_once ROOT_DIR.'/core/our_gains_class.php';

class ourGains extends Our_gains {

    public $ordersCount,$ordersTable,$statRows,$visitorsCount;
    private $orderTemplate;

    public function buildOrdersTable() {

        $this->ordersCount = '<a class="nav-link" href="#top" title="Сообщений пока нет"> Сообщения </a>';
        $this->ordersTable = '';
        $this->orderTemplate = DIR_TMPL . 'ordersTable.html';
        $activeURL = '<a class="nav-link" data-toggle="collapse" href="#mainOrders" aria-expanded="false" aria-controls="mainOrders">
            Сообщения <span class="badge badge-%s">%d</span></a>
        ';

        $this->getData('orders');
        $cnt = $this->getRowsCount();

        // we have some data collected fro the database
        if ($cnt > 0 ) {
            $ordersTableRows = '';
            $Orders = $this->getRows();
            $dayAhead = $Orders[0]['add_date'] + 86400;
            $badgeColor = ($dayAhead > time()) ? 'danger' : 'light';

            $this->ordersCount = sprintf($activeURL,$badgeColor,$cnt);
            foreach ($Orders as $order) {
                $ordersTableRows .= sprintf("<tr>%s</tr>",$this->setTableRow($order));
            }

            ob_start(); include_once $this->orderTemplate;
            $this->ordersTable = ob_get_clean();
        }

    }

    public function buildVisitorTable($start,$rowsPerPage) {
        $this->getData('visits', [$start,$rowsPerPage]);
        $this->visitorsCount = $this->getRowsCount();
        // we have some data collected fro the database
        if ($this->visitorsCount > 0 ) {
            $Visitors = $this->getRows();
            foreach ($Visitors as $visitor) {
                $this->statRows .= sprintf("<tr>%s</tr>",$this->setTableRow($visitor));
            }
        }
        return $this;
    }


    /**
     * @param $inputRow
     * @return string
     * generate the table row based on data collected from the database:
     * <td>...</td> ...
     */
    private function setTableRow($inputRow) {
        $outString = '';
        $tableFields = $this->getTableFields();
        if (!is_array($tableFields)) {
            $tableFields = explode(',',$tableFields);
        }
        foreach ($tableFields as $field) {
            if ($field == 'id') {
                $outString .= '<th scope="row">'.$inputRow[$field].'</th>';
            } elseif (preg_match("/date/",$field)) {
                $outString .= '<td class="text-monospace small">'
                    .date( "D, j M Y. H:i:s" , $inputRow[$field])
                    .'</td>';
            } else {

                if (mb_strlen($inputRow[$field], 'utf8') > 180) {
                    $inputRow[$field] = $this->cutString($inputRow[$field],100);
                    $inputRow[$field] = '<small>'.$inputRow[$field].'</small>';
                }
                $outString .= '<td>'.$inputRow[$field].'</td>';
            }
        }
        return $outString;
    }

    /**
     * @param $string
     * @param int $chars
     * @return string
     */
    public function cutString($string, $chars=80) {
        // remove all of html tags
        $string = strip_tags($string);
        // remove unnecessary symbols
        $string = mb_substr($string, 0, $chars);
        // remove special chars from the end of string
        $string = rtrim($string, "!,.-");
        // remove space symbol from the end of line
//        $string = mb_substr($string, 0, strrpos($string, ' '));
        return $string.' ...';
    }
}

