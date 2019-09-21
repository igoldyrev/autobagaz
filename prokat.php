<?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/metatags.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/header.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/proposition/proposition.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation/navigation.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/breadcrumbs/breadcrumbs.php");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/keywords/keywords.php");
echo "<title> $titleconst"; echo $keywords[1][title]; echo "</title>";
echo "<meta name='description' content='"; echo $keywords[1][description];      echo "'/>";
echo "<meta name='keywords' content='"; echo $keywords[1][keywords]; echo "'/>";
$_SESSION['url'] = $_SERVER['REQUEST_URI']; ?>


<div class="wrapper">
    <?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">
        <?php
        $id = $_GET['id'];

        if (!isset($id)) {
            echo "<title> $titleconst"; echo $keywords[1][title]; echo "</title>";
            echo "<p class='text'>Случается так, что багажник, автобокс(бокс на крышу),велокрепление, лыжное крепление и иные бывают нужны разово, или время от времени.</p>";
            echo "<p class='text'>В этом случае удобно воспользоваться арендой багажного оборудования-быстро и надежно закрепить лесенку, длинномерные грузы, выехать к месту отдыха с боксом, уехать с велосипедом покорять парки Перми и Пермский край в целом или поставить лыжное крепление и с комфортом перевезти горные/охотничьи лыжи к курорту, отдохнуть и избавить салон своего авто от неминуемых пятен от растаявшего снега с лыж/бордов. Отдыхать активно теперь не только приятно, но еще и удобно!</p>";
            echo "<p class='text'>В случае сложных дорожных условий в путешествии или плохой погоды во время охоты/рыбалки-воспользуйтесь прокатом браслетов или цепей противоскольжения и самые сложные дороги станут легко проходимыми даже для самых маленьких и легких машин.</p>";
        } elseif ($id == 'reelings') {
            $tovar = $_SESSION['autobagazhniki'][0][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['autobagazhniki'][0][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'shtatnye') {
            $tovar = $_SESSION['autobagazhniki'][1][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['autobagazhniki'][1][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'smooth') {
            $tovar = $_SESSION['autobagazhniki'][2][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['autobagazhniki'][2][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'vodostok') {
            $tovar = $_SESSION['autobagazhniki'][3][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['autobagazhniki'][3][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == '400Mblack') {
            $tovar = $_SESSION['vetlan'][0][name1];
            echo "<title>Взятие в прокат "; echo $_SESSION['vetlan'][0][name1]; echo "</title>";
            $checkedbox  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == '400Mgray') {
            $tovar = $_SESSION['vetlan'][0][name2];
            echo "<title>Взятие в прокат "; echo $_SESSION['vetlan'][0][name2]; echo "</title>";
            $checkedbox  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == '400Mwhite') {
            $tovar = $_SESSION['vetlan'][0][name3];
            echo "<title>Взятие в прокат "; echo $_SESSION['vetlan'][0][name3]; echo "</title>";
            $checkedbox  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == '430Mblack') {
            $tovar = $_SESSION['vetlan'][1][name1];
            echo "<title>Взятие в прокат "; echo $_SESSION['vetlan'][1][name1]; echo "</title>";
            $checkedbox  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == '430Mgray') {
            $tovar = $_SESSION['vetlan'][1][name2];
            echo "<title>Взятие в прокат "; echo $_SESSION['vetlan'][1][name2]; echo "</title>";
            $checkedbox  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == '430Mwhite') {
            $tovar = $_SESSION['vetlan'][1][name3];
            echo "<title>Взятие в прокат "; echo $_SESSION['vetlan'][1][name3]; echo "</title>";
            $checkedbox  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == '550Mblack') {
            $tovar = $_SESSION['vetlan'][2][name1];
            echo "<title>Взятие в прокат "; echo $_SESSION['vetlan'][2][name1]; echo "</title>";
            $checkedbox  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == '550Mgray') {
            $tovar = $_SESSION['vetlan'][2][name2];
            echo "<title>Взятие в прокат "; echo $_SESSION['vetlan'][2][name2]; echo "</title>";
            $checkedbox  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == '550Mwhite') {
            $tovar = $_SESSION['vetlan'][2][name3];
            echo "<title>Взятие в прокат "; echo $_SESSION['vetlan'][2][name3]; echo "</title>";
            $checkedbox  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'vk1') {
            $tovar = $_SESSION['velokrysha'][0][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['velokrysha'][0][name]; echo "</title>";
            $checkedvelokrysha  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'vk2') {
            $tovar = $_SESSION['velokrysha'][1][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['velokrysha'][1][name]; echo "</title>";
            $checkedvelokrysha  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'vk3') {
            $tovar = $_SESSION['velokrysha'][2][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['velokrysha'][2][name]; echo "</title>";
            $checkedvelokrysha  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'vk4') {
            $tovar = $_SESSION['velokrysha'][3][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['velokrysha'][3][name]; echo "</title>";
            $checkedvelokrysha  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'vf1') {
            $tovar = $_SESSION['velofarkop'][0][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['velofarkop'][0][name]; echo "</title>";
            $checkedvelofarkop  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'vf2') {
            $tovar = $_SESSION['velofarkop'][1][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['velofarkop'][1][name]; echo "</title>";
            $checkedvelofarkop  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'amos34') {
            $tovar = $_SESSION['lyzhi'][0][name1];
            echo "<title>Взятие в прокат "; echo $_SESSION['lyzhi'][0][name1]; echo "</title>";
            $checkedlyzhi  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'amos56') {
            $tovar = $_SESSION['lyzhi'][0][name2];
            echo "<title>Взятие в прокат "; echo $_SESSION['lyzhi'][0][name2]; echo "</title>";
            $checkedlyzhi  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'atlant34') {
            $tovar = $_SESSION['lyzhi'][1][name1];
            echo "<title>Взятие в прокат "; echo $_SESSION['lyzhi'][1][name1]; echo "</title>";
            $checkedlyzhi  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'atlant56') {
            $tovar = $_SESSION['lyzhi'][1][name2];
            echo "<title>Взятие в прокат "; echo $_SESSION['lyzhi'][1][name2]; echo "</title>";
            $checkedlyzhi  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'montblanc34') {
            $tovar = $_SESSION['lyzhi'][2][name1];
            echo "<title>Взятие в прокат "; echo $_SESSION['lyzhi'][2][name1]; echo "</title>";
            $checkedlyzhi  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'montblanc56') {
            $tovar = $_SESSION['lyzhi'][2][name2];
            echo "<title>Взятие в прокат "; echo $_SESSION['lyzhi'][2][name2]; echo "</title>";
            $checkedlyzhi  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'thule34') {
            $tovar = $_SESSION['lyzhi'][3][name1];
            echo "<title>Взятие в прокат "; echo $_SESSION['lyzhi'][3][name1]; echo "</title>";
            $checkedlyzhi  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'thule56') {
            $tovar = $_SESSION['lyzhi'][3][name2];
            echo "<title>Взятие в прокат "; echo $_SESSION['lyzhi'][3][name2]; echo "</title>";
            $checkedlyzhi  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'xtender') {
            $tovar = $_SESSION['lyzhi'][4][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['lyzhi'][4][name]; echo "</title>";
            $checkedlyzhi  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'r12') {
            $tovar = $_SESSION['braslet'][name1];
            echo "<title>Взятие в прокат "; echo $_SESSION['braslet'][name1]; echo "</title>";
            $checkedbraslets  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'r16') {
            $tovar = $_SESSION['braslet'][name2];
            echo "<title>Взятие в прокат "; echo $_SESSION['braslet'][name2]; echo "</title>";
            $checkedbraslets  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'gazel') {
            $tovar = $_SESSION['braslet'][name3];
            echo "<title>Взятие в прокат "; echo $_SESSION['braslet'][name3]; echo "</title>";
            $checkedbraslets  = "checked"; ?>
            <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'stay_set_su') {
            $tovar = $_SESSION['inno_basic'][0][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['inno_basic'][0][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
                <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'stay_set_fr') {
            $tovar = $_SESSION['inno_basic'][1][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['inno_basic'][1][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
                <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'stay_set_xr') {
            $tovar = $_SESSION['inno_basic'][2][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['inno_basic'][2][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
                <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'stay_set') {
            $tovar = $_SESSION['inno_basic'][3][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['inno_basic'][3][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
                <?php echo "<p>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'xs100') {
            $tovar = $_SESSION['inno_aero'][0][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['inno_aero'][0][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
                <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'xs200') {
            $tovar = $_SESSION['inno_aero'][1][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['inno_aero'][1][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
                <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'xs300') {
            $tovar = $_SESSION['inno_aero'][2][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['inno_aero'][2][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
                <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'xs400') {
            $tovar = $_SESSION['inno_aero'][3][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['inno_aero'][3][name]; echo "</title>";
            $checkedbagazh  = "checked"; ?>
            <div class="good-message">
                <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'inmaxspace460') {
            $tovar = $_SESSION['inmax'][name];
            echo "<title>Взятие в прокат "; echo $_SESSION['inmax'][name]; echo "</title>";
            $checkedbox  = "checked"; ?>
            <div class="good-message">
                <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
            </div>
            <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive480blackoneside') {
          $tovar = $_SESSION['terradrivefour'][0][name1];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivefour'][0][name1];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive480grayoneside') {
          $tovar = $_SESSION['terradrivefour'][0][name2];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivefour'][0][name2];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive480blacktwoside') {
          $tovar = $_SESSION['terradrivefour'][0][name3];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivefour'][0][name3];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive480graytwoside') {
          $tovar = $_SESSION['terradrivefour'][0][name4];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivefour'][0][name4];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive440blackoneside') {
          $tovar = $_SESSION['terradrivefour'][1][name1];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivefour'][1][name1];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive440grayoneside') {
          $tovar = $_SESSION['terradrivefour'][1][name2];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivefour'][1][name2];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive440blacktwoside') {
          $tovar = $_SESSION['terradrivefour'][1][name3];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivefour'][1][name3];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive440graytwoside') {
          $tovar = $_SESSION['terradrivefour'][1][name4];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivefour'][1][name4];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive480glossyblack') {
          $tovar = $_SESSION['terradrivetwo'][0][name1];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivetwo'][0][name1];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive480glossywhite') {
          $tovar = $_SESSION['terradrivetwo'][0][name2];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivetwo'][0][name2];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive440glossyblack') {
          $tovar = $_SESSION['terradrivetwo'][1][name1];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivetwo'][1][name1];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive440glossywhite') {
          $tovar = $_SESSION['terradrivetwo'][1][name2];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivetwo'][1][name2];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive420black') {
          $tovar = $_SESSION['terradrivetwo'][2][name1];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivetwo'][2][name1];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive420gray') {
          $tovar = $_SESSION['terradrivetwo'][2][name2];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivetwo'][2][name2];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive320black') {
          $tovar = $_SESSION['terradrivetwo'][3][name1];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivetwo'][3][name1];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive320gray') {
          $tovar = $_SESSION['terradrivetwo'][3][name2];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['terradrivetwo'][3][name2];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'terradrive600glossyblack') {
          $tovar = $_SESSION['$terradriveone'][0][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['$terradriveone'][0][name];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'bonusblack') {
          $tovar = $_SESSION['bonus'][0][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['bonus'][0][name];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'bonusgray') {
          $tovar = $_SESSION['bonus'][1][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['bonus'][1][name];
          echo "</title>";
          $checkedbox = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'reelingskrepysh') {
          $tovar = $_SESSION['reelings'][0][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['reelings'][0][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'reelingsfavorit') {
          $tovar = $_SESSION['reelings'][1][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['reelings'][1][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'reelingsduster') {
          $tovar = $_SESSION['reelings'][2][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['reelings'][2][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'reelingseuro') {
          $tovar = $_SESSION['reelings'][3][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['reelings'][3][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        }
        elseif ($id == 'reelingsatlant') {
          $tovar = $_SESSION['reelings'][4][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['reelings'][4][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'reelingslux') {
          $tovar = $_SESSION['reelings'][5][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['reelings'][5][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'reelingsmontblanc') {
          $tovar = $_SESSION['reelings'][6][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['reelings'][6][name];
          echo "</title>";      
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'statnyec15') {
          $tovar = $_SESSION['shtatnye'][0][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['shtatnye'][0][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'statnyelux') {
          $tovar = $_SESSION['shtatnye'][1][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['shtatnye'][1][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'statnyeatlant') {
          $tovar = $_SESSION['shtatnye'][2][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['shtatnye'][2][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'smoothd1') {
          $tovar = $_SESSION['smooth'][0][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['smooth'][0][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'smoothlux') {
          $tovar = $_SESSION['smooth'][1][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['smooth'][1][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'smoothatlant') {
          $tovar = $_SESSION['smooth'][2][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['smooth'][2][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'smoothmontblanc') {
          $tovar = $_SESSION['smooth'][3][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['smooth'][3][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        } elseif ($id == 'vodostokatlant') {
          $tovar = $_SESSION['vodostok'][0][name];
          echo "<title>Взятие в прокат ";
          echo $_SESSION['vodostok'][0][name];
          echo "</title>";
          $checkedbagazh = "checked"; ?>
          <div class="good-message">
            <?php echo "<p class='text'>Вы выбрали для проката $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div>
          <?php include($_SERVER["DOCUMENT_ROOT"] . "/backend/forms/prokatform.php");
        }
        $_SESSION['tovar'] = $tovar; ?>
        <p class='text'>Чтобы воспользоваться услугами аренды необходимо сделать несколько простых шагов:</p>
        <ol class="list list--decimal">
            <li>Забронируйте багажник, бокс, или любой необходимый аксессуар по телефону, или оставив заявку на сайте (для нас важно, чтобы ваше путешествие ничто не омрачило-выбранное багажное оборудование 100% будет Вас ждать точно в срок)</li>
            <li>В день аренды необходимо приехать в пункт проката, взяв с собой:
                <ul class="list list__unsorted">
                    <li>паспорт</li>
                    <li>залоговую сумму (полная стоимость товара, взятого в прокат)</li>
                </ul>
            </li>
            <li>В нашем магазине-прокате мы оформляем договор проката, квитанцию об оплате и выдаем Вам выбранное багажное оборудование.</li>
            <li>Чтобы сократить время визита в магазин-вы можете заполнить <a onclick="yaCounter40650914.reachGoal('down_prokat'); return true" class='link' href ="/content/prokat/Dogovor_prokata.doc">договор</a> и отправить нам его на электронный адрес <a onclick="yaCounter40650914.reachGoal('write_mail'); return true" class='link' href="mailto:autobagaz@yandex.ru">autobagaz@yandex.ru</a>
        </ol>
        <div class="prokat-docs">
            <div>
                <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i><a onclick="yaCounter40650914.reachGoal('down_prokat'); return true" class='link link--green-hover' href ="/content/prokat/Dogovor_prokata.doc">Скачать договор проката</a>
            </div>
            <div>
                <i class="fa fa-file-text-o fa-2x" aria-hidden="true"></i><a onclick="yaCounter40650914.reachGoal('down_prokat'); return true" class='link link--green-hover' href="/content/prokat/Pravila_ekspluatacii_avtoboksov.doc">Скачать правила эксплуатации автобоксов</a>
            </div>
        </div>
<p class='page__text'>Стоимость дня проката определяется исходя из времени пользования оборудованием:</p>
<div class="table">
    <div class="table__column table__column-prokat--srok"></div>
    <ul class="table__header">
        <li class="table__cell">Сроки проката</li>
        <li class="table__cell">Прокат дуг багажника, крепления для велосипеда (на крышу), лыж, лодки, браслетов противоскольжения</li>
        <li class="table__cell">Прокат автобокса, велокрепления на фаркоп/заднюю дверь, цепей противоскольжения</li>
    </ul>
    <ul class="table__row">
        <li class="table__cell table__cell--price">От 0 до 14 дней	</li>
        <li class="table__cell table__cell--price">130 рублей/день</li>
        <li class="table__cell table__cell--price">270 рублей/день</li>
    </ul>
    <ul class="table__row">
        <li class="table__cell table__cell--price">От 15 до 21 дня</li>
        <li class="table__cell table__cell--price">110 рублей/день</li>
        <li class="table__cell table__cell--price">240 рублей/день</li>
    </ul>
    <ul class="table__row">
        <li class="table__cell table__cell--price">От 21 дня</li>
        <li class="table__cell table__cell--price">90 рублей/день</li>
        <li class="table__cell table__cell--price">210 рублей/день</li>
    </ul>
</div>
<p class='page__text'>Обращаем ваше внимание, что время проката считается календарными днями. Монтаж/демонтаж багажных систем осуществляется полностью силами арендатора, либо оплачивается отдельно.</p>
<p class='page__text'>С общими правилами пользования багажным оборудованием можно ознакомиться <a onclick="yaCounter40650914.reachGoal('down_prokat'); return true" class='link' href="/content/prokat/Pravila_ekspluatacii_avtoboksov.doc">здесь</a>.</p>

    </div>
</div>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/footer/footer.html");
include($_SERVER["DOCUMENT_ROOT"] . "/backend/blocks/counters.html"); ?>
