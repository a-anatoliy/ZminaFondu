<?php
/**
 * Created by PhpStorm.
 * User: Anatol
 * Date: 17.12.2018
 * Time: 16:03
 */

class Our_gains {

    /**
     * @var array
     */
    private $rows = array();

    /**
     * @var
     */
    private $rowsCount, $query, $dbh, $qMap, $tableFields;

    /**
     * Our_gains constructor.
     * @param $cfg
     */
    public function __construct($cfg) {
        require_once ROOT_DIR.'/core/data_class.php';
        require_once ROOT_DIR.'/core/querymap_class.php';

        $this->dbh  = new Data($cfg);
        $this->qMap = new QueryMap();
    }

    /**
     * @param string $collectionName
     * @param array $params
     * @return $this
     */
    public function getData($collectionName = 'orders', $params = array()) {
        $localMap = [
            'orders' => 'SELECT_ALL_ORDERS',
            'visits' => 'SELECT_ALL_VISITOR'
        ];

        $this->setQuery($localMap[$collectionName]);
        // get all of an appropriate records from the database
        // default is 'orders'
        $allData = $this->dbh->getAll(
            $this->getQuery(),
            $params
        );
        // set this array of data
        $this->setRows($allData);
        // how many rows do we have
        $this->setRowsCount(sizeof($allData));

        // set the fields of current table
        $this->setTableFields($collectionName);

        return $this;
    }

    /**
     * @return array
     */
    public function getRows() { return $this->rows; }

    /**
     * @param array $rows
     */
    private function setRows($rows) { $this->rows = $rows; }

    /**
     * @return mixed
     */
    public function getRowsCount() { return $this->rowsCount; }

    /**
     * @param mixed $rowsCount
     */
    private function setRowsCount($rowsCount) { $this->rowsCount = $rowsCount; }

    /**
     * @return mixed
     */
    public function getQuery() { return $this->query; }

    /**
     * @param $q
     */
    private function setQuery($q) {
        $this->query =  $this->qMap->getQuery($q);
    }

    /**
     * @return String
     */
    public function getTableFields() { return $this->tableFields; }

    /**
     * @param mixed $tableName
     */
    private function setTableFields($tableName) {
        $this->tableFields = $this->qMap->getTableFields($tableName);
    }



}
