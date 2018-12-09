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

//echo "your message has been sent";
print_r($tmpl);
$message = "Дякуюмо Вася. Відправлено. Наші фахівці зв'яжуться з вами найближчим часом";

/*
Informer Object (
[username] => Kraków
[usermail] => a3three@gmail.com
[usertel] => none
[comment] => аю згоду на обробк
[sendto:Informer:private] => info@zminafondu.kiev.ua
[hasError:Informer:private] =>
[orgName:Informer:private] => ZminaFondu
[subject:Informer:private] => Лист від користувача сайту
[cc_sendto:Informer:private] => Lawkruzz@gmail.com
[bcc_sendto:Informer:private] =>
[sentStatusCode] =>
[sentMsgStatus] => fail
[lang] => ua
[internalError] => mail(): Failed to connect to mailserver at "localhost" port 25, verify your "SMTP" and "smtp_port" setting in php.ini or use ini_set()
[encyFileName] => )
*/
