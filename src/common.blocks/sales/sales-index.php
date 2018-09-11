<?php
$sales = [
  [
    'id' => 's1',
    'name' => 'Велокрепление AMOS (для одного велосипеда) ',
    'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/velo_amos_1x.jpg" alt="велокрепление AMOS (для одного велосипеда)">',
    'price' => '1 500 рублей ',
    'strike_price' => '2 200 рублей',
  ],
  [
    'id' => 's2',
    'name' => 'Велокрепление LUX Bike-1',
    'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/lux_bike_1.jpg" alt="Велокрепление LUX Bike-1">',
    'price' => '2 500 рублей',
    'strike_price' => '3 500 рублей',
  ],
  [
    'id' => 's3',
    'name' => 'Велокрепление Atlant Roof Rider',
    'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/atlant_roof_rider.jpg" alt="Велокрепление Atlant Roof Rider">',
    'price' => '4 300 рублей',
    'strike_price' => '5 900 рублей',
  ],
];
$_SESSION['sales'] = $sales;
echo "<h2 class='title title-h2'>Специальные предложения</h2>"; ?>
<div class="sales">
  <?php foreach ($sales as $sale): ?>
    <div class="sales__item">
      <?php echo $sale['img']; ?>
      <div class="sales__description">
        <h4 class="title title-h4"><?php echo $sale['name']; ?></h4>
        <div class="sales__item-price">
          <p>
            <span class="text">Новая цена: </span><span class="sales__price"><?php echo $sale['price']; ?></span>
          </p>
          <p>
            <span class="text">Старая цена: </span><span
              class="sales__price sales__price--strike"><?php echo $sale['strike_price']; ?></span>
          </p>
        </div>
        <div class="sales__item-button">
          <a onclick="yaCounter40650914.reachGoal('click_zakaz'); return true" href="/buy/<?php echo $sale['id']; ?>"
             class="button button__buy">Заказать</a>
        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>
