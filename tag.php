<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/keywords/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/gallerybreadcrumbs.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">

        <?php
        $dbname = "9082410193_gallery";
        include($_SERVER["DOCUMENT_ROOT"] . "/backend/connectdb.php");

        $tag = $_GET['tag'];

        $query = "SELECT * FROM `photos`";
        $res = mysqli_query($connect, $query); ?>

        <div class="gallery"><?php

            while ($row = mysqli_fetch_assoc($res)){

                if ($tag == $row['tag1']){?>

                    <div class="gallery__item">
                        <img src="<?php echo $row['img0']?>" class="gallery__img" alt="<?php echo $row['name']?>">
                        <a href="/gallery/<?php echo $row['link']?>" class="gallery__name"><?php echo $row['name']?></a>
                        <div class="gallery__info">
                            <div class="gallery__tag-inner">
                                <a href="/tag.php?tag=<?php echo $row['tag1']?>" class="gallery__tag"><?php echo $row['tag1']?></a>
                                <a href="#" class="gallery__tag"><?php echo $row['tag2']?></a>
                                <a href="#" class="gallery__tag"><?php echo $row['tag3']?></a>
                            </div>
                            <p class="text"><?php echo $row['date']?></p>
                        </div>
                    </div><?php
                }
            } ?>
        </div>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>