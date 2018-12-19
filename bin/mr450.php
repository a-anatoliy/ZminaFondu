<?php
/**
 * Created by PhpStorm.
 * User: Anatol
 * Date: 17.12.2018
 * Time: 8:04
 */

session_start();
define('ROOT_DIR' , $_SERVER['DOCUMENT_ROOT'] );
define('CONFIG'   , ROOT_DIR . '/data/cfg/config.php');
define('DB_CONFIG', ROOT_DIR . '/data/cfg/rnd_string.php');

$cfg = array_merge(
    require_once CONFIG,    // get main configuration
    require_once DB_CONFIG  // get the database configuration
);

define('DIR_TMPL' , ROOT_DIR . '/themes/'.$cfg['site']['theme'].'/tmpl/' );
$mainWebAddr = $cfg['site']['url'];
$pagerStart = 0;

require_once ROOT_DIR . '/lib/ourGains.php';

$gains = new ourGains($cfg);
$orders   = $gains->buildOrdersTable();
$visitors = $gains->buildVisitorTable($pagerStart,$cfg['stat']['rowsPerPage']);

//echo '<pre>';var_dump($orders);echo '</pre>';

$totalemails = 12345;
$newItems = 1239;
$pagination = 'pagination';
?>
<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="x-ua-compatible" content="IE=edge,chrome=1" http_equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="author" content="Yukai Sp. z o.o.">

    <!-- Bootstrap CSS -->
    <link rel="icon" href="/i/favicon.ico">
    <link href="/css/fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/animate.css">

    <title>статистика посещений</title>
    <style>
        /*
        .navbar-inverse {
            background-color: #F8F8F8;
            border-color: #E7E7E7;
        }
        */

        /*.navbar { min-height: 40px !important; }*/
        .navbar-brand {
            padding: 4px 145px;
            height: 40px !important;
            line-height: 40px !important;
            color: #000 !important;
            text-shadow: 0 1px 0 rgba(255,255,255,.1), 0 0 30px rgba(255,255,255,.125) !important;
        }

        .drop-shadow {
            -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .5);
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .5);
        }
    </style>
</head>
<body>

<!- ############################################### -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Статистика посещений</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample05">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Статистика
                    <span class="badge badge-secondary"> <?=$totalemails?> </span>
                </a>
            </li>
            <li class="nav-item"> <?=$gains->ordersCount?> </li>
            <li class="nav-item"> <a class="nav-link" href="<?=$mainWebAddr?>" target="_blank">Сайт</a> </li>

        </ul>
    </div>
</nav>
<!- ############################################### -->
<?=$gains->ordersTable?>
<!- ############################################### -->
<div class="container-fluid">

    <?=$pagination?>

    <div class="row">
        <div class="col-12">
            <table class="table table-hover table-bordered table-sm mt-2 table-striped">
                <thead class="thead-dark">
                    <tr><th scope="col">#</th><th scope="col">ip</th><th scope="col">uri</th><th scope="col">agent</th><th scope="col">ref</th><th scope="col">query</th><th scope="col">user</th><th scope="col">geo</th><th scope="col">Дата</th></tr>
                </thead>
                <tbody>
                    <?=$gains->statRows?>
                </tbody>
            </table>
        </div>
    </div>
<!- ############################################### -->
    <?=$pagination?>
<!- ############################################### -->
</div>
<!-- Footer -->
<footer class="bg-black small text-center text-white-50">
    <div class="container main-fnt">Copyright &copy; Yukai - 2018</div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="/js/popper.min.js"></script>
<!-- Plugin JavaScript -->
<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/js/jquery.easing.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
</body>
</html>
