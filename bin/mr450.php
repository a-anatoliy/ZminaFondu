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

require ROOT_DIR . '/core/argh_class.php';
// ---------------------------------------------------------
$auth = new Argh();

if (isset($_POST['lgn']) && isset($_POST['psw'])) { //Если логин и пароль были отправлены
    if (!$auth->auth($_POST['lgn'], $_POST['psw'])) { //Если логин и пароль введен не правильно
        echo "<h4 style=\"color:red;\">Incorrect value of either login or password</h4>";
        include DIR_TMPL . 'statLoginForm.html';
        exit;
    }
}

if (isset($_GET["is_exit"])) { //Если нажата кнопка выхода
    if ($_GET["is_exit"] == 1) {
        $auth->out(); //Выходим
        header("Location: ?is_exit=0"); //Редирект после выхода
    }
}

if (!$auth->isAuth()) {
    include DIR_TMPL . 'statLoginForm.html';
    exit;
}

// ---------------------------------------------------------
//Get the page number
$startP = filter_input(INPUT_GET,'s56',FILTER_SANITIZE_NUMBER_INT);
if(!isset($startP)) { $startP = 1; }



$mainWebAddr = $cfg['site']['url'];

require_once ROOT_DIR . '/lib/ourGains.php';
require_once ROOT_DIR . '/lib/Paginator.php';

$gains  = new ourGains($cfg);

// get all of orders
$orders = $gains->buildOrdersTable();

//Total data to display per page
$per_page = $cfg['stat']['rowsPerPage'];

// get all of the visitors
$start = ($startP - 1) * $per_page;
$visitors = $gains->buildVisitorTable($start,$per_page);

$paginator = new Paginator($cfg,$startP);
//echo '<pre>'; var_dump($paginator->getPages()); echo '</pre>';
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
    <link rel="stylesheet" href="/css/counter.css">

    <title>статистика посещений</title>

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
                    <span class="badge badge-secondary"> <?=$paginator->getTotalItems()?> </span>
                </a>
            </li>
            <li class="nav-item"> <?=$gains->ordersCount?> </li>
            <li class="nav-item"> <a class="nav-link" href="<?=$mainWebAddr?>" target="_blank">Сайт</a> </li>
        </ul>
    </div>
    <a class="btn btn-outline-light btn-sm" href='?is_exit=1'>logout</a>
</nav>

<!-- ############################################### -->
<?=$gains->ordersTable?>
<!-- ############################################### -->
<div class="container-fluid">
    <?php
        include DIR_TMPL . 'statPagination.html';
    ?>
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
    <?php
        include DIR_TMPL . 'statPagination.html';
    ?>
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
