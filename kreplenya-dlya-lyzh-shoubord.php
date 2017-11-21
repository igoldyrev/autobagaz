<?php
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/arrays/velokreplenya_array.php");

    echo "<title> $titleconst"; echo $keywords[19][title]; echo "</title>";
    echo "<meta name='description' content='"; echo $keywords[19][description]; echo "'/>";
    echo "<meta name='keywords' content='"; echo $keywords[19][keywords]; echo "'/>"; ?>
<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php");?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html");?>
        <div class="content">
            <?php
            $_SESSION['lyzhi'] = $lyzhi;
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];

            echo "<h1 class='page__title-h1'>Крепления для лыж и сноубордов</h1>";
            echo "<p class='page__text'>Каждый любитель активного зимнего отдыха неминуемо сталкивается с проблемой транспортировки своего инвентаря. Торчащие изо всех окон лыжи и палки — это, конечно, романтично и очень по-советски, однако вряд ли такой способ перевозки можно назвать удобным, а тем более — оптимальным.</p>";
            echo "<p class='page__text'>Стандартная длина лыж и сноуборда — около полутора метров, даже в самом просторном салоне перевозить такие большие предметы — значит лишиться комфорта на все время поездки. Стоит ли лишать себя удобства поездки на горнолыжный курорт или просто за город с друзьями? Вовсе нет, если в вашей машине есть специальный багажник для сноуборда или крепление лыж.</p>";
            echo "<p class='page__text'>Эта простая, но крайне надежная конструкция, будет крепко держать ваш спортивный инвентарь. Лыжи любой фирмы производителя можно установить в крепления за считанные секунды. Багажники для сноуборда устроены таким образом, что сноуборд будет надежно закреплен и не будет колебаться даже на большой скорости и резких поворотах.</p>";
            echo "<p class='page__text'>Мы предлагаем крепления для лыж и сноубордов следующих производителей:</p>"; ?>

            <div class="good">
                <h2 class="good__name"><?php echo $lyzhi[0]['title']; ?></h2>
                <div class="good__description">
                    <div class="img_div">
                        <?php echo $lyzhi[0]['img']; ?>
                    </div>
                    <div class="good__text">
                        <p><?php echo $lyzhi[0]['desc']; ?></p>
                    </div></div>
                <div class="good__price">
                    <div class="good__price-info">
                        <table align="center">
                            <tr><td class="producttable" align="left"><?php echo $lyzhi[0]['desc34']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[0]['price34']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $lyzhi[0]['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $lyzhi[0]['id1']; ?>">Взять в прокат</a></button></td></tr>
                            <tr><td class="producttable" align="left"><?php echo $lyzhi[0]['desc56']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[0]['price56']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $lyzhi[0]['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $lyzhi[0]['id2']; ?>">Взять в прокат</a></button></td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="good">
                <h2 class="good__name"><?php echo $lyzhi[1]['title']; ?></h2>
                <div class="good__description">
                    <div class="img_div">
                        <?php echo $lyzhi[1]['img']; ?>
                    </div>
                    <div class="good__text">
                        <p><?php echo $lyzhi[1]['desc']; ?></p>
                    </div></div>
                <div class="good__price">
                    <div class="good__price-info">
                        <table align="center">
                            <tr><td class="producttable" align="left"><?php echo $lyzhi[1]['desc34']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[1]['price34']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $lyzhi[1]['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $lyzhi[1]['id1']; ?>">Взять в прокат</a></button></td></tr>
                            <tr><td class="producttable" align="left"><?php echo $lyzhi[1]['desc56']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[1]['price56']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $lyzhi[1]['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $lyzhi[1]['id2']; ?>">Взять в прокат</a></button></td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="good">
                <h2 class="good__name"><?php echo $lyzhi[2]['title']; ?></h2>
                <div class="good__description">
                    <div class="img_div">
                        <?php echo $lyzhi[2]['img']; ?>
                    </div>
                    <div class="good__text">
                        <p><?php echo $lyzhi[2]['desc']; ?></p>
                    </div></div>
                <div class="good__price">
                    <div class="good__price-info">
                        <table align="center">
                            <tr><td class="producttable" align="left"><?php echo $lyzhi[2]['desc34']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[2]['price34']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $lyzhi[2]['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $lyzhi[2]['id1']; ?>">Взять в прокат</a></button></td></tr>
                            <tr><td class="producttable" align="left"><?php echo $lyzhi[2]['desc56']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[2]['price56']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $lyzhi[2]['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $lyzhi[2]['id2']; ?>">Взять в прокат</a></button></td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="good">
                <h2 class="good__name"><?php echo $lyzhi[3]['title']; ?></h2>
                <div class="good__description">
                    <div class="img_div">
                        <?php echo $lyzhi[3]['img']; ?>
                    </div>
                    <div class="good__text">
                        <p><?php echo $lyzhi[3]['desc']; ?></p>
                    </div></div>
                <div class="good__price">
                    <div class="good__price-info">
                        <table align="center">
                            <tr><td class="producttable" align="left"><?php echo $lyzhi[3]['desc34']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[3]['price34']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $lyzhi[3]['id1']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $lyzhi[3]['id1']; ?>">Взять в прокат</a></button></td></tr>
                            <tr><td class="producttable" align="left"><?php echo $lyzhi[3]['desc56']; ?></td><td class="producttable" align="center"><?php echo $lyzhi[3]['price56']; ?></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $lyzhi[3]['id2']; ?>">Заказать</a></button></td><td class="producttable" align="center"><button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $lyzhi[3]['id2']; ?>">Взять в прокат</a></button></td></tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="good">
                <h2 class="good__name"><?php echo $lyzhi[4]['name']; ?></h2>
                <div class="good__description">
                    <div class="img_div">
                        <?php echo $lyzhi[4]['img1']; echo $lyzhi[4]['img2']; echo $lyzhi[4]['img3']; ?>
                    </div>
                    <div class="good__text">
                        <p><?php echo $lyzhi[4]['desc']; ?></p>
                    </div></div>
                <div class="good__price">
                    <div class="good__price-info">
                        <p><?php echo $lyzhi[4]['price']; ?></p>
                    </div>
                    <div class="good__price-button">
                        <button onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" class="button__buy"><a class="button__buy-link" href="/buy/<?php echo $lyzhi[4]['id']; ?>">Заказать</a></button>
                        <button onclick="yaCounter40650914.reachGoal('click_prokat'); return true" class="button__buy button__buy--prokat"><a class="button__buy-link" href="/prokat/<?php echo $lyzhi[4]['id']; ?>">Взять в прокат</a></button>
                    </div>
                </div>
            </div>
            <?php 	include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php"); ?>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>