<?php
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/keywords/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
echo "<title> $titleconst"; echo $keywords[2][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[2][description]; echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[2][keywords]; echo "'/>";
include ($_SERVER["DOCUMENT_ROOT"]."/content/gallery/backend/pages-array.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/gallery/backend/gallery-array.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php echo "<h1 class='title title-h1'>Галерея работ</h1>";

        $auto = $_GET['auto'];

        if (!isset($auto)) {
            echo "<p class='text'>В этом разделе приведены фотографии наших клиентов, которые когда-либо приобретали у нас багажник или автобокс. Как Вы видите, у нас действительно есть выбор практически на любой автомобиль!</p>"; ?>

            <div class="catalog">
                <?php foreach ($pages as $block): ?>

                    <div class="catalog__item">
                        <a href="gallery?auto=<?php echo $block['pagename']; ?>" class="catalog__item-link"></a>
                        <div class="catalog__image-wrap">
                            <?php echo $block['img']; ?>
                        </div>
                        <div class="catalog__text">
                            <p class="text"><?php echo $block['name']; ?></p>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div> <?php

        } elseif ($auto == 'xray0303') { ?>
        <h3 class="title title-h3"><?php
            echo $gallery[0][name]; ?> </h3>
            <div class="img__wrap"> <?php
                echo $gallery[0][img1];
                echo $gallery[0][img2];
                echo $gallery[0][img3];
                echo $gallery[0][img4];
                echo $gallery[0][img5];
                echo $gallery[0][img6];
                echo $gallery[0][img7];
                echo $gallery[0][img8]; ?>
            </div><?php

        } elseif ($auto == 'bmwx5') {?>
        <h3 class="title title-h3"> <?php
            echo $gallery[1][name]; ?> </h3>
            <div class="img__wrap"> <?php
                echo $gallery[1][img1];
                echo $gallery[1][img2];
                echo $gallery[1][img3];
                echo $gallery[1][img4];
                echo $gallery[1][img5];
                echo $gallery[1][img6];
                echo $gallery[1][img7];
                echo $gallery[1][img8]; ?>
            </div> <?php
        } elseif ($auto == 'mazdampv') { ?>
        <h3 class="title title-h3"> <?php
            echo $gallery[2][name]; ?> </h3>
            <div class="img__wrap"> <?php
                echo $gallery[2][img1];
                echo $gallery[2][img2];
                echo $gallery[2][img3];
                echo $gallery[2][img4];
                echo $gallery[2][img5];
                echo $gallery[2][img6];
                echo $gallery[2][img7];
                echo $gallery[2][img8]; ?>
            </div> <?php

        } elseif ($auto == 'uazpatriot') { ?>
        <h3 class="title title-h3"> <?php echo $gallery[3][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[3][img1];
                echo $gallery[3][img2];
                echo $gallery[3][img3];
                echo $gallery[3][img4];
                echo $gallery[3][img5];
                echo $gallery[3][img6];
                echo $gallery[3][img7];
                echo $gallery[3][img8];
                echo '</div>';
        } elseif ($auto == 'wvjetta') {
            ?> <h3 class="title title-h3"> <?php echo $gallery[4][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[4][img1];
                echo $gallery[4][img2];
                echo $gallery[4][img3];
                echo $gallery[4][img4];
                echo $gallery[4][img5];
                echo $gallery[4][img6];
                echo $gallery[4][img7];
                echo $gallery[4][img8];
                echo '</div>';
        } elseif ($auto == 'xtrail') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[5][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[5][img1];
                echo $gallery[5][img2];
                echo $gallery[5][img3];
                echo $gallery[5][img4];
                echo $gallery[5][img5];
                echo $gallery[5][img6];
                echo $gallery[5][img7];
                echo $gallery[5][img8];
                echo '</div>';
        } elseif ($auto == 'lada2111') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[6][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[6][img1];
                echo $gallery[6][img2];
                echo $gallery[6][img3];
                echo $gallery[6][img4];
                echo $gallery[6][img5];
                echo $gallery[6][img6];
                echo $gallery[6][img7];
                echo $gallery[6][img8];
                echo '</div>';
        } elseif ($auto == 'ladalargus') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[7][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[7][img1];
                echo $gallery[7][img2];
                echo $gallery[7][img3];
                echo $gallery[7][img4];
                echo $gallery[7][img5];
                echo $gallery[7][img6];
                echo $gallery[7][img7];
                echo $gallery[7][img8];
                echo '</div>';
        } elseif ($auto == 'focus2') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[8][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[8][img1];
                echo $gallery[8][img2];
                echo $gallery[8][img3];
                echo $gallery[8][img4];
                echo $gallery[8][img5];
                echo $gallery[8][img6];
                echo $gallery[8][img7];
                echo $gallery[8][img8];
                echo '</div>';
        } elseif ($auto == 'seed') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[9][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[9][img1];
                echo $gallery[9][img2];
                echo $gallery[9][img3];
                echo $gallery[9][img4];
                echo $gallery[9][img5];
                echo $gallery[9][img6];
                echo $gallery[9][img7];
                echo $gallery[9][img8];
                echo '</div>';
        } elseif ($auto == 'xray0602') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[10][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[10][img1];
                echo $gallery[10][img2];
                echo $gallery[10][img3];
                echo $gallery[10][img4];
                echo $gallery[10][img5];
                echo $gallery[10][img6];
                echo $gallery[10][img7];
                echo $gallery[10][img8];
                echo '</div>';
        } elseif ($auto == 'chevrolet') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[11][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[11][img1];
                echo $gallery[11][img2];
                echo $gallery[11][img3];
                echo $gallery[11][img4];
                echo $gallery[11][img5];
                echo $gallery[11][img6];
                echo $gallery[11][img7];
                echo $gallery[11][img8];
                echo '</div>';
        } elseif ($auto == 'kiario') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[12][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[12][img1];
                echo $gallery[12][img2];
                echo $gallery[12][img3];
                echo $gallery[12][img4];
                echo $gallery[12][img5];
                echo $gallery[12][img6];
                echo $gallery[12][img7];
                echo $gallery[12][img8];
                echo '</div>';
        } elseif ($auto == 'lada2107') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[13][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[13][img1];
                echo $gallery[13][img2];
                echo $gallery[13][img3];
                echo $gallery[13][img4];
                echo $gallery[13][img5];
                echo $gallery[13][img6];
                echo $gallery[13][img7];
                echo $gallery[13][img8];
                echo '</div>';
        } elseif ($auto == 'lancer') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[14][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[14][img1];
                echo $gallery[14][img2];
                echo $gallery[14][img3];
                echo $gallery[14][img4];
                echo $gallery[14][img5];
                echo $gallery[14][img6];
                echo $gallery[14][img7];
                echo $gallery[14][img8];
                echo '</div>';
        } elseif ($auto == 'outback') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[15][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[15][img1];
                echo $gallery[15][img2];
                echo $gallery[15][img3];
                echo $gallery[15][img4];
                echo $gallery[15][img5];
                echo $gallery[15][img6];
                echo $gallery[15][img7];
                echo $gallery[15][img8];
                echo '</div>';
        } elseif ($auto == '21110621') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[16][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[16][img1];
                echo $gallery[16][img2];
                echo $gallery[16][img3];
                echo $gallery[16][img4];
                echo $gallery[16][img5];
                echo $gallery[16][img6];
                echo $gallery[16][img7];
                echo $gallery[16][img8];
                echo '</div>';
        } elseif ($auto == 'polo') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[17][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[17][img1];
                echo $gallery[17][img2];
                echo $gallery[17][img3];
                echo $gallery[17][img4];
                echo $gallery[17][img5];
                echo $gallery[17][img6];
                echo $gallery[17][img7];
                echo $gallery[17][img8];
                echo '</div>';
        } elseif ($auto == 'bmwx50621') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[18][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[18][img1];
                echo $gallery[18][img2];
                echo $gallery[18][img3];
                echo $gallery[18][img4];
                echo $gallery[18][img5];
                echo $gallery[18][img6];
                echo $gallery[18][img7];
                echo $gallery[18][img8];
                echo '</div>';
        } elseif ($auto == 'nivachevrolet') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[19][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[19][img1];
                echo $gallery[19][img2];
                echo $gallery[19][img3];
                echo $gallery[19][img4];
                echo $gallery[19][img5];
                echo $gallery[19][img6];
                echo $gallery[19][img7];
                echo $gallery[19][img8];
                echo '</div>';
        } elseif ($auto == 'lifanx50') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[20][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[20][img1];
                echo $gallery[20][img2];
                echo $gallery[20][img3];
                echo $gallery[20][img4];
                echo $gallery[20][img5];
                echo $gallery[20][img6];
                echo $gallery[20][img7];
                echo $gallery[20][img8];
                echo '</div>';
        } elseif ($auto == 'renologan') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[21][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[21][img1];
                echo $gallery[21][img2];
                echo $gallery[21][img3];
                echo $gallery[21][img4];
                echo $gallery[21][img5];
                echo $gallery[21][img6];
                echo $gallery[21][img7];
                echo $gallery[21][img8];
                echo '</div>';
        } elseif ($auto == 'ladaxray2707') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[22][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[22][img1];
                echo $gallery[22][img2];
                echo $gallery[22][img3];
                echo $gallery[22][img4];
                echo $gallery[22][img5];
                echo $gallery[22][img6];
                echo $gallery[22][img7];
                echo $gallery[22][img8];
                echo '</div>';
        } elseif ($auto == 'rapid2807') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[23][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[23][img1];
                echo $gallery[23][img2];
                echo $gallery[23][img3];
                echo $gallery[23][img4];
                echo $gallery[23][img5];
                echo $gallery[23][img6];
                echo $gallery[23][img7];
                echo $gallery[23][img8];
                echo '</div>';
        } elseif ($auto == 'ladaxray3007') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[24][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[24][img1];
                echo $gallery[24][img2];
                echo $gallery[24][img3];
                echo $gallery[24][img4];
                echo $gallery[24][img5];
                echo $gallery[24][img6];
                echo $gallery[24][img7];
                echo $gallery[24][img8];
                echo '</div>';
        } elseif ($auto == 'creta0108') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[25][name]; ?> </h3>
                <h4 class="title title-h4">Hyundai Creta без рейлинга</h4>
                <div class="img__wrap"> <?php
                echo $gallery[25][img1];
                echo $gallery[25][img2];
                echo '</div>';?>
                <h4 class="title title-h4">Hyundai Creta с рейлингом</h4><?php
                echo '<div class="img__wrap">';
                echo $gallery[25][img3];
                echo $gallery[25][img4];
                echo $gallery[25][img5];
                echo $gallery[25][img6];
                echo $gallery[25][img7];
                echo $gallery[25][img8];
                echo '</div>';
        } elseif ($auto == 'cryiser0809') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[26][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[26][img1];
                echo $gallery[26][img2];
                echo $gallery[26][img3];
                echo $gallery[26][img4];
                echo $gallery[26][img5];
                echo $gallery[26][img6];
                echo $gallery[26][img7];
                echo $gallery[26][img8];
                echo '</div>';
        } elseif ($auto == 'duster0810') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[27][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[27][img1];
                echo $gallery[27][img2];
                echo $gallery[27][img3];
                echo $gallery[27][img4];
                echo $gallery[27][img5];
                echo $gallery[27][img6];
                echo $gallery[27][img7];
                echo $gallery[27][img8];
                echo '</div>';
        } elseif ($auto == 'sandero0820') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[28][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[28][img1];
                echo $gallery[28][img2];
                echo $gallery[28][img3];
                echo $gallery[28][img4];
                echo $gallery[28][img5];
                echo $gallery[28][img6];
                echo $gallery[28][img7];
                echo $gallery[28][img8];
                echo '</div>';
        } elseif ($auto == 'ieti0826') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[29][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[29][img1];
                echo $gallery[29][img2];
                echo $gallery[29][img3];
                echo $gallery[29][img4];
                echo $gallery[29][img5];
                echo $gallery[29][img6];
                echo $gallery[29][img7];
                echo $gallery[29][img8];
                echo '</div>';
        } elseif ($auto == 'ix358831') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[30][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[30][img1];
                echo $gallery[30][img2];
                echo $gallery[30][img3];
                echo $gallery[30][img4];
                echo $gallery[30][img5];
                echo $gallery[30][img6];
                echo $gallery[30][img7];
                echo $gallery[30][img8];
                echo '</div>';
        } elseif ($auto == 'xray0902') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[31][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[31][img1];
                echo $gallery[31][img2];
                echo $gallery[31][img3];
                echo $gallery[31][img4];
                echo $gallery[31][img5];
                echo $gallery[31][img6];
                echo $gallery[31][img7];
                echo $gallery[31][img8];
                echo '</div>';
        } elseif ($auto == 'mokka0908') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[32][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[32][img1];
                echo $gallery[32][img2];
                echo $gallery[32][img3];
                echo $gallery[32][img4];
                echo $gallery[32][img5];
                echo $gallery[32][img6];
                echo $gallery[32][img7];
                echo $gallery[32][img8];
                echo '</div>';
        } elseif ($auto == 'kaptur0802') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[33][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[33][img1];
                echo $gallery[33][img2];
                echo $gallery[33][img3];
                echo $gallery[33][img4];
                echo $gallery[33][img5];
                echo $gallery[33][img6];
                echo $gallery[33][img7];
                echo $gallery[33][img8];
                echo '</div>';
        } elseif ($auto == 'priora0802') {
                ?> <h3 class="title title-h3"> <?php echo $gallery[34][name]; ?> </h3>
                <div class="img__wrap"> <?php
                echo $gallery[34][img1];
                echo $gallery[34][img2];
                echo $gallery[34][img3];
                echo $gallery[34][img4];
                echo $gallery[34][img5];
                echo $gallery[34][img6];
                echo $gallery[34][img7];
                echo $gallery[34][img8]; ?>
                </div> <?php
                } ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>