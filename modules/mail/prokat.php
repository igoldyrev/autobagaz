<?php
$prokat = "
Заказан товар".$_SESSION['tovar'].";
Имя: ".$name.";
Телефон: ".$phone.";
Оборудование: ".$bagazhnik.", ".$autobox.", ".$velokreplenie_krysha.", ".$velokreplenie_farkop.", ".$lyzhnoe_kreplenie.", ".$braslets.";
Срок: ".$time.";
Дополнительная информация: ".$text.";

Техническая информация:
ip-адрес: ".$_SERVER['REMOTE_ADDR']."
Ссылка на скрипт, который прислал письмо: ".$_SERVER['REQUEST_URI']."
";