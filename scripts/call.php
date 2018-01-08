<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/modules/keywords.php");
include($_SERVER["DOCUMENT_ROOT"] . "/admin/headtags.html"); ?>

<div class="wrapper">
    <div class="wrapper-content">
        <div class="content">
            <?php
            $url = $_SESSION['url'];

            // Соединение с БД MySQL
            $dbname = "9082410193_zakaz";

            include($_SERVER["DOCUMENT_ROOT"] . "/modules/connectdb.php");

            //В файле на первом этапе нужно принять данные из пост массива. Для этого создаем переменные
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            //Первая функция преобразует все символы, которые пользователь попытается добавить в форму
            $name = htmlspecialchars($name);
            $phone = htmlspecialchars($phone);
            //Вторая функция декодирует url, если пользователь попытается его добавить в форму
            $name = urldecode($name);
            $phone = urldecode($phone);
            //Третьей функцией мы удалим пробелы с начала и конца строки, если таковые имеются
            $name = trim($name);
            $phone = trim($phone);
            //Заносим данные из формы в переменные
            $name = $_REQUEST['name'];
            $phone = $_REQUEST['phone'];

            //Создаем запрос в базу данных
//            $sql_insert = "INSERT INTO calls (name, phone)" .
//                "VALUES('{$name}', '{$phone}');";
//            mysqli_query($sql_insert);
//
//            $sql_users = "INSERT INTO users (name, phone)" .
//                "VALUES('{$name}', '{$phone}');";
//            mysqli_query($sql_users);

            include($_SERVER["DOCUMENT_ROOT"] . "/modules/mails.php");

            if((isset($_POST['name'])&&$_POST['name']!="")&&(isset($_POST['phone'])&&$_POST['phone']!="")){

                if (mail("goldirev12@yandex.ru", "Звонок с сайта!!!",
                    $call, "From: autobagaz@yandex.ru \r\n")){
                    echo "<title>Вам обязательно перезвоним!</title>";
                    echo "<div class='good_message'>";
                    echo "<p>Мы Вам обязательно перезвоним!</p>";
                    echo "</div>";
                    echo "<p class='page__text page__text--notification'>Через 5 секунд Вы будете перенаправлены на предыдущую страницу</p>";
                    echo "<p class='page__text page__text--notification'>Если этого не произошло, то нажмите на ссылку:</p>";
                    echo "<a class='page__link page__link--notification page__link--sitemap' href='" . $url . "'>Вернуться назад</a>";
                    header('Refresh: 5; URL='.$url);
                }
                else {
                    echo "<title>При отправке данных возникли проблемы</title>";
                    echo "<div class='good_message good_message--wrong'>";
                    echo "<p class='page__text page__text--notification'>При отправке данных возникли проблемы :(</p>";
                    echo "</div>";
                    echo "<a class='page__link page__link--notification page__link--sitemap' href='".$url."'>Вернуться назад</a>";
                }
            }
            else {
                echo "<title>Вы не заполнили одно из полей формы</title>";
                echo "<div class='good_message good_message--wrong'>";
                echo "<p class='page__text page__text--notification'>Вы не заполнили одно из обязательных полей формы, вернитесь, пожалуйста, и заполните его</p>";
                echo "</div>";
                echo "<a class='page__link page__link--notification page__link--sitemap' href='".$url."'>Вернуться назад</a>";
            }
            unset($_SESSION['url']);
            ?>
        </div>
    </div>
    <?php  include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>