<?php include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/metatagslight.php");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/navigation-mobile/navigation-mobile.html");
include($_SERVER["DOCUMENT_ROOT"] . "/src/common.blocks/header/top-header.php");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/header/header.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/proposition/proposition.html");
include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/navigation/navigation.html"); ?>

<div class="wrapper">
    <?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/left-nav/left-nav.html"); ?>
    <div class="wrapper__content">

    <?php

    $id = $_GET['id'];

    if (!isset($id)) {
        echo "<title>"; echo "Выберите товар для заказа"; echo "</title>"; ?>
        <div class="good_message">
        <?php echo "<p>Вы  не выбрали ничего для заказа. Вернитесь в каталог и выберите из него что-нибудь. А затем заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    }

    if ($_SESSION['autobagazhniki']) {
      foreach ($_SESSION['autobagazhniki'] as $bagazhnikibuy):

        if ($id == $bagazhnikibuy['id']) {
          $tovar = $bagazhnikibuy['name'];
          echo "<title>Заказ товара ";
          echo $bagazhnikibuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['sales']) {
      foreach ($_SESSION['sales'] as $salesbuy):

        if ($id == $salesbuy['id']) {
          $tovar = $salesbuy['name'];
          echo "<title>Заказ товара ";
          echo $salesbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($id == 'yuago') {
      $tovar = $_SESSION['yuago'][name];
      echo "<title>Заказ товара ";
      echo $_SESSION['yuago'][name];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'turino') {
      $tovar = $_SESSION['turino'][name];
      echo "<title>Заказ товара ";
      echo $_SESSION['turino'][name];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'lux600blackmetal') {
      $tovar = $_SESSION['lux'][name1];
      echo "<title>Заказ товара ";
      echo $_SESSION['lux'][name1];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'lux600blackfrosted') {
      $tovar = $_SESSION['lux'][name2];
      echo "<title>Заказ товара ";
      echo $_SESSION['lux'][name2];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'lux600white') {
      $tovar = $_SESSION['lux'][name3];
      echo "<title>Заказ товара ";
      echo $_SESSION['lux'][name3];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'lux960blackfrosted') {
      $tovar = $_SESSION['lux'][name4];
      echo "<title>Заказ товара ";
      echo $_SESSION['lux'][name4];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'lux960blackmetal') {
      $tovar = $_SESSION['lux'][name5];
      echo "<title>Заказ товара ";
      echo $_SESSION['lux'][name5];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'lux960white') {
      $tovar = $_SESSION['lux'][name6];
      echo "<title>Заказ товара ";
      echo $_SESSION['lux'][name6];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'dc320') {
        $tovar = $_SESSION['discoveryclassic'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['discoveryclassic'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'dc430') {
        $tovar = $_SESSION['discoveryclassic'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['discoveryclassic'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'dc500') {
        $tovar = $_SESSION['discoveryclassic'][name3];
        echo "<title>Заказ товара "; echo $_SESSION['discoveryclassic'][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ds431') {
        $tovar = $_SESSION['discoverysport'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['discoverysport'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'ds501') {
        $tovar = $_SESSION['discoverysport'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['discoverysport'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'dynamic434') {
        $tovar = $_SESSION['dynamic'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['dynamic'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'dynamic504') {
        $tovar = $_SESSION['dynamic'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['dynamic'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'airtek435') {
        $tovar = $_SESSION['airtek'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['airtek'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'airtek505') {
        $tovar = $_SESSION['airtek'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['airtek'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '400Mblack') {
        $tovar = $_SESSION['vetlan'][0][name1];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][0][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '400Mgray') {
        $tovar = $_SESSION['vetlan'][0][name2];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][0][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '400Mwhite') {
        $tovar = $_SESSION['vetlan'][0][name3];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][0][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '430Mblack') {
        $tovar = $_SESSION['vetlan'][1][name1];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][1][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '430Mgray') {
        $tovar = $_SESSION['vetlan'][1][name2];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][1][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '430Mwhite') {
        $tovar = $_SESSION['vetlan'][1][name3];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][1][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '550Mblack') {
        $tovar = $_SESSION['vetlan'][2][name1];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][2][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '550Mgray') {
        $tovar = $_SESSION['vetlan'][2][name2];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][2][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == '550Mwhite') {
        $tovar = $_SESSION['vetlan'][2][name3];
        echo "<title>Заказ товара "; echo $_SESSION['vetlan'][2][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vk1') {
        $tovar = $_SESSION['velokrysha'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][0][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vk2') {
        $tovar = $_SESSION['velokrysha'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][1][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vk3') {
        $tovar = $_SESSION['velokrysha'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][2][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vk4') {
        $tovar = $_SESSION['velokrysha'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['velokrysha'][3][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vf1') {
        $tovar = $_SESSION['velofarkop'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['velofarkop'][0][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'vf2') {
        $tovar = $_SESSION['velofarkop'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['velofarkop'][1][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'amos34') {
        $tovar = $_SESSION['lyzhi'][0][name1];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][0][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'amos56') {
        $tovar = $_SESSION['lyzhi'][0][name2];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][0][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'atlant34') {
        $tovar = $_SESSION['lyzhi'][1][name1];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][1][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'atlant56') {
        $tovar = $_SESSION['lyzhi'][1][name2];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][1][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'montblanc34') {
        $tovar = $_SESSION['lyzhi'][2][name1];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][2][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'montblanc56') {
        $tovar = $_SESSION['lyzhi'][2][name2];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][2][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'thule34') {
        $tovar = $_SESSION['lyzhi'][3][name1];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][3][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'thule56') {
        $tovar = $_SESSION['lyzhi'][3][name2];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][3][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xtender') {
        $tovar = $_SESSION['lyzhi'][4][name];
        echo "<title>Заказ товара "; echo $_SESSION['lyzhi'][4][name]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'r12') {
        $tovar = $_SESSION['braslet'][name1];
        echo "<title>Заказ товара "; echo $_SESSION['braslet'][name1]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'r16') {
        $tovar = $_SESSION['braslet'][name2];
        echo "<title>Заказ товара "; echo $_SESSION['braslet'][name2]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'gazel') {
        $tovar = $_SESSION['braslet'][name3];
        echo "<title>Заказ товара "; echo $_SESSION['braslet'][name3]; echo "</title>";?>
        <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'stay_set_su') {
        $tovar = $_SESSION['inno_basic'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_basic'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'stay_set_fr') {
        $tovar = $_SESSION['inno_basic'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_basic'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'stay_set_xr') {
        $tovar = $_SESSION['inno_basic'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_basic'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'stay_set') {
        $tovar = $_SESSION['inno_basic'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_basic'][3][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xs100') {
        $tovar = $_SESSION['inno_aero'][0][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_aero'][0][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xs200') {
        $tovar = $_SESSION['inno_aero'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_aero'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xs300') {
        $tovar = $_SESSION['inno_aero'][2][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_aero'][2][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'xs400') {
        $tovar = $_SESSION['inno_aero'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_aero'][3][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA1260U5') {
        $tovar = $_SESSION['inno_box'][0][name1];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][0][name1]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA1260U6') {
        $tovar = $_SESSION['inno_box'][0][name2];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][0][name2]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA1250U1') {
        $tovar = $_SESSION['inno_box'][0][name3];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][0][name3]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA1460U5') {
        $tovar = $_SESSION['inno_box'][1][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][1][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA33RBK') {
        $tovar = $_SESSION['inno_box'][2][name1];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][2][name1]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA33RDS') {
        $tovar = $_SESSION['inno_box'][2][name2];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][2][name2]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'BRA56U1') {
        $tovar = $_SESSION['inno_box'][3][name];
        echo "<title>Заказ товара "; echo $_SESSION['inno_box'][3][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    }

    if ($_SESSION['lada_xray']) {
      foreach ($_SESSION['lada_xray'] as $lada_xraybuy):

        if ($id == $lada_xraybuy['id']) {
          $tovar = $lada_xraybuy['name'];
          echo "<title>Заказ товара ";
          echo $lada_xraybuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['lada_largus']) {
      foreach ($_SESSION['lada_largus'] as $lada_largusbuy):

        if ($id == $lada_largusbuy['id']) {
          $tovar = $lada_largusbuy['name'];
          echo "<title>Заказ товара ";
          echo $lada_largusbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['granta_liftbek']) {
      foreach ($_SESSION['granta_liftbek'] as $granta_liftbekbuy):

        if ($id == $granta_liftbekbuy['id']) {
          $tovar = $granta_liftbekbuy['name'];
          echo "<title>Заказ товара ";
          echo $granta_liftbekbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['granta_e']) {
      foreach ($_SESSION['granta_e'] as $granta_ebuy):

        if ($id == $granta_ebuy['id']) {
          $tovar = $granta_ebuy['name'];
          echo "<title>Заказ товара ";
          echo $granta_ebuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['granta_sedan']) {
      foreach ($_SESSION['granta_sedan'] as $granta_sedanbuy):

        if ($id == $granta_sedanbuy['id']) {
          $tovar = $granta_sedanbuy['name'];
          echo "<title>Заказ товара ";
          echo $granta_sedanbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['kalina_xetchbek']) {
      foreach ($_SESSION['kalina_xetchbek'] as $kalina_xetchbekbuy):

        if ($id == $kalina_xetchbekbuy['id']) {
          $tovar = $kalina_xetchbekbuy['name'];
          echo "<title>Заказ товара ";
          echo $kalina_xetchbekbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['kalina_universal']) {
      foreach ($_SESSION['kalina_universal'] as $kalina_universalbuy):

        if ($id == $kalina_universalbuy['id']) {
          $tovar = $kalina_universalbuy['name'];
          echo "<title>Заказ товара ";
          echo $kalina_universalbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['lada_4x4']) {
      foreach ($_SESSION['lada_4x4'] as $lada_4x4buy):

        if ($id == $lada_4x4buy['id']) {
          $tovar = $lada_4x4buy['name'];
          echo "<title>Заказ товара ";
          echo $lada_4x4buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['lada_4x4_l']) {
      foreach ($_SESSION['lada_4x4_l'] as $lada_4x4_lbuy):

        if ($id == $lada_4x4_lbuy['id']) {
          $tovar = $lada_4x4_lbuy['name'];
          echo "<title>Заказ товара ";
          echo $lada_4x4_lbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['niva_m']) {
      foreach ($_SESSION['niva_m'] as $niva_mbuy):

        if ($id == $niva_mbuy['id']) {
          $tovar = $niva_mbuy['name'];
          echo "<title>Заказ товара ";
          echo $niva_mbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['niva_l']) {
      foreach ($_SESSION['niva_l'] as $niva_lbuy):

        if ($id == $niva_lbuy['id']) {
          $tovar = $niva_lbuy['name'];
          echo "<title>Заказ товара ";
          echo $niva_lbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['kia_ceed_2006']) {
      foreach ($_SESSION['kia_ceed_2006'] as $kia_ceed_2006buy):

        if ($id == $kia_ceed_2006buy['id']) {
          $tovar = $kia_ceed_2006buy['name'];
          echo "<title>Заказ товара ";
          echo $kia_ceed_2006buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['kia_ceed_2012']) {
      foreach ($_SESSION['kia_ceed_2012'] as $kia_ceed_2012buy):

        if ($id == $kia_ceed_2012buy['id']) {
          $tovar = $kia_ceed_2012buy['name'];
          echo "<title>Заказ товара ";
          echo $kia_ceed_2012buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['opel_astra_2004']) {
      foreach ($_SESSION['opel_astra_2004'] as $opel_astra_2004buy):

        if ($id == $opel_astra_2004buy['id']) {
          $tovar = $opel_astra_2004buy['name'];
          echo "<title>Заказ товара ";
          echo $opel_astra_2004buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['landrover']) {
      foreach ($_SESSION['landrover'] as $landroverbuy):

        if ($id == $landroverbuy['id']) {
          $tovar = $landroverbuy['name'];
          echo "<title>Заказ товара ";
          echo $landroverbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['hyundai_creta']) {
      foreach ($_SESSION['hyundai_creta'] as $hyundai_cretabuy):

        if ($id == $hyundai_cretabuy['id']) {
          $tovar = $hyundai_cretabuy['name'];
          echo "<title>Заказ товара ";
          echo $hyundai_cretabuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['hyundai_solaris']) {
      foreach ($_SESSION['hyundai_solaris'] as $hyundai_solarisbuy):

        if ($id == $hyundai_solarisbuy['id']) {
          $tovar = $hyundai_solarisbuy['name'];
          echo "<title>Заказ товара ";
          echo $hyundai_solarisbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['hyundai_i30']) {
      foreach ($_SESSION['hyundai_i30'] as $hyundai_i30buy):

        if ($id == $hyundai_i30buy['id']) {
          $tovar = $hyundai_i30buy['name'];
          echo "<title>Заказ товара ";
          echo $hyundai_i30buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['mazda3']) {
      foreach ($_SESSION['mazda3'] as $mazda3buy):

        if ($id == $mazda3buy['id']) {
          $tovar = $mazda3buy['name'];
          echo "<title>Заказ товара ";
          echo $mazda3buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['mazda_cx5_1']) {
      foreach ($_SESSION['mazda_cx5_1'] as $mazda_cx5_1buy):

        if ($id == $mazda_cx5_1buy['id']) {
          $tovar = $mazda_cx5_1buy['name'];
          echo "<title>Заказ товара ";
          echo $mazda_cx5_1buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['mazda_cx5_2']) {
      foreach ($_SESSION['mazda_cx5_2'] as $mazda_cx5_2buy):

        if ($id == $mazda_cx5_2buy['id']) {
          $tovar = $mazda_cx5_2buy['name'];
          echo "<title>Заказ товара ";
          echo $mazda_cx5_2buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['toyota_rav4_2006']) {
      foreach ($_SESSION['toyota_rav4_2006'] as $toyota_rav4_2006buy):

        if ($id == $toyota_rav4_2006buy['id']) {
          $tovar = $toyota_rav4_2006buy['name'];
          echo "<title>Заказ товара ";
          echo $toyota_rav4_2006buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['toyota_rav4_2013']) {
      foreach ($_SESSION['toyota_rav4_2013'] as $toyota_rav4_2013buy):

        if ($id == $toyota_rav4_2013buy['id']) {
          $tovar = $toyota_rav4_2013buy['name'];
          echo "<title>Заказ товара ";
          echo $toyota_rav4_2013buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['toyota_prado150']) {
      foreach ($_SESSION['toyota_prado150'] as $toyota_prado150buy):

        if ($id == $toyota_prado150buy['id']) {
          $tovar = $toyota_prado150buy['name'];
          echo "<title>Заказ товара ";
          echo $toyota_prado150buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['renault_kaptur']) {
      foreach ($_SESSION['renault_kaptur'] as $renault_kapturbuy):

        if ($id == $renault_kapturbuy['id']) {
          $tovar = $renault_kapturbuy['name'];
          echo "<title>Заказ товара ";
          echo $renault_kapturbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['renault_logan_2004']) {
      foreach ($_SESSION['renault_logan_2004'] as $renault_logan_2004buy):

        if ($id == $renault_logan_2004buy['id']) {
          $tovar = $renault_logan_2004buy['name'];
          echo "<title>Заказ товара ";
          echo $renault_logan_2004buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['renault_logan_2015']) {
      foreach ($_SESSION['renault_logan_2015'] as $renault_logan_2015buy):

        if ($id == $renault_logan_2015buy['id']) {
          $tovar = $renault_logan_2015buy['name'];
          echo "<title>Заказ товара ";
          echo $renault_logan_2015buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['renault_sandero_2010']) {
      foreach ($_SESSION['renault_sandero_2010'] as $renault_sandero_2010buy):

        if ($id == $renault_sandero_2010buy['id']) {
          $tovar = $renault_sandero_2010buy['name'];
          echo "<title>Заказ товара ";
          echo $renault_sandero_2010buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['renault_sandero_2014']) {
      foreach ($_SESSION['renault_sandero_2014'] as $renault_sandero_2014buy):

        if ($id == $renault_sandero_2014buy['id']) {
          $tovar = $renault_sandero_2014buy['name'];
          echo "<title>Заказ товара ";
          echo $renault_sandero_2014buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['renault_sandero_2014']) {
      foreach ($_SESSION['renault_sandero_2014'] as $renault_sandero_2014buy):

        if ($id == $renault_sandero_2014buy['id']) {
          $tovar = $renault_sandero_2014buy['name'];
          echo "<title>Заказ товара ";
          echo $renault_sandero_2014buy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['mi_do']) {
      foreach ($_SESSION['mi_do'] as $mi_dobuy):

        if ($id == $mi_dobuy['id']) {
          $tovar = $mi_dobuy['name'];
          echo "<title>Заказ товара ";
          echo $mi_dobuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['on_do']) {
      foreach ($_SESSION['on_do'] as $on_dobuy):

        if ($id == $on_dobuy['id']) {
          $tovar = $on_dobuy['name'];
          echo "<title>Заказ товара ";
          echo $on_dobuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['cheviniva']) {
      foreach ($_SESSION['cheviniva'] as $chevinivabuy):

        if ($id == $chevinivabuy['id']) {
          $tovar = $chevinivabuy['name'];
          echo "<title>Заказ товара ";
          echo $chevinivabuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['greatwall']) {
      foreach ($_SESSION['greatwall'] as $greatwallbuy):

        if ($id == $greatwallbuy['id']) {
          $tovar = $greatwallbuy['name'];
          echo "<title>Заказ товара ";
          echo $greatwallbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['isuzu']) {
      foreach ($_SESSION['isuzu'] as $isuzubuy):

        if ($id == $isuzubuy['id']) {
          $tovar = $isuzubuy['name'];
          echo "<title>Заказ товара ";
          echo $isuzubuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['jeep']) {
      foreach ($_SESSION['jeep'] as $jeepbuy):

        if ($id == $jeepbuy['id']) {
          $tovar = $jeepbuy['name'];
          echo "<title>Заказ товара ";
          echo $jeepbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['kia']) {
      foreach ($_SESSION['kia'] as $kiabuy):

        if ($id == $kiabuy['id']) {
          $tovar = $kiabuy['name'];
          echo "<title>Заказ товара ";
          echo $kiabuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['landrover']) {
      foreach ($_SESSION['landrover'] as $landroverbuy):

        if ($id == $landroverbuy['id']) {
          $tovar = $landroverbuy['name'];
          echo "<title>Заказ товара ";
          echo $landroverbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['mitsubishi']) {
      foreach ($_SESSION['mitsubishi'] as $mitsubishibuy):

        if ($id == $mitsubishibuy['id']) {
          $tovar = $mitsubishibuy['name'];
          echo "<title>Заказ товара ";
          echo $mitsubishibuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['nissan']) {
      foreach ($_SESSION['nissan'] as $nissanbuy):

        if ($id == $nissanbuy['id']) {
          $tovar = $nissanbuy['name'];
          echo "<title>Заказ товара ";
          echo $nissanbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['renault']) {
      foreach ($_SESSION['renault'] as $renaultbuy):

        if ($id == $renaultbuy['id']) {
          $tovar = $renaultbuy['name'];
          echo "<title>Заказ товара ";
          echo $renaultbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['ssang_yong']) {
      foreach ($_SESSION['ssang_yong'] as $ssang_yongbuy):

        if ($id == $ssang_yongbuy['id']) {
          $tovar = $ssang_yongbuy['name'];
          echo "<title>Заказ товара ";
          echo $ssang_yongbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['toyota']) {
      foreach ($_SESSION['toyota'] as $toyotabuy):

        if ($id == $toyotabuy['id']) {
          $tovar = $toyotabuy['name'];
          echo "<title>Заказ товара ";
          echo $toyotabuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['gazel']) {
      foreach ($_SESSION['gazel'] as $gazelbuy):

        if ($id == $gazelbuy['id']) {
          $tovar = $gazelbuy['name'];
          echo "<title>Заказ товара ";
          echo $gazelbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['niva']) {
      foreach ($_SESSION['niva'] as $nivabuy):

        if ($id == $nivabuy['id']) {
          $tovar = $nivabuy['name'];
          echo "<title>Заказ товара ";
          echo $nivabuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['uaz_buxanka']) {
      foreach ($_SESSION['uaz_buxanka'] as $uaz_buxankabuy):

        if ($id == $uaz_buxankabuy['id']) {
          $tovar = $uaz_buxankabuy['name'];
          echo "<title>Заказ товара ";
          echo $uaz_buxankabuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['uaz_patriot']) {
      foreach ($_SESSION['uaz_patriot'] as $uaz_patriotbuy):

        if ($id == $uaz_patriotbuy['id']) {
          $tovar = $uaz_patriotbuy['name'];
          echo "<title>Заказ товара ";
          echo $uaz_patriotbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['uaz_hunter']) {
      foreach ($_SESSION['uaz_hunter'] as $uaz_hunterbuy):

        if ($id == $uaz_hunterbuy['id']) {
          $tovar = $uaz_hunterbuy['name'];
          echo "<title>Заказ товара ";
          echo $uaz_hunterbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['universal']) {
      foreach ($_SESSION['universal'] as $universalbuy):

        if ($id == $universalbuy['id']) {
          $tovar = $universalbuy['name'];
          echo "<title>Заказ товара ";
          echo $universalbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['stairs']) {
      foreach ($_SESSION['stairs'] as $stairsbuy):

        if ($id == $stairsbuy['id']) {
          $tovar = $stairsbuy['name'];
          echo "<title>Заказ товара ";
          echo $stairsbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }


    if ($id == 'inmaxspace460') {
        $tovar = $_SESSION['inmax'][name];
        echo "<title>Заказ товара "; echo $_SESSION['inmax'][name]; echo "</title>";?>
        <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
        </div> <?php
    } elseif ($id == 'terradrive480blackoneside') {
      $tovar = $_SESSION['terradrivefour'][0][name1];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivefour'][0][name1];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive480grayoneside') {
      $tovar = $_SESSION['terradrivefour'][0][name2];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivefour'][0][name2];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive480blacktwoside') {
      $tovar = $_SESSION['terradrivefour'][0][name3];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivefour'][0][name3];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive480graytwoside') {
      $tovar = $_SESSION['terradrivefour'][0][name4];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivefour'][0][name4];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive440blackoneside') {
      $tovar = $_SESSION['terradrivefour'][1][name1];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivefour'][1][name1];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive440grayoneside') {
      $tovar = $_SESSION['terradrivefour'][1][name2];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivefour'][1][name2];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive440blacktwoside') {
      $tovar = $_SESSION['terradrivefour'][1][name3];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivefour'][1][name3];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive440graytwoside') {
      $tovar = $_SESSION['terradrivefour'][1][name4];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivefour'][1][name4];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive480glossyblack') {
      $tovar = $_SESSION['terradrivetwo'][0][name1];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivetwo'][0][name1];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive480glossywhite') {
      $tovar = $_SESSION['terradrivetwo'][0][name2];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivetwo'][0][name2];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive440glossyblack') {
      $tovar = $_SESSION['terradrivetwo'][1][name1];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivetwo'][1][name1];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive440glossywhite') {
      $tovar = $_SESSION['terradrivetwo'][1][name2];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivetwo'][1][name2];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive420black') {
      $tovar = $_SESSION['terradrivetwo'][2][name1];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivetwo'][2][name1];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive420gray') {
      $tovar = $_SESSION['terradrivetwo'][2][name2];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivetwo'][2][name2];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive320black') {
      $tovar = $_SESSION['terradrivetwo'][3][name1];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivetwo'][3][name1];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive320gray') {
      $tovar = $_SESSION['terradrivetwo'][3][name2];
      echo "<title>Заказ товара ";
      echo $_SESSION['terradrivetwo'][3][name2];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    } elseif ($id == 'terradrive600glossyblack') {
      $tovar = $_SESSION['$terradriveone'][0][name];
      echo "<title>Заказ товара ";
      echo $_SESSION['$terradriveone'][0][name];
      echo "</title>"; ?>
      <div class="good-message">
        <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
      </div> <?php
    }

    if ($_SESSION['bonus']) {
      foreach ($_SESSION['bonus'] as $bonusbuy):

        if ($id == $bonusbuy['id']) {
          $tovar = $bonusbuy['name'];
          echo "<title>Заказ товара ";
          echo $bonusbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }


    if ($_SESSION['reelings']) {
      foreach ($_SESSION['reelings'] as $reelingsbuy):

        if ($id == $reelingsbuy['id']) {
          $tovar = $reelingsbuy['name'];
          echo "<title>Заказ товара ";
          echo $reelingsbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['shtatnye']) {
      foreach ($_SESSION['shtatnye'] as $shtatnyebuy):

        if ($id == $shtatnyebuy['id']) {
          $tovar = $shtatnyebuy['name'];
          echo "<title>Заказ товара ";
          echo $shtatnyebuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['smooth']) {
      foreach ($_SESSION['smooth'] as $smoothbuy):

        if ($id == $smoothbuy['id']) {
          $tovar = $smoothbuy['name'];
          echo "<title>Заказ товара ";
          echo $smoothbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['vodostok']) {
      foreach ($_SESSION['vodostok'] as $vodostokbuy):

        if ($id == $vodostokbuy['id']) {
          $tovar = $vodostokbuy['name'];
          echo "<title>Заказ товара ";
          echo $vodostokbuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['cayman']) {
      foreach ($_SESSION['cayman'] as $caybuy):

        if ($id == $caybuy['id']) {
          $tovar = $caybuy['name'];
          echo "<title>Заказ товара ";
          echo $caybuy['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['oregonromb']) {
      foreach ($_SESSION['oregonromb'] as $oromb):

        if ($id == $oromb['id']) {
          $tovar = $oromb['name'];
          echo "<title>Заказ товара ";
          echo $oromb['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['oregonmodel']) {
      foreach ($_SESSION['oregonmodel'] as $omodel):

        if ($id == $omodel['id']) {
          $tovar = $omodel['name'];
          echo "<title>Заказ товара ";
          echo $omodel['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['oregonuniversal']) {
      foreach ($_SESSION['oregonuniversal'] as $ouniv):

        if ($id == $ouniv['id']) {
          $tovar = $ouniv['name'];
          echo "<title>Заказ товара ";
          echo $ouniv['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['trendromb']) {
      foreach ($_SESSION['trendromb'] as $tromb):

        if ($id == $tromb['id']) {
          $tovar = $tromb['name'];
          echo "<title>Заказ товара ";
          echo $tromb['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }

    if ($_SESSION['trend']) {
      foreach ($_SESSION['trend'] as $tr):

        if ($id == $tr['id']) {
          $tovar = $tr['name'];
          echo "<title>Заказ товара ";
          echo $tr['name'];
          echo "</title>"; ?>
          <div class="good-message">
            <?php echo "<p>Вы выбрали для заказа $tovar. Заполните форму ниже и мы с Вами свяжемся в ближайшее время.</p>"; ?>
          </div> <?php
        }
      endforeach;
    }
    

    $_SESSION['tovar'] = $tovar;
    include ($_SERVER["DOCUMENT_ROOT"]."/backend/forms/buyform.php");
    ?>
    </div>
</div>
<?php include ($_SERVER["DOCUMENT_ROOT"]."/src/common.blocks/footer/footer.html");
include ($_SERVER["DOCUMENT_ROOT"]."/backend/blocks/counters.html"); ?>
