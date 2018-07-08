<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/takelazh/backend/keywords.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php
        $takelazh = $_GET['takelazh'];
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];

        if (!isset($takelazh)) {
            echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
            echo "<meta name='description' content='"; echo $keywords[0][description];      echo "'/>";
            echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Такелажная продукция</h1>";?>
                <div class="catalog">
                    <div class="catalog__item">
                        <a href="/takelazh/dynamic_strops" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <img class="catalog__image" src="/content/takelazh/img/dynamic/1.JPG" alt="динамические стропы">
                        </div>
                        <div class="catalog__text">
                            <p class="text">Динамические стропы</p>
                        </div>
                    </div>
                    <div class="catalog__item">
                        <a href="/takelazh/textil_strops" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <a href="/takelazh/textil_strops"><img class="catalog__image" src="/content/takelazh/img/textil/3.JPG" alt="текстильные стропы"></a>
                        </div>
                        <div class="catalog__text">
                            <p class="text">Текстильные стропы</p>
                        </div>
                    </div>
                </div> <?php
            } elseif ($takelazh == 'dynamic_strops') {
                echo "<title> $titleconst"; echo $keywords[1][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[1][description];      echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[1][keywords]; echo "'/>";

            echo "<h1 class='title title-h1'>Динамические стропы</h1>";
            echo "<p class='text'>Динамический строп предназначен для эвакуации транспортных средств за счет значительной силы инерции. Основное отличие от текстильной стропы, быстрое восстановление после растяжения.</p>"; ?>
            <div class="img__wrap">
                <img class="img good__img" src="/content/takelazh/img/dynamic/1.JPG" alt="динамические стропы">
                <img class="img good__img" src="/content/takelazh/img/dynamic/2.JPG" alt="динамические стропы">
                <img class="img good__img" src="/content/takelazh/img/dynamic/3.JPG" alt="динамические стропы">
                <img class="img good__img" src="/content/takelazh/img/dynamic/4.JPG" alt="динамические стропы">
                <img class="img good__img" src="/content/takelazh/img/dynamic/5.JPG" alt="динамические стропы">
                <img class="img good__img" src="/content/takelazh/img/dynamic/6.JPG" alt="динамические стропы">
                <img class="img good__img" src="/content/takelazh/img/dynamic/7.JPG" alt="динамические стропы">
            </div>
            <p class="text">Имеются в наличии стропы с разрывом на 4 т (а/м до 1,4 т), 7 т (для а/м 1,8 т), 8 т (для а/м 1,8 т), 9 т (для а/м 1,5-2,5 т), 10 т (для а/м 1,8 т), 12 т (для а/м 2-3 т) и 15 т (для а/м 3 - 4 т)</p>
            <p class="text">Также для строп предлагается сумка для удобного хранения и перевозки.</p>
            <div class="img__wrap">
                <img class="img good__img" src="/content/takelazh/img/bug/1.jpg" alt="сумка-перевозка">
                <img class="img good__img" src="/content/takelazh/img/bug/2.jpg" alt="сумка-перевозка">
                <img class="img good__img" src="/content/takelazh/img/bug/3.jpg" alt="сумка-перевозка">
            </div>
            <p class="text">Цены на данную продукцию Вы можете узнать <a class="link" href="tel:+73422889969">по телефону</a> или заполнив форму ниже на этой же странице.</p>
            <?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } elseif ($takelazh == 'textil_strops') {
                echo "<title> $titleconst"; echo $keywords[2][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[2][description];      echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[2][keywords]; echo "'/>";

                echo "<h1 class='title title-h1'>Текстильные стропы</h1>"; ?>
                <div class="img__wrap">
                    <img class="img good__img" src="/content/takelazh/img/textil/1.jpg" alt="текстильные стропы">
                    <img class="img good__img" src="/content/takelazh/img/textil/2.JPG" alt="текстильные стропы">
                    <img class="img good__img" src="/content/takelazh/img/textil/3.JPG" alt="текстильные стропы">
                    <img class="img good__img" src="/content/takelazh/img/textil/4.JPG" alt="текстильные стропы">
                    <img class="img good__img" src="/content/takelazh/img/textil/5.JPG" alt="текстильные стропы">
                    <img class="img good__img" src="/content/takelazh/img/textil/6.JPG" alt="текстильные стропы">
                    <img class="img good__img" src="/content/takelazh/img/textil/7.JPG" alt="текстильные стропы">
                    <img class="img good__img" src="/content/takelazh/img/textil/8.JPG" alt="текстильные стропы">
                    <img class="img good__img" src="/content/takelazh/img/textil/9.JPG" alt="текстильные стропы">
                </div>
                <p class="text">Имеются в наличии стропы с разрывом на 1 т, 2 т, 3 т, 4 т, 5 т, 6 т, 8 т и 10 т. </p>
                <p class="text">Цены на данную продукцию Вы можете узнать <a class="link" href="tel:+73422889969">по телефону</a> или заполнив форму ниже на этой же странице.</p>
            <?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php");
            } ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>


