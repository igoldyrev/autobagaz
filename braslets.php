<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
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
        <h1 class="title title-h1"><?php echo $braslet['title']; ?></h1>
        <p class="text"><?php echo $braslet['desc']; ?></p>
        <div class="good">
            <h2 class="title title-h2"><?php echo $braslet['name1']; ?></h2>
            <div class="good__description">
                <div class="img__wrap">
                    <?php echo $braslet['img1']; echo $braslet['img2']; echo $braslet['img3']; ?>
                </div>
            </div>
            <div class="good__price">
                <span class="text"><?php echo $braslet['desc1']; ?> <span class="text"<?php echo $styleprice ?>><strong><?php echo $braslet['price1']; ?></strong></span></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $braslet['id1']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $braslet['id1']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
        </div>
        <div class="good">
            <h2 class="title title-h2"><?php echo $braslet['name2']; ?></h2>
            <div class="good__description">
                <div class="img__wrap">
                    <?php echo $braslet['img4']; echo $braslet['img5']; ?>
                </div>
            </div>
            <div class="good__price">
                <span class="text"><?php echo $braslet['desc2']; ?> <span class="text"<?php echo $styleprice ?>><strong><?php echo $braslet['price2']; ?></strong></span></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $braslet['id2']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $braslet['id2']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
        </div>
        <div class="good">
            <h2 class="title title-h2"><?php echo $braslet['name3']; ?></h2>
            <div class="good__description">
                <div class="img__wrap">
                    <?php echo $braslet['img4']; echo $braslet['img5']; ?>
                </div>
            </div>
            <div class="good__price">
                <span class="text"><?php echo $braslet['desc3']; ?> <span class="text"<?php echo $styleprice ?>><strong><?php echo $braslet['price3']; ?></strong></span></span>
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