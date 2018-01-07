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
                $dbname = "9082410193_news";

                include ($_SERVER["DOCUMENT_ROOT"]."/modules/connectdb.php");

                // Количество новостей на странице
                $on_page = 10;

                // Получаем количество записей таблицы news
                $query = "SELECT COUNT(*) FROM news";
                $res = mysqli_query($connect, $query);
                $count_records = mysqli_fetch_row($res);
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
                $query = "SELECT * FROM `news` ORDER BY `news_date` DESC LIMIT $start_from, $on_page";
                $res = mysqli_query($connect, $query);

                // Вывод результатов

                echo "<div class='news'>";
                while ($row = mysqli_fetch_assoc($res))
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

                } elseif ($newspage == 'postuplenya_amos') {
                echo "<title> $titleconst"; echo $news[0][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[0][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[0][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Новинка! Новые поступления лыжных креплений и багажников</h1>
                <p class="page__text">У нас в наличии появились бюджетные крепления Amos для 3-х и 5-ти пар лыж или 2-х или 4-х сноубордов.</p>
                <p class="page__text">А также у нас появились бюджетные багажники на рейлинги.</p>
                <div align="center">
                    <img src="/images/news/190117/amos.jpg" alt="amos">
                </div> <?php
            } elseif ($newspage == 'reelings_xray') {
                echo "<title> $titleconst"; echo $news[1][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[1][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[1][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Новинка! Рейлинги на X-Ray!</h1>
                <p class="page__text">Рейлинги предназначены для автомобиля LADA XRAY (Лада Икс Рей). БЕЗ СВЕРЛЕНИЯ КРЫШИ!</p>
                <p class="page__text">Оригинальный дизайн, гармонично дополняющий облик автомобиля.</p>
                <p class="page__text">Материалы и комплектующие высокого качества – упрочненный алюминиевый профиль с защитно-декоративным анодным покрытием, и АБС - пластик с защитным слоем, предотвращающим выгорание и обесцвечивание.</p>
                <div class="img_div">
                    <img class="img_main" src="/images/gallery/20170727_7_xray.jpg" srcset="
		/images/gallery/20170727_7_xray.jpg 1550w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="x-ray">
                    <img class="img_main" src="/images/gallery/20170602_4_xray.jpg" srcset="
		/images/gallery/20170602_4_xray.jpg 750w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="x-ray">
                    <img class="img_main" src="/images/gallery/20170303_4_xray.jpg" srcset="
		/images/gallery/20170303_4_xray.jpg 550w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="x-ray">
                </div> <?php
            } elseif ($newspage == 'rozygryzh_bagazhnika') {
                echo "<title> $titleconst"; echo $news[3][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[3][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[3][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Розыгрыш багажника от autobagaz.ru</h1>
                <h3 class="page__title-h3">Дорогие Друзья!</h3>
                <p class="page__text">Зачастую бывает так, что объема стандартного багажника автомобиля не хватает под те вещи, что мы берем с собой в путь. Особо остро это касается обратной дороги с путешествий, когда мы везем с собой гостинцы и сувениры для наших любимых.</p>
                <p class="page__text">Проблему нехватки места очень просто снять дополнительным оборудованием: багажниками и автобоксами, которые расширят возможный объем перевозимого груза на 320-700литров.</p>
                <p class="page__text">Близится весна с долгими майскими праздниками и жаркое лето, когда так приятно всей семьей отправиться отдыхать на природу, или в путешествие к морю или в горы.</p>
                <p class="page__text">В связи с этим, мы решили разыграть багажник на любой автомобиль в нашем магазине.</p>
                <p align="center" class="page__text"><b>Условия простые!</b></p>
                <ol class="page__list">
                    <li>Вы проживаете в Пермском крае (забирать приз придется из магазина), но если вы готовы ехать из другого города за ним, мы не против.</li>
                    <li>Состоять в группе <a class="page__link" href="https://vk.com/autobagaz" target="blank">vk.com/autobagaz</a></li>
                    <li>Сделать репост <a class="page__link" href="https://vk.com/wall-86325723_894">записи розыгрыша</a></li>
                    <li>Не удалять пост до 19.03.2017</li>
                </ol>
                <p class="page__text"><b>Победителя определим 20.03.2017 с помощью приложения - Random. Фото и видео отчет будут прилагаться!</b></p>
                <p class="page__text">Более того, всем участникам группы, кто покажет данную запись-гарантированный приз: минус 10% от стоимости проката любого оборудования в магазине до конца 2017 года!</p>
                <p class="page__text">Желаем вам удачи!</p>
                <div align="center">
                    <img src="/images/news/200217/rozygryzh.jpg" alt="rozygryzh" width="400px">
                </div> <?php
            } elseif ($newspage == 'braslety') {
                echo "<title> $titleconst"; echo $news[4][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[4][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[4][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Новинка! В продаже появились браслеты противоскольжения!</h1>
                <p class="page__text">Всесезонные, всепогодные. Устанавливаются без наезда, домкрата и инструмента в 1 минуту. Даже для полного привода достаточно 2-х браслетов. Отличный подарок активным автолюбителям.</p>
                <p class="page__text">Размеры:</p>
                <ul class="page__list">
                    <li>R12-15: 500рублей/штука;</li>
                    <li>R16-22,5: 1000 рублей/штука;</li>
                    <li>Газели: от 1200 рублей/штука;</li>
                </ul>
                <div align="center">
                    <img src="/images/news/120317/braslet.jpg" alt="braslet" width="300px">
                </div> <?php
            } elseif ($newspage == 'itogi_rozygryzha') {
                echo "<title> $titleconst"; echo $news[5][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[5][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[5][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Итоги розыгрыша багажника от autobagaz.ru</h1>
                <p class="page__text">Подвели итоги розыгрыша от магазина "AutoBagaz". Победителем становится <a class="page__link" href="https://vk.com/seregautev" target="_blank">Сергей Утев.</a></p>
                <p class="page__text">Также хотим сообщить радостную новость, через 1-2 недели планируется следующий розыгрыш! Следите за новостями <a class="page__link" href="https://vk.com/autobagaz" target="_blank">группы</a> и приглашайте друзей ;)</p>
                <div align="center">
                    <img src="/images/news/210317/pobeditel.jpg" alt="pobeditel" width="300px">
                </div> <?php
            } elseif ($newspage == 'rozygryzh_velokreplenya') {
                echo "<title> $titleconst"; echo $news[6][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[6][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[6][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Розыгрыш велокрепления от autobagaz.ru</h1>
                <h3 class="page__title-h3">Дорогие Друзья!</h3>
                <p class="page__text">Мы обьявляем конкурс, в котором разыграем крепление для перевозки велосипеда на крышу!</p>
                <p align="center" class="page__text"><b>Условия простые!</b></p>
                <ol class="page__list">
                    <li>Вы проживаете в Пермском крае (забирать приз придется из магазина), но если вы готовы ехать из другого города за ним, мы не против.</li>
                    <li>Состоять в группе <a class="page__link" href="https://vk.com/autobagaz" target="blank">vk.com/autobagaz</a></li>
                    <li>Сделать репост <a class="page__link" href="https://vk.com/wall-86325723_961" target="blank">записи розыгрыша</a></li>
                    <li>Не удалять пост до 19.05.2017</li>
                </ol>
                <p class="page__text"><b>Победителя определим 20.05.2017 с помощью генератора случайных чисел. Фото и видео отчет будут прилагаться!</b></p>
                <p class="page__text">Желаем вам удачи!</p>
                <div align="center">
                    <img src="/images/news/220417/rozygryzh.jpg" alt="rozygryzh" width="400px">
                </div> <?php
            } elseif ($newspage == 'postuplenya_avtoboksov') {
                echo "<title> $titleconst"; echo $news[7][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[7][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[7][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Поступления автобоксов Vetlan</h1>
                <p class="page__text">В нашем магазине поступление автобоксов Vetlan, серии 400М, 430М и 530М. Подробнее об их характеристиках и ценах можно узнать на <a class="page__link" href ="/autobox/vetlan" target="_blank">специальной</a> странице.</p>
                <p class="page__text">Заказать боксы можно на той же странице, выбрав интересующий вас бокс или позвонить <a class="page__link" href="tel:+73422889969">по телефону</a>.
                <div align="center">
                    <img src="/images/vetlan/550M/1.jpg" alt="Vetlan 550M" width="300px">
                </div> <?php
            } elseif ($newspage == 'mayskie_prazdniki') {
                echo "<title> $titleconst"; echo $news[2][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[2][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[2][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Расписание работы в майские праздники</h1>
                <h3 class="page__title-h3">Уважаемые клиенты!</h3>
                <p class="page__text">Рады Вам сообщить, что, несмотря на праздники, наш магазин работает по прежнему графику.</p>
                <div align="center">
                    <img src="/images/news/300417/01.jpg" alt="1 май" width="300px">
                </div> <?php
            } elseif ($newspage == 'akcia_na_boksy') {
                echo "<title> $titleconst"; echo $news[9][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[9][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[9][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Горячее предложение от магазина Autobagaz!</h1>
                <p align="center" class="page__textф">В связи с сезоном отпусков и поездок за город наш магазин решил сделать Вам приятный подарок!</p>
                <p class="page__text"><b>Автобокс Vetlan 400</b></p>
                <ol class="page__list">
                    <li>Размер: 165х80х35см</li>
                    <li>Литраж: 400 л</li>
                    <li>Материал: ABC</li>
                    <li>Крепление: скобочное (на любой вид багажников)</li>
                    <li>Замок: три точки запирания</li>
                    <li>Варианты цветов: Черный, серый, белый</li>
                </ol>
                <p class="page__text"><b>Цена 9000 рублей</b></p>
                <p class="page__text">Боксов в наличии <span class="page__strike"><span class="page__text">4 штуки</span></span> 1 штука.</p>
                <div class="img_div">
                    <img class="img_main" src="/images/news/030517/akcia.jpg" srcset="
		/images/news/030517/akcia.jpg 300w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="Акция">
                </div> <?php
            } elseif ($newspage == '12_june') {
                echo "<title> $titleconst"; echo $news[10][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[10][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[10][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Расписание работы 12 июня</h1>
                <p class="page__text" align="center">Уважаемые клиенты!</p>
                <p class="page__text">Рады Вам сообщить, что, несмотря на праздник, наш магазин работает с 10-00 до 16-00.</p>
                <div class="img_div">
                    <img class="img_main" src="/images/news/110617/12june.jpg" srcset="
		/images/news/110617/12june.jpg 350w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="День России">
                </div> <?php
            } elseif ($newspage == 'cenopad') {
                echo "<title> $titleconst"; echo $news[11][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[11][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[11][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Внимание!!! AUTOBAGAZный ценопад!</h1>

                <p class="page__text">У вас все еще нет велокрепления?! Тогда мы идем к вам!</p>
                <p class="page__text"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Велокрепление для одного велосипеда - 1500 рублей.</p>
                <p class="page__text"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Велокрепление на фаркоп - 3800 рублей.</p>
                <p class="page__text">Приятные плюшки от магазина "AutobagaZ":</p>
                <p class="page__text"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Расширенная гарантия на оборудование +1 год от магазина, итого 3 года гарантии;</p>
                <p class="page__text"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Скидка 500 рублей на лыжные крепления;</p>
                <p class="page__text"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Вкуснейший чай или ароматный кофе;</p>
                <p class="page__text"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Бесплатный монтаж велооборудования.</p>
                <p class="page__text">Наш адрес: г. Пермь ул. Спешилова 102/29</p>
                <p class="page__text">Тел: 288-99-69</p>
                <div class="img_div">
                    <img class="img_main" src="/images/news/250717/farkop.jpg" srcset="/images/news/250717/farkop.jpg 700w" alt="Велокрепление на фаркоп" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/news/250717/krysha.jpg" srcset="/images/news/250717/krysha.jpg 700w" alt="Велокрепление на крышу" sizes="(max-width: 2000px) 150px, 300px, 350px">
                </div> <?php
            } elseif ($newspage == 'akcia_na_braslets') {
                echo "<title> $titleconst"; echo $news[12][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[12][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[12][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Внимание!!! Акция в магазине "AutobagaZ"!!!</h1>
                <p class="page__text">Браслет противоскольжения R12-15 - <strong>Цена 500 рублей/шт.</strong></p>
                <p class="page__text">При покупке 3 штук - четвертый в <strong>ПОДАРОК!</strong></p>
                <p class="page__text">Браслет противоскольжения R16-22 - <strong>Цена 1000 рублей/шт.</strong></p>
                <p class="page__text">При покупке 3 штук - четвертый в <strong>ПОДАРОК!</strong></p>
                <p class="page__text">Наш адрес: г. Пермь ул. Спешилова 102/29</p>
                <p class="page__text">Тел: 288-99-69</p>
                <div class="img_div">
                    <img class="img_main" src="/images/news/091017/akcia_braslet.jpg" srcset="/images/news/091017/akcia_braslet.jpg 300w" alt="Браслеты противоскольжения" sizes="(max-width: 2000px) 150px, 300px, 350px">
                </div> <?php
            } elseif ($newspage == 'oxota_na_autobagaz') {
                echo "<title> $titleconst"; echo $news[13][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[13][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[13][keywords]; echo "'/>"; ?>

                <h1 class="page__title-h1">Внимание!!! ОХОТА НА AUTOBAGAZ!</h1>
                <p class="page__text">Награда: 1000 рублей (Одна тысяча рублей) За поимку!</p>
                <p align="center" class="page__text"><strong>Правила охоты:</strong></p>
                <p class="page__text">1) Надо поймать машину с отличительными знаками на заднем стекле.
                    (Поимка осуществляется с путем обгона машины, по наклейке на заднем стекле вашего автомобиля мы поймем что вы участник и остановимся)</p>
                <p class="page__text">2)Делаем фотографию на фоне вашей машины с призом.</p>
                <p class="page__text">3)Забираете приз и едете довольные по своим делам</p>
                <p class="page__text">4)Поймать можно 1 раз в неделю. (Для всех участников акции)</p>
                <p class="page__text">(Да может так случится, что вы поймали, а приза уже нет. В подтверждении того что приз выдан, ФОТО в группе, если фото нет то приз еще не выдан)</p>
                <p class="page__text">ЛОВИМ: Volkswagen Jetta (фото наклеек ниже)</p>
                <p class="page__text">Пример наклейки которая должна быть у вас на стекле (ПРИМЕР)</p>
                <p align="center" class="page__text"><strong>Что для этого нужно?</strong></p>
                <p class="page__text">Быть участником группы в контакте <a class="page__link" href="https://vk.com/autobagaz" target="_blank">https://vk.com/autobagaz</a> (это нужно для того чтобы понимать, поймали на этой неделе машину или нет)</p>
                <p class="page__text">Взять наклейку в магазине "AutobagaZ" по адресу: г.Пермь ул.Спешилова 102/29</p>
                <p class="page__text">(Наклейку необходимо наклеить на заднее стекло вашего автомобиля)</p>
                <p class="page__text">Если все условия соблюдены, поздравляем вы участник ОХОТЫ!</p>
                <p class="page__text">Желаем удачи на дорогах! Как говорится, НИ гвоздя, НИ жезла.</p>
                <p class="page__text">Просим соблюдать правила дорожного движения во время ОХОТЫ (речь идет про обгон)</p>
                <div class="img_div">
                    <img class="img_main" src="/images/news/121017/1.jpg" srcset="/images/news/121017/1.jpg 100w" alt="Охота на Autobagaz" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/news/121017/2.jpg" srcset="/images/news/121017/2.jpg 300w" alt="Охота на Autobagaz" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/news/121017/3.jpg" srcset="/images/news/121017/3.jpg 1000w" alt="Охота на Autobagaz" sizes="(max-width: 2000px) 150px, 300px, 350px">
                </div>
                <H2 class="page__title-h2"> Поздравляем первого победителя!</H2>
                <p class="page__text">Алексею удалось поймать наш автомобиль в районе парка культуры (Кировский район).</p>
                <p class="page__text">Продолжаем охоту, господа!</p>
                <div class="img_div">
                    <img class="img_main" src="/images/news/121017/4.jpg" srcset="/images/news/121017/4.jpg 500w" alt="Охота на Autobagaz" sizes="(max-width: 2000px) 150px, 300px, 350px">
                    <img class="img_main" src="/images/news/121017/5.jpg" srcset="/images/news/121017/5.jpg 500w" alt="Охота на Autobagaz" sizes="(max-width: 2000px) 150px, 300px, 350px">
                </div>
                <?php
            } elseif ($newspage == 'rozygryzh_montblanc') {
                echo "<title> $titleconst"; echo $news[14][title]; echo "</title>";
                echo "<meta name='description' content='"; echo $news[14][description]; echo "'/>";
                echo "<meta name='keywords' content='"; echo $news[14][keywords]; echo "'/>"; ?>
            <h1 class="page__title-h1">Розыгрыш лыжных креплений Mont Blanc (для двух пар лыж)</h1>
            <p class="page__text">Магазин "AutoBagaz" поздравляет вас с наступающим Новым годом!</p>
            <p class="page__text">Розыгрыш проводится среди покупателей в период с 16.12.17 по 17.01.18 (Телефон для справок: 2-88-99-69)</p>
            <p class="page__text">Розыгрыш лыжного крепления Mont Blanc состоится <b>30.01.2018</b></p>
            <h4 class="page__title-h4">Розыгрыш ЗА РЕПОСТ! Разыгрываем три подарка!</h4>
            <p class="page__text"><i class="fa fa-star" aria-hidden="true"></i>1 место: Сертификат на 1500 рублей.</p>
            <p class="page__text"><i class="fa fa-star" aria-hidden="true"></i>2 место: Сертификат на 1000 рублей.</p>
            <p class="page__text"><i class="fa fa-star" aria-hidden="true"></i>3 место: Сертификат на 500 рублей.</p>
            <h4 class="page__title-h4">Что необходимо для участия в розыгрыше?</h4>
            <p class="page__text"><i class="fa fa-star" aria-hidden="true"></i>Вступить в группу <a class="page__link" href="https://vk.com/autobagaz" target="_blank">Автобоксы и Багажники | Пермь</a></p>
            <p class="page__text"><i class="fa fa-star" aria-hidden="true"></i>Сделать репост этой <a class="page__link" href="https://vk.com/wall-86325723_1143" target="_blank">записи</a></p>
            <p class="page__text"><i class="fa fa-star" aria-hidden="true"></i>Розыгрыш сертификатов состоится <b>09.01.2018</b></p>
            <p class="page__text">Дорогие друзья, мы рады вступить в новый год вместе с вами! Позвольте поздравить вас с этим замечательным праздником, пожелать здоровья, успехов и благополучия вам и вашим семьям. Чтобы в новом году были новые победы и свершения, исполнялись самые заветные желания. А мы и впредь будем помогать вам идти к своим целям, отдавая лучшее, что у нас есть. Искренне ваш, магазин <a class="page__link" href="/">AutoBagaz.ru</a></p>
            <p class="page__text">Сертификат дает возможность оплаты до 30% стоимости товаров нашего магазина.</p>
                <div class="img_div">
                    <img class="img_main" src="/images/news/191217/montblanc.jpg" srcset="/images/news/191217/montblanc.jpg 300w" alt="Розыгрыш лыжных креплений Mont Blanc" sizes="(max-width: 2000px) 150px, 300px, 350px">
                </div>
          <?php  } ?>
        </div>
    </div>
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/modules/footer/footer.html");
    include ($_SERVER["DOCUMENT_ROOT"]."/modules/counters.html"); ?>
</div>