<?php

/**
 * Created by PhpStorm.
 * User: Tolya
 * Date: 21.03.2018
 * Time: 8:56
 */
class Ency {

    private $utils;
    private $format = "\n%s|%s|%s|%s|%s|%s";

    public function __construct($newItem) {
        $this->info = $newItem;
        $this->utils = new Utils();
    }

    public function evidence() {
        // date|ip|name|email|phone|message
        $entry_line = sprintf($this->format,
            date("d.m.Y H:i:s"), $this->utils->getVisitorIP(),
            $this->info->username, $this->info->usermail,
            $this->info->usertel, $this->info->comment
        );

        if (!empty($this->info->internalError)) {
            $entry_line = sprintf("%s|%s",$entry_line,$this->info->internalError);
        }

        $this->utils->writeFile($this->info->encyFileName,$entry_line);

        return 1;
    }

}