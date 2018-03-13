<?php
$path = '/content/gallery/img1/'; // директория для загрузки
$ext = array_pop(explode('.',$_FILES['file']['name'])); // расширение
$new_name = time().'.'.$ext; // новое имя с расширением
$full_path = $path.$new_name; // полный путь с новым именем и расширением
echo "<pre>";
echo var_dump($_FILES['file']);
echo "</pre>";

if($_FILES['file']['error'] == 0){

    if(move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$full_path)){

        var_dump($_FILES['file']);

        echo '<br>';
        echo $full_path;
        echo '<br>';
        echo $new_name;

        // Если файл успешно загружен, то вносим в БД
        // Можно сохранить $full_path (полный путь) или просто имя файла - $new_name
    }
}