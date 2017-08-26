<?php
$sql = mysql_connect('localhost', '9082410193', 'GfhjkmDatabase');
mysql_select_db('9082410193_zakaz', $sql);

mysql_query ("set_client='utf8'");//Следующие 2 строки решают проблему с кодировкой.
mysql_query ("SET NAMES utf8"); ?>