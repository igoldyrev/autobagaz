<?php
$base_link = "<a class='breadcrumbs__link' href='/'>Главная страница</a>";

$get_url = $_SERVER['REQUEST_URI'];
$url_parts = explode( '/', parse_url($get_url, PHP_URL_PATH) );
$count = count($url_parts);

if ($get_url == '/news/postuplenya_amos') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[0]['title']?></span>
    </div>
     <?php
} elseif ($get_url == '/news/reelings_xray') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
    <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
    <span class="breadcrumbs__text"><?php echo $news[1]['title']?></span>
    </div>
    <?php
}

