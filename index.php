<?php
session_start();
define('ROOT_DIR', __DIR__ );

require ROOT_DIR . '/bin/starter.php';
require ROOT_DIR . '/core/visitor_class.php';
$user = new Visitor();
$user->countIt();

?>
<!doctype html>
<html lang="en">
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="x-ua-compatible" content="IE=edge,chrome=1" http_equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="msapplication-tap-highlight" content="no">

    <meta name="keywords" content="Зміна фонду, переведення квартири до нежитлового фонду, встановлення вхідної групи, авторський та технічний нагляд, розробка та контроль за розробкою технічної та проектної документації"/>
    <meta name="description" content="Зміна фонду з житлового на нежитловий. Київ. Перевести квартиру під магазин. Переобладнати квартиру під офіс зі зміною фонду. Квартиру на першому поверсі здати в оренду банку. Квартиру під офіс банку."/>
    <meta name="author" content="Yukai Sp. Z o.o.">
    <meta name="robots" content="index"/>

    <meta property="og:title" content="Переведення квартири до нежитлового фонду. Київ. 2018"/>
    <meta property="og:description" content="Зміна фонду з житлового на нежитловий. Київ. Перевести квартиру під магазин. Переобладнати квартиру під офіс зі зміною фонду. Квартиру на першому поверсі здати в оренду банку. Квартиру під офіс банку."/>
    <meta property="og:url" content="https://zminafondu.kiev.ua"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="Переведення квартири до нежитлового фонду. Київ. 2018"/>
    <meta property="og:image" content="http://zminafondu.kiev.ua/i/002s.jpg"/>
    <meta property="og:image:secure_url" content="http://zminafondu.kiev.ua/i/002s.jpg"/>
    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:image:width" content="252"/>
    <meta property="og:image:height" content="190"/>
    <meta itemprop="name" content="Переведення квартири до нежитлового фонду. Київ."/>
    <meta itemprop="description" content="Переведення квартири до нежитлового фонду. Київ."/>
    <meta itemprop="image" content="http://zminafondu.kiev.ua/i/002s.jpg"/>

    <link href="https://fonts.googleapis.com/css?family=Jura" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="icon" href="/i/favicon.ico">
    <link href="/css/fonts/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/animate.css">

    <title>Зміна житлового фонду на нежитловий (місто Київ)</title>

    <!-- Facebook Pixel Code
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '975700909487438');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=975700909487438&ev=PageView&noscript=1" /></noscript>
    End Facebook Pixel Code -->

    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    </head>

  <body>

  <div class="container">

      <div class="row menu-border">
          <div class="col-md-6 col-sm-12 text-left">
              <nav class="navbar navbar-expand-lg navbar-light font-weight-bold navbar-expand-sm">
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                          aria-controls="nav-content" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                      <div class="navbar-nav main-fnt menu-fnt">
                          <a class="nav-item nav-link active page-scroll" href="/">Головна </a>
                          <a class="nav-item nav-link ml-2 mr-2 page-scroll" href="#about">Про Компанію</a>
                          <a class="nav-item nav-link page-scroll" href="#contact">Контакт</a>
                      </div>
                  </div>
              </nav>
          </div>

          <div class="col-6 d-none d-md-block align-middle text-sm-right align-self-center">
              <span class="main-fnt font-weight-bold contact">
                  + 38 (067) 505-93-14
                  <span class="pl-2 pr-2 text-muted">||</span>
                  <a class="text-secondary" href="mailto:info@zminafondu.kiev.ua">
                      info<i class="fa fa-at"></i>ZminaFondu.Kiev.UA</a>
              </span>
          </div>
      </div>

      <div class="row">
          <div class="col-12 mt-1 cntn">
              <h1 class="brand-heading pl-5 animated bounceInLeft">
                  Зміна житлового фонду<br>на нежитловий (місто Київ)</h1>
          </div>
      </div>
      <div class="row cntn">
          <div class="col-3 text-center d-none d-sm-block">
              <img class="rounded border border-dark mt-5 img-fluid" src="/i/004s.jpg" width="210" height="280">
          </div>
          <div class="col-9 main-fnt main-fnt-size">
              <ul class="animated bounceInRight">
                  <li><b>Срок виконання - 1.5 років</b> (+/- 3 міс.);</li>
                  <li><b>Вартість робіт по переведенню визначається індивідуально.</b>
                      (виготовлення всіх без виключення документів по переведенню з встановленням вхідної групи, включаючи авторський та технічний нагляд);</li>
                  <li><b>Вартість будівельних робіт визначається згідно Проекту.</b>
                      (залежить від складності та об'єму робіт, намірів та побажань Замовника, може включати внутрішні роботи під конкретні цілі використання, ексклюзивний підхід тощо);</li>
                  <li><b>По закінченню робіт, Замовник отримує:</b></li>
                  <ul>
                      <strong>
                        <li> повний пакет дозвільної документації;</li>
                        <li> технічну документацію на об'єкт нежитлової нерухомості
                            </strong>
                                (зареєстрований в містобудівному кадастрі проект, дозвіл на початок виконання робіт, новий технічний паспорт, договір пайової участі, картки благоустрою);</li>
                            <strong>
                        <li> реєстрацію декларації про закінчення будівельних робіт;</li>
                        <li> внесення інформації щодо нежитлового фонду в реєстр прав власності на нерухоме майно.</li>
                      </strong>
                  ​</ul>
                  <li class="font-weight-bold">Запис на консультацію (платна): 067-505-93-14, виїзд на первинний огляд - 1000 грн</li>
              </ul>
          </div>
      </div>
      <div class="full-width-div border-bottom border-dark">&nbsp;</div>
      <div class="row cntn text-center pt-5">
          <div class="col-4">
              <img class="img-fluid rounded mx-auto pt-3 pb-3" src="/i/003s.jpg" width="234" height="190">
          </div>
          <div class="col-4">
              <img class="img-fluid rounded mx-auto pt-3 pb-3" src="/i/001s.jpg" width="267" height="190">
          </div>
          <div class="col-4">
              <img class="img-fluid rounded mx-auto pt-3 pb-3" src="/i/002s.jpg" width="252" height="190">
          </div>
      </div>
      <div class="full-width-div border-bottom border-dark">&nbsp;</div>
      <div class="row mb-1" id="about">
          <div class="col-12 cntn main-fnt main-fnt-size about pt-5">
              <h3>ТОВ "Юридична консультаційно-аутсорсингова <br>компанія "Лойєр ЮА"</h3>
              <p>ЄДРПОУ 39712770</p>
              <p>п/р UA54 320649 00000 26009052706378<br>в ПАТ КБ "Приват Банк", МФО 305299</p>
              <p>вул. Деревлянська, 8, м. Київ, 04119</p>
              <p>тел.: + 38 (067) 505-93-14</p>
              <p>Lawkruzz<i class="fa fa-at"></i>gmail.com</p>
          </div>
      </div>

      <div class="row">
          <div class="col-12">
              <div id="map_container"><div id="map"></div></div>
          </div>
      </div>

      <div class="row" id="contact">
          <div class="col-12 cntn main-fnt main-fnt-size about pt-4">
            <h3>Зворотній зв’язок</h3>
          </div>
      </div>

      <div class="row">
          <div class="col-12 cntn main-fnt main-fnt-size about pb-5 mb-4" id="form-div">
              <form role="form" id="contactForm" class="animated shake needs-validation">
                  <div class="form-row">
                      <div class="col-6">
                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-prepend"><div class="input-group-text"><span class="fa fa-user"></div></div>
                                  <input type="text" class="form-control" name="name" id="name" placeholder="Ім'я" required />
                              </div>
                          </div>

                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-prepend"><div class="input-group-text"><span class="fa fa-envelope"></span></div></div>
                                  <input type="email" class="form-control" name="email" id="email" placeholder="Email" required="required"/>
                              </div>
                          </div>
                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-prepend"><div class="input-group-text"><span class="fa fa-phone"></span></div></div>
                                  <input type="phone" class="form-control" name="phone" id="phone" placeholder="Номер телефону"/>
                              </div>
                          </div>
                      </div>
                      <div class="col-6">
                          <div class="form-group">
                              <textarea name="message" id="message" class="form-control" rows="6" cols="25" required="required" placeholder="Повідомлення"></textarea>
                          </div>
                      </div>
                  </div>
                  <div class="form-group pb-2">
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="agree" id="agree" required="required" >
                          <label class="form-check-label text-left" for="agree">
                            * <i>Надаю згоду на обробку та зберігання власних персональних даних з метою їх ідентифікації.</i>
                          </label>
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="col-12 form-group">
                          <div class="clearfix">
                              <button type="submit" id="form-submit" class="btn btn-secondary contact-button float-left"> відправити </button>
                              &nbsp; <button type="reset" value="reset" accesskey="r" id="form-reset" class="btn btn-secondary contact-button" onclick="formReset()"> скасувати </button>
                              <div id="msgSubmit" class="float-lg-right hidden"></div>
                          </div>
                      </div>
                  </div>
              </form>
              <div id="loader" class="text-center align-middle align-self-center">
                  <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                  <span class="sr-only">Loading...</span>
              </div>
          </div>
      </div>

  </div>

    <!-- Footer -->
    <footer class="bg-black small text-center text-white-50">
        <div class="container main-fnt">
            <!-- FB share button code -->
            <div class="fb-share-button" data-href="http://zminafondu.kiev.ua" data-layout="button"></div>
        </div>
        <div class="container main-fnt">Copyright &copy; Yukai, Lawer UA - 2018</div>
    </footer>

    <a id="back-to-top"
       href="#"
       class="btn btn-outline-secondary btn-sm back-to-top"
       role="button" title="TOP"
       data-toggle="tooltip" data-placement="left">
        <span class="fa fa-chevron-up"></span>
    </a>

  <!-- Bootstrap core JavaScript -->
  <script src="/js/popper.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="/js/jquery-3.3.1.min.js"></script>
  <script src="/js/jquery.easing.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>

  <script src="/js/map_init.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=KEY&callback=initMap&clickableIcons=false" async defer></script>

  <script src="/js/some.js"></script>

  </body>
</html>
