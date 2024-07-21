<?php
 /**
 * Конфигурационный файл
 * Site: http://bezramok-tlt.ru
 * Регистрация пользователя письмом
 */


 //Ключ защиты
 if(!defined('BEZ_KEY'))
 {
     header("HTTP/1.1 404 Not Found");
     exit(file_get_contents('./404.html'));
 }

 //Адрес базы данных
 define('BEZ_DBSERVER','cha6408987.mysql');

 //Логин БД
 define('BEZ_DBUSER','cha6408987_mysql');

 //Пароль БД
 define('BEZ_DBPASSWORD','MZa2mmZ-');

 //БД
 define('BEZ_DATABASE','cha6408987_users');

 //Префикс БД
 define('BEZ_DBPREFIX','cha6408987_');

 //Errors
 define('BEZ_ERROR_CONNECT','Немогу соеденится с БД');

 //Errors
 define('BEZ_NO_DB_SELECT','Данная БД отсутствует на сервере');

 //Адрес хоста сайта
 define('BEZ_HOST','http://'. $_SERVER['HTTP_HOST'] .'/');
 
 //Адрес почты от кого отправляем
 define('BEZ_MAIL_AUTOR','Регистрация на http://bezramok-tlt.ru <no-reply@bezramok-tlt.ru>');
 ?>