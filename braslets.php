<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/content/braslets/backend/keywords.php");
echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[0][description];      echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";
include ($_SERVER["DOCUMENT_ROOT"]."/content/braslets/backend/array.php");
$_SESSION['braslet'] = $braslet;
$_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <div class="good">
            <h1 class="title title-h1"><?php echo $braslet['title']; ?></h1>
            <div class="good__description">
                <div class="img__wrap">
                    <?php echo $braslet['img']; ?>
                </div>
                <p class="text"><?php echo $braslet['desc']; ?></p>
            </div>
            <div class="good__price">
                <span class="text"><?php echo $braslet['desc1']; ?> </span><span class="text"><strong><?php echo $braslet['price1']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $braslet['id1']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $braslet['id1']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
            <div class="good__price">
                <span class="text"><?php echo $braslet['desc2']; ?> </span><span class="text"><strong><?php echo $braslet['price2']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $braslet['id2']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $braslet['id2']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
            <div class="good__price">
                <span class="page__text"><?php echo $braslet['desc3']; ?> </span><span class="page__text"><strong><?php echo $braslet['price3']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $braslet['id3']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $braslet['id3']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
        </div>
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php"); ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>