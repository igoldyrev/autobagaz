<?php
$get_url = $_SERVER['REQUEST_URI'];

$url_parts = explode( '/', parse_url($get_url, PHP_URL_PATH) );

if (!isset($get_url)) {

} elseif ($get_url == '/news') { ?>
    <a class="page__link" href="<?php echo '/'; ?>">Каталог</a>
    <a class="page__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Новости</a> <?php
} elseif ($get_url == '/news/postuplenya_amos') { ?>
    <a class="page__link" href="<?php echo '/'; ?>">Каталог</a>
    <a class="page__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Новости</a>
    <a class="page__link" href="<?php echo '/'; echo $url_parts[1]; echo '/'; echo $url_parts[2]; ?>"><?php echo $news[0]['title']; ?></a>' <?php
}
