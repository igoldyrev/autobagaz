<?php
include ($_SERVER["DOCUMENT_ROOT"]."/frames/keywords.php");
include ($_SERVER["DOCUMENT_ROOT"]."/frames/headtags.php");
	echo "<title> $titleconst"; echo $keywords[3][title]; echo "</title>";
	echo "<meta name='description' content='"; echo $keywords[3][description]; echo "'/>";
	echo "<meta name='keywords' content='"; echo $keywords[3][keywords]; echo "'/>";

include ($_SERVER["DOCUMENT_ROOT"]."/frames/header.html"); ?>
<div id="leftmenu">
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/leftmenu.html"); ?>
</div>
<div id="content">
<?php
$prewiew = [
	[
		'id' => '1',
		'pagename' => 'xray0303',
		'name' => 'Lada Xray',
		'img' => '<img class="img_main" src="/images/gallery/20170303_1_xray.jpg"  alt="Lada Xray" width="180px">',
		],
		[
		'id' => 2,
		'name' => 'BMW X5',
		'pagename' => 'bmwx5',
		'img' => '<img class="img_main" src="/images/gallery/20170429_1_bmwx5.jpg" alt="BMW X5" width="180px">',
		],
		[
		'id' => 3,
		'name' => 'Mazda MPV',
		'pagename' => 'mazdampv',
		'img' => '<img class="img_main" src="/images/gallery/20170511_1_mpv.jpg" alt="Mazda MPV" width="180px">',
		],
		[
		'id' => 4,
		'name' => 'UAZ Patriot',
		'pagename' => 'uazpatriot',
		'img' => '<img class="img_main" src="/images/gallery/20170513_1_patriot.jpg" alt="UAZ Patriot" width="180px">',
		],
		[
		'id' => 5,
		'name' => 'Volkswagen Jetta',
		'pagename' => 'wvjetta',
		'img' => '<img class="img_main" src="/images/gallery/20170517_1_jetta.jpg" alt="Volkswagen Jetta" width="180px">',
		],
		[
		'id' => 6,
		'name' => 'Nissan X-Trail',
		'pagename' => 'xtrail',
		'img' => '<img class="img_main" src="/images/gallery/20170517_1_xtrail.jpg" alt="Nissan X-Trail" width="180px">',
		],
		[
		'id' => 7,
		'name' => 'Lada 2111',
		'pagename' => 'lada2111',
		'img' => '<img class="img_main" src="/images/gallery/20170525_1_2111.jpg" alt="Lada 2111" width="180px">',
		],
		[
		'id' => 8,
		'name' => 'Lada Largus',
		'pagename' => 'ladalargus',
		'img' => '<img class="img_main" src="/images/gallery/20170525_1_lada.jpg" alt="Lada Largus" width="180px">',
		],
		[
		'id' => 9,
		'name' => 'Ford Focus 2',
		'pagename' => 'focus2',
		'img' => '<img class="img_main" src="/images/gallery/20170528_1_ford.jpg" alt="Ford Focus 2" width="180px">',
		],
		[
		'id' => 10,
		'name' => 'Kia Seed',
		'pagename' => 'seed',
		'img' => '<img class="img_main" src="/images/gallery/20170602_1_seed.jpg" alt="Kia Seed" width="180px">',
		],
		[
		'id' => 11,
		'name' => 'Lada Xray',
		'pagename' => 'xray0602',
		'img' => '<img class="img_main" src="/images/gallery/20170602_1_xray.jpg" alt="Lada Xray" width="180px">',
		],
		[
		'id' => 12,
		'name' => 'Niva Chevrolet',
		'pagename' => 'chevrolet',
		'img' => '<img class="img_main" src="/images/gallery/20170611_1_niva.jpg" alt="Niva Chevrolet" width="180px">',
		],
		[
		'id' => 13,
		'name' => 'Kia Rio',
		'pagename' => 'kiario',
		'img' => '<img class="img_main" src="/images/gallery/20170616_1_rio.jpg" alt="Kia Rio" width="180px">',
		],
		[
		'id' => 14,
		'name' => 'Lada 2107',
		'pagename' => 'lada2107',
		'img' => '<img class="img_main" src="/images/gallery/20170617_1_2107.jpg" alt="Lada 2107" width="180px">',
		],
		[
		'id' => 15,
		'name' => 'Mitsubisi Lancer',
		'pagename' => 'lancer',
		'img' => '<img class="img_main" src="/images/gallery/20170617_1_lancer.jpg" alt="Mitsubisi Lancer" width="180px">',
		],
		[
		'id' => 16,
		'name' => 'Subaru Outback',
		'pagename' => 'outback',
		'img' => '<img class="img_main" src="/images/gallery/20170617_1_outback.jpg" alt="Subaru Outback" width="180px">',
		],
		[
		'id' => 17,
		'name' => 'Lada 2111',
		'pagename' => '21110621',
		'img' => '<img class="img_main" src="/images/gallery/20170621_1_2111.jpg" alt="Lada 2111" width="180px">',
		],
		[
		'id' => 18,
		'name' => 'Volkswagen Polo',
		'pagename' => 'polo',
		'img' => '<img class="img_main" src="/images/gallery/20170621_1_polo.jpg" alt="Volkswagen Polo" width="180px">',
		],
		[
		'id' => 19,
		'name' => 'BMW X5',
		'pagename' => 'bmwx50621',
		'img' => '<img class="img_main" src="/images/gallery/20170621_1_x5.jpg" alt="BMW X5" width="180px">',
		],
		[
		'id' => 20,
		'name' => 'Chevrolet Niva',
		'pagename' => 'nivachevrolet',
		'img' => '<img class="img_main" src="/images/gallery/20170623_1_niva.jpg" alt="Chevrolet Niva" width="180px">',
		],
		[
		'id' => 21,
		'name' => 'Lifan X50',
		'pagename' => 'lifanx50',
		'img' => '<img class="img_main" src="/images/gallery/20170623_1_x50.jpg" alt="Lifan X50" width="180px">',
		],
		[
		'id' => 22,
		'name' => 'Reno Logan',
		'pagename' => 'renologan',
		'img' => '<img class="img_main" src="/images/gallery/20170716_1_logan.jpg" alt="Reno Logan" width="180px">',
		],
		[
		'id' => 23,
		'name' => 'Lada Xray',
		'pagename' => 'ladaxray2707',
		'img' => '<img class="img_main" src="/images/gallery/20170727_6_xray.jpg" alt="Lada Xray" width="180px">',
		],
		[
		'id' => 24,
		'name' => 'Skoda Rapid',
		'pagename' => 'rapid2807',
		'img' => '<img class="img_main" src="/images/gallery/20170728_1_rapid.jpg" alt="Skoda Rapid" width="180px">',
		],
		[
		'id' => 25,
		'name' => 'Lada Xray',
		'pagename' => 'ladaxray3007',
		'img' => '<img class="img_main" src="/images/gallery/20170730_1_xray.jpg" alt="Lada Xray" width="180px">',
		],
		[
		'id' => 26,
		'name' => 'Hyundai Creta',
		'pagename' => 'creta0108',
		'img' => '<img class="img_main" src="/images/gallery/20170801_3_creta.jpg" alt="Hyundai Creta" width="180px">',
		],
		[
		'id' => 27,
		'name' => 'Toyota Land Cryiser',
		'pagename' => 'cryiser0809',
		'img' => '<img class="img_main" src="/images/gallery/20170809_3_landcryiser.jpg" alt="Toyota Land Cryiser" width="180px">',
		],
		[
		'id' => 28,
		'name' => 'Reno Duster',
		'pagename' => 'duster0810',
		'img' => '<img class="img_main" src="/images/gallery/20170810_1_duster.jpg" alt="Reno Duster" width="180px">',
		],
		[
		'id' => 29,
		'name' => 'Reno Sandero',
		'pagename' => 'sandero0820',
		'img' => '<img class="img_main" src="/images/gallery/20170820_1_sandero.jpg" alt="Reno Sandero" width="180px">',
		],
		[
		'id' => 30,
		'name' => 'Skoda Ieti',
		'pagename' => 'ieti0826',
		'img' => '<img class="img_main" src="/images/gallery/20170826_1_ieti.jpg" alt="Skoda Ieti" width="180px">',
		],
		[
		'id' => 31,
		'name' => 'Hyundai ix35',
		'pagename' => 'ix358831',
		'img' => '<img class="img_main" src="/images/gallery/20170831_3_ix35.jpg" alt="Hyundai ix35" width="180px">',
		],
		[
		'id' => 32,
		'name' => 'Lada Xray',
		'pagename' => 'xray0902',
		'img' => '<img class="img_main" src="/images/gallery/20170902_1_xray.jpg" alt="Lada Xray" width="180px">',
		],
];
$gallery = [
		[
		'id' => 1,
		'name' => 'Lada Xray',
		'img1' => '<img class="img_main" src="/images/gallery/20170303_1_xray.jpg" srcset="/images/gallery/20170303_1_xray.jpg 900w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170303_2_xray.jpg" srcset="/images/gallery/20170303_2_xray.jpg 600w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170303_3_xray.jpg" srcset="/images/gallery/20170303_3_xray.jpg 600w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170303_4_xray.jpg" srcset="/images/gallery/20170303_4_xray.jpg 600w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170303_5_xray.jpg" srcset="/images/gallery/20170303_5_xray.jpg 500w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img6' => '<img class="img_main" src="/images/gallery/20170303_6_xray.jpg" srcset="/images/gallery/20170303_6_xray.jpg 700w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 2,
		'name' => 'BMW X5',
		'img1' => '<img class="img_main" src="/images/gallery/20170429_1_bmwx5.jpg" srcset="/images/gallery/20170429_1_bmwx5.jpg 900w" alt="BMW X5" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170429_2_bmwx5.jpg" srcset="/images/gallery/20170429_2_bmwx5.jpg 600w" alt="BMW X5" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170429_3_bmwx5.jpg" srcset="/images/gallery/20170429_3_bmwx5.jpg 600w" alt="BMW X5" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 3,
		'name' => 'Mazda MPV',
		'img1' => '<img class="img_main" src="/images/gallery/20170511_1_mpv.jpg" srcset="/images/gallery/20170511_1_mpv.jpg 700w" alt="Mazda MPV" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170511_2_mpv.jpg" srcset="/images/gallery/20170511_2_mpv.jpg 900w" alt="Mazda MPV" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170511_3_mpv.jpg" srcset="/images/gallery/20170511_3_mpv.jpg 900w" alt="Mazda MPV" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170511_4_mpv.jpg" srcset="/images/gallery/20170511_4_mpv.jpg 800w" alt="Mazda MPV" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 4,
		'name' => 'UAZ Patriot',
		'img1' => '<img class="img_main" src="/images/gallery/20170513_1_patriot.jpg" srcset="/images/gallery/20170513_1_patriot.jpg 500w" alt="UAZ Patriot" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170513_2_patriot.jpg" srcset="/images/gallery/20170513_2_patriot.jpg 500w" alt="UAZ Patriot" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170513_3_patriot.jpg" srcset="/images/gallery/20170513_3_patriot.jpg 600w" alt="UAZ Patriot" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170513_4_patriot.jpg" srcset="/images/gallery/20170513_4_patriot.jpg 600w" alt="UAZ Patriot" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170513_5_patriot.jpg" srcset="/images/gallery/20170513_5_patriot.jpg 600w" alt="UAZ Patriot" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img6' => '<img class="img_main" src="/images/gallery/20170513_6_patriot.jpg" srcset="/images/gallery/20170513_6_patriot.jpg 500w" alt="UAZ Patriot" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img7' => '<img class="img_main" src="/images/gallery/20170513_7_patriot.jpg" srcset="/images/gallery/20170513_7_patriot.jpg 600w" alt="UAZ Patriot" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img8' => '<img class="img_main" src="/images/gallery/20170513_8_patriot.jpg" srcset="/images/gallery/20170513_8_patriot.jpg 600w" alt="UAZ Patriot" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 5,
		'name' => 'Volkswagen Jetta',
		'img1' => '<img class="img_main" src="/images/gallery/20170517_1_jetta.jpg" srcset="/images/gallery/20170517_1_jetta.jpg 600w" alt="Volkswagen Jetta" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170517_2_jetta.jpg" srcset="/images/gallery/20170517_2_jetta.jpg 700w" alt="Volkswagen Jetta" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170517_3_jetta.jpg" srcset="/images/gallery/20170517_3_jetta.jpg 600w" alt="Volkswagen Jetta" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 6,
		'name' => 'Nissan X-Trail',
		'img1' => '<img class="img_main" src="/images/gallery/20170517_1_xtrail.jpg" srcset="/images/gallery/20170517_1_xtrail.jpg 700w" alt="Nissan X-Trail" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170517_2_xtrail.jpg" srcset="/images/gallery/20170517_2_xtrail.jpg 600w" alt="Nissan X-Trail" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170517_3_xtrail.jpg" srcset="/images/gallery/20170517_3_xtrail.jpg 500w" alt="Nissan X-Trail" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170517_4_xtrail.jpg" srcset="/images/gallery/20170517_4_xtrail.jpg 700w" alt="Nissan X-Trail" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170517_5_xtrail.jpg" srcset="/images/gallery/20170517_5_xtrail.jpg 600w" alt="Nissan X-Trail" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img6' => '<img class="img_main" src="/images/gallery/20170517_6_xtrail.jpg" srcset="/images/gallery/20170517_6_xtrail.jpg 700w" alt="Nissan X-Trail" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 7,
		'name' => 'Lada 2111',
		'img1' => '<img class="img_main" src="/images/gallery/20170525_1_2111.jpg" srcset="/images/gallery/20170525_1_2111.jpg 900w" alt="Lada 2111" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170525_2_2111.jpg" srcset="/images/gallery/20170525_2_2111.jpg 700w" alt="Lada 2111" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170525_3_2111.jpg" srcset="/images/gallery/20170525_3_2111.jpg 700w" alt="Lada 2111" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170525_4_2111.jpg" srcset="/images/gallery/20170525_4_2111.jpg 900w" alt="Lada 2111" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170525_5_2111.jpg" srcset="/images/gallery/20170525_5_2111.jpg 700w" alt="Lada 2111" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 8,
		'name' => 'Lada Largus',
		'img1' => '<img class="img_main" src="/images/gallery/20170525_1_lada.jpg" srcset="/images/gallery/20170525_1_lada.jpg 800w" alt="Lada Largus" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170525_2_lada.jpg" srcset="/images/gallery/20170525_2_lada.jpg 700w" alt="Lada Largus" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170525_3_lada.jpg" srcset="/images/gallery/20170525_3_lada.jpg 700w" alt="Lada Largus" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 9,
		'name' => 'Ford Focus 2',
		'img1' => '<img class="img_main" src="/images/gallery/20170528_1_ford.jpg" srcset="/images/gallery/20170528_1_ford.jpg 900w" alt="Ford Focus 2" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170528_2_ford.jpg" srcset="/images/gallery/20170528_2_ford.jpg 600w" alt="Ford Focus 2" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170528_3_ford.jpg" srcset="/images/gallery/20170528_3_ford.jpg 600w" alt="Ford Focus 2" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 10,
		'name' => 'Kia Seed',
		'img1' => '<img class="img_main" src="/images/gallery/20170602_1_seed.jpg" srcset="/images/gallery/20170602_1_seed.jpg 800w" alt="Kia Seed" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170602_2_seed.jpg" srcset="/images/gallery/20170602_2_seed.jpg 600w" alt="Kia Seed" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170602_3_seed.jpg" srcset="/images/gallery/20170602_3_seed.jpg 600w" alt="Kia Seed" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170602_4_seed.jpg" srcset="/images/gallery/20170602_4_seed.jpg 600w" alt="Kia Seed" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 11,
		'name' => 'Lada Xray',
		'img1' => '<img class="img_main" src="/images/gallery/20170602_1_xray.jpg" srcset="/images/gallery/20170602_1_xray.jpg 900w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170602_2_xray.jpg" srcset="/images/gallery/20170602_2_xray.jpg 800w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170602_3_xray.jpg" srcset="/images/gallery/20170602_3_xray.jpg 800w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170602_4_xray.jpg" srcset="/images/gallery/20170602_4_xray.jpg 800w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170602_5_xray.jpg" srcset="/images/gallery/20170602_5_xray.jpg 800w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img6' => '<img class="img_main" src="/images/gallery/20170602_6_xray.jpg" srcset="/images/gallery/20170602_6_xray.jpg 800w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img7' => '<img class="img_main" src="/images/gallery/20170602_7_xray.jpg" srcset="/images/gallery/20170602_7_xray.jpg 800w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 12,
		'name' => 'Niva Chevrolet',
		'img1' => '<img class="img_main" src="/images/gallery/20170611_1_niva.jpg" srcset="/images/gallery/20170611_1_niva.jpg 900w" alt="Niva Chevrolet" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170611_2_niva.jpg" srcset="/images/gallery/20170611_2_niva.jpg 800w" alt="Niva Chevrolet" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170611_3_niva.jpg" srcset="/images/gallery/20170611_3_niva.jpg 800w" alt="Niva Chevrolet" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170611_4_niva.jpg" srcset="/images/gallery/20170611_4_niva.jpg 800w" alt="Niva Chevrolet" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170611_5_niva.jpg" srcset="/images/gallery/20170611_5_niva.jpg 800w" alt="Niva Chevrolet" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 13,
		'name' => 'Kia Rio',
		'img1' => '<img class="img_main" src="/images/gallery/20170616_1_rio.jpg" srcset="/images/gallery/20170616_1_rio.jpg 800w" alt="Kia Rio" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170616_2_rio.jpg" srcset="/images/gallery/20170616_2_rio.jpg 600w" alt="Kia Rio" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170616_3_rio.jpg" srcset="/images/gallery/20170616_3_rio.jpg 600w" alt="Kia Rio" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 14,
		'name' => 'Lada 2107',
		'img1' => '<img class="img_main" src="/images/gallery/20170617_1_2107.jpg" srcset="/images/gallery/20170617_1_2107.jpg 900w" alt="Lada 2107" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170617_2_2107.jpg" srcset="/images/gallery/20170617_2_2107.jpg 700w" alt="Lada 2107" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170617_3_2107.jpg" srcset="/images/gallery/20170617_3_2107.jpg 700w" alt="Lada 2107" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 15,
		'name' => 'Mitsubisi Lancer',
		'img1' => '<img class="img_main" src="/images/gallery/20170617_1_lancer.jpg" srcset="/images/gallery/20170617_1_lancer.jpg 2000w" alt="Mitsubisi Lancer" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170617_2_lancer.jpg" srcset="/images/gallery/20170617_2_lancer.jpg 2000w" alt="Mitsubisi Lancer" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170617_3_lancer.jpg" srcset="/images/gallery/20170617_3_lancer.jpg 2000w" alt="Mitsubisi Lancer" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170617_4_lancer.jpg" srcset="/images/gallery/20170617_4_lancer.jpg 1500w" alt="Mitsubisi Lancer" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 16,
		'name' => 'Subaru Outback',
		'img1' => '<img class="img_main" src="/images/gallery/20170617_1_outback.jpg" srcset="/images/gallery/20170617_1_outback.jpg 600w" alt="Subaru Outback" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170617_2_outback.jpg" srcset="/images/gallery/20170617_2_outback.jpg 600w" alt="Subaru Outback" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 17,
		'name' => 'Lada 2111',
		'img1' => '<img class="img_main" src="/images/gallery/20170621_1_2111.jpg" srcset="/images/gallery/20170621_1_2111.jpg 2000w" alt="Lada 2111" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170621_2_2111.jpg" srcset="/images/gallery/20170621_2_2111.jpg 2000w" alt="Lada 2111" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170621_3_2111.jpg" srcset="/images/gallery/20170621_3_2111.jpg 2000w" alt="Lada 2111" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 18,
		'name' => 'Volkswagen Polo',
		'img1' => '<img class="img_main" src="/images/gallery/20170621_1_polo.jpg" srcset="/images/gallery/20170621_1_polo.jpg 2000w" alt="Volkswagen Polo" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170621_2_polo.jpg" srcset="/images/gallery/20170621_2_polo.jpg 2000w" alt="Volkswagen Polo" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170621_3_polo.jpg" srcset="/images/gallery/20170621_3_polo.jpg 2000w" alt="Volkswagen Polo" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170621_4_polo.jpg" srcset="/images/gallery/20170621_4_polo.jpg 2000w" alt="Volkswagen Polo" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170621_5_polo.jpg" srcset="/images/gallery/20170621_5_polo.jpg 2000w" alt="Volkswagen Polo" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 19,
		'name' => 'BMW X5',
		'img1' => '<img class="img_main" src="/images/gallery/20170621_1_x5.jpg" srcset="/images/gallery/20170621_1_x5.jpg 2000w" alt="BMW X5" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170621_2_x5.jpg" srcset="/images/gallery/20170621_2_x5.jpg 2000w" alt="BMW X5" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170621_3_x5.jpg" srcset="/images/gallery/20170621_3_x5.jpg 2000w" alt="BMW X5" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 20,
		'name' => 'Chevrolet Niva',
		'img1' => '<img class="img_main" src="/images/gallery/20170623_1_niva.jpg" srcset="/images/gallery/20170623_1_niva.jpg 2000w" alt="Chevrolet Niva" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170623_2_niva.jpg" srcset="/images/gallery/20170623_2_niva.jpg 2000w" alt="Chevrolet Niva" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170623_3_niva.jpg" srcset="/images/gallery/20170623_3_niva.jpg 2000w" alt="Chevrolet Niva" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 21,
		'name' => 'Lifan X50',
		'img1' => '<img class="img_main" src="/images/gallery/20170623_1_x50.jpg" srcset="/images/gallery/20170623_1_x50.jpg 2000w" alt="Lifan X50" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170623_2_x50.jpg" srcset="/images/gallery/20170623_2_x50.jpg 2000w" alt="Lifan X50" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170623_3_x50.jpg" srcset="/images/gallery/20170623_3_x50.jpg 2000w" alt="Lifan X50" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 22,
		'name' => 'Reno Logan',
		'img1' => '<img class="img_main" src="/images/gallery/20170716_1_logan.jpg" srcset="/images/gallery/20170716_1_logan.jpg 2000w" alt="Reno Logan" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170716_2_logan.jpg" srcset="/images/gallery/20170716_2_logan.jpg 2000w" alt="Reno Logan" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 23,
		'name' => 'Lada Xray',
		'img1' => '<img class="img_main" src="/images/gallery/20170727_1_xray.jpg" srcset="/images/gallery/20170727_1_xray.jpg 2000w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170727_2_xray.jpg" srcset="/images/gallery/20170727_2_xray.jpg 2000w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170727_3_xray.jpg" srcset="/images/gallery/20170727_3_xray.jpg 2000w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170727_4_xray.jpg" srcset="/images/gallery/20170727_4_xray.jpg 2000w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170727_5_xray.jpg" srcset="/images/gallery/20170727_5_xray.jpg 2000w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img6' => '<img class="img_main" src="/images/gallery/20170727_6_xray.jpg" srcset="/images/gallery/20170727_6_xray.jpg 2000w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img7' => '<img class="img_main" src="/images/gallery/20170727_7_xray.jpg" srcset="/images/gallery/20170727_7_xray.jpg 2000w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 24,
		'name' => 'Skoda Rapid',
		'img1' => '<img class="img_main" src="/images/gallery/20170728_1_rapid.jpg" srcset="/images/gallery/20170728_1_rapid.jpg 2000w" alt="Skoda Rapid" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170728_2_rapid.jpg" srcset="/images/gallery/20170728_2_rapid.jpg 2000w" alt="Skoda Rapid" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170728_3_rapid.jpg" srcset="/images/gallery/20170728_3_rapid.jpg 2000w" alt="Skoda Rapid" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 25,
		'name' => 'Lada Xray',
		'img1' => '<img class="img_main" src="/images/gallery/20170730_1_xray.jpg" srcset="/images/gallery/20170730_1_xray.jpg 1500w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170730_2_xray.jpg" srcset="/images/gallery/20170730_2_xray.jpg 1500w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170730_3_xray.jpg" srcset="/images/gallery/20170730_3_xray.jpg 1500w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170730_4_xray.jpg" srcset="/images/gallery/20170730_4_xray.jpg 1500w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170730_5_xray.jpg" srcset="/images/gallery/20170730_5_xray.jpg 1500w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 26,
		'name' => 'Hyundai Creta',
		'img1' => '<img class="img_main" src="/images/gallery/20170801_1_creta.jpg" srcset="/images/gallery/20170801_1_creta.jpg 1100w" alt="Hyundai Creta" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170801_2_creta.jpg" srcset="/images/gallery/20170801_2_creta.jpg 1100w" alt="Hyundai Creta" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170801_3_creta.jpg" srcset="/images/gallery/20170801_3_creta.jpg 1100w" alt="Hyundai Creta" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170801_4_creta.jpg" srcset="/images/gallery/20170801_4_creta.jpg 1100w" alt="Hyundai Creta" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170801_5_creta.jpg" srcset="/images/gallery/20170801_5_creta.jpg 1100w" alt="Hyundai Creta" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img6' => '<img class="img_main" src="/images/gallery/20170801_6_creta.jpg" srcset="/images/gallery/20170801_6_creta.jpg 1100w" alt="Hyundai Creta" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 27,
		'name' => 'Toyota Land Cryiser',
		'img1' => '<img class="img_main" src="/images/gallery/20170809_1_landcryiser.jpg" srcset="/images/gallery/20170809_1_landcryiser.jpg 1100w" alt="Toyota Land Cryiser" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170809_2_landcryiser.jpg" srcset="/images/gallery/20170809_2_landcryiser.jpg 1100w" alt="Toyota Land Cryiser" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170809_3_landcryiser.jpg" srcset="/images/gallery/20170809_3_landcryiser.jpg 1100w" alt="Toyota Land Cryiser" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 28,
		'name' => 'Reno Duster',
		'img1' => '<img class="img_main" src="/images/gallery/20170810_1_duster.jpg" srcset="/images/gallery/20170810_1_duster.jpg 1100w" alt="Reno Duster" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170810_2_duster.jpg" srcset="/images/gallery/20170810_2_duster.jpg 1100w" alt="Reno Duster" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170810_3_duster.jpg" srcset="/images/gallery/20170810_3_duster.jpg 1100w" alt="Reno Duster" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 29,
		'name' => 'Reno Sandero',
		'img1' => '<img class="img_main" src="/images/gallery/20170820_1_sandero.jpg" srcset="/images/gallery/20170820_1_sandero.jpg 1100w" alt="Reno Sandero" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170820_2_sandero.jpg" srcset="/images/gallery/20170820_2_sandero.jpg 1100w" alt="Reno Sandero" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170820_3_sandero.jpg" srcset="/images/gallery/20170820_3_sandero.jpg 1100w" alt="Reno Sandero" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170820_4_sandero.jpg" srcset="/images/gallery/20170820_4_sandero.jpg 1100w" alt="Reno Sandero" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170820_5_sandero.jpg" srcset="/images/gallery/20170820_5_sandero.jpg 1100w" alt="Reno Sandero" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 30,
		'name' => 'Skoda Ieti',
		'img1' => '<img class="img_main" src="/images/gallery/20170826_1_ieti.jpg" srcset="/images/gallery/20170826_1_ieti.jpg 1100w" alt="Skoda Ieti" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170826_2_ieti.jpg" srcset="/images/gallery/20170826_2_ieti.jpg 1100w" alt="Skoda Ieti" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 31,
		'name' => 'Hyundai ix35',
		'img1' => '<img class="img_main" src="/images/gallery/20170831_1_ix35.jpg" srcset="/images/gallery/20170831_1_ix35.jpg 1100w" alt="Hyundai ix35" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170831_2_ix35.jpg" srcset="/images/gallery/20170831_2_ix35.jpg 1100w" alt="Hyundai ix35" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170831_3_ix35.jpg" srcset="/images/gallery/20170831_3_ix35.jpg 1100w" alt="Hyundai ix35" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
		[
		'id' => 32,
		'name' => 'Lada Xray',
		'img1' => '<img class="img_main" src="/images/gallery/20170902_1_xray.jpg" srcset="/images/gallery/20170902_1_xray.jpg 1100w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img2' => '<img class="img_main" src="/images/gallery/20170902_2_xray.jpg" srcset="/images/gallery/20170902_2_xray.jpg 1100w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img3' => '<img class="img_main" src="/images/gallery/20170902_3_xray.jpg" srcset="/images/gallery/20170902_3_xray.jpg 1100w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img4' => '<img class="img_main" src="/images/gallery/20170902_4_xray.jpg" srcset="/images/gallery/20170902_4_xray.jpg 1100w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		'img5' => '<img class="img_main" src="/images/gallery/20170902_5_xray.jpg" srcset="/images/gallery/20170902_5_xray.jpg 1100w" alt="Lada Xray" sizes="(max-width: 2000px) 150px, 300px, 350px">',
		],
];

echo "<h1>Галерея работ</h1>";

	$auto = $_GET['auto'];
	
	if (!isset($auto)) {
	echo "<p>В этом разделе приведены фотографии наших клиентов, которые когда-либо приобретали у нас багажник или автобокс. Как Вы видите, у нас действительно есть выбор практически на любой автомобиль!</p>";
		foreach ($prewiew as $block): ?>
	<div class="gallery">
	<div class="img_div">
		<?php echo $block['img']; ?>
	</div>
	<div align="center">
	<a href="gallery?auto=<?php echo $block['pagename']; ?>"><?php echo $block['name']; ?></a></div></div>
<?php endforeach; 
	} elseif ($auto == 'xray0303') {
	 ?> <h3> <?php echo $gallery[0][name]; ?> </h3> 
			<div class="img_div"> <?php
				echo $gallery[0][img1]; 
				echo $gallery[0][img2];
				echo $gallery[0][img3];  
				echo $gallery[0][img4];  
				echo $gallery[0][img5];  
				echo $gallery[0][img6];  
				echo $gallery[0][img7];
				echo $gallery[0][img8];
				echo '</div>';
	} elseif ($auto == 'bmwx5') {
	?> <h3> <?php echo $gallery[1][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[1][img1]; 
				echo $gallery[1][img2];
				echo $gallery[1][img3];  
				echo $gallery[1][img4];  
				echo $gallery[1][img5];  
				echo $gallery[1][img6];  
				echo $gallery[1][img7];
				echo $gallery[1][img8];
				echo '</div>';
	} elseif ($auto == 'mazdampv') {
	?> <h3> <?php echo $gallery[2][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[2][img1]; 
				echo $gallery[2][img2];
				echo $gallery[2][img3];  
				echo $gallery[2][img4];  
				echo $gallery[2][img5];  
				echo $gallery[2][img6];  
				echo $gallery[2][img7];
				echo $gallery[2][img8];
				echo '</div>';
	} elseif ($auto == 'uazpatriot') {
	?> <h3> <?php echo $gallery[3][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[3][img1]; 
				echo $gallery[3][img2];
				echo $gallery[3][img3];  
				echo $gallery[3][img4];  
				echo $gallery[3][img5];  
				echo $gallery[3][img6];  
				echo $gallery[3][img7];
				echo $gallery[3][img8];
				echo '</div>';
	} elseif ($auto == 'wvjetta') {
	?> <h3> <?php echo $gallery[4][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[4][img1]; 
				echo $gallery[4][img2];
				echo $gallery[4][img3];  
				echo $gallery[4][img4];  
				echo $gallery[4][img5];  
				echo $gallery[4][img6];  
				echo $gallery[4][img7];
				echo $gallery[4][img8];
				echo '</div>';
	} elseif ($auto == 'xtrail') {
	?> <h3> <?php echo $gallery[5][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[5][img1]; 
				echo $gallery[5][img2];
				echo $gallery[5][img3];  
				echo $gallery[5][img4];  
				echo $gallery[5][img5];  
				echo $gallery[5][img6];  
				echo $gallery[5][img7];
				echo $gallery[5][img8];
				echo '</div>';
	} elseif ($auto == 'lada2111') {
	?> <h3> <?php echo $gallery[6][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[6][img1]; 
				echo $gallery[6][img2];
				echo $gallery[6][img3];  
				echo $gallery[6][img4];  
				echo $gallery[6][img5];  
				echo $gallery[6][img6];  
				echo $gallery[6][img7];
				echo $gallery[6][img8];
				echo '</div>';
	} elseif ($auto == 'ladalargus') {
	?> <h3> <?php echo $gallery[7][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[7][img1]; 
				echo $gallery[7][img2];
				echo $gallery[7][img3];  
				echo $gallery[7][img4];  
				echo $gallery[7][img5];  
				echo $gallery[7][img6];  
				echo $gallery[7][img7];
				echo $gallery[7][img8];
				echo '</div>';
	} elseif ($auto == 'focus2') {
	?> <h3> <?php echo $gallery[8][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[8][img1]; 
				echo $gallery[8][img2];
				echo $gallery[8][img3];  
				echo $gallery[8][img4];  
				echo $gallery[8][img5];  
				echo $gallery[8][img6];  
				echo $gallery[8][img7];
				echo $gallery[8][img8];
				echo '</div>';
	} elseif ($auto == 'seed') {
	?> <h3> <?php echo $gallery[9][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[9][img1]; 
				echo $gallery[9][img2];
				echo $gallery[9][img3];  
				echo $gallery[9][img4];  
				echo $gallery[9][img5];  
				echo $gallery[9][img6];  
				echo $gallery[9][img7];
				echo $gallery[9][img8];
				echo '</div>';
	} elseif ($auto == 'xray0602') {
	?> <h3> <?php echo $gallery[10][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[10][img1]; 
				echo $gallery[10][img2];
				echo $gallery[10][img3];  
				echo $gallery[10][img4];  
				echo $gallery[10][img5];  
				echo $gallery[10][img6];  
				echo $gallery[10][img7];
				echo $gallery[10][img8];
				echo '</div>';
	} elseif ($auto == 'chevrolet') {
	?> <h3> <?php echo $gallery[11][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[11][img1]; 
				echo $gallery[11][img2];
				echo $gallery[11][img3];  
				echo $gallery[11][img4];  
				echo $gallery[11][img5];  
				echo $gallery[11][img6];  
				echo $gallery[11][img7];
				echo $gallery[11][img8];
				echo '</div>';
	} elseif ($auto == 'kiario') {
	?> <h3> <?php echo $gallery[12][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[12][img1]; 
				echo $gallery[12][img2];
				echo $gallery[12][img3];  
				echo $gallery[12][img4];  
				echo $gallery[12][img5];  
				echo $gallery[12][img6];  
				echo $gallery[12][img7];
				echo $gallery[12][img8];
				echo '</div>';
	} elseif ($auto == 'lada2107') {
	?> <h3> <?php echo $gallery[13][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[13][img1]; 
				echo $gallery[13][img2];
				echo $gallery[13][img3];  
				echo $gallery[13][img4];  
				echo $gallery[13][img5];  
				echo $gallery[13][img6];  
				echo $gallery[13][img7];
				echo $gallery[13][img8];
				echo '</div>';
	} elseif ($auto == 'lancer') {
	?> <h3> <?php echo $gallery[14][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[14][img1]; 
				echo $gallery[14][img2];
				echo $gallery[14][img3];  
				echo $gallery[14][img4];  
				echo $gallery[14][img5];  
				echo $gallery[14][img6];  
				echo $gallery[14][img7];
				echo $gallery[14][img8];
				echo '</div>';
	} elseif ($auto == 'outback') {
	?> <h3> <?php echo $gallery[15][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[15][img1]; 
				echo $gallery[15][img2];
				echo $gallery[15][img3];  
				echo $gallery[15][img4];  
				echo $gallery[15][img5];  
				echo $gallery[15][img6];  
				echo $gallery[15][img7];
				echo $gallery[15][img8];
				echo '</div>';
	} elseif ($auto == '21110621') {
	?> <h3> <?php echo $gallery[16][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[16][img1]; 
				echo $gallery[16][img2];
				echo $gallery[16][img3];  
				echo $gallery[16][img4];  
				echo $gallery[16][img5];  
				echo $gallery[16][img6];  
				echo $gallery[16][img7];
				echo $gallery[16][img8];
				echo '</div>';
	} elseif ($auto == 'polo') {
	?> <h3> <?php echo $gallery[17][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[17][img1]; 
				echo $gallery[17][img2];
				echo $gallery[17][img3];  
				echo $gallery[17][img4];  
				echo $gallery[17][img5];  
				echo $gallery[17][img6];  
				echo $gallery[17][img7];
				echo $gallery[17][img8];
				echo '</div>';
	} elseif ($auto == 'bmwx50621') {
	?> <h3> <?php echo $gallery[18][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[18][img1]; 
				echo $gallery[18][img2];
				echo $gallery[18][img3];  
				echo $gallery[18][img4];  
				echo $gallery[18][img5];  
				echo $gallery[18][img6];  
				echo $gallery[18][img7];
				echo $gallery[18][img8];
				echo '</div>';
	} elseif ($auto == 'nivachevrolet') {
	?> <h3> <?php echo $gallery[19][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[19][img1]; 
				echo $gallery[19][img2];
				echo $gallery[19][img3];  
				echo $gallery[19][img4];  
				echo $gallery[19][img5];  
				echo $gallery[19][img6];  
				echo $gallery[19][img7];
				echo $gallery[19][img8];
				echo '</div>';
	} elseif ($auto == 'lifanx50') {
	?> <h3> <?php echo $gallery[20][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[20][img1]; 
				echo $gallery[20][img2];
				echo $gallery[20][img3];  
				echo $gallery[20][img4];  
				echo $gallery[20][img5];  
				echo $gallery[20][img6];  
				echo $gallery[20][img7];
				echo $gallery[20][img8];
				echo '</div>';
	} elseif ($auto == 'renologan') {
	?> <h3> <?php echo $gallery[21][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[21][img1]; 
				echo $gallery[21][img2];
				echo $gallery[21][img3];  
				echo $gallery[21][img4];  
				echo $gallery[21][img5];  
				echo $gallery[21][img6];  
				echo $gallery[21][img7];
				echo $gallery[21][img8];
				echo '</div>';
	} elseif ($auto == 'ladaxray2707') {
	?> <h3> <?php echo $gallery[22][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[22][img1]; 
				echo $gallery[22][img2];
				echo $gallery[22][img3];  
				echo $gallery[22][img4];  
				echo $gallery[22][img5];  
				echo $gallery[22][img6];  
				echo $gallery[22][img7];
				echo $gallery[22][img8];
				echo '</div>';
	} elseif ($auto == 'rapid2807') {
	?> <h3> <?php echo $gallery[23][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[23][img1]; 
				echo $gallery[23][img2];
				echo $gallery[23][img3];  
				echo $gallery[23][img4];  
				echo $gallery[23][img5];  
				echo $gallery[23][img6];  
				echo $gallery[23][img7];
				echo $gallery[23][img8];
				echo '</div>';
	} elseif ($auto == 'ladaxray3007') {
	?> <h3> <?php echo $gallery[24][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[24][img1]; 
				echo $gallery[24][img2];
				echo $gallery[24][img3];  
				echo $gallery[24][img4];  
				echo $gallery[24][img5];  
				echo $gallery[24][img6];  
				echo $gallery[24][img7];
				echo $gallery[24][img8];
				echo '</div>';
	} elseif ($auto == 'creta0108') {
	?> <h3> <?php echo $gallery[25][name]; ?> </h3> 
	<h4>Hyundai Creta без рейлинга</h4>
	<div class="img_div"> <?php
				echo $gallery[25][img1]; 
				echo $gallery[25][img2]; ?>
	<h4>Hyundai Creta с рейлингом</h4>
		<?php	echo $gallery[25][img3];  
				echo $gallery[25][img4];  
				echo $gallery[25][img5];  
				echo $gallery[25][img6];  
				echo $gallery[25][img7];
				echo $gallery[25][img8];
				echo '</div>';
	} elseif ($auto == 'cryiser0809') {
	?> <h3> <?php echo $gallery[26][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[26][img1]; 
				echo $gallery[26][img2];
				echo $gallery[26][img3];  
				echo $gallery[26][img4];  
				echo $gallery[26][img5];  
				echo $gallery[26][img6];  
				echo $gallery[26][img7];
				echo $gallery[26][img8];
				echo '</div>';
	} elseif ($auto == 'duster0810') {
	?> <h3> <?php echo $gallery[27][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[27][img1]; 
				echo $gallery[27][img2];
				echo $gallery[27][img3];  
				echo $gallery[27][img4];  
				echo $gallery[27][img5];  
				echo $gallery[27][img6];  
				echo $gallery[27][img7];
				echo $gallery[27][img8];
				echo '</div>';
	} elseif ($auto == 'sandero0820') {
	?> <h3> <?php echo $gallery[28][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[28][img1]; 
				echo $gallery[28][img2];
				echo $gallery[28][img3];  
				echo $gallery[28][img4];  
				echo $gallery[28][img5];  
				echo $gallery[28][img6];  
				echo $gallery[28][img7];
				echo $gallery[28][img8];
				echo '</div>';
	} elseif ($auto == 'ieti0826') {
	?> <h3> <?php echo $gallery[29][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[29][img1]; 
				echo $gallery[29][img2];
				echo $gallery[29][img3];  
				echo $gallery[29][img4];  
				echo $gallery[29][img5];  
				echo $gallery[29][img6];  
				echo $gallery[29][img7];
				echo $gallery[29][img8];
				echo '</div>';
	} elseif ($auto == 'ix358831') {
	?> <h3> <?php echo $gallery[30][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[30][img1]; 
				echo $gallery[30][img2];
				echo $gallery[30][img3];  
				echo $gallery[30][img4];  
				echo $gallery[30][img5];  
				echo $gallery[30][img6];  
				echo $gallery[30][img7];
				echo $gallery[30][img8];
				echo '</div>';
	} elseif ($auto == 'xray0902') {
	?> <h3> <?php echo $gallery[31][name]; ?> </h3> 	
	<div class="img_div"> <?php
				echo $gallery[31][img1]; 
				echo $gallery[31][img2];
				echo $gallery[31][img3];  
				echo $gallery[31][img4];  
				echo $gallery[31][img5];  
				echo $gallery[31][img6];  
				echo $gallery[301][img7];
				echo $gallery[31][img8];
				echo '</div>';
	}
?>	
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/footer.html");?>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/frames/counters.html");?>