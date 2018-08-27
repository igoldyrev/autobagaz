<?php
include($_SERVER["DOCUMENT_ROOT"] . "/backend/keywords/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
echo "<title> $titleconst"; echo $keywords[13][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[13][description]; echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[13][keywords]; echo "'/>"; ?>

<div class="wrapper">
  <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/left-nav/left-nav.html"); ?>
  <div class="wrapper__content">
    <h1 class="title title-h1">Сертификаты и лицензии</h1>
    <div class="sertificates">
      <div class="sertificates__item">
        <a href="/content/sertificates/gibdd.jpg" class="link sertificates__link"><i
            class="fa fa-file-text-o sertificates__icon"></i>Письмо ГИБДД</a>
      </div>
      <div class="sertificates__item">
        <a href="/content/sertificates/Delta-1.png" class="link sertificates__link"><i
            class="fa fa-file-text-o sertificates__icon"></i>Багажники Delta</a>
      </div>
      <div class="sertificates__item">
        <a href="/content/sertificates/LUX-1.jpg" class="link sertificates__link"><i
            class="fa fa-file-text-o sertificates__icon"></i>Багажники LUX</a>
        <a href="/content/sertificates/pdf/LUX.pdf" target="_blank" class="link sertificates__link"><i
            class="fa fa-file-pdf-o sertificates__icon sertificates__icon--red"></i>Скачать в PDF</a>
      </div>
      <div class="sertificates__item">
        <a href="/content/sertificates/BagazhnikAtlant-1.jpg" class="link sertificates__link"><i
            class="fa fa-file-text-o sertificates__icon"></i>Багажники Атлант</a>
        <a href="/content/sertificates/pdf/Atlant.pdf" target="_blank" class="link sertificates__link"><i
            class="fa fa-file-pdf-o sertificates__icon sertificates__icon--red"></i>Скачать в PDF</a>
      </div>
      <div class="sertificates__item">
        <a href="/content/sertificates/BoxesAtlant.jpg" class="link sertificates__link"><i
            class="fa fa-file-text-o sertificates__icon"></i>Автобоксы Атлант</a>
        <a href="/content/sertificates/pdf/AtlantBoxes.pdf" target="_blank" class="link sertificates__link"><i
            class="fa fa-file-pdf-o sertificates__icon sertificates__icon--red"></i>Скачать в PDF</a>
      </div>
      <div class="sertificates__item">
        <a href="/content/sertificates/Baltex-1.jpg" class="link sertificates__link"><i
            class="fa fa-file-text-o sertificates__icon"></i>Baltex</a>
        <a href="/content/sertificates/pdf/Baltex.pdf" target="_blank" class="link sertificates__link"><i
            class="fa fa-file-pdf-o sertificates__icon sertificates__icon--red"></i>Скачать в PDF</a>
      </div>
      <div class="sertificates__item">
        <a href="/content/sertificates/LeaderPlus-1.jpg" class="link sertificates__link"><i
            class="fa fa-file-text-o sertificates__icon"></i>Leader Plus</a>
        <a href="/content/sertificates/pdf/LeaderPlus.pdf" target="_blank" class="link sertificates__link"><i
            class="fa fa-file-pdf-o sertificates__icon sertificates__icon--red"></i>Скачать в PDF</a>
      </div>
      <div class="sertificates__item">
        <a href="/content/sertificates/Baltex-1.jpg" class="link sertificates__link"><i
            class="fa fa-file-text-o sertificates__icon"></i>Bosal</a>
        <a href="/content/sertificates/pdf/Bosal.pdf" target="_blank" class="link sertificates__link"><i
            class="fa fa-file-pdf-o sertificates__icon sertificates__icon--red"></i>Скачать в PDF</a>
      </div>
    </div>
  </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
