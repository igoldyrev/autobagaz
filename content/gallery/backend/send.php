<?php
$text = $_POST['text'];
$text = $_REQUEST['text'];

$name = mb_strtolower(str_replace(" ","",$text));

$path = '/content/gallery/img1/'; // директория для загрузки

$total = count($_FILES['file']['name']); //счетчик файлов
var_dump($total);
echo $total;

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

if ($total == '1') {

$sql_name = "INSERT INTO photos (date, name, $arrimg[0]) VALUES ('$date')";
mysqli_query($connect, $sql_name);

}elseif ($total == '2') {

    $sql_name = "INSERT INTO photos (date, name, $arrimg[0], $arrimg[1]) VALUES ('$date', '$text', '$arrurl[0]', '$arrurl[1]')";
    mysqli_query($connect, $sql_name);

}elseif ($total == '3') {

    $sql_name = "INSERT INTO photos (date, name, $arrimg[0], $arrimg[1], $arrimg[2]) VALUES ('$date', '$text', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]')";
    mysqli_query($connect, $sql_name);

}elseif ($total == '4') {

    $sql_name = "INSERT INTO photos (date, name, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3]) VALUES ('$date', '$text', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]')";
    mysqli_query($connect, $sql_name);

}elseif ($total == '5') {

    $sql_name = "INSERT INTO photos (date, name, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4]) VALUES ('$date', '$text', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]')";
    mysqli_query($connect, $sql_name);

}elseif ($total == '6') {

    $sql_name = "INSERT INTO photos (date, name, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], $arrimg[5]) VALUES ('$date', '$text', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$arrurl[5]')";
    mysqli_query($connect, $sql_name);

}elseif ($total == '7') {

    $sql_name = "INSERT INTO photos (date, name, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], $arrimg[5], $arrimg[6]) VALUES ('$date', '$text', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$arrurl[5]', '$arrurl[6]')";
    mysqli_query($connect, $sql_name);

}elseif ($total == '8') {

    $sql_name = "INSERT INTO photos (date, name, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], $arrimg[5], $arrimg[6], $arrimg[7]) VALUES ('$date', '$text', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$arrurl[5]', '$arrurl[6]', '$arrurl[7]')";
    mysqli_query($connect, $sql_name);

}elseif ($total == '9') {

    $sql_name = "INSERT INTO photos (date, name, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], $arrimg[5], $arrimg[6], $arrimg[7], $arrimg[8]) VALUES ('$date', '$text', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$arrurl[5]', '$arrurl[6]', '$arrurl[7]', '$arrurl[8]')";
    mysqli_query($connect, $sql_name);

}elseif ($total == '10') {

    $sql_name = "INSERT INTO photos (date, name, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], $arrimg[5], $arrimg[6], $arrimg[7], $arrimg[8], $arrimg[9]) VALUES ('$date', '$text', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$arrurl[5]', '$arrurl[6]', '$arrurl[7]', '$arrurl[8]', '$arrurl[9]')";
    mysqli_query($connect, $sql_name);

}