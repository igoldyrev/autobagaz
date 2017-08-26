<?php
mysql_connect("localhost", "9082410193", "GfhjkmDatabase")//параметры в скобках ("хост", "имя пользователя", "пароль")
or die("<p>Ошибка подключения к базе данных! " . mysql_error() . "</p>");


mys ql_select_db("9082410193_zakaz")//параметр в скобках ("имя базы, с которой соединяемся")
 or die("<p>Ошибка выбора базы данных! ". mysql_error() . "</p>");

mysql_query ("set_client='utf8'");//Следующие 2 строки решают проблему с кодировкой.
mysql_query ("SET NAMES utf8");
 
?>