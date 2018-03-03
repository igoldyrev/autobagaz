<?php
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/arrays/level2.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/arrays/level3.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/arrays/news.php");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/arrays/gallery.php");

$get_url = $_SERVER['REQUEST_URI'];
$url_parts = explode( '/', parse_url($get_url, PHP_URL_PATH) );
$count = count($url_parts);

foreach ($news as $newsitem):

    if($get_url == $newsitem['link']) { ?>

        <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Новости и статьи</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $newsitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($gallery as $galleryitem):

    if($get_url == $galleryitem['link']) { ?>

        <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Галерея работ</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $galleryitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($level2 as $level2item):

    if($get_url == $level2item['link']) { ?>

        <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $level2item['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($autobagazhniki as $autobagazhnikiitem):

    if($get_url == $autobagazhnikiitem['link']) { ?>

        <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="/autobagazhniki">Автомобильные багажники</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $autobagazhnikiitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($level3 as $level3item):

    if($get_url == $level3item['link']) {

        if($url_parts[1] == 'autobox') { ?>

            <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Автомобильные боксы</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $level3item['name']; ?></span>
        </div><?php

        } elseif ($url_parts[1] == 'velokreplenya') { ?>

            <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Велокрепления</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $level3item['name']; ?></span>
        </div><?php

        } elseif ($url_parts[1] == 'reelings') { ?>

            <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $level3item['name']; ?></span>
        </div><?php

        } elseif ($url_parts[1] == 'inno') { ?>

            <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Багажные системы Inno</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $level3item['name']; ?></span>
        </div><?php

        } elseif ($url_parts[1] == 'takelazh') { ?>

            <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Такелажная продукция</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $level3item['name']; ?></span>
        </div><?php

        } elseif ($url_parts[1] == 'expiditions') { ?>

            <div class="breadcrumbs">
            <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
            <a class="breadcrumbs__link" href="/expidition">Экспедиционные багажники</a>&#8594;
            <span class="breadcrumbs__text"><?php echo $level3item['name']; ?></span>
        </div><?php

        }
    }

endforeach;

foreach ($reelingslada as $reelingsladaitem):

    if($get_url == $reelingsladaitem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
        <a class="breadcrumbs__link" href="/reelings/lada">Рейлинги для автомобилей Lada</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $reelingsladaitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($reelingschevi as $reelingscheviitem):

    if($get_url == $reelingscheviitem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
        <a class="breadcrumbs__link" href="/reelings/chevrolet">Рейлинги для автомобилей Chevrolet</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $reelingscheviitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($reelingsrenault as $reelingsrenaultitem):

    if($get_url == $reelingsrenaultitem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
        <a class="breadcrumbs__link" href="/reelings/renault">Рейлинги для автомобилей Renault</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $reelingsrenaultitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($reelingskia as $reelingskiaitem):

    if($get_url == $reelingskiaitem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
        <a class="breadcrumbs__link" href="/reelings/kia">Рейлинги для автомобилей KIA</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $reelingskiaitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($reelingsmazda as $reelingsmazdaitem):

    if($get_url == $reelingsmazdaitem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
        <a class="breadcrumbs__link" href="/reelings/mazda">Рейлинги для автомобилей Mazda</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $reelingsmazdaitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($reelingshyundai as $reelingshyundaiitem):

    if($get_url == $reelingshyundaiitem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
        <a class="breadcrumbs__link" href="/reelings/hyundai">Рейлинги для автомобилей Hyundai</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $reelingshyundaiitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($reelingsopel as $reelingsopelitem):

    if($get_url == $reelingsopelitem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
        <a class="breadcrumbs__link" href="/reelings/opel">Рейлинги для автомобилей Opel</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $reelingsopelitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($reelingstoyota as $reelingstoyotaitem):

    if($get_url == $reelingstoyotaitem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
        <a class="breadcrumbs__link" href="/reelings/toyota">Рейлинги для автомобилей Toyota</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $reelingstoyotaitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($reelingsrover as $reelingsroveritem):

    if($get_url == $reelingsroveritem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
        <a class="breadcrumbs__link" href="/reelings/landrover">Рейлинги для автомобилей Land Rover</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $reelingsroveritem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($reelingsdatsun as $reelingsdatsunitem):

    if($get_url == $reelingsdatsunitem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Рейлинги</a>&#8594;
        <a class="breadcrumbs__link" href="/reelings/datsun">Рейлинги для автомобилей Datsun</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $reelingsdatsunitem['name']; ?></span>
        </div><?php

    }

endforeach;

foreach ($innoboxes as $innoboxesitem):

    if($get_url == $innoboxesitem['link']) { ?>

        <div class="breadcrumbs">
        <a class="breadcrumbs__link" href="/">Главная страница</a>&#8594;
        <a class="breadcrumbs__link" href="<?php echo '/'; echo $url_parts[1]; ?>">Багажные системы Inno</a>&#8594;
        <a class="breadcrumbs__link" href="/inno/inno-boxes">Автомобильные боксы Inno</a>&#8594;
        <span class="breadcrumbs__text"><?php echo $innoboxesitem['name']; ?></span>
        </div><?php

    }

endforeach;