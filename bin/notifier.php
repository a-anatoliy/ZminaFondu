<?php
/**
 * Created by PhpStorm.
 * User: Anatol
 * Date: 04.12.2018
 * Time: 15:59
 */


//defined('_ATHREERUN') or die("Direct access isn't permitted.");

if (!$_POST) exit('No direct script access allowed');


require $_SERVER['DOCUMENT_ROOT'].'/lib/informer.php';

$i = new Informer();
$res = $i->informUs();
$TmplDir = $_SERVER['DOCUMENT_ROOT'].'/themes/default/tmpl/';
$tmpl    = $TmplDir . (($res->sentMsgStatus === 'fail') ? 'sendFail' : 'sendSuccess');
$tmpl   .= '.html';

$name = $res->username;
$errMsg = $res->internalError;
return include_once $tmpl;

