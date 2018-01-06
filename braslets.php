<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/arrays/velokreplenya_array.php");

echo "<title> $titleconst"; echo $keywords[21][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[21][description]; echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[21][keywords]; echo "'/>";?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php");?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html");?>
        <div class="content">
            <?php
            $_SESSION['braslet'] = $braslet;
            $_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>

            <div class="good">
                <h1 class="good__name"><?php echo $braslet['title']; ?></h1>
                <div class="good__description">
                    <div class="img_div">
                        <?php echo $braslet['img']; ?>
                    </div>
                    <div class="good__text">
                        <p class="page__text"><?php echo $braslet['desc']; ?></p>
                    </div></div>
                <div class="good__price">
                    <div class="good__price-info">
                        <span class="page__text"><?php echo $braslet['desc1']; ?> </span><span class="page__text"><strong><?php echo $braslet['price1']; ?></strong></span>
                    </div>
                    <div class="good__price-button">
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $braslet['id1']; ?>" class="button button__buy" >Заказать</a>
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $braslet['id1']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                    </div>
                </div>
                <div class="good__price">
                    <div class="good__price-info">
                        <span class="page__text"><?php echo $braslet['desc2']; ?> </span><span class="page__text"><strong><?php echo $braslet['price2']; ?></strong></span>
                    </div>
                    <div class="good__price-button">
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $braslet['id2']; ?>" class="button button__buy" >Заказать</a>
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $braslet['id2']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                    </div>
                </div>
                <div class="good__price">
                    <div class="good__price-info">
                        <span class="page__text"><?php echo $braslet['desc3']; ?> </span><span class="page__text"><strong><?php echo $braslet['price3']; ?></strong></span>
                    </div>
                    <div class="good__price-button">
                        <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $braslet['id3']; ?>" class="button button__buy" >Заказать</a>
                        <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $braslet['id3']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                    </div>
                </div>
            </div>
            <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php"); ?>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>