<?php
 /**
 * Обработчик формы регистрации
 * Регистрация пользователя письмом
 */

 // Выводим сообщение об удачной регистрации
 
	
 
 /*Если нажата кнопка на регистрацию,
 начинаем проверку*/

 if(isset($_POST['submit'])){

	$login = $_POST['email'];
	$pass = $_POST['pass'];
	$pass2 = $_POST['pass2'];
	if(validateRegistrationData($login, $pass, $pass2)){
		if(checkUserExists($login) === true){
			if (registerUser($login, $pass) ){
				echo 'ok';
			} else {
				showErrorMessage(registerUser($login, $pass));
			}
		} else{
			 echo (checkUserExists('akkejla@yandex.ru'));
		}
	}else {
		echo validateRegistrationData($login, $pass, $pass2);
	}
 }
if(isset($_GET['key'])){
$key = $_GET['key'];
echo $key;
 activateAccount($key);
}
 
?>