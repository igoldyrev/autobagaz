<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/expiditions/backend/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/expiditions/backend/array.php");
echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[0][description];      echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";
$_SESSION['expiditions'] = $expiditions;
$_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <h1 class="title title-h1">Экспедиционные багажники</h1>
        <div class="good-mini__wrap">
            <?php foreach ($expiditions as $item): ?>
            <div class="good-mini">
                <div class="img__wrap">
                    <img class="img good__img" src="<?php echo $item['img1'] ?>">
                </div>
                <h4 class="title title-h4"><?php echo $item['name'] ?></h4>
                <p class="text">Цена: <?php echo $item['price'] ?></p>
                <a onclick="yaCounter40650914.reachGoal('click_about'); return true" href="/expiditions/<?php echo $item['id']; ?>" class="button button__about" >Подробнее</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
