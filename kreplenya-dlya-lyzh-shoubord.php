<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/content/lyzhnye-kreplenya/backend/keywords.php");
echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[0][description];      echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";
include ($_SERVER["DOCUMENT_ROOT"]."/content/lyzhnye-kreplenya/backend/array.php");
$_SESSION['lyzhi'] = $lyzhi;
$_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php echo "<h1 class='title title-h1'>Крепления для лыж и сноубордов</h1>";
        echo "<p class='text'>Каждый любитель активного зимнего отдыха неминуемо сталкивается с проблемой транспортировки своего инвентаря. Торчащие изо всех окон лыжи и палки — это, конечно, романтично и очень по-советски, однако вряд ли такой способ перевозки можно назвать удобным, а тем более — оптимальным.</p>";
        echo "<p class='text'>Стандартная длина лыж и сноуборда — около полутора метров, даже в самом просторном салоне перевозить такие большие предметы — значит лишиться комфорта на все время поездки. Стоит ли лишать себя удобства поездки на горнолыжный курорт или просто за город с друзьями? Вовсе нет, если в вашей машине есть специальный багажник для сноуборда или крепление лыж.</p>";
        echo "<p class='text'>Эта простая, но крайне надежная конструкция, будет крепко держать ваш спортивный инвентарь. Лыжи любой фирмы производителя можно установить в крепления за считанные секунды. Багажники для сноуборда устроены таким образом, что сноуборд будет надежно закреплен и не будет колебаться даже на большой скорости и резких поворотах.</p>";
        echo "<p class='text'>Мы предлагаем крепления для лыж и сноубордов следующих производителей:</p>"; ?>
        <div class="good">
            <h2 class="title title-h2"><?php echo $lyzhi[0]['title']; ?></h2>
            <div class="img__wrap">
                <?php echo $lyzhi[0]['img']; ?>
            </div>
            <p class="text"><?php echo $lyzhi[0]['desc']; ?></p>
            <div class="good__price">
                <span class="text"><?php echo $lyzhi[0]['desc34']; ?> </span><span class="text"><strong><?php echo $lyzhi[0]['price34']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lyzhi[0]['id1']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $lyzhi[0]['id1']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
            <div class="good__price">
                <span class="text"><?php echo $lyzhi[0]['desc56']; ?> </span><span class="text"><strong><?php echo $lyzhi[0]['price56']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lyzhi[0]['id2']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $lyzhi[0]['id2']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
        </div>
        <div class="good">
            <h2 class="title title-h2"><?php echo $lyzhi[1]['title']; ?></h2>
            <div class="img__wrap">
                <?php echo $lyzhi[1]['img']; ?>
            </div>
            <p class="text"><?php echo $lyzhi[1]['desc']; ?></p>
            <div class="good__price">
                <span class="text"><?php echo $lyzhi[1]['desc34']; ?> </span><span class="text"><strong><?php echo $lyzhi[1]['price34']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lyzhi[1]['id1']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $lyzhi[1]['id1']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
            <div class="good__price">
                <span class="text"><?php echo $lyzhi[1]['desc56']; ?> </span><span class="text"><strong><?php echo $lyzhi[1]['price56']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lyzhi[1]['id2']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $lyzhi[1]['id2']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
        </div>
        <div class="good">
            <h2 class="title title-h2"><?php echo $lyzhi[2]['title']; ?></h2>
            <div class="img__wrap">
                <?php echo $lyzhi[2]['img']; ?>
            </div>
            <p class="text"><?php echo $lyzhi[2]['desc']; ?></p>
            <div class="good__price">
                <span class="text"><?php echo $lyzhi[2]['desc34']; ?> </span><span class="text"><strong><?php echo $lyzhi[2]['price34']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lyzhi[2]['id1']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $lyzhi[2]['id1']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
            <div class="good__price">
                <span class="text"><?php echo $lyzhi[2]['desc56']; ?> </span><span class="text"><strong><?php echo $lyzhi[2]['price56']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lyzhi[2]['id2']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $lyzhi[2]['id2']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
        </div>
        <div class="good">
            <h2 class="title title-h2"><?php echo $lyzhi[3]['title']; ?></h2>
            <div class="img__wrap">
                <?php echo $lyzhi[3]['img']; ?>
            </div>
            <p class="text"><?php echo $lyzhi[3]['desc']; ?></p>
            <div class="good__price">
                <span class="text"><?php echo $lyzhi[3]['desc34']; ?> </span><span class="text"><strong><?php echo $lyzhi[3]['price34']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lyzhi[3]['id1']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $lyzhi[3]['id1']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
            <div class="good__price">
                <span class="text"><?php echo $lyzhi[3]['desc56']; ?> </span><span class="text"><strong><?php echo $lyzhi[3]['price56']; ?></strong></span>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lyzhi[3]['id2']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $lyzhi[3]['id2']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
        </div>
        <div class="good">
            <h2 class="title title-h2"><?php echo $lyzhi[4]['name']; ?></h2>
            <div class="img__wrap">
                <?php echo $lyzhi[4]['img1']; echo $lyzhi[4]['img2']; echo $lyzhi[4]['img3']; ?>
            </div>
            <p class="text"><?php echo $lyzhi[4]['desc']; ?></p>
            <div class="good__price">
                <p class="text"><strong><?php echo $lyzhi[4]['price']; ?></strong></p>
                <div class="good__buttons">
                    <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $lyzhi[4]['id']; ?>" class="button button__buy" >Заказать</a>
                    <a onclick="yaCounter40650914.reachGoal('click_prokat'); return true" href="/prokat/<?php echo $lyzhi[4]['id']; ?>" class="button button__buy button__buy--prokat">Взять в прокат</a>
                </div>
            </div>
        </div>
        <?php 	include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/helpform.php"); ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>