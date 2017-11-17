<?php 
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/keywords_news.php");
include ($_SERVER["DOCUMENT_ROOT"]."/modules/headtags.php"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/header/header.php"); ?>
    <div class="wrapper-content">
        <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/left-nav/left-nav.html");?>
        <div class="content">
            <?php
            $newspage = $_GET['newspage'];
            if (!isset($newspage)) {
                echo "<title> $titleconst"; echo $keywords[25][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $keywords[25][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $keywords[25][keywords]; echo "'/>";
                // Соединение с БД MySQL
                $sql = mysql_connect('localhost', '9082410193', 'GfhjkmDatabase');
                mysql_select_db('9082410193_news', $sql);

                mysql_query ("set_client='utf8'");//Следующие 2 строки решают проблему с кодировкой.
                mysql_query ("SET NAMES utf8");
                // Количество новостей на странице
                $on_page = 10;
                // Получаем количество записей таблицы news.scss
                $query = "SELECT COUNT(*) FROM `news`";
                $res = mysql_query($query);
                $count_records = mysql_fetch_row($res);
                $count_records = $count_records[0];
                // Получаем количество страниц
                // Делим количество записей на количество новостей на странице
                // и округляем в большую сторону
                $num_pages = ceil($count_records / $on_page);
                // Текущая страница из GET-параметра page
                // Если параметр не определен, то текущая страница равна 1
                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                // Если текущая страница меньше единицы, то страница равна 1
                if ($current_page < 1)
                {
                    $current_page = 1;
                }
                // Если текущая страница больше общего количества страница, то
                // текущая страница равна количеству страниц
                elseif ($current_page > $num_pages)
                {
                    $current_page = $num_pages;
                }
                // Начать получение данных от числа (текущая страница - 1) * количество записей на странице
                $start_from = ($current_page - 1) * $on_page;
                // Формат оператора LIMIT <ЗАПИСЬ ОТ>, <КОЛИЧЕСТВО ЗАПИСЕЙ>
                $query = "SELECT `news_title`, `news_link`, `news_annotation`, `news_author`, `news_date` FROM `news` ORDER BY `news_date` DESC LIMIT $start_from, $on_page";
                $res = mysql_query($query);

                // Вывод результатов

                echo "<div class='news'>";
                while ($row = mysql_fetch_assoc($res))
                {
                    echo "<div class='news__item'>";
                    echo "<div class='news__info'>";
                        echo "<span class='news__date page__text'>".$row['news_date']."</span>";
                        echo "<span class='page__text'>Автор: ".$row['news_author']."</span>";
                    echo "</div>";
                    echo "<a href='".$row['news_link']."' class='news__title page__link'>".$row['news_title']."</a>";
                    echo "<p class='news__annotation page__text'>".$row['news_annotation']."</p>";
                    echo "<a href='".$row['news_link']."' class='news__link page__link'>Читать далее</a>";
                    echo "</div>";
                }
                echo "</div>";

                // Вывод списка страниц
                echo '<p class="news__page page__text">';
                for ($page = 1; $page <= $num_pages; $page++)
                {
                    if ($page == $current_page)
                    {
                        echo '<strong>'.$page.'</strong> &nbsp;';
                    }
                    else
                    {
                        echo '<a class="page__link" href="/news/'.$page.'">'.$page.'</a> &nbsp;';
                    }
                }
                echo '</p>';

                }; ?>



                </div>
    </div>
</div>






<?php

 /*elseif ($newspage == 'postuplenya_amos') {
	echo "<title> $titleconst"; echo $news.scss[0][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[0][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[0][keywords]; echo "'/>"; ?>
	
	<h1>Новинка! Новые поступления лыжных креплений и багажников</h1>
	<p>У нас в наличии появились бюджетные крепления Amos для 3-х и 5-ти пар лыж или 2-х или 4-х сноубордов.</p>
	<p>А также у нас появились бюджетные багажники на рейлинги.</p>
	<div align="center">
		<img src="/images/news.scss/190117/amos.jpg" alt="amos">
	</div> <?php
} elseif ($newspage == 'reelings_xray') {
	echo "<title> $titleconst"; echo $news.scss[1][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[1][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[1][keywords]; echo "'/>"; ?>
	
	<h1>Новинка! Рейлинги на X-Ray!</h1>
	<p>Рейлинги предназначены для автомобиля LADA XRAY (Лада Икс Рей). БЕЗ СВЕРЛЕНИЯ КРЫШИ!</p>
	<p>Оригинальный дизайн, гармонично дополняющий облик автомобиля.</p> 
	<p>Материалы и комплектующие высокого качества – упрочненный алюминиевый профиль с защитно-декоративным анодным покрытием, и АБС - пластик с защитным слоем, предотвращающим выгорание и обесцвечивание.</p>
	<div class="img_div">
		<img class="img_main" src="/images/gallery/20170727_7_xray.jpg" srcset="
		/images/gallery/20170727_7_xray.jpg 1550w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="x-ray">
		<img class="img_main" src="/images/gallery/20170602_4_xray.jpg" srcset="
		/images/gallery/20170602_4_xray.jpg 750w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="x-ray">
		<img class="img_main" src="/images/gallery/20170303_4_xray.jpg" srcset="
		/images/gallery/20170303_4_xray.jpg 550w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="x-ray">
	</div> <?php
} elseif ($newspage == 'rozygryzh_bagazhnika') {
	echo "<title> $titleconst"; echo $news.scss[3][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[3][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[3][keywords]; echo "'/>"; ?>
	
	<h1>Розыгрыш багажника от autobagaz.ru</h1>
	<h3>Дорогие Друзья!</h3> 
	<p>Зачастую бывает так, что объема стандартного багажника автомобиля не хватает под те вещи, что мы берем с собой в путь. Особо остро это касается обратной дороги с путешествий, когда мы везем с собой гостинцы и сувениры для наших любимых.</p>
	<p>Проблему нехватки места очень просто снять дополнительным оборудованием: багажниками и автобоксами, которые расширят возможный объем перевозимого груза на 320-700литров.</p>
	<p>Близится весна с долгими майскими праздниками и жаркое лето, когда так приятно всей семьей отправиться отдыхать на природу, или в путешествие к морю или в горы.</p>
	<p>В связи с этим, мы решили разыграть багажник на любой автомобиль в нашем магазине.</p>
	<p align="center"><b>Условия простые!</b></p> 
	<ol>
		<li>Вы проживаете в Пермском крае (забирать приз придется из магазина), но если вы готовы ехать из другого города за ним, мы не против.</li>
		<li>Состоять в группе <a href="https://vk.com/autobagaz" target="blank">vk.com/autobagaz</a></li> 
		<li>Сделать репост <a href="https://vk.com/wall-86325723_894">записи розыгрыша</a></li> 
		<li>Не удалять пост до 19.03.2017</li> 
	</ol>
	<p><b>Победителя определим 20.03.2017 с помощью приложения - Random. Фото и видео отчет будут прилагаться!</b></p>
	<p>Более того, всем участникам группы, кто покажет данную запись-гарантированный приз: минус 10% от стоимости проката любого оборудования в магазине до конца 2017 года!</p> 
	<p>Желаем вам удачи!</p>
	<div align="center">
		<img src="/images/news.scss/200217/rozygryzh.jpg" alt="rozygryzh" width="400px">
	</div> <?php
} elseif ($newspage == 'braslety') {
	echo "<title> $titleconst"; echo $news.scss[4][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[4][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[4][keywords]; echo "'/>"; ?>
	
	<h1>Новинка! В продаже появились браслеты противоскольжения!</h1>
	<p>Всесезонные, всепогодные. Устанавливаются без наезда, домкрата и инструмента в 1 минуту. Даже для полного привода достаточно 2-х браслетов. Отличный подарок активным автолюбителям.</p>
	<p>Размеры:</p>
	<ul>
		<li>R12-15: 500рублей/штука;</li>
		<li>R16-22,5: 1000 рублей/штука;</li>
		<li>Газели: от 1200 рублей/штука;</li>
	</ul>
	<div align="center">
		<img src="/images/news.scss/120317/braslet.jpg" alt="braslet" width="300px">
	</div> <?php
} elseif ($newspage == 'itogi_rozygryzha') {
	echo "<title> $titleconst"; echo $news.scss[5][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[5][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[5][keywords]; echo "'/>"; ?>
	
	<h1>Итоги розыгрыша багажника от autobagaz.ru</h1>
	<p>Подвели итоги розыгрыша от магазина "AutoBagaz". Победителем становится <a href="https://vk.com/seregautev" target="_blank">Сергей Утев.</a></p> 
	<p>Также хотим сообщить радостную новость, через 1-2 недели планируется следующий розыгрыш! Следите за новостями <a href="https://vk.com/autobagaz" target="_blank">группы</a> и приглашайте друзей ;)</p>
	<div align="center">
		<img src="/images/news.scss/210317/pobeditel.jpg" alt="pobeditel" width="300px">
	</div> <?php
} elseif ($newspage == 'rozygryzh_velokreplenya') {
	echo "<title> $titleconst"; echo $news.scss[6][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[6][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[6][keywords]; echo "'/>"; ?>
	
	<h1>Розыгрыш велокрепления от autobagaz.ru</h1>
	<h3>Дорогие Друзья!</h3> 
	<p>Мы обьявляем конкурс, в котором разыграем крепление для перевозки велосипеда на крышу!</p>
	<p align="center"><b>Условия простые!</b></p> 
	<ol>
		<li>Вы проживаете в Пермском крае (забирать приз придется из магазина), но если вы готовы ехать из другого города за ним, мы не против.</li>
		<li>Состоять в группе <a href="https://vk.com/autobagaz" target="blank">vk.com/autobagaz</a></li> 
		<li>Сделать репост <a href="https://vk.com/wall-86325723_961" target="blank">записи розыгрыша</a></li> 
		<li>Не удалять пост до 19.05.2017</li> 
	</ol>
	<p><b>Победителя определим 20.05.2017 с помощью генератора случайных чисел. Фото и видео отчет будут прилагаться!</b></p>
	<p>Желаем вам удачи!</p>
	<div align="center">
		<img src="/images/news.scss/220417/rozygryzh.jpg" alt="rozygryzh" width="400px">
	</div> <?php
} elseif ($newspage == 'postuplenya_avtoboksov') {
	echo "<title> $titleconst"; echo $news.scss[7][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[7][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[7][keywords]; echo "'/>"; ?>
	
	<h1>Поступления автобоксов Vetlan</h1>
	<p>В нашем магазине поступление автобоксов Vetlan, серии 400М, 430М и 530М. Подробнее об их характеристиках и ценах можно узнать на <a href ="/vetlan" target="_blank">специальной</a> странице.</p> 
	<p>Заказать боксы можно через специальную <a href ="/zayavka" target="_blank">форму</a> или позвонить по телефону.
<div align="center">
<img src="/images/vetlan/550M/1.jpg" alt="Vetlan 550M" width="300px">
</div> <?php
} elseif ($newspage == 'mayskie_prazdniki') {
	echo "<title> $titleconst"; echo $news.scss[2][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[2][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[2][keywords]; echo "'/>"; ?>
	
	<h1>Расписание работы в майские праздники</h1>
	<h3>Уважаемые клиенты!</h3>
	<p>Рады Вам сообщить, что, несмотря на праздники, наш магазин работает по прежнему графику.</p>
	<div align="center">
		<img src="/images/news.scss/300417/01.jpg" alt="1 май" width="300px">
	</div> <?php
} elseif ($newspage == 'akcia_na_boksy') {
	echo "<title> $titleconst"; echo $news.scss[9][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[9][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[9][keywords]; echo "'/>"; ?>
	
	<h1>Горячее предложение от магазина Autobagaz!</h1>
	<p align="center">В связи с сезоном отпусков и поездок за город наш магазин решил сделать Вам приятный подарок!</p>
	<p><b>Автобокс Vetlan 400</b></p>
	<ol>
		<li>Размер: 165х80х35см</li>
		<li>Литраж: 400 л</li>
		<li>Материал: ABC</li>
		<li>Крепление: скобочное (на любой вид багажников)</li>
		<li>Замок: три точки запирания</li>
		<li>Варианты цветов: Черный, серый, белый</li>
	</ol>
	<p><b>Цена 9000 рублей</b></p>
	<p>Боксов в наличии <span class="strike"><span class="text">4 штуки</span></span> 1 штука.</p>
	<div class="img_div">
		<img class="img_main" src="/images/news.scss/030517/akcia.jpg" srcset="
		/images/news.scss/030517/akcia.jpg 300w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="Акция">
	</div> <?php
} elseif ($newspage == '12_june') {
	echo "<title> $titleconst"; echo $news.scss[10][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[10][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[10][keywords]; echo "'/>"; ?>
	
	<h1>Расписание работы 12 июня</h1>
	<p align="center">Уважаемые клиенты!</p>
	<p>Рады Вам сообщить, что, несмотря на праздник, наш магазин работает с 10-00 до 16-00.</p>
	<div class="img_div">
		<img class="img_main" src="/images/news.scss/110617/12june.jpg" srcset="
		/images/news.scss/110617/12june.jpg 350w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="День России">
	</div> <?php
} elseif ($newspage == 'cenopad') {
	echo "<title> $titleconst"; echo $news.scss[11][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[11][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[11][keywords]; echo "'/>"; ?>
	
	<h1>Внимание!!! AUTOBAGAZный ценопад!</h1>

	<p>У вас все еще нет велокрепления?! Тогда мы идем к вам!</p>
	<p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Велокрепление для одного велосипеда - 1500 рублей.</p>
	<p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Велокрепление на фаркоп - 3800 рублей.</p>
	<p>Приятные плюшки от магазина "AutobagaZ":</p> 
	<p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Расширенная гарантия на оборудование +1 год от магазина, итого 3 года гарантии;</p>
	<p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Скидка 500 рублей на лыжные крепления;</p>
	<p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Вкуснейший чай или ароматный кофе;</p>
	<p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Бесплатный монтаж велооборудования.</p>
	<p>Наш адрес: г. Пермь ул. Спешилова 102/29</p>
	<p>Тел: 288-99-69</p>
	<div class="img_div">
		<img class="img_main" src="/images/news.scss/250717/farkop.jpg" srcset="/images/news.scss/250717/farkop.jpg 700w" alt="Велокрепление на фаркоп" sizes="(max-width: 2000px) 150px, 300px, 350px">
		<img class="img_main" src="/images/news.scss/250717/krysha.jpg" srcset="/images/news.scss/250717/krysha.jpg 700w" alt="Велокрепление на крышу" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div> <?php
} elseif ($newspage == 'akcia_na_braslets') {
	echo "<title> $titleconst"; echo $news.scss[12][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $news.scss[12][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $news.scss[12][keywords]; echo "'/>"; ?>
	
	<h1>Внимание!!! Акция в магазине "AutobagaZ"!!!</h1>
	<p>Браслет противоскольжения R12-15 - <strong>Цена 500 рублей/шт.</strong></p>
	<p>При покупке 3 штук - четвертый в <strong>ПОДАРОК!</strong></p>
	<p>Браслет противоскольжения R16-22 - <strong>Цена 1000 рублей/шт.</strong></p>
	<p>При покупке 3 штук - четвертый в <strong>ПОДАРОК!</strong></p>
	<p>Наш адрес: г. Пермь ул. Спешилова 102/29</p>
	<p>Тел: 288-99-69</p>
	<div class="img_div">
		<img class="img_main" src="/images/news.scss/091017/akcia_braslet.jpg" srcset="/images/news.scss/091017/akcia_braslet.jpg 300w" alt="Браслеты противоскольжения" sizes="(max-width: 2000px) 150px, 300px, 350px">
	</div> <?php
} elseif ($newspage == 'oxota_na_autobagaz') {
    echo "<title> $titleconst"; echo $news.scss[13][title]; echo "</title>";
    echo "<meta name='description' content='"; echo $news.scss[13][description]; echo "'/>";
    echo "<meta name='keywords' content='"; echo $news.scss[13][keywords]; echo "'/>"; ?>

    <h1>Внимание!!! ОХОТА НА AUTOBAGAZ!</h1>
    <p>Награда: 1000 рублей (Одна тысяча рублей) За поимку!</p>
    <p align="center"><strong>Правила охоты:</strong></p>
    <p>1) Надо поймать машину с отличительными знаками на заднем стекле.
        (Поимка осуществляется с путем обгона машины, по наклейке на заднем стекле вашего автомобиля мы поймем что вы участник и остановимся)</p>
    <p>2)Делаем фотографию на фоне вашей машины с призом.</p>
    <p>3)Забираете приз и едете довольные по своим делам</p>
    <p>4)Поймать можно 1 раз в неделю. (Для всех участников акции)</p>
    <p>(Да может так случится, что вы поймали, а приза уже нет. В подтверждении того что приз выдан, ФОТО в группе, если фото нет то приз еще не выдан)</p>
    <p>ЛОВИМ: Volkswagen Jetta (фото наклеек ниже)</p>
    <p>Пример наклейки которая должна быть у вас на стекле (ПРИМЕР)</p>
    <p align="center"><strong>Что для этого нужно?</strong></p>
    <p>Быть участником группы в контакте <a href="https://vk.com/autobagaz" target="_blank">https://vk.com/autobagaz</a> (это нужно для того чтобы понимать, поймали на этой неделе машину или нет)</p>
    <p>Взять наклейку в магазине "AutobagaZ" по адресу: г.Пермь ул.Спешилова 102/29</p>
    <p>(Наклейку необходимо наклеить на заднее стекло вашего автомобиля)</p>
    <p>Если все условия соблюдены, поздравляем вы участник ОХОТЫ!</p>
    <p>Желаем удачи на дорогах! Как говорится, НИ гвоздя, НИ жезла.</p>
    <p>Просим соблюдать правила дорожного движения во время ОХОТЫ (речь идет про обгон)</p>
    <div class="img_div">
        <img class="img_main" src="/images/news.scss/121017/1.jpg" srcset="/images/news.scss/121017/1.jpg 100w" alt="Охота на Autobagaz" sizes="(max-width: 2000px) 150px, 300px, 350px">
        <img class="img_main" src="/images/news.scss/121017/2.jpg" srcset="/images/news.scss/121017/2.jpg 300w" alt="Охота на Autobagaz" sizes="(max-width: 2000px) 150px, 300px, 350px">
        <img class="img_main" src="/images/news.scss/121017/3.jpg" srcset="/images/news.scss/121017/3.jpg 1000w" alt="Охота на Autobagaz" sizes="(max-width: 2000px) 150px, 300px, 350px">
    </div>
        <H2> Поздравляем первого победителя!</H2>
        <p>Алексею удалось поймать наш автомобиль в районе парка культуры (Кировский район).</p>
        <p>Продолжаем охоту господа!</p>
    <div class="img_div">
        <img class="img_main" src="/images/news.scss/121017/4.jpg" srcset="/images/news.scss/121017/4.jpg 500w" alt="Охота на Autobagaz" sizes="(max-width: 2000px) 150px, 300px, 350px">
        <img class="img_main" src="/images/news.scss/121017/5.jpg" srcset="/images/news.scss/121017/5.jpg 500w" alt="Охота на Autobagaz" sizes="(max-width: 2000px) 150px, 300px, 350px">
    </div>
    <?php
} ?>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>