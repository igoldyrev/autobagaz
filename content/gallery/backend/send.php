<?php
$text = $_POST['text'];
$text = $_REQUEST['text'];

$name = mb_strtolower(str_replace(" ","",$text));

$path = '/content/gallery/img1/'; // директория для загрузки

$total = count($_FILES['file']['name']); //счетчик файлов

$dbname = "9082410193_gallery";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

//Пустые массивы для хранения переменных img0 - img9 и адресов изображений
$arrimg = array();
$arrurl = array();

for($i=0; $i<$total; $i++) {
    $ext = array_pop(explode('.',$_FILES['file']['name'][$i])); //получение расширения

    //Уникальные номера файлов
    for ($j=1; $j<=$total; $j++) {

        $rand = rand(0, 50);
        $new_name = $name.'-'.date("d-m-Y").'-'.$rand.'.'.$ext ; // новое имя с расширением
    }

    $tmpFilePath = $_FILES['file']['tmp_name'][$i]; //Получаем временный путь хранения файла

    if ($tmpFilePath != ""){

        echo '<pre>';

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


$date = date("d-m-Y");

$sql_name = "INSERT INTO photos (date, name, $arrimg[0], $arrimg[1]) VALUES ('$date', '$text', '$arrurl[0]', '$arrurl[1]')";
mysqli_query($connect, $sql_name);