<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/content/autobagazhniki/backend/keywords.php");
echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[0][description];      echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";
include ($_SERVER["DOCUMENT_ROOT"]."/content/autobagazhniki/backend/array.php");
$_SESSION['autobagazhniki'] = $autobagazhniki;
$_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <h1 class="title title-h1">Автомобильные багажники</h1>
        <p class="text">Проблема перевозки крупногабаритных вещей периодически возникает у каждого автомобилиста. Длинномерные грузы, громоздкие коробки и поклажу неравномерной формы редко удается разместить в стандартном багажнике автомобиля, и они начинают скапливаться в салоне, занимая собой личное пространство пассажиров и водителя. Было создано множество средств для решения этой проблемы, но, пожалуй, самыми известными и привычными из них для нас являются багажники на крышу автомобиля.</p>
        <p class="text">Каждый день в нашем магазине есть 3-10 вариантов различных багажников на любой автомобиль. И для Вашего удобства мы разбили их на категории с обозначением минимальной цены.</p>

    <?php foreach ($autobagazhniki as $item): ?>
    <div class="good">
        <h2 class="title title-h2"><?php echo $item['name']; ?></h2>
        <div class="good__description">
            <div class="img__wrap">
                <?php echo $item['img1']; echo $item['img2']; ?>
            </div>
            <p class="text"><?php echo $item['desc']; ?></p>
        </div>
        <div class="good__price">
            <p class="text"><strong><?php echo $item['price']; ?></strong></p>
            <div class="good__buttons">
                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/product/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $item['id']; ?>" class="button button__buy" >Заказать</a>
                <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $item['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."backend/blocks/counters.html"); ?>