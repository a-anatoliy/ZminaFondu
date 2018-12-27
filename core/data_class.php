<?php

/**
 * Created by PhpStorm.
 * User: Tolya
 * Date: 07.05.2018
 * Time: 16:07
 */
class Data {
    // Database Connection Configuration Parameters
    // array('driver' => 'mysql','host' => '','dbname' => '','username' => '','password' => '')
//    protected $_config;

    // Database Connection
    public $dbc;

    // Connection options
    private $opts;

    /**
     * Statement Handle.
     */
    public $sth = null;

    /**
     * An SQL query.
     */
    public static $query = '';

    /* function __construct
     * Opens the database connection
     * @param $config is an array of database connection parameters
     */
    public function __construct($cfg) {

        $this->_cfg = $cfg['db'];
        $this->opts = [
            // turn off emulation mode for "real" prepared statements
            PDO::ATTR_EMULATE_PREPARES   => false,

            //turn on errors in the form of exceptions
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,

            //make the default fetch be an associative array
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->getPDOConnection();
    }

    /* Function __destruct
     * Closes the database connection
     */
    public function __destruct() {
        $this->dbc = NULL;
    }

    /* Function getPDOConnection
     * Get a connection to the database using PDO.
     */
    private function getPDOConnection() {
        // Check if the connection is already established
        if ($this->dbc == NULL) {
            // Create the connection
            $dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8mb4",
                $this->_cfg['hst'],$this->_cfg['tbl']);
            try {
                $this->dbc = new PDO($dsn,$this->_cfg['usr'],$this->_cfg['pss'],$this->opts );
            } catch( PDOException $e ) {
                echo __LINE__.$e->getMessage();
            }
        }
        return $this->dbc;
    }

    /**
     * Add record to the DB, returns ID if success ant 0 otherwise
     */
    public function add($query, $param = array()) {
        $this->sth = $this->dbc->prepare($query);
        return ($this->sth->execute((array) $param)) ? $this->dbc->lastInsertId() : 0;
    }

    /**
     * Execution query
     */
    public static function set($query, $param = array()) {
        self::$sth = self::getDbh()->prepare($query);
        return self::$sth->execute((array) $param);
    }

    /**
     * get row from the db
     */
    public function getRow($query, $param = array()) {
        $this->sth = $this->dbc->prepare($query);
        $this->sth->execute((array) $param);
        return $this->sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * select all rows from table
     */
    public function getAll($query, $param = array()) {
        $this->sth = $this->dbc->prepare($query);
        $this->sth->execute((array) $param);
        return $this->sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * get value
     */
    public function getValue($query, $param = array(), $default = null) {
        $result = $this->getRow($query, $param);
        if (!empty($result)) {
            $result = array_shift($result);
        }

        return (empty($result)) ? $default : $result;
    }

    /**
     * get row from the table
     */
    public static function getColumn($query, $param = array()) {
        self::$sth = self::getDbh()->prepare($query);
        self::$sth->execute((array) $param);
        return self::$sth->fetchAll(PDO::FETCH_COLUMN);
    }


}
/*
Примеры использования
DB::getRow — получение одной записи из БД

$item = DB::getRow("SELECT * FROM `category` WHERE `id` = ?", 1);
// Или
$item = DB::getRow("SELECT * FROM `category` WHERE `id` = :id", array('id' => 1));

print_r($item);

Результат:

Array
(
    [id] => 1
    [parent] => 0
    [name] => Мороженое
)

DB::getAll — получение нескольких записей из БД

$items = DB::getAll("SELECT * FROM `category` WHERE `id` > 2");
print_r($items);

Результат:

Array
(
    [0] => Array
        (
            [id] => 3
            [parent] => 0
            [name] => Фрукты
        )
    [1] => Array
        (
            [id] => 4
            [parent] => 0
            [name] => Ягоды
        )
    [2] => Array
        (
            [id] => 5
            [parent] => 2
            [name] => Грибы
        )
    ...
)

DB::getValue — получения значения

$value = DB::getValue("SELECT `name` FROM `category` WHERE `id` = 2");
print_r($value);

Результат:

Овощи

DB::getColumn — получения значений колонки

$values = DB::getColumn("SELECT `name` FROM `category`");
print_r($values);

Результат:

Array
(
    [0] => Мороженое
    [1] => Овощи
    [2] => Фрукты
    [3] => Ягоды
    [4] => Грибы
    [5] => Морепродукты
    ...
)

DB::add — добавление в БД

Метод возвращает ID вставленной записи.

$insert_id = DB::add("INSERT INTO `category` SET `name` = ?", 'Яблоки');

DB::set — все остальные запросы

Выполняет запросы в БД, такие как DELETE, UPDATE, CREATE TABLE и т.д. В случаи успеха возвращает true.

DB::set("DELETE FROM `category` WHERE `id` > ? AND `parent` > ?", array(123, 0));
 */
