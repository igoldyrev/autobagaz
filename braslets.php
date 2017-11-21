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
                    <table align="center">
                        <tr><td class="producttable" align="left"><?php echo $braslet['desc1']; ?></td><td class="producttable" align="center"><?php echo $braslet['price1']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $braslet['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $braslet['id1']; ?>">Взять в прокат</a></button></td></tr>
                        <tr><td class="producttable" align="left"><?php echo $braslet['desc2']; ?></td><td class="producttable" align="center"><?php echo $braslet['price2']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $braslet['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $braslet['id2']; ?>">Взять в прокат</a></button></td></tr>
                        <tr><td class="producttable" align="left"><?php echo $braslet['desc3']; ?></td><td class="producttable" align="center"><?php echo $braslet['price3']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $braslet['id3']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $braslet['id3']; ?>">Взять в прокат</a></button></td></tr>
                    </table>
                </div>
            </div>
            <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php"); ?>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>