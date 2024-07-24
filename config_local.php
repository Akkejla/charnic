<?php
 /**
 * Конфигурационный файл
 * Регистрация пользователя письмом
 */


 //Ключ защиты
/* if(!defined('EPP_KEY'))
 {
     header("HTTP/1.1 404 Not Found");
     exit(file_get_contents('./404.html'));
 }*/

 //Адрес базы данных
 define('EPP_DBSERVER','127.0.0.1');

 //Логин БД
 define('EPP_DBUSER','root');

 //Пароль БД
 define('EPP_DBPASSWORD','root');

 //БД
 define('EPP_DATABASE','epp');

 //Префикс БД
 define('EPP_DBPREFIX','');

 //Таблица пользоаптелей
 define('USERS','users');

 //Errors
 define('EPP_ERROR_CONNECT','Не могу соеденится с БД');

 //Errors
 define('EPP_NO_DB_SELECT','Данная БД отсутствует на сервере');

 //Адрес хоста сайта
 define('EPP_HOST','http://'. $_SERVER['HTTP_HOST'] .'/');
 
 //Адрес почты от кого отправляем
 define('EPP_MAIL_AUTOR','Регистрация на http://charnic.ru ');
 ?>