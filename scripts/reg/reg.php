<?php
 /**
 * Обработчик формы регистрации
 * Регистрация пользователя письмом
 */
 
 //Выводим сообщение об удачной регистрации
 if(isset($_GET['status']) and $_GET['status'] == 'ok')
	echo '<b>Вы успешно зарегистрировались! Пожалуйста активируйте свой аккаунт!</b>';
 
 //Выводим сообщение об удачной регистрации
 if(isset($_GET['active']) and $_GET['active'] == 'ok')
	echo '<b>Ваш аккаунт на http://charnic.ru успешно активирован!</b>';
	
 //Производим активацию аккаунта
 if (isset($_GET['key'])) {
    // Проверяем ключ
    $sql = 'SELECT * 
        FROM ' . EPP_DBPREFIX . USERS . '
        WHERE active_hex = :key';
    // Подготавливаем PDO выражение для SQL запроса
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':key', $_GET['key'], PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) == 0) {
        $err[] = 'Ключ активации не верен!';
    }

    // Проверяем наличие ошибок и выводим пользователю


	if(count($err) > 0)
		echo showErrorMessage($err);
	else
	{
		//Получаем адрес пользователя
		$email = $rows[0]['login'];
	
		//Активируем аккаунт пользователя
		$sql = 'UPDATE ' . EPP_DBPREFIX . USERS . '
				SET `status` = 1
				WHERE `login` = :email';
		//Подготавливаем PDO выражение для SQL запроса
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		
		//Отправляем письмо для активации
		$title = 'Ваш аккаунт на http://charnic.ru успешно активирован';
		$message = 'Поздравляю Вас, Ваш аккаунт на http://charnic.ru успешно активирован';
			
		sendMessageMail($email, EPP_MAIL_AUTOR, $title, $message);
			
		/*Перенаправляем пользователя на 
		нужную нам страницу*/
		header('Location:'. EPP_HOST .'?mode=reg&active=ok');
		exit;
	}
 }
 /*Если нажата кнопка на регистрацию,
 начинаем проверку*/
 if(isset($_POST['submit']))
 {
	//Утюжим пришедшие данные
	if(empty($_POST['email']))
		$err[] = 'Поле Email не может быть пустым!';
	else
	{
		if(emailValid($_POST['email']) === false)
           $err[] = 'Не правильно введен E-mail'."\n";
	}
	
	if(empty($_POST['pass']))
		$err[] = 'Поле Пароль не может быть пустым';
	
	if(empty($_POST['pass2']))
		$err[] = 'Поле Подтверждения пароля не может быть пустым';
	
	//Проверяем наличие ошибок и выводим пользователю
	if(count($err) > 0)
		echo showErrorMessage($err);
	else
	{
		/*Продолжаем проверять введеные данные
		Проверяем на совподение пароли*/
		if($_POST['pass'] != $_POST['pass2'])
			$err[] = 'Пароли не совподают';
			
		//Проверяем наличие ошибок и выводим пользователю
	    if(count($err) > 0)
			echo showErrorMessage($err);
		else
		{
			/*Проверяем существует ли у нас 
			такой пользователь в БД*/
			$sql = 'SELECT `login` 
					FROM ' . EPP_DBPREFIX . USERS . '
					WHERE `login` = :login';
			//Подготавливаем PDO выражение для SQL запроса
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':login', $_POST['email'], PDO::PARAM_STR);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			if(count($rows) > 0)
				$err[] = 'К сожалению Логин: <b>'. $_POST['email'] .'</b> занят!';
			
			//Проверяем наличие ошибок и выводим пользователю
			if(count($err) > 0)
				echo showErrorMessage($err);
			else
			{
				//Получаем ХЕШ соли
				$salt = salt();
				
				//Солим пароль
				$pass = md5(md5($_POST['pass']).$salt);
				
				/*Если все хорошо, пишем данные в базу*/
				$sql = 'INSERT INTO '.  EPP_DBPREFIX . USERS . '
				       (login, pass, salt, active_hex, status)
				       VALUES
				       (:email, :pass, :salt, :active_hex, 0)';

				$stmt = $db->prepare($sql);
				$stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
				$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
				$stmt->bindValue(':salt', $salt, PDO::PARAM_STR);
				$stmt->bindValue(':active_hex', md5($salt), PDO::PARAM_STR);
				$stmt->execute();
				
				//Отправляем письмо для активации
				$url = EPP_HOST .'?mode=reg&key='. md5($salt);
				$title = 'Регистрация на http://charnic.ru';
				$message = 'Для активации Вашего акаунта пройдите по ссылке 
				<a href="'. $url .'">'. $url .'</a>';
				
				sendMessageMail($_POST['email'], EPP_MAIL_AUTOR, $title, $message);
				
				//Сбрасываем параметры
				header('Location:'. EPP_HOST .'?mode=reg&status=ok');
				exit;
			}
		}
	}
 }
 
?>