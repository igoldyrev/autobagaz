<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include ($_SERVER["DOCUMENT_ROOT"]."/content/farkops/backend/keywords.php");
echo "<title> $titleconst"; echo $keywords[0][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[0][description];      echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[0][keywords]; echo "'/>"; ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php $_SESSION['url'] = $_SERVER['REQUEST_URI'];

        echo "<h1 class='title title-h1'>Фаркопы</h1>";
        echo "<p class='text'>В современном мире автомобиль уже не роскошь, а средство передвижения. Зачастую, помимо комфортной езды появляется необходимость перевозки длинномерного, широкого, или сыпучего груза. Часть задач можно снять <a class='link' href='/autobagazhniki'>багажником (дугами на крыше)</a>, но для некоторых грузов,таких как песок, щебень и др. - идеально подходит прицеп. Для надежного соединения автомобиля с прицепом служит специальное устройство - фаркоп (ТСУ). Так же, помимо перевозки грузов фаркопы используются для установки платформ для боксов или <a class='link' href='/velokreplenya/farkop'>велокреплений на фаркоп</a>.</p>";
        echo "<p class='text'>Тягово-сцепные устройства (фаркопы) различают на несколько видов, в зависимости от способа установки, нагрузок, защиты от кражи и проч:</p>"; ?>

            <ol class="list list--decimal">
                <div class="img__wrap">
                    <img class="img good__img" src="/content/farkops/img/a.jpg" alt="фаркоп тип А">
                </div>
                <li>фаркоп с шаром-крюком «Типа А»- самый распространенный вид ТСУ на данный момент. Имеет жесткое крепление рамы фаркопа к кузову автомобиля, а так же крюк, зажимаемый в пластинах, при помощи болтового соединения. Часто ,так же, такой вид фаркопов называют «усло-съемным», из-за возможности легкого демонтажа-просто открутите 2 болта и гайки.<br><br>Максимально допустимый вес прицепа с грузом-1500 кг. Нагрузка на шар-не более 150.</li>
                <li>фаркопы с шаром типа В - съемный, полуавтоматический крюк на гайке.</li>
                <div class="img__wrap">
                    <img class="img good__img" src="/content/farkops/img/c.jpg" alt="фаркоп тип C">
                </div>
                <li>фаркопы с шаром типа С - съемные шары на двух болтах, оборудованные системой "Eco-Fit"</li>
                <div class="img__wrap">
                    <img class="img good__img" src="/content/farkops/img/e.jpg" alt="фаркоп тип E">
                </div>
                <li>Фаркопы с шаром типа Е - зачастую, американский образец, выполненный в виде вставки под квадрат размерами 30х30 или 50х50мм. Требуют подготовленной базы на автомобиле, либо устанавливается отдельно. Установленный шар в приемник фиксируется при помощи «пальца» и пружинной скобы.<br><br>Один из самых надежных видов фаркопов-на некоторые образцы допустимы нагрузки и в 5-7 тонн.</li>
                <div class="img__wrap">
                    <img class="img good__img" src="/content/farkops/img/f.jpg" alt="фаркоп тип F">
                </div>
                <li>ТСУ с шаром типа F-фланцевые, кованые шары с 2-мя отверстиями для монтажа</li>
                <div class="img__wrap">
                    <img class="img good__img" src="/content/farkops/img/G.jpg" alt="фаркоп тип G">
                </div>
                <li>ТСУ с шаром типа G- он же но под 4 болта, с нагрузкой до 3500 кг</li>
                <div class="img__wrap">
                    <img class="img good__img" src="/content/farkops/img/H.jpg" alt="фаркоп тип H">
                </div>
                <li>Фаркопы с шаром типа H-полностью сварное изделие</li>
            </ol>

            <?php echo "<p class='text'>Особой экзотикой являются фаркопы, имеющие электропривод, позволяющий спрятать шар под автомобилем,не снимая его.</p>";
            echo "<p class='text'>Крайне важно понимать, что автомобиль с прицепом является средством повышенной опасности на дороге, потому к выбору ТСУ необходимо подойти максимально ответственно.</p>";
            echo "<p class='text'>Следует учесть характер планируемых грузов: вес, длина и пр.</p>";
            echo "<p class='text'>Так как все фаркопы разрабатываются под конкретный автомобиль, следует учитывать: марку и модель машины, год выпуска, тип кузова. Часто на один автомобиль существует 7-12 вариантов ТСУ. Правильно подобрать надежный вариант Вам помогут наши специалисты, просто позвоните нам, или заполните форму ниже, которая находится на этой же странице и мы с вами свяжемся.</p>";
            echo "<p class='text'>Мы работаем только с качественными, сертифицированными фаркопами лучших производителей мира ,такими как: Thule (Швеция), Brink (Нидерланды),Bosal (Россия), Imiola (Польша), Galia (Словакия), Westfalia (Германия), Лидер+ (Россия), Трейлер (Россия), Балтекс (Россия) и др.</p>";
            echo "<p class='text'>Также готовы предоставить Вам монтаж в нашем сертифицированном сервисе. На гарантию автомобиля наша работа не повлияет.</p>";

            include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/helpform.php"); ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>