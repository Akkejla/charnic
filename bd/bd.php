<?php
 /**
 * Подключение к базе данных
 * Site: http://charnic.ru
 * Регистрация пользователя письмом
 */

 //Ключ защиты
 if(!defined('EPP_KEY'))
 {
     header("HTTP/1.1 404 Not Found");
     exit(file_get_contents('./../404.html'));
 }

//Подключение к базе данных mySQL с помощью PDO
try {
    $db = new PDO('mysql:host=localhost;dbname='.EPP_DATABASE, EPP_DBUSER, EPP_DBPASSWORD, array(
    	PDO::ATTR_PERSISTENT => true
    	));

} catch (PDOException $e) {
    print "Ошибка соединеия!: " . $e->getMessage() . "<br/>";
    die();
}

