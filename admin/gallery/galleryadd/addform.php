<?php echo "<title>Добавление записи в галерею</title>";
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php"); ?>

<div class="admin__container">
    <h1 class="title title-h1">Добавление записи в галерею</h1>

    <?php
    $dbname = "9082410193_gallery";

    include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php"); ?>

    <div class="form__container">
        <form action="/admin/gallery/galleryadd/addpost" method="post" enctype="multipart/form-data">
            <span class="form__label">Введите название записи (например, Lada Xray):</span>
            <div class="form__input-wrap">
                <input type="text" name="name" required autofocus class="form__input" placeholder="Введите имя записи">
                <label for="name" class="form__label--shown">Введите имя записи</label>
            </div>
            <p class="text">Введите 2-3 ключевых слова, по одному в каждое поле ниже:</p>
            <span class="form__label">Введите первое ключевое слово (например, Opel Mokka):</span>
            <div class="form__input-wrap">
                <input type="text" name="tagone" class="form__input" placeholder="Введите первое ключевое слово">
                <label for="tagone" class="form__label--shown">Введите первое ключевое слово</label>
            </div>
            <span class="form__label">Введите второе ключевое слово (например, Vetlan 550M):</span>
            <div class="form__input-wrap">
                <input type="text" name="tagtwo" class="form__input" placeholder="Введите второе ключевое слово">
                <label for="tagtwo" class="form__label--shown">Введите второе ключевое слово</label>
            </div>
            <span class="form__label">Введите третье ключевое слово (например, Д-1):</span>
            <div class="form__input-wrap">
                <input type="text" name="tagthree" class="form__input" placeholder="Введите третье ключевое слово (необязательно)">
                <label for="tagthree" class="form__label--shown">Введите третье ключевое слово</label>
            </div>

            <input type="file" name="file[]" id="file" multiple="multiple">
            <input class='button button__zakaz' id='submit' type='submit' value='Добавить запись'>
        </form>
    </div>
    <div class="admin__link-wrap clearfix">
        <a class="admin__link" href="/admin/index.php">Вернуться на главную админки</a>
    </div>
</div>