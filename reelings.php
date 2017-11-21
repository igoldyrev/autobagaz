<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");

echo "<title> $titleconst"; echo $keywords[20][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[20][description]; echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[20][keywords]; echo "'/>"; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php");?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html");?>
        <div class="content">
            <?php
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];

            echo "<h1 class='page__title-h1'>Рейлинги</h1>";
            echo "<p class='page__text'>Автомобиль должен быть не только функциональным, но и красивым, должен радовать глаз. С этим утверждением сегодня согласится, наверное, каждый. Тем более сейчас, когда автомобилей на дорогах стало особенно много. Придать облику вашего авто законченность и спортивную элегантность, подчеркнуть его сдержанную энергию, полную внутренней силы, способна такая незначительная на первый взгляд деталь как рейлинги на крыше автомобиля. Редкий водитель доволен объемом багажного отделения своего автомобиля. Но - благодаря рейлингам - даже малолитражка (не говоря уже о внедорожниках или машинах «средней ценовой категории») может перевозить куда большие объемы груза, чем было заложено конструкторами. Таким образом, решительно для любого автомобиля рейлинги - это необходимость, а часто и одно из условий, позволяющее установить на авто багажники: как стандартные, так и герметичные удобные боксы.</p>";
            echo "<h2 class='page__title-h2'>Мы предлагаем рейлинги двух проихводителей: Voyager и Can (Турция)</h2>"; ?>
            <div class="img_div">
                <img class="img_main" src="/images/reelings/can.jpg" srcset="/images/reelings/can.jpg 300w" alt="Can" sizes="(max-width: 2000px) 150px, 300px, 350px">
                <img class="img_main" src="/images/reelings/voyager.jpg" srcset="/images/reelings/voyager.jpg 300w" alt="Voyager" sizes="(max-width: 2000px) 150px, 300px, 350px">
            </div>
            <p class="page__text"><b>Цена 12 500 рублей</b></p>
            <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php"); ?>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>