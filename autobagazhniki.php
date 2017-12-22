<?php
include($_SERVER["DOCUMENT_ROOT"] . "/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");
    echo "<title> $titleconst"; echo $keywords[7][title]; echo "</title>";
    echo "<meta name='description' content='"; echo $keywords[7][description];      echo "'/>";
    echo "<meta name='keywords' content='"; echo $keywords[7][keywords]; echo "'/>";

include ($_SERVER["DOCUMENT_ROOT"]."/arrays/autobagazhniki_1.php");
$_SESSION['autobagazhniki'] = $autobagazhniki;
$_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php");?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html"); ?>
        <div class="content">
            <h1 class="page__title-h1">Автомобильные багажники</h1>
            <p class="page__text">Проблема перевозки крупногабаритных вещей периодически возникает у каждого автомобилиста. Длинномерные грузы, громоздкие коробки и поклажу неравномерной формы редко удается разместить в стандартном багажнике автомобиля, и они начинают скапливаться в салоне, занимая собой личное пространство пассажиров и водителя. Было создано множество средств для решения этой проблемы, но, пожалуй, самыми известными и привычными из них для нас являются багажники на крышу автомобиля.</p>
            <p class="page__text">Каждый день в нашем магазине есть 3-10 вариантов различных багажников на любой автомобиль. И для Вашего удобства мы разбили их на категории с обозначением минимальной цены.</p>
            <?php foreach ($autobagazhniki as $item): ?>
            <div class="good">
                <h2 class="good__name"><?php echo $item['name']; ?></h2>
                <div class="good__description">
                    <div class="img_div">
                        <?php echo $item['img1']; echo $item['img2']; ?>
                    </div>
                    <div class="good__text">
                        <p class="page__text"><?php echo $item['desc']; ?></p>
                    </div>
                </div>
                <div class="good__price">
                    <div class="good__price-info">
                        <p class="page__text"><?php echo $item['price']; ?></p>
                    </div>
                    <div class="good__price-button">
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $item['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <p class="page__text">Если вы являетесь гордым обладателем японского, корейского или китайского автомобиля, остальные продавцы разводят руками в подборе оборудования-не отчаивайтесь, наш богатый опыт поможет вам решить данный вопрос быстро и из наличия!</p>
            <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php"); ?>
            </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>