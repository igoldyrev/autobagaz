<?php echo "<title>Добавление записи в комиссионку</title>";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/authorization/aboutuser.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header-admin.html");

$dbname = "9082410193_zakaz";
include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");


$name = $_POST['name'];
$price = $_POST['price'];
$category = $_POST['category'];

$name = htmlspecialchars($name);
$price = htmlspecialchars($price);
$category = htmlspecialchars($category);

$name = urldecode($name);
$price = urldecode($price);
$category = urldecode($category);

$name = trim($name);
$price = trim($price);
$category = trim($category);

$name = $_REQUEST['name'];
$price = $_REQUEST['price'];
$category = $_REQUEST['category'];

$namemini = strtolower(str_replace(" ", "", $name));

//Функция для транслита русских названий в транслит для ссылок
function translit($str)
{
  $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц',
    'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
  $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', '', '', '', 'e', 'yu', 'ya');
  return str_replace($rus, $lat, $str);
}

$translitname = mb_strtolower(translit($namemini));

$path = '/uploads/komissionka/'; // директория для загрузки

$total = count($_FILES['photos']['name']); //счетчик файлов

//Пустые массивы для хранения переменных img0 - img9 и адресов изображений
$arrimg = array();
$arrurl = array();

//цикл, который заносит адреса загруженных файлов в таблицу БД
for ($i = 0; $i < $total; $i++) {
  $ext = array_pop(explode('.', $_FILES['photos']['name'][$i])); //получение расширения

  //Уникальные номера файлов для избежания перезаписи
  for ($j = 1; $j <= $total; $j++) {

    $rand = rand(0, 200);
    $new_name = $translitname . '-' . date("d-m-Y") . '-' . $rand . '.' . $ext; // новое имя с расширением
  }

  $tmpFilePath = $_FILES['photos']['tmp_name'][$i]; //Получаем временный путь хранения файла

  if ($tmpFilePath != "") {

    // Переносим файл на новое местоположение
    $newFilePath = $_SERVER['DOCUMENT_ROOT'] . $path . $new_name;
    $newpath = $path . $new_name;

    if (move_uploaded_file($tmpFilePath, $newFilePath)) {

      $img = 'komm_items_img' . $i;

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
$url = $translitname . '-' . $dateurlmini . '-' . $randurl;

if ($total == '1') {
  $sql_name = "INSERT INTO komm_items (komm_items_name, $arrimg[0], komm_items_price, komm_items_group, komm_items_status) VALUES ('$name', '$arrurl[0]', '$price', '$category', 'СОЗДАН')";
  mysqli_query($connect, $sql_name);
  $messageSuccess = 'Товар успешно добавлен!';
} elseif ($total == '2') {
  $sql_name = "INSERT INTO komm_items (komm_items_name, $arrimg[0], $arrimg[1], komm_items_price, komm_items_group, komm_items_status) VALUES ('$name', '$arrurl[0]', '$arrurl[1]', '$price', '$category', 'СОЗДАН')";
  mysqli_query($connect, $sql_name);
  $messageSuccess = 'Товар успешно добавлен!';
} elseif ($total == '3') {
  $sql_name = "INSERT INTO komm_items (komm_items_name, $arrimg[0], $arrimg[1], $arrimg[2], komm_items_price, komm_items_group, komm_items_status) VALUES ('$name', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$price', '$category', 'СОЗДАН')";
  mysqli_query($connect, $sql_name);
  $messageSuccess = 'Товар успешно добавлен!';
} elseif ($total == '4') {
  $sql_name = "INSERT INTO komm_items (komm_items_name, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], komm_items_price, komm_items_group, komm_items_status) VALUES ('$name', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$price', '$category', 'СОЗДАН')";
  mysqli_query($connect, $sql_name);
  $messageSuccess = 'Товар успешно добавлен!';
} elseif ($total == '5') {
  $sql_name = "INSERT INTO komm_items (komm_items_name, $arrimg[0], $arrimg[1], $arrimg[2], $arrimg[3], $arrimg[4], komm_items_price, komm_items_group, komm_items_status) VALUES ('$name', '$arrurl[0]', '$arrurl[1]', '$arrurl[2]', '$arrurl[3]', '$arrurl[4]', '$price', '$category', 'СОЗДАН')";
  mysqli_query($connect, $sql_name);
  $messageSuccess = 'Товар успешно добавлен!';
}
?>

<div class="admin__container">
  <h1 class="title title-h1">Добавление записи в Комиссионку</h1>

  <div class="form__container">
    <form action="" method="post" enctype="multipart/form-data">
      <span class="form__label">Введите название товара (например, багажник для Lada Xray):</span>
      <div class="form__input-wrap">
        <input type="text" name="name" required autofocus class="form__input" placeholder="Введите имя товара">
        <label for="name" class="form__label--shown">Введите имя товара</label>
      </div>
      <span class="form__label">Введите цену товара (необязательно):</span>
      <div class="form__input-wrap">
        <input type="text" name="price" class="form__input" placeholder="Введите цену товара">
        <label for="price" class="form__label--shown">Введите цену товара</label>
      </div>
      <span class="form__label">Введите категорию товара (например, автомобильные багажники, фаркопы, корзины):</span>
      <div class="form__input-wrap">
        <input type="text" name="category" class="form__input" placeholder="Введите категорию товара">
        <label for="categoty" class="form__label--shown">Введите категорию товара</label>
      </div>
      <span class="form__label">Выберите фотографии (до 5 штук):</span>
      <div class="form__input-wrap">
        <input type="file" name="photos[]" class="form__input-file" id="photos" multiple="multiple">
        <label for="photos" class="form__label form__label--file">Выбрать фото</label>
      </div>
      <input class='button button__zakaz' id='submit' type='submit' value='Добавить запись'>
    </form>
    <?php
    if (!empty($message)) {
      echo "<p class='good-message good-message--wrong'>" . $message . "</p>";
    } elseif (!empty($messageSuccess)) {
      echo "<p class='good-message'>" . $messageSuccess . "</p>";
    } ?>
  </div>
  <div class="admin__link-wrap clearfix">
    <a class="admin__link" href="/admin/">Вернуться на главную админки</a>
  </div>
</div>
