<?php
/**
 * Created by PhpStorm.
 * User: Anatol
 * Date: 04.12.2018
 * Time: 15:59
 */

//defined('_ATHREERUN') or die("Direct access isn't permitted.");

if (!$_POST) exit('No direct script access allowed');



sleep(4);
//echo "your message has been sent";
print_r($_POST);
$message = "Дякуюмо Вася. Відправлено. Наші фахівці зв'яжуться з вами найближчим часом";
