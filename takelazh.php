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
                        <a href="/takelazh/dynamic_strops" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/takelazh/dynamic_strops"><img class="item__image-img" src="/images/autotuns/dynamic/1.JPG" alt="динамические стропы"></a>
                        </div>
                        <div class="item__link">
                            <a href="/takelazh/dynamic_strops">Динамические стропы</a>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/takelazh/textil_strops" class="catalog__item-link"></a>
                        <div class="item__image">
                            <a href="/takelazh/textil_strops"><img class="item__image-img" src="/images/autotuns/textil/3.JPG" alt="текстильные стропы"></a>
                        </div>
                        <div class="item__link">
                            <a href="/takelazh/textil_strops">Текстильные стропы</a>
                        </div>
                    </div>
                </div> <?php
            } elseif ($takelazh == 'dynamic_strops') {
                echo "<title> $titleconst"; echo $keywords[36][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[36][description];      echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[36][keywords]; echo "'/>";

            echo "<h1 class='page__title-h1'>Динамические стропы</h1>";
            echo "<p class='page__text'>Динамический строп предназначен для эвакуации транспортных средств за счет значительной силы инерции. Основное отличие от текстильной стропы, быстрое восстановление после растяжения.</p>"; ?>
            <div class="img_div">
                <img class="img_main" src="/images/autotuns/dynamic/1.JPG" srcset="/images/autotuns/dynamic/1.JPG 4000w" alt="динамические стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                <img class="img_main" src="/images/autotuns/dynamic/2.JPG" srcset="/images/autotuns/dynamic/2.JPG 4000w" alt="динамические стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                <img class="img_main" src="/images/autotuns/dynamic/3.JPG" srcset="/images/autotuns/dynamic/3.JPG 4000w" alt="динамические стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                <img class="img_main" src="/images/autotuns/dynamic/4.JPG" srcset="/images/autotuns/dynamic/4.JPG 4000w" alt="динамические стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                <img class="img_main" src="/images/autotuns/dynamic/5.JPG" srcset="/images/autotuns/dynamic/5.JPG 4000w" alt="динамические стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                <img class="img_main" src="/images/autotuns/dynamic/6.JPG" srcset="/images/autotuns/dynamic/6.JPG 4000w" alt="динамические стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                <img class="img_main" src="/images/autotuns/dynamic/7.JPG" srcset="/images/autotuns/dynamic/7.JPG 4000w" alt="динамические стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
            </div>
            <p class="page__text">Имеются в наличии стропы с разрывом на 4 т (а/м до 1,4 т), 7 т (для а/м 1,8 т), 8 т (для а/м 1,8 т), 9 т (для а/м 1,5-2,5 т), 10 т (для а/м 1,8 т), 12 т (для а/м 2-3 т) и 15 т (для а/м 3 - 4 т)</p>
            <p class="page__text">Также для строп предлагается сумка для удобного хранения и перевозки.</p>
            <div class="img_div">
                <img class="img_main" src="/images/autotuns/bug/1.jpg" srcset="/images/autotuns/bug/1.jpg 1000w" alt="сумка-перевозка" sizes="(max-width: 2000px) 150px, 300px, 350px">
                <img class="img_main" src="/images/autotuns/bug/2.jpg" srcset="/images/autotuns/bug/2.jpg 1000w" alt="сумка-перевозка" sizes="(max-width: 2000px) 150px, 300px, 350px">
                <img class="img_main" src="/images/autotuns/bug/3.jpg" srcset="/images/autotuns/bug/3.jpg 1000w" alt="сумка-перевозка" sizes="(max-width: 2000px) 150px, 300px, 350px">
            </div>
            <p class="page__text">Цены на данную продукцию Вы можете узнать <a class="page__link" href="tel:+73422889969">по телефону</a> или заполнив форму ниже на этой же странице.</p> <?php
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } elseif ($takelazh == 'textil_strops') {
                echo "<title> $titleconst"; echo $keywords[37][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[37][description];      echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[37][keywords]; echo "'/>";

                echo "<h1 class='page__title-h1'>Текстильные стропы</h1>"; ?>
                <div class="img_div">
                    <img class="img_main" src="/images/autotuns/textil/1.jpg" srcset="/images/autotuns/textil/1.jpg 4000w" alt="текстильные стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/autotuns/textil/2.JPG" srcset="/images/autotuns/textil/2.JPG 4000w" alt="текстильные стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/autotuns/textil/3.JPG" srcset="/images/autotuns/textil/3.JPG 4000w" alt="текстильные стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/autotuns/textil/4.JPG" srcset="/images/autotuns/textil/4.JPG 4000w" alt="текстильные стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/autotuns/textil/5.JPG" srcset="/images/autotuns/textil/5.JPG 4000w" alt="текстильные стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/autotuns/textil/6.JPG" srcset="/images/autotuns/textil/6.JPG 4000w" alt="текстильные стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/autotuns/textil/7.JPG" srcset="/images/autotuns/textil/7.JPG 4000w" alt="текстильные стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/autotuns/textil/8.JPG" srcset="/images/autotuns/textil/8.JPG 4000w" alt="текстильные стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/autotuns/textil/9.JPG" srcset="/images/autotuns/textil/9.JPG 4000w" alt="текстильные стропы" sizes="(max-width: 2000px) 150px, 300px, 350px">
                </div>
                <p class="page__text">Имеются в наличии стропы с разрывом на 1 т, 2 т, 3 т, 4 т, 5 т, 6 т, 8 т и 10 т. </p>
                <p class="page__text">Цены на данную продукцию Вы можете узнать <a class="page__link" href="tel:+73422889969">по телефону</a> или заполнив форму ниже на этой же странице.</p> <?php
                include ($_SERVER["DOCUMENT_ROOT"]."/modules/forms/helpform.php");
            } ?>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>


