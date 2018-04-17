<?php
include($_SERVER["DOCUMENT_ROOT"] . "/backend/keywords/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
echo "<title> $titleconst"; echo $keywords[13][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[13][description]; echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[13][keywords]; echo "'/>"; ?>

    <div class="wrapper">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
        <div class="wrapper__content">
            <h1 class="title title-h1">Сертификаты и лицензии</h1>
            <div class="sertificates">
                <div class="sertificates__item">
                    <h3 class="title title-h3">Sertificat name</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/BagazhnikAtlant-1.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Sertificat name</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/BagazhnikAtlant-1.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Sertificat name</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/BagazhnikAtlant-1.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Sertificat name</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/BagazhnikAtlant-1.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Sertificat name</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/BagazhnikAtlant-1.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Sertificat name</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/BagazhnikAtlant-1.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>