<?php
$text = $_POST['text'];
$text = $_REQUEST['text'];

$name = mb_strtolower(str_replace(" ","",$text));

$path = '/content/gallery/img1/'; // директория для загрузки

$total = count($_FILES['file']['name']); //счетчик файлов

for($i=0; $i<$total; $i++) {
    $ext = array_pop(explode('.',$_FILES['file']['name'][$i])); //получение расширения

    //Уникальные номера файлов
    for ($j=1; $j<=$total; $j++) {

        $rand = rand(0, 50);
        $new_name = $name.'-'.date("d-m-Y").'-'.$rand.$ext ; // новое имя с расширением
    }

    $tmpFilePath = $_FILES['file']['tmp_name'][$i]; //Получаем временный путь хранения файла

    if ($tmpFilePath != ""){

        $newFilePath = $_SERVER['DOCUMENT_ROOT'].$path.$new_name;

        if(move_uploaded_file($tmpFilePath, $newFilePath)) {

            var_dump($newFilePath);
            var_dump($new_name);

            //Здесь писать код для добавления в БД

        }
    }
}