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
                    <h3 class="title title-h3">Письмо ГИБДД</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/gibdd.jpg">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Багажники LUX</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/LUX-1.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/LUX-2.jpg">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Багажники Атлант</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/BagazhnikAtlant-1.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/BagazhnikAtlant-2.jpg">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Автобоксы Атлант</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/BoxesAtlant.jpg">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Багажники Delta</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/Delta-1.png">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Delta-2.png">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Baltex</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/Baltex-1.jpg">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Leader Plus</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/LeaderPlus-1.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/LeaderPlus-2.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/LeaderPlus-3.jpg">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Bosal</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/Bosal-01.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Bosal-02.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Bosal-03.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Bosal-04.jpg">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Bosal</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/Bosal-05.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Bosal-06.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Bosal-07.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Bosal-08.jpg">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Bosal</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/Bosal-09.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Bosal-10.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Bosal-11.jpg">
                    </div>
                </div>
                <div class="sertificates__item">
                    <h3 class="title title-h3">Bosal</h3>
                    <div class="sertificates__photos">
                        <img class="img sertificates__img" src="/content/sertificates/Bosal-12.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Bosal-13.jpg">
                        <img class="img sertificates__img sertificates__img--small" src="/content/sertificates/Bosal-14.jpg">
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>