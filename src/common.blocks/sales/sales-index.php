<?php
$sales = [
  [
    'id' => 's1',
    'name' => 'Носовая сумка TERRA DRIVE для автобоксов',
    'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/terra_bug_nose.jpg" alt="Носовая сумка TERRA DRIVE для автобоксов">',
    'price' => '2 200 рублей',
    'strike_price' => '3 000 рублей',
  ],
  [
    'id' => 's2',
    'name' => 'Основная сумка TERRA DRIVE для автобоксов',
    'img' => '<img class="sales__img" src="/src/common.blocks/sales/img/terra_bug.jpg" alt="Основная сумка TERRA DRIVE для автобоксов">',
    'price' => '2 200 рублей',
    'strike_price' => '3 000 рублей',
  ],
  [
    'id' => 's3',
    'name' => 'Лыжное крепление Amos для 3-4-х пар лыж/2 сноуборда',
    'img' => '<img class="sales__img" src="/content/lyzhnye-kreplenya/img/amos.jpg" alt="Лыжное крепление Amos для 3-4-х пар лыж">',
    'price' => '2 500 рублей',
    'strike_price' => '3 000 рублей',
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
