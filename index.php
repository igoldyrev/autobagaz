<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<?php
$page = $_GET['page'];

if (!isset($page)) {
	echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[0][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>";
	include ($_SERVER["DOCUMENT_ROOT"]."/frames/newslist.php"); ?>
	
	<div class="catalog">
		<div class="menu_item">
			<div class="item_image">
			<a href="/autobagazhniki"><img src="/images/index/1_autobagazniki.jpg" alt="autobagazhniki" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/autobagazhniki">Автобагажники</a>
			</div>
		</div>
		<div class="menu_item">
			<div class="item_image">
			<a href="/autobox"><img src="/images/index/2_autobox.jpg" alt="autobox" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/autobox">Автомобильные боксы</a>
			</div>
		</div>
		<div class="menu_item">
			<div class="item_image">
			<a href="/velokreplenya"><img src="/images/index/3_velokreplenya.jpg" alt="velokreplenya" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/velokreplenya">Велокрепления</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/kreplenya-dlya-lyzh-shoubord"><img src="/images/index/4_lyzh_kreplenya.jpg" alt="lyzhnye kreplenya" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/kreplenya-dlya-lyzh-shoubord">Крепления для лыж и сноубордов</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/reelings"><img src="/images/index/6_reelings.jpg" alt="reelings" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/reelings">Рейлинги</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/braslets"><img src="/images/index/7_braslet.jpg" alt="braslet" width="175px"></a>
			</div>
			<div class="item_link">
			<a href="/braslets">Браслеты противоскольжения</a>
			</div>
		</div>
		<div class="menu_item">
		<div class="item_image">
			<a href="/farkops"><img src="/images/index/8_farkops.jpg" alt="farkops" width="125px"></a>
			</div>
			<div class="item_link">
			<a href="/farkops">Фаркопы</a>
			</div>
	</div></div>
	<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/sales.php"); ?>

	<h2>Наши бренды:</h2>
		<div align="center" class="brands">
			<img src="/images/logos/mont_blanc.jpg" alt="mont blanc" width="150px">
			<img src="/images/logos/lux.png" alt="lux" width="150px">
			<img src="/images/logos/atlant.png" alt="atlant" width="150px">
			<img src="/images/logos/amos.jpg" alt="amos" width="150px">
		</div>
		<div align="center" class="brands">
			<img src="/images/logos/yuago.png" alt="yuago" width="150px">
			<img src="/images/logos/atera.png" alt="atera" width="150px">
			<img src="/images/logos/menabo.jpg" alt="menabo" width="150px">
			<img src="/images/logos/yakima.png" alt="yakima" width="150px">
		</div>
		<div align="center" class="brands">
			<img src="/images/logos/vetlan.png" alt="vetlan" width="150px">
			<img src="/images/logos/turino.jpg" alt="turino" width="150px">
			<img src="/images/logos/inno.jpg" alt="inno" width="150px">
			<img src="/images/logos/whispbar.png" alt="whispbar" width="150px">
		</div>
		<div align="center" class="brands">
			<img src="/images/logos/myravei.png" alt="myravei" width="150px">
		</div>

		<p>Для многих современных людей автомобиль является не только свидетельством жизненного успеха, но и незаменимым помощником для перевозки грузов. Имея личное авто можно без проблем осуществить перевозку вещей в загородный дом или дачу или же снаряжения при занятиях активным отдыхом. Так, для осуществления грузоперевозок на легковом автомобиле существует багажник, устанавливаемый на крышу авто. Это может быт как простая и эстетичная конструкция, состоящая из двух дуг, так и более сложная, к примеру, автобокс или багажник для лодки. Наш магазин предлагает вашему вниманию автобагажники от известных мировых брендов. Если вам необходимо перевезти вещи или вы занимаетесь активным отдыхом – то вы попали по назначению. У нас вы сможете подобрать именно то, что вам нужно: автомобильные багажники, автомобильные боксы, которые станут незаменимыми помощниками при перевозке вещей и спортивного снаряжения. А для того, чтобы обеспечить вам комфорт и безопасность передвижения по зимней трассе, мы предлагаем вашему вниманию цепи противоскольжения от мировых производителей.</p>
	<h3>Универсальные багажники</h3>
		<p>В наиболее простом варианте такой автобагажник представляет собой две паралельные дуги. Благодаря простоте и функциональности, данная конструкция предназначена для перевозки любых грузов, позволяя надежно закрепить предметы. Кроме стандартных вариантов, существует также корзина для авто. Универсальные модели автобагажников в основном предназначаются для иномарок и современных российских авто. Потому, если вам нужно подобрать багажник для отечественного автомобиля, то придется буквально «примерять» различные модели, дабы подобрать наиболее удобную и подходящую.</p>
	<h3>Автобоксы</h3>
		<p>Такие багажники представляют собой конструкции в виде кейсов, которые изготавливаются из прочного толстого пластика. Такая конструкция позволяет полностью обезопасить ваш груз от атмосферных осадков, уличной грязи и злоумышленников, поскольку устройство оснащается надежным замком.</p>
	<h3>Специальные приспособления</h3>
		<p>К ним относится велокрепление, багажник для лодки и прочие всевозможные приспособления, специализированные под перевозку определённого вида грузов. Такие конструкции отлично подходят для тех, кто любит активный отдых или занимается определённым видом спорта. В данном случае, универсальный багажник окажется не очень удобным, а потому, современные производители разработали ряд специальных приспособлений и насадок к ним, обеспечивающих комфортную и безопасную перевозку конкретного вида снаряжения. Все большее количество людей в наши дни открывают для себя удобство и функциональность автобагажников. Современные конструкции совершенно не портят внешний вид вашего авто и выглядят эстетично, позволяя значительно расширить его функциональные возможности. К тому же у нас существует такая услуга, как прокат багажников и автобовков, что будет отличным вариантом в том случае, если автобагажник нужен вам единоразово и вы не видите прямой необходимости в его покупке.</p>
	<p class="brands" align="center">Mont Blanc (Монблан) Lux (Люкс) Atlant (Атлант) Amos (Амос) Yuago (ЯГО) Atera (Атера) Menabo (Менабо) Yakima (Якима) Turino (Турино) Inno (Инно) Whispbar (Виспбар) Myravei (Муравей) Vetlan (Ветлан)</p> <?php

	} elseif ($page == 'contacts') {
	echo "<title> $titleconst"; echo $keywords[6][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[6][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[6][keywords]; echo "'/>";

	echo "<p>Компания <b>Автобагаж</b></p>";
	echo "<p>Контакты для связи:</p>";
	echo "<p style='padding: 5px;line-height:2'>+7 (342) 288 99 69<br>+7 912 489 79 39 Валентин Сарафанов<br>+7 965 572 26 28 Илья Голдырев<br>+7 909 100 40 06 Денис Зарубин (руководитель)</p>";
	echo "<a href='mailto:autobagaz@yandex.ru'>autobagaz@yandex.ru</a>";
	echo "<p align='center'><b>Режим работы:</b></p>";
	echo "<p><b>Пн - Пт с 10:00 до 19:00</b></p>";
	echo "<p><b>Сб - Вс с 10:00 до 18:00</b></p>";
	echo "<p>Наш адрес: г.Пермь, Ул. Спешилова 102/29</p>";
	echo "<p align='center'><b>Мы находимся здесь:</b></p>"; ?>
	<div class="img_div">
		<img class="img_main" src="/images/contacts/shop_autobagaz_poster.jpg" srcset="
		/images/contacts/shop_autobagaz_poster.jpg 2100w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="autobagaz">
		<img class="img_main" src="/images/contacts/shop_autobagaz_back.jpg" srcset="
		/images/contacts/shop_autobagaz_back.jpg 2100w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="autobagaz">
		<img class="img_main" src="/images/logo_circle.jpg" srcset="
		/images/logo_circle.jpg 200w" sizes="(max-width: 2000px) 150px, 300px, 350px" alt="autobagaz">
	</div>
	<div><script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=dPv1vaWzXDrNMJs9tlKwl_50qOYIqktt&amp;width=100%&amp;height=250&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script></div> <?php	
	echo "<p>Индивидуальный предприниматель: Зарубин Денис Юрьевич<br>ИНН 590850700022 ОГРНИП 316595800158377<br>
	р/с 40802810149770015620 в Пермском отделении №6984 ПАО Сбербанк России<br>
	БИК 045773603 к/с № 30101810900000000603<br>
	Свидетельство о регистрации 59 004723382 от 17.11.2016</p>";
	} elseif ($page == 'komissionka') {
	echo "<title> $titleconst"; echo $keywords[5][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[5][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[5][keywords]; echo "'/>";
	
	include ($_SERVER["DOCUMENT_ROOT"]."/arrays/komissionka.php");

	echo "<h1>Комиссионка</h1>";
	echo "<p>В этом разделе мы продаем б/у багажники, автобоксы и аксессуары в рабочем состоянии. Часть багажников - использовались в прокате, часть - были оставлены на реализацию нашими клиентами. В течении 2-х недель вы можете вернуть багажник, если он вам не подойдет или окажется неисправен.</p>";
	echo "<p>Если у вас есть ненужный багажник - мы его купим.</p>";
	echo "<h2>Автомобильные багажники</h2>"; ?>
	<p><?php echo $bagazhniki[0][name]; ?> </p>
			<div class="img_div"> <?php
				echo $bagazhniki[0][img1];
				echo $bagazhniki[0][img2];
				echo $bagazhniki[0][img3];
				echo $bagazhniki[0][img4];
				echo $bagazhniki[0][img5];
				echo '</div>'; ?>
			<p><b><?php echo $bagazhniki[0][price]; ?></b></p>
	<p><?php echo $bagazhniki[1][name]; ?> </p>
			<div class="img_div"> <?php
				echo $bagazhniki[1][img1];
				echo $bagazhniki[1][img2];
				echo $bagazhniki[1][img3];
				echo $bagazhniki[1][img4];
				echo $bagazhniki[1][img5];
				echo '</div>'; ?>
			<p><b><?php echo $bagazhniki[1][price]; ?></b></p>
	<p><?php echo $bagazhniki[2][name]; ?> </p>
			<div class="img_div"> <?php
				echo $bagazhniki[2][img1];
				echo $bagazhniki[2][img2];
				echo $bagazhniki[2][img3];
				echo $bagazhniki[2][img4];
				echo $bagazhniki[2][img5];
				echo '</div>'; ?>
			<p><b><?php echo $bagazhniki[2][price]; ?></b></p>
	<p><?php echo $bagazhniki[3][name]; ?> </p>
			<div class="img_div"> <?php
				echo $bagazhniki[3][img1];
				echo $bagazhniki[3][img2];
				echo $bagazhniki[3][img3];
				echo $bagazhniki[3][img4];
				echo $bagazhniki[3][img5];
				echo '</div>'; ?>
			<p><b><?php echo $bagazhniki[3][price]; ?></b></p>
	<p><?php echo $bagazhniki[4][name]; ?> </p>
			<div class="img_div"> <?php
				echo $bagazhniki[4][img1];
				echo $bagazhniki[4][img2];
				echo $bagazhniki[4][img3];
				echo $bagazhniki[4][img4];
				echo $bagazhniki[4][img5];
				echo '</div>'; ?>
			<p><b><?php echo $bagazhniki[4][price]; ?></b></p>
	<?php echo "<h2>Фаркопы</h2>"; ?>
	<p><?php echo $farkops[0][name];?> </p>
			<div class="img_div"> <?php
				echo $farkops[0][img1];
				echo $farkops[0][img2];
				echo $farkops[0][img3];
				echo $farkops[0][img4];
				echo '</div>'; ?>
			<p><b><?php echo $farkops[0][price];?> </b></p>
	<?php echo "<h2>Корзины</h2>"; ?>
	<p><?php echo $korzins[0][name];?> </p>
			<div class="img_div"> <?php
				echo $korzins[0][img1];
				echo $korzins[0][img2];
				echo $korzins[0][img3];
				echo '</div>'; ?>
			<p><b><?php echo $korzins[0][price];?> </b></p> <?php
	} elseif ($page == 'podbor') {
	echo "<title> $titleconst"; echo $keywords[1][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[1][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[1][keywords]; echo "'/>";

	echo "<h1>Как подобрать бокс на крышу автомобиля?</h1>";
	echo "<p>Подобрать багажный автомобильный бокс не трудно! Главное это определить для себя приоритетные задачи, которые он будет выполнять. Ну, и конечно же, чтобы бокс, который вы выбрали, вам нравился! </p>";
	echo "<p>Итак, первое - определитесь, что вы хотите перевозить - кучу вещей, сноуборд или лыжи, палатку или надувную лодку. При подборе бокса на крышу автомобиля необходимо помнить, что внутренние размеры у него меньше на 5-7см, чем указанные наружные. Это необходимо учитывать, например, при перевозке лыж или сноубордов – бокс должен как минимум на 6см быть длиннее. </p>";
	echo "<p class='speechleft'>Какие должны быть размеры бокса?</p>"; ?>
	<div style="padding-top:15px">
	<p class="speechright">Далее определяемся с размерами бокса. Можно отталкиваться от габаритов вашего автомобиля. Хотя, честно скажу, во многих случаях это не имеет никакого значения, на крышу большого автомобиля можно установить маленький бокс , а на маленький автомобиль можно установить большой бокс. Все дело только в эстетическом виде - кому-то нравится, а кому-то нет. Определяющим здесь может стать угол открытия вверх пятой двери у автомобилей с кузовами типа универсал или хетчбек. Нависание автобокса над лобовым стеклом на 20-30см с водительского места никак не ощущается. Из этого всего можно вывести основные рекомендации по установке бокса: для автомобилей с пятой дверью (если она открывается наверх) крайними точками будут: 1) открытая вверх до конца дверь; 2) кромка лобового стекла + 30см; для всех прочих авто определяющими критериями будут габариты багажа и эстетика внешнего вида.</p>
	</div>
	<div style="padding-top:15px">
	<p class="speechleft">Как определиться с цветом бокса?</p>
	</div>
	<div style="padding-top:15px">
	<p class="speechright">Багажные боксы производятся в универсальной цветовой гамме: чёрные, серые или белые. Они могут быть матовые, либо глянцевые. Эти цвета настолько универсальны, что подойдут автомобилю любой расцветки. В крайнем случае, если вы хотите чего-то более экстравагантного, то всегда можно его перекрасить или приукрасить аэрографией. </p>
	</div>
	<div style="padding-top:15px">
	<p class="speechleft">Как автобокс влияет на расход топлива?</p>
	</div>
	<div style="padding-top:15px">
	<p class="speechright">Чем больше габаритные размеры бокса, тем выше сопротивление воздуха при движении. Существуют автобоксы с улучшенной аэродинамикой, такие как Thule Dynamic, Thule Excellence, Hapro Zenith, Menabo Mania. Но в любом случае порядка 1 литра топлива на сотню к расходу надо будет добавить.<br><br> 
	Удобство установки зависит от того, как бокс крепится к поперечинам базового багажника. Возможны разные варианты крепления: простейший - четырьмя скобами с 8-ю «барашками», на установку уйдет минут 15 и необходим помощник, который будет держать скобу, пока вы её прикручиваете; скобы с системой зажима Easy-Fit фирмы Hapro, на установку уйдет минут 5-7 и нужен помощник, удерживающий скобу, пока вы её затягиваете; «клешни» c системой затяжки Dual Force фирмы Thule, позволяющей зафиксировать бокс за 2-3 минуты, сделать это можно одному, без посторонней помощи. </p>
	</div>
	<div style="padding-top:15px">
	<p class="speechleft">Какие бывают системы открывания крышек автобоксов?</p>
	</div>
	<div style="padding-top:15px">
	<p class="speechright">Таковых бывает три типа: открывание бокса сзади, сбоку и с обеих сторон. Сразу скажу, что двухстороннее открытие даёт преимущество при установке автобокса – не надо тянуться к дальним точкам фиксации обтирая пыльный автомобиль (в случае, если крыша высокая, бывает, что без стремянки не обойтись) и при распределении багажа внутри бокса + возможность достать его с любой стороны.</p>
	</div>
	<div style="padding-top:15px">
	<p class="speechleft">Как выбрать бокс из наиболее качественного пластика?</p>
	</div>
	<div style="padding-top:15px">
	<p class="speechright">Качество пластика определяется устойчивостью к ультрафиолетовым лучам, ударопрочностью, отсутствием запаха. Имейте ввиду, что толстый пластик – это не всегда хорошо. Новейшие технологии производства позволяют использовать тонкий , эластичный и прочный пластик ABS , который даёт все выше перечисленные преимущества и в добавок он меньше весит. Из такого пластика делают свои багажные боксы все серьёзные производители. </p>
	</div>
	<div style="padding-top:15px">
	<p class="speechleft">А как мне выбрать наиболее лучшего производителя?</p>
	</div>
	<div style="padding-top:15px">
	<p class="speechright">Чем известней бренд, тем выше качество и комфорт в эксплуатации. Такими брендами являются известные всем фирмы, такие как: Thule - Швеция (флагман в мире багажников для автомобилей), Mont Blanc – Швеция, Hapro – Голландия. И менее известные: Menabo – Италия, Farad – Италия. <br><br>
	Так же существуют китайские производители боксов, которые внешне копируют знаменитые бренды, но не всегда их качество соответствует необходимым параметрам. Замечу, что и у китайских производителей, есть достойные представители жанра, такие как, например, Nord. 
	 </p>
	</div>
	<div style="padding-top:15px">
	<p class="speechleft">И все-таки, как мне выбрать такой бокс, чтобы он был совместим с моим багажником (поперечинами)?</p>
	</div>
	<div style="padding-top:15px; padding-bottom:10px">
	<p class="speechright">При выборе бокса на крышу уточняйте, насколько он будет совместим с перекладинами базового багажника. Перекладины бывают трёх видов:<br><br>Прямоугольные – на них устанавливаются все виды автобоксов с различными типами креплений.<br><br> 
	Овальные аэродинамические – на них устанавливается 85% багажных боксов со своими креплениями. Для оставшихся 15% необходимо будет приобрести дополнительные переходники в Т-образный профиль.<br><br>
	Крыло (Thule WingBar и Yakima Whispbar) - на них устанавливается 65% боксов на крышу, для остальных приобретаются переходники. Смею заметить, что такой профиль является третьим поколением багажников на крышу и представляет собой полностью бесшумный профиль, он наиболее комфортен, его преимущество в том, что вам нет необходимости снимать его с автомобиля. И ко всему он придает вашему средству передвижения эстетический вид. 
	</p></div> <?php 
	} elseif ($page == 'gallery') {
	echo "<title> $titleconst"; echo $keywords[3][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[3][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[3][keywords]; echo "'/>";

	echo "<h1>Здесь будет размещена галерея</h1>";
	}
?>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html"); ?>