<?php
include($_SERVER["DOCUMENT_ROOT"] . "/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php");?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html");?>
        <div class="content">
            <?php
            $takelazh = $_GET['takelazh'];
            if (!isset($takelazh)) {
                echo "<title> $titleconst"; echo $keywords[35][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[35][description];      echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[35][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Такелажная продукция</h1>";?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/dynamic_strops" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/dynamic_strops"><img class="item__image-img" src="/images/autotuns/dynamic/1.JPG" alt="динамические стропы"></a>
                        </div>
                        <div class="item__link">
                            <a href="/dynamic_strops">Динамические стропы</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/textil_strops" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/textil_strops"><img class="item__image-img" src="/images/autotuns/textil/3.JPG" alt="текстильные стропы"></a>
                        </div>
                        <div class="item__link">
                            <a href="/textil_strops">Текстильные стропы</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($takelazh == 'dynamic_strops') {
                echo "<title> $titleconst"; echo $keywords[36][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[36][description];      echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[36][keywords]; echo "'/>";

            } elseif ($takelazh == 'textil_strops') {
                echo "<title> $titleconst"; echo $keywords[37][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[37][description];      echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[37][keywords]; echo "'/>";

            }
            ?>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>


