// JavaScript
function sendMessageMail() {
  // Получаем значения полей формы
  var to = document.getElementById('to').value;
  var from = document.getElementById('from').value;
  var title = document.getElementById('title').value;
  var message = document.getElementById('message').value;

  // Создаем объект XMLHttpRequest
  var xhr = new XMLHttpRequest();

  // Настраиваем обработчик ответа от сервера
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Обрабатываем ответ от сервера
      if (xhr.responseText === 'true') {
        // Письмо отправлено успешно
        alert('Письмо отправлено!');
      } else {
        // Произошла ошибка при отправке письма
        alert('Ошибка отправки письма: ' + xhr.responseText);
      }
    }
  };

  // Отправляем AJAX-запрос на сервер
  xhr.open('POST', './functions/send_mail.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send('to=' + encodeURIComponent(to) + '&from=' + encodeURIComponent(from) + '&title=' + encodeURIComponent(title) + '&message=' + encodeURIComponent(message));
}
