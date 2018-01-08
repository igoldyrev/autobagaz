<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/modules/keywords.php");
include($_SERVER["DOCUMENT_ROOT"] . "/admin/headtags.html"); ?>

<div class="wrapper">
    <div class="wrapper-content">
        <div class="content">
            <?php
            $recaptcha = $_POST['g-recaptcha-response'];
            if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']){
                $secret = '6LenJjcUAAAAABdHEQwyLXTrML44hGMRy82nYjYJ';
                $ip = $_SERVER['REMOTE_ADDR'];
                $response = $_POST['g-recaptcha-response'];
                $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
                $arr = json_decode($rsp, TRUE);
                if($arr['success']){
                    // Соединение с БД MySQL
                    $dbname = "9082410193_zakaz";

                    include($_SERVER["DOCUMENT_ROOT"] . "/modules/connectdb.php");

                    //В файле на первом этапе нужно принять данные из пост массива. Для этого создаем переменные
                    $name = $_POST['name'];
                    $phone = $_POST['phone'];
                    $rewiew = $_POST['rewiew'];
//Первая функция преобразует все символы, которые пользователь попытается добавить в форму
                    $name = htmlspecialchars($name);
                    $phone = htmlspecialchars($phone);
                    $rewiew = htmlspecialchars($rewiew);
//Вторая функция декодирует url, если пользователь попытается его добавить в форму
                    $name = urldecode($name);
                    $phone = urldecode($phone);
                    $rewiew = urldecode($rewiew);
//Третьей функцией мы удалим пробелы с начала и конца строки, если таковые имеются
                    $name = trim($name);
                    $phone = trim($phone);
                    $rewiew = trim($rewiew);
//Заносим данные из формы в переменные
                    $name = $_REQUEST['name'];
                    $phone = $_REQUEST['phone'];
                    $rewiew = $_REQUEST['rewiew'];

                    //Создаем запрос в базу данных
                    $sql_insert = "INSERT INTO guestbook (name, phone, rewiew)" . "VALUES('{$name}', '{$phone}', '{$rewiew}');";
                    mysqli_query($sql_insert);

                    $sql_users = "INSERT INTO users (name, phone)" . "VALUES('{$name}', '{$phone}');";
                    mysqli_query($sql_users);

                    include($_SERVER["DOCUMENT_ROOT"] . "/modules/mails.php");

                    if((isset($_POST['name'])&&$_POST['name']!="")&&(isset($_POST['rewiew'])&&$_POST['rewiew']!="")){
                        if (mail("autobagaz@yandex.ru", "Новый отзыв на сайте",
                            $rewiewmail, "From: autobagaz@yandex.ru \r\n")){
                            echo "<title>Ваш отзыв успешно размещен на сайте!</title>";
                            echo "<div class='good_message'>";
                            echo "<p>Ваш отзыв успешно размещен на сайте!</p>";
                            echo "</div>";
                            echo "<p class='page__text page__text--notification'>Через 5 секунд Вы будете перенаправлены на предыдущую страницу</p>";
                            echo "<p class='page__text page__text--notification'>Если этого не произошло, то нажмите на ссылку:</p>";
                            echo "<a class='page__link page__link--notification page__link--sitemap' href='/guestbook'>Вернуться назад</a>";
                            header('Refresh: 5; URL=/guestbook');
                        }
                        else {
                            echo "<title>При отправке данных возникли проблемы</title>";
                            echo "<div class='good_message good_message--wrong'>";
                            echo "<p class='page__text page__text--notification'>При отправке данных возникли проблемы :(</p>";
                            echo "</div>";
                            echo "<a class='page__link page__link--notification page__link--sitemap' href='/guestbook'>Вернуться назад</a>";
                        }
                    }
                    else {
                        echo "<title>Вы не заполнили одно из полей формы</title>";
                        echo "<div class='good_message good_message--wrong'>";
                        echo "<p class='page__text page__text--notification'>Вы не заполнили одно из обязательных полей формы, вернитесь, пожалуйста, и заполните его</p>";
                        echo "</div>";
                        echo "<a class='page__link page__link--notification page__link--sitemap' href='/guestbook'>Вернуться назад</a>";
                    }
                }
                else {
                    echo "<title>Вы неправильно ввели  капчу</title>";
                    echo "<div class='good_message good_message--wrong'>";
                    echo "<p class='page__text page__text--notification'>Вы неправильно ввели  капчу, вернитесь, пожалуйста, и введите правильно</p>";
                    echo "</div>";
                    echo "<a class='page__link page__link--notification page__link--sitemap' href='/guestbook'>Вернуться назад</a>";
                }
            }
            else {
                echo "<title>Вы не ввели  капчу</title>";
                echo "<div class='good_message good_message--wrong'>";
                echo "<p class='page__text page__text--notification'>Вы не ввели  капчу, вернитесь, пожалуйста, и введите её</p>";
                echo "</div>";
                echo "<a class='page__link page__link--notification page__link--sitemap' href='/guestbook'>Вернуться назад</a>";
            }
            ?>
        </div>
    </div>
    <?php  include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>