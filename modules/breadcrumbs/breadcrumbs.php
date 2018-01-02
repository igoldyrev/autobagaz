<?php
$base_link = "<a class='breadcrumbs__link' href='/'>Главная страница</a>";
$inno_boxes = "<a class='breadcrumbs__link' href='/inno/inno-boxes'>Автомобильные боксы Inno</a>";
$gallery_link = "<a class='breadcrumbs__link' href='/gallery'>Галерея работ</a>";

$get_url = $_SERVER['REQUEST_URI'];
$url_parts = explode( '/', parse_url($get_url, PHP_URL_PATH) );
$count = count($url_parts);

//Страницы новостей
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
        <a class="breadcrumbs__link" href="/news"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[1]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/oxota_na_autobagaz') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[13]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/rozygryzh_montblanc') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[25]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $news[14]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/1') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[25]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news/2') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[25]['title']?></span>
    </div> <?php
} elseif ($get_url == '/news') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[25]['title']?></span>
    </div> <?php
}
//Страницы каталога
  elseif ($get_url == '/autobagazhniki') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[7]['title']?></span>
    </div> <?php
} elseif ($get_url == '/kreplenya-dlya-lyzh-shoubord') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[19]['title']?></span>
    </div> <?php
} elseif ($get_url == '/reelings') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[20]['title']?></span>
    </div> <?php
} elseif ($get_url == '/braslets') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[21]['title']?></span>
    </div> <?php
} elseif ($get_url == '/farkops') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[22]['title']?></span>
    </div> <?php
}

//Автобоксы
elseif ($get_url == '/autobox') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[8]['title']?></span>
    </div> <?php
} elseif ($get_url == '/autobox/vetlan') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[8]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[9]['title']?></span>
    </div> <?php
} elseif ($get_url == '/autobox/atlant') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[8]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[10]['title']?></span>
    </div> <?php
} elseif ($get_url == '/autobox/yuago') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[8]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[13]['title']?></span>
    </div> <?php
} elseif ($get_url == '/autobox/turino') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[8]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[14]['title']?></span>
    </div> <?php
} elseif ($get_url == '/autobox/lux') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[8]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[15]['title']?></span>
    </div> <?php
}

//Велокрепления
elseif ($get_url == '/velokreplenya') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[16]['title']?></span>
    </div> <?php
} elseif ($get_url == '/velokreplenya/krysha') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[16]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[17]['title']?></span>
    </div> <?php
} elseif ($get_url == '/velokreplenya/farkop') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[16]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[18]['title']?></span>
    </div> <?php
}

//Раздел Инно
elseif ($get_url == '/inno') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[30]['title']?></span>
    </div> <?php
} elseif ($get_url == '/inno/inno-basic') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[30]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[31]['title']?></span>
    </div> <?php
} elseif ($get_url == '/inno/inno-boxes') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[30]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[32]['title']?></span>
    </div> <?php
} elseif ($get_url == '/inno/roofbox') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[30]['title']?></a>&#8594;
        <?php echo $inno_boxes; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[34]['title']?></span>
    </div> <?php
} elseif ($get_url == '/inno/new-shadow') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[30]['title']?></a>&#8594;
        <?php echo $inno_boxes; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[33]['title']?></span>
    </div> <?php
}

//Раздел такелаж
elseif ($get_url == '/takelazh') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[35]['title']?></span>
    </div> <?php
} elseif ($get_url == '/takelazh/dynamic_strops') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[35]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[36]['title']?></span>
    </div> <?php
} elseif ($get_url == '/takelazh/textil_strops') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[35]['title']?></a>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[37]['title']?></span>
    </div> <?php
}

//Страницы разделов
elseif ($get_url == '/prokat') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[2]['title']?></span>
    </div> <?php
} elseif ($get_url == '/special-offers') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[38]['title']?></span>
    </div> <?php
} elseif ($get_url == '/guestbook') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[24]['title']?></span>
    </div> <?php
} elseif ($get_url == '/guestbook/add') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>"><?php echo $keywords[24]['title']?></a>&#8594;
        <span class="breadcrumbs__text">Добавление отзыва</span>
    </div> <?php
} elseif ($get_url == '/contacts') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[6]['title']?></span>
    </div> <?php
} elseif ($get_url == '/partners') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[29]['title']?></span>
    </div> <?php
} elseif ($get_url == '/sitemap') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[23]['title']?></span>
    </div> <?php
}

//Галерея
elseif ($get_url == '/gallery') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <span class="breadcrumbs__text"><?php echo $keywords[3]['title']?></span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=xray0303') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Lada Xray</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=bmwx5') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">BMW X5</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=mazdampv') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Mazda MPV</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=uazpatriot') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">UAZ Patriot</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=wvjetta') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Volkswagen Jetta</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=xtrail') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Nissan X-Trail</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=lada2111') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Lada 2111</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=ladalargus') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Lada Largus</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=focus2') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Ford Focus 2</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=seed') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Kia Seed</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=xray0602') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Lada Xray</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=chevrolet') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Niva Chevrolet</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=kiario') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Kia Rio</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=lada2107') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Lada 2107</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=lancer') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Mitsubisi Lancer</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=outback') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Subaru Outback</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=21110621') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Lada 2111</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=polo') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Volkswagen Polo</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=bmwx50621') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">BMW X5</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=nivachevrolet') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Chevrolet Niva</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=lifanx50') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Lifan X50</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=renologan') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Reno Logan</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=ladaxray2707') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Lada Xray</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=rapid2807') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Skoda Rapid</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=ladaxray3007') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Lada Xray</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=creta0108') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Hyundai Creta</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=cryiser0809') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Toyota Land Cryiser</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=duster0810') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Reno Duster</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=sandero0820') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Reno Sandero</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=ieti0826') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Skoda Ieti</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=ix358831') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Hyundai ix35</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=xray0902') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Lada Xray</span>
    </div> <?php
} elseif ($get_url == '/gallery?auto=mokka0908') { ?>
    <div class="breadcrumbs">
        <?php echo $base_link; ?>&#8594;
        <?php echo $gallery_link; ?>&#8594;
        <span class="breadcrumbs__text">Opel Mokka</span>
    </div> <?php
}