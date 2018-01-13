<?php
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/modules/keywords.php");
include($_SERVER["DOCUMENT_ROOT"] . "/admin/headtags.html"); ?>

<div class="wrapper">
    <div class="wrapper-content">
        <div class="content">
            <?php
            $recaptcha = $_POST['g-recaptcha-response'];
            $url = $_SESSION['url'];
            if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']){
                $secret = '6LenJjcUAAAAABdHEQwyLXTrML44hGMRy82nYjYJ';
                $ip = $_SERVER['REMOTE_ADDR'];
                $response = $_POST['g-recaptcha-response'];
                $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
                $arr = json_decode($rsp, TRUE);
                if($arr['success']) {
                    // Соединение с БД MySQL
                    $dbname = "9082410193_zakaz";

                    include($_SERVER["DOCUMENT_ROOT"] . "/modules/connectdb.php");

                    //В файле на первом этапе нужно принять данные из пост массива. Для этого создаем переменные
                    $name = $_POST['name'];
                    $phone = $_POST['phone'];
                    $time = $_POST['time'];
                    $text = $_POST['text'];
                    if(isset($_POST['bagazhnik']) == true ){
                        $bagazhnik = 'Багажник на крышу';
                    }
                    if(isset($_POST['autobox']) == true ){
                        $autobox = 'Автобокс';
                    }
                    if(isset($_POST['velokreplenie_krysha']) == true ){
                        $velokreplenie_krysha = 'Велокрепление на крышу';
                    }
                    if(isset($_POST['velokreplenie_farkop']) == true ){
                        $velokreplenie_farkop = 'Велокрепление на фаркоп';
                    }
                    if(isset($_POST['lyzhnoe_kreplenie']) == true ){
                        $lyzhnoe_kreplenie = 'Лыжное крепление';
                    }
                    if(isset($_POST['braslets']) == true ){
                        $braslets = 'Браслеты противоскольжения';
                    }

//Первая функция преобразует все символы, которые пользователь попытается добавить в форму
                    $name = htmlspecialchars($name);
                    $phone = htmlspecialchars($phone);
                    $time = htmlspecialchars($time);
                    $text = htmlspecialchars($text);
//Вторая функция декодирует url, если пользователь попытается его добавить в форму
                    $name = urldecode($name);
                    $phone = urldecode($phone);
                    $time = urldecode($time);
                    $text = urldecode($text);
//Третьей функцией мы удалим пробелы с начала и конца строки, если таковые имеются
                    $name = trim($name);
                    $phone = trim($phone);
                    $time = trim($time);
                    $text = trim($text);
//Заносим данные из формы в переменные
                    $name = $_REQUEST['name'];
                    $phone = $_REQUEST['phone'];
                    $time = $_REQUEST['time'];
                    $text = $_REQUEST['text'];

                    //Создаем запрос в базу данных

                    $sql_users = "INSERT INTO users (name, phone)" . "VALUES('{$name}', '{$phone}');";
                    mysqli_query($sql_users);

                    include($_SERVER["DOCUMENT_ROOT"] . "/modules/mails.php");

                    if((isset($_POST['name'])&&$_POST['name']!="")&&(isset($_POST['phone'])&&$_POST['phone']!="")) {

                        if (mail($email, "Заказ оборудования в прокат", $prokat, "From: autobagaz@yandex.ru \r\n")) {
                            echo "<title>Вы успешно забронировали оборудование!</title>";
                            echo "<div class='good_message'>";
                            echo "<p>Вы успешно забронировали оборудование! Мы с Вами свяжемся в ближайшее время!</p>";
                            echo "</div>";
                            echo "<p class='page__text page__text--notification'>Через 5 секунд Вы будете перенаправлены на предыдущую страницу</p>";
                            echo "<p class='page__text page__text--notification'>Если этого не произошло, то нажмите на ссылку:</p>";
                            echo "<a class='page__link page__link--notification page__link--sitemap' href='" . $url . "'>Вернуться назад</a>";
                            header('Refresh: 5; URL='.$url);
                        }
                        else {
                            echo "<title>При отправке заказа возникли проблемы</title>";
                            echo "<div class='good_message good_message--wrong'>";
                            echo "<p class='page__text page__text--notification'>При отправке заказа возникли проблемы :(</p>";
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
                }
                else {
                    echo "<title>Вы неправильно ввели  капчу</title>";
                    echo "<div class='good_message good_message--wrong'>";
                    echo "<p class='page__text page__text--notification'>Вы неправильно ввели  капчу, вернитесь, пожалуйста, и введите правильно</p>";
                    echo "</div>";
                    echo "<a class='page__link page__link--notification page__link--sitemap' href='".$url."'>Вернуться назад</a>";
                }
            }
            else {
                echo "<title>Вы не ввели  капчу</title>";
                echo "<div class='good_message good_message--wrong'>";
                echo "<p class='page__text page__text--notification'>Вы не ввели  капчу, вернитесь, пожалуйста, и введите её</p>";
                echo "</div>";
                echo "<a class='page__link page__link--notification page__link--sitemap' href='".$url."'>Вернуться назад</a>";
            }
            unset($_SESSION['tovar']);
            unset($_SESSION['url']);
            ?>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>