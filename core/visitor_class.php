<?php

/**
 * Created by PhpStorm.
 * User: Tolya
 * Date: 04.05.2018
 * Time: 12:49
 */
class Visitor {
    // default value which will be used for all of undef variables
    const UNDEF_VALUE  = 'none';

    // Cookie Name used for each visitor
    const VISITED_COOKIE_NAME  = 'ZminaFondu_visited';

    // Where to obtain info about visitor
    const IP_INFO_SITE  = 'http://ipinfo.io/';

    // Number of hours a visitor is considered as "unique"
    const UNIQUE_HOURS = 48;

    // ------- variables --------------------------------------------------------------------
    // Show "unique" visits only ?
    private $unique_visits = true;

    // do we need to insert info about this visitor into db ?
    public $insert = true;

    //      time| ip| url| agent|refer|query|user  | geo Location
    public $date,$ip,$uri,$agent,$ref,$query,$user,$geoloc;

    private $country_code;

    public $dbFields = array('ip','uri','agent','ref','query','user','geoloc');

    private $propName = array(
        'agent' => 'HTTP_USER_AGENT',
        'uri'   => 'REQUEST_URI',
        'query' => 'QUERY_STRING',
        'user'  => 'PHP_AUTH_USER'
    );

    public function __construct() {
        $this->date = date("d.m.Y H:i:s");
        $this->ip   = $this->getVisitorIP();

        // set default country code
        $this->country_code = 'UA';

        // set all of values defined in the propName array
        // as an object properties
        foreach ($this->propName as $prop => $val) {
            $this->$prop = $this->v($_SERVER[$val]);
        }

        // decode the value of HTTP_REFERER
        $this->ref = isset($_SERVER['HTTP_REFERER'])
            ? urldecode($_SERVER['HTTP_REFERER'])
            : $_SESSION['origURL'] ;

        // get the country info of current visitor
        if (! empty($this->ip) && (strcmp($this->ip, '127.0.0.1') !== 0)) {
            $details = json_decode(file_get_contents($this::IP_INFO_SITE.$this->ip."/json"));
            if(isset($details->country)) {
                $this->geoloc = sprintf("%s %s, %s - %s",
                    $details->country,$details->region,$details->city,$details->org);
                $this->country_code = strtolower($details->country);
            }
        } else { $this->geoloc = 'local'; }

        // check if we have new unique visitor
        if ( !$this->unique_visits || !isset($_COOKIE[$this::VISITED_COOKIE_NAME]) ) {
            if( $this->unique_visits ) {
                // Send a cookie to the visitor (to track him) along with the P3P compact privacy policy
                header('P3P: CP="NOI NID"');
                setcookie($this::VISITED_COOKIE_NAME, 'yes', time() + 60 * 60 * $this::UNIQUE_HOURS, '/');
            }
        } else { $this->insert = false; }

    }

    /**
     * @return $this
     */
    public function countIt() {
        if ($this->insert) {
            try {
//                var_dump($this);
                $this->addToDB();
            } catch (\ErrorException $e) {
                echo $e->getMessage();
            }
        }

        return $this;
    }

    // Obtaining A visitor IP address
    private function getVisitorIP() {
        $ip = '0.0.0.0';
        if( ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) && ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) ) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; }
        elseif( ( isset( $_SERVER['HTTP_CLIENT_IP'])) && (!empty($_SERVER['HTTP_CLIENT_IP'] ) ) ) {
            $ip = explode(".",$_SERVER['HTTP_CLIENT_IP']);
            $ip = $ip[3].".".$ip[2].".".$ip[1].".".$ip[0]; }
        elseif((!isset( $_SERVER['HTTP_X_FORWARDED_FOR'])) || (empty($_SERVER['HTTP_X_FORWARDED_FOR']))) {
            if ((!isset( $_SERVER['HTTP_CLIENT_IP'])) && (empty($_SERVER['HTTP_CLIENT_IP']))) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        }
        return $ip;
    }

    private function addToDB() {
        require_once 'data_class.php';
        require_once 'querymap_class.php';
        // establish the db connection
        $cfg = require_once
            $_SERVER['DOCUMENT_ROOT'].'/data/cfg/rnd_string.php';  // get the database configuration
        $d = new Data($cfg);
        $params = array();
        foreach ($this->dbFields as $dbField) {
            array_push($params,$this->$dbField);
        }
        $res = $d->add(QueryMap::INSERT_VISITOR,$params);
        return $res;
    }

    private function setSessVal ($k,$v) { $_SESSION[$k] = $v; }
    private function setCookieVal($k,$v) { setcookie ($k, $v, time() + 3600*24, "/"); }
    private function v(&$var) { return !empty($var) ? $var : $this::UNDEF_VALUE; }

}
