<?php

/**
 * Created by PhpStorm.
 * User: Tolya
 * Date: 03.04.2018
 * Time: 10:38
 */
class anthology {
    const UNDEF_VALUE = 'none';

    // Show "unique" visits only ?
    public $unique_visits = false;

    // Number of hours a visitor is considered as "unique"
    public $unique_hours = 24;

    // Directory to write to (without any trailing slashes)
//    public $hit_count_dir = 'hitcount';

    // File to write to
    public $hit_count_file = 'hitcount.txt';

    // Cookie Name
    public $cookie_name = 'bt_hit_count';

//    private $format = "\n%d|%s|%s|%s|%s|%s|%s|%s";
    private $format = "\n%d|%s|%s|%s|%s|%s|%s";
    private $count;


    private function setLastCountVal() {
        $fp = fopen($this->hit_count_file, 'r');
        while(! feof($fp)) { $line = fgets($fp); }
        fclose($fp);
        $this->count = (int) trim($line);
/*
        $pos = -1; $line = ''; $c = '';
        do {
            $line = $c . $line;
            fseek($fp, $pos--, SEEK_END);
            $c = fgetc($fp);
//            $c = fgets($fp);
        } while ($c != PHP_EOL);
        fclose($fp);
        $this->count = (int) trim($line);
*/
    }

//    private function getLastCountVal() { return $this->count; }

    // Record HIT
    public function recordHit($guestParam) {

        foreach ($guestParam as $k => $v) { $this->$k = $v; }

        if ( !$this->unique_visits || !isset($_COOKIE[$this->cookie_name]) ) {
            $this->writeFile();
            if( $this->unique_visits ) {
                // Send a cookie to the visitor (to track him) along with the P3P compact privacy policy
                header('P3P: CP="NOI NID"');
                setcookie($this->cookie_name, 1, time() + 60 * 60 * $this->unique_hours);
            }

        }
    } // End of Method

    private function writeFile() {
        $this->setLastCountVal();

        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? strtolower($_SERVER['HTTP_USER_AGENT']) : 'unknown';
        $ref   = isset($this->refer)    ? urldecode($this->refer) : 'none' ;
        $uri   = $this->v($this->reqUri);
//        $user  = $this->v($_SERVER['PHP_AUTH_USER']);
        $query = $this->v($_SERVER['QUERY_STRING']);

        // ID              |time|         ip|      url|  agent|refer|query|user
        //17|29.01.2018 15:35:05|10.94.3.102|/form.php|mozilla| none|     |
        date_default_timezone_set('CET');
        $entry_line = sprintf($this->format,
            ++$this->count,
            date("d.m.Y H:i:s"),
            $this->ip,
            $uri, $agent, $ref, $query
//            ,$user
        );
        $fp = fopen($this->hit_count_file, 'a+', LOCK_EX)
        or die("ERROR: Can't write to [".$this->hit_count_file."], please make sure that your path is correct and you have appropriate permissions on the target directory and/or file!");
        fputs($fp, $entry_line);
        fclose($fp);
    }

    public function getHitCount() { $this->setLastCountVal(); return $this->count; }
    private function v(&$var) { return !empty($var) ? $var : $this::UNDEF_VALUE; }

}