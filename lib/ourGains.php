<?php
/**
 * Created by PhpStorm.
 * User: Anatol
 * Date: 17.12.2018
 * Time: 16:36
 */

require_once ROOT_DIR.'/core/our_gains_class.php';

class ourGains extends Our_gains {

    public $ordersCount,$ordersTable,$statRows;
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
        $cnt = $this->getRowsCount();
        // we have some data collected fro the database
        if ($cnt > 0 ) {
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
                $outString .= '<td>'.$inputRow[$field].'</td>';
            }
        }
        return $outString;
    }
}

