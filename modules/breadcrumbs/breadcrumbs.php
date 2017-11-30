<?php
$base_link = "<a class='breadcrumbs__link' href='/'>Главная страница</a>";
$inno_boxes = "<a class='breadcrumbs__link' href='/inno/inno-boxes'>Автомобильные боксы Inno</a>";

$get_url = $_SERVER['REQUEST_URI'];
$url_parts = explode( '/', parse_url($get_url, PHP_URL_PATH) );
$count = count($url_parts);

if ($get_url == '/news/postuplenya_amos') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[0]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/reelings_xray') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[1]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/rozygryzh_bagazhnika') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[3]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/braslety') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[4]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/itogi_rozygryzha') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[5]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/rozygryzh_velokreplenya') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[6]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/postuplenya_avtoboksov') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[7]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/mayskie_prazdniki') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[8]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/akcia_na_boksy') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[9]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/12_june') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[10]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/cenopad') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[11]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/akcia_na_braslets') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[12]['title']?></span>
    </div> <?php
} elseif ($get_url == '/podbor') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[1]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/oxota_na_autobagaz') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[13]['title']?></span>
    </div> <?php
}