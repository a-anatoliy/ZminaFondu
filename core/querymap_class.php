<?php

/**
 * Created by PhpStorm.
 * User: Tolya
 * Date: 22.04.2018
 * Time: 19:24
 */
class QueryMap {

    const DB_PREFIX = 'zf_';
    private $tableFields,$q;

    public function __construct() {

        $this->tableFields = array(
            'orders' => ['id','name','email','phone','message','add_date'],
            'visits' => ['id','ip','uri','agent','ref','query','user','geoloc','add_date'],
        );

    $this->q = array(
    'SELECT_ALL_ORDERS'    => 'SELECT '.$this->getTableFields('orders').' FROM '.QueryMap::DB_PREFIX.'orders ORDER BY add_date DESC;',
    'SELECT_VISITOR_CNT'   => 'SELECT count(id) as total FROM '.QueryMap::DB_PREFIX.'stats',
    'SELECT_VISITOR_LIMIT' => 'SELECT '.$this->getTableFields('visits') .' FROM '.QueryMap::DB_PREFIX.'stats ORDER BY add_date DESC LIMIT ?,?;',
    'INSERT_ORDER'         => 'INSERT INTO '.QueryMap::DB_PREFIX.'orders ('.$this->getTableFields('orders').') values (NULL,?,?,?,?,UNIX_TIMESTAMP());',
    'INSERT_VISITOR'       => 'INSERT INTO '.QueryMap::DB_PREFIX.'stats (' .$this->getTableFields('visits') .') values (NULL,?,?,?,?,?,?,?,UNIX_TIMESTAMP());'
    );

    }

    /**
     * @param $qName
     * @return mixed
     */
    public function getQuery($qName) {
        if(array_key_exists($qName,$this->q))
             { return $this->q[$qName]; }
        else { die ("Unknown query name: $qName"); }
    }

    public function getTableFields($tblName) {
        if (array_key_exists($tblName,$this->tableFields))
             { return implode(',', $this->tableFields[$tblName]); }
        else { die ("Unknown table name: - $tblName"); }
    }

}



