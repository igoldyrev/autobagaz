<?php
$get_url = $_SERVER['REQUEST_URI'];
$url_parts = explode( '/', parse_url($get_url, PHP_URL_PATH) );
$count = count($url_parts);

if ($count == '3') { ?>
    <a class="page__link" href="/">Каталог</a>
    <a class="page__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Новости</a>
    <a class="page__link" href="<?php echo '/'; echo $url_parts[1]; echo '/'; echo $url_parts[2]; ?>"><?php echo $news[0]['title']?></a> <?php
} elseif ($count == '2') { ?>
    <a class="page__link" href="/">Каталог</a>
    <a class="page__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Новости</a> <?php
}
