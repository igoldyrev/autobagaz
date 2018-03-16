<?php echo "<title>Запись в галерею добавлена</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <h1 class="title title-h1">Запись в галерею добавлена</h1>
    <?php
    $dbname = "9082410193_gallery";
    include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

    $name = $_POST['name'];
    $tagone = $_POST['tagone'];
    $tagtwo = $_POST['tagtwo'];
    $tagthree = $_POST['tagthree'];

    $name = htmlspecialchars($name);
    $tagone = htmlspecialchars($tagone);
    $tagtwo = htmlspecialchars($tagtwo);
    $tagthree = htmlspecialchars($tagthree);

    $name = urldecode($name);
    $tagone = urldecode($tagone);
    $tagtwo = urldecode($tagtwo);
    $tagthree = urldecode($tagthree);

    $name = trim($name);
    $tagone = trim($tagone);
    $tagtwo = trim($tagtwo);
    $tagthree = trim($tagthree);

    $name = $_REQUEST['name'];
    $tagone = $_REQUEST['tagone'];
    $tagtwo = $_REQUEST['tagtwo'];
    $tagthree = $_REQUEST['tagthree'];

    $namemini = mb_strtolower(str_replace(" ","",$name)); // делаем введенное имя подходящим для имени файла

    //Функция для транслита русских названий в транслит для ссылок
    function translit($str) {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', '', '', '', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }
    $translitname = mb_strtolower(translit($namemini));

    $path = '/uploads/gallery/'; // директория для загрузки

    $total = count($_FILES['photos']['name']); //счетчик файлов

    //Пустые массивы для хранения переменных img0 - img9 и адресов изображений
    $arrimg = array();
    $arrurl = array();

    //цикл, который заносит адреса загруженных файлов в таблицу БД
    for($i=0; $i<$total; $i++) {
        $ext = array_pop(explode('.',$_FILES['photos']['name'][$i])); //получение расширения

        //Уникальные номера файлов для избежания перезаписи
        for ($j=1; $j<=$total; $j++) {

            $rand = rand(0, 100);
            $new_name = $translitname.'-'.date("d-m-Y").'-'.$rand.'.'.$ext ; // новое имя с расширением
        }

        $tmpFilePath = $_FILES['photos']['tmp_name'][$i]; //Получаем временный путь хранения файла

        if ($tmpFilePath != ""){

            // Переносим файл на новое местоположение
            $newFilePath = $_SERVER['DOCUMENT_ROOT'].$path.$new_name;
            $newpath = $path.$new_name;

            if(move_uploaded_file($tmpFilePath, $newFilePath)) {

                $img = 'img'.$i;

                //Заносим в массивы информацию о переменных и адресах изображений
                $arrimg[] = $img;
                $arrurl[] = $newpath;
            }
        }
    }

    // Генерируем сегодняшнюю дату
    $date = date("d-m-Y");

    // Создаем уникальный адрес для страниц
    $dateurl = $date;
    $dateurlmini = str_replace("-", "", $dateurl);
    $randurl = rand(0, 20);
    $url = $translitname.'-'.$dateurlmini.'-'.$randurl;

    // Условия записи в БД в зависимости от количества отправленных файлов
    if ($total == '1') {

        $sql_name = "INSERT INTO photos (date, name, link, tag1, tag2, tag3, $arrimg[0]) VALUES ('$date', '$name', '$url', '$tagone', '$tagtwo', '$tagthree', '$arrurl[0]')";
        mysqli_query($connect, $sql_name);

    }elseif ($total == '2') {

        $sql_name = "INSERT INTO photos (date, name, link, tag1, tag2, tag3, $arrimg[0], $arrimg[1]) VALUES ('$date', '$name', '$url', '$tagone', '$tagtwo', '$tagthree', '$arrurl[0]', '$arrurl[1]')";
        mysqli_query($connect, $sql_name);

    }elseif ($total == '3') {

        $sql_name = "INSERT INTO photos (date, name, link, tag1, tag2, tag3, $arrimg[0], $arrimg[1], $arrimg[2]) VALUES ('$date', '$name', '$url', '$tagone', '$tagtwo', '$tagthree', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]')";
        mysqli_query($connect, $sql_name);

    }elseif ($total == '4') {

        $sql_name = "INSERT INTO photos (date, name, link, tag1, tag2, tag3, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3]) VALUES ('$date', '$name', '$url', '$tagone', '$tagtwo', '$tagthree', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]')";
        mysqli_query($connect, $sql_name);

    }elseif ($total == '5') {

        $sql_name = "INSERT INTO photos (date, name, link, tag1, tag2, tag3, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4]) VALUES ('$date', '$name', '$url', '$tagone', '$tagtwo', '$tagthree', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]')";
        mysqli_query($connect, $sql_name);

    }elseif ($total == '6') {

        $sql_name = "INSERT INTO photos (date, name, link, tag1, tag2, tag3, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], $arrimg[5]) VALUES ('$date', '$name', '$url', '$tagone', '$tagtwo', '$tagthree', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$arrurl[5]')";
        mysqli_query($connect, $sql_name);

    }elseif ($total == '7') {

        $sql_name = "INSERT INTO photos (date, name, link, tag1, tag2, tag3, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], $arrimg[5], $arrimg[6]) VALUES ('$date', '$name', '$url', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$arrurl[5]', '$arrurl[6]')";
        mysqli_query($connect, $sql_name);

    }elseif ($total == '8') {

        $sql_name = "INSERT INTO photos (date, name, link, tag1, tag2, tag3, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], $arrimg[5], $arrimg[6], $arrimg[7]) VALUES ('$date', '$name', '$url', '$tagone', '$tagtwo', '$tagthree', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$arrurl[5]', '$arrurl[6]', '$arrurl[7]')";
        mysqli_query($connect, $sql_name);

    }elseif ($total == '9') {

        $sql_name = "INSERT INTO photos (date, name, link, tag1, tag2, tag3, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], $arrimg[5], $arrimg[6], $arrimg[7], $arrimg[8]) VALUES ('$date', '$name', '$url', '$tagone', '$tagtwo', '$tagthree', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$arrurl[5]', '$arrurl[6]', '$arrurl[7]', '$arrurl[8]')";
        mysqli_query($connect, $sql_name);

    }elseif ($total == '10') {

        $sql_name = "INSERT INTO photos (date, name, tag1, tag2, tag3, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], $arrimg[5], $arrimg[6], $arrimg[7], $arrimg[8], $arrimg[9]) VALUES ('$date', '$name', '$url', '$tagone', '$tagtwo', '$tagthree', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$arrurl[5]', '$arrurl[6]', '$arrurl[7]', '$arrurl[8]', '$arrurl[9]')";
        mysqli_query($connect, $sql_name);

    } ?>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/gallery/galleryadd/addform">Добавить еще одну запись</a>
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>