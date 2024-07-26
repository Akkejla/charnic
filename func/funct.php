 <?php
 /**
 * Файл с пользовательскими функциями
 * Site: http://charnic.ru
 * Регистрация пользователя письмом
 */
 
 /**Отпровляем сообщение на почту
 * @param string  $to
 * @param string  $from
 * @param string  $title
 * @param string  $message
 */
function sendMessageMail($to, $from, $title, $message)
{
    //Формируем заголовок письма
    $subject = $title;
    $subject = '=?utf-8?b?'. base64_encode($subject) .'?=';

    //Формируем заголовки для почтового сервера
    $headers  = "Content-type: text/html; charset=\"utf-8\"\r\n";
    $headers .= "From: ". $from ."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Date: ". date('D, d M Y h:i:s O') ."\r\n";

    //Отправляем данные на ящик админа сайта
    if(!mail($to, $subject, $message, $headers))
        return 'Ошибка отправки письма!';
    else
        return true;
}
 function activateAccount($key) {
   global $db;
    // Проверяем ключ
    $sql = 'SELECT * 
        FROM ' . EPP_DBPREFIX . USERS . '
        WHERE active_hex = :key';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':key', $key, PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) == 0) {
        return 'Ключ активации не верен!';
    }

    // Получаем адрес пользователя
    $email = $rows[0]['login'];

    // Активируем аккаунт пользователя
    $sql = 'UPDATE ' . EPP_DBPREFIX . USERS . '
        SET status = 1
        WHERE login = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Отправляем письмо для активации
    $title = 'Ваш аккаунт на http://charnic.ru успешно активирован';
    $message = 'Поздравляю Вас, Ваш аккаунт на http://charnic.ru успешно активирован';
    sendMessageMail($email, EPP_MAIL_AUTOR, $title, $message);

    // Перенаправляем пользователя
    $_SESSION['message'] = '<b>Вы успешно активировали аккаунт! ';
    header('Location:'. EPP_HOST .'?mode=reg&active=ok');
    exit;
}

function validateRegistrationData($email, $pass, $pass2)
{
    $err = [];

    // Проверка поля email
    if (empty($email)) {
        $err[] = 'Поле Email не может быть пустым!';
    } else {
        if (emailValid($email) === false) {
            $err[] = 'Не правильно введен E-mail' . "\n";
        }
    }

    // Проверка поля пароля
    if (empty($pass)) {
        $err[] = 'Поле Пароль не может быть пустым';
    }

    // Проверка поля подтверждения пароля
    if (empty($pass2)) {
        $err[] = 'Поле Подтверждения пароля не может быть пустым';
    }

    // Проверка совпадения паролей
    if ($pass !== $pass2) {
        $err[] = 'Пароли не совпадают';
    }

    if (count($err) > 0) {
        return $err;
    } else {
        return true;
    }
}

function checkUserExists($login)
{
    global $db;

    $sql = 'SELECT login 
            FROM ' . EPP_DBPREFIX . USERS . ' 
            WHERE login = :login';

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':login', $login, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) == 0) {
        return true;
    } else {
        $_SESSION['error_message'] = 'К сожалению Логин: <b>' . $login . '</b> занят!';
        return false;
    }
}



function registerUser($email, $pass)
{
    global $db, $_SESSION;
    
    // Получаем ХЕША соли
    $salt = salt();

    // Солим пароль
    $password = md5(md5($pass) . $salt);
    $active_hex = md5($salt);

    // Формируем SQL-запрос для вставки пользователя в базу данных
    $sql = 'INSERT INTO ' . EPP_DBPREFIX . USERS . '
           (login, pass, salt, active_hex, status)
           VALUES
           (:email, :password, :salt, :active_hex, 0)';

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    $stmt->bindValue(':salt', $salt, PDO::PARAM_STR);
    $stmt->bindValue(':active_hex', $active_hex, PDO::PARAM_STR);

    // Выполняем SQL-запрос
    if ($stmt->execute()) {
        // Отправляем письмо для активации
        $url = EPP_HOST . '?mode=reg&key=' . $active_hex;
        $title = 'Регистрация на http://charnic.ru';
        $message = 'Для активации Вашего акаунта пройдите по ссылке 
        <a href="' . $url . '">' . $url . '</a>';

        if (sendMessageMail($email, EPP_MAIL_AUTOR, $title, $message)) {
            // Сбрасываем параметры
            header('Location:' . EPP_HOST . '?mode=reg&status=ok');
            exit;
        } else {
            showErrorMessage('Ошибка отправки письма!');
        }
        return true;
    } else {
        return $stmt->errorInfo(); // Возвращаем информацию об ошибке
    }
}

  /**функция вывода ошибок
  * @param array  $data
  */
 function showErrorMessage($data)
 {
   $err = '';	
	
	if(is_array($data))
	{
		foreach($data as $val)
			$err .= '<span style="color:red;">'. $val .'</span>'."\n";
	}
	else
		$err .= '<span style="color:red;">'. $data .'</span>'."\n";  
  $_SESSION['error_message'] = '<div class="error-message">' . $err . '</div>';

    // Возвращаем пустую строку, так как ошибка будет выведена в футере
    return '';
 }
 

 /**Простой генератор соли
 * @param string  $sql
 */
 function salt()
 {
	$salt = substr(md5(uniqid()), -8);
	return $salt;
 }

/** Проверка валидации email
* @param string $email
* return boolian
*/
 function emailValid($email){
  if(function_exists('filter_var')){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
      return true;
    }else{
      return false;
    }
  }else{
    if(!preg_match("/^[a-z0-9_.-]+@([a-z0-9]+\.)+[a-z]{2,6}$/i", $email)){
      return false;
    }else{
      return true;
    }
  }      
 }
 // функция переключения стиля
function toggleStyle() {
    // Получаем текущий стиль из сессии
    $current_style = isset($_SESSION['style']) ? $_SESSION['style'] : 'light';

    // Определяем URL-параметр для смены стиля
    $style_param = ($current_style == 'dark') ? 'light' : 'dark';

    // Формируем ссылку для смены стиля
    $style_link = EPP_HOST . '?style=' . $style_param;

    // Проверяем, содержит ли текущий URL параметры
    $query_string = strpos($_SERVER['REQUEST_URI'], '?');
    if ($query_string !== false) {
        // Получаем текущие параметры из URL
        $current_params = explode('?', $_SERVER['REQUEST_URI'])[1];
        $params = array();
        parse_str($current_params, $params);

        // Обновляем значение параметра 'style'
        $params['style'] = $style_param;

        // Формируем новый URL с обновленным параметром 'style'
        $style_link = EPP_HOST . '?' . http_build_query($params);
    }

    // Если присутствует параметр 'style' в запросе, обновляем значение в сессии
    if (isset($_GET['style']) && $_GET['style'] !== $current_style) {
        $_SESSION['style'] = $_GET['style'];
        // Перенаправляем пользователя на текущую страницу без параметра 'style'
          // $currentUrl = $_SERVER['REQUEST_URI'];
          // $currentUrl = strtok($currentUrl, '?');
          // header("Location: $currentUrl");
          exit;
        
    }

    return array(
        'style_link' => $style_link,
        'style_param' => $style_param
    );
  }

  // Зона для авторизованного и не авторизованного пользователя
  function loadZoneFile($user)
  {
      if ($user === false) {
          include './page/unauth_zone/unauth_zone.php';
      } else {
         include './page/auth_zone/auth_zone.php';
      }
  }

// Данные авторизованного пользователя
  
function getUserData($login)
{
    global $db; // Используем глобальный объект $db

    /*Проверяем существует ли у нас 
    такой пользователь в БД*/
    $sql = 'SELECT * 
           FROM ' . EPP_DBPREFIX . USERS . '
           WHERE login = :login';
           
    //Подготавливаем PDO выражение для SQL запроса
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':login', $login, PDO::PARAM_STR);
    $stmt->execute();

    //Получаем данные SQL запроса
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Возвращаем данные пользователя
        return $user;
    } else {
        // Возвращаем ошибку
        return false;
    }
}

 ?>
