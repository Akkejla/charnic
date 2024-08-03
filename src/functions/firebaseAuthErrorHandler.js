// firebaseAuthErrorHandler.js
export const handleFirebaseAuthError = (error) => {
 switch (error.code) {
    case 'auth/claims-too-large':
      return 'Полезная нагрузка претензий, предоставленная в setCustomUserClaims(), превышает максимально допустимый размер в 1000 байт.';
    case 'auth/email-already-exists':
      return 'Предоставленный email уже используется существующим пользователем. Каждый пользователь должен иметь уникальный email.';
    case 'auth/id-token-expired':
      return 'Предоставленный Firebase ID-токен истек.';
    case 'auth/id-token-revoked':
      return 'Firebase ID-токен был отозван.';
    case 'auth/insufficient-permission':
      return 'Учетные данные, используемые для инициализации Admin SDK, не имеют достаточных разрешений для доступа к запрашиваемому ресурсу аутентификации. Обратитесь к разделу "Настройка проекта Firebase" для получения документации о том, как сгенерировать учетные данные с соответствующими разрешениями и использовать их для аутентификации Admin SDK.';
    case 'auth/internal-error':
      return 'Сервер аутентификации столкнулся с неожиданной ошибкой при попытке обработать запрос. Сообщение об ошибке должно содержать ответ от сервера аутентификации, содержащий дополнительную информацию. Если ошибка сохраняется, сообщите о проблеме в нашем канале поддержки сообщений об ошибках.';
    case 'auth/invalid-argument':
      return 'Недействительный аргумент был предоставлен методу аутентификации. Сообщение об ошибке должно содержать дополнительную информацию.';
    case 'auth/invalid-claims':
      return 'Предоставленные атрибуты пользовательских претензий в setCustomUserClaims() недействительны.';
    case 'auth/invalid-continue-uri':
      return 'URL продолжения должен быть действительным URL-адресом.';
    case 'auth/invalid-creation-time':
      return 'Время создания должно быть действительной строкой даты UTC.';
    case 'auth/invalid-credential':
      return 'Неверный логин или пароль!';
    case 'auth/invalid-disabled-field':
      return 'Предоставленное значение для свойства отключенного пользователя недействительно. Это должно быть логическим значением.';
    case 'auth/invalid-display-name':
      return 'Предоставленное значение для свойства displayName пользователя недействительно. Это должна быть непустая строка.';
    case 'auth/invalid-dynamic-link-domain':
      return 'Предоставленный домен динамической ссылки не настроен или не авторизован для текущего проекта.';
    case 'auth/invalid-email':
      return 'Предоставленное значение для свойства email пользователя недействительно. Это должен быть строковый адрес электронной почты.';
    case 'auth/invalid-email-verified':
      return 'Предоставленное значение для свойства emailVerified пользователя недействительно. Это должно быть логическим значением.';
    case 'auth/invalid-hash-algorithm':
      return 'Алгоритм хеширования должен соответствовать одной из строк в списке поддерживаемых алгоритмов.';
    case 'auth/invalid-hash-block-size':
      return 'Размер блока хеша должен быть допустимым числом.';
    case 'auth/invalid-hash-derived-key-length':
      return 'Длина ключа, полученного из хеша, должна быть допустимым числом.';
    case 'auth/invalid-hash-key':
      return 'Ключ хеша должен быть допустимым буферным объектом.';
    case 'auth/invalid-hash-memory-cost':
      return 'Стоимость памяти хеширования должна быть допустимым числом.';
    case 'auth/invalid-hash-parallelization':
      return 'Параллелизация хеширования должна быть допустимым числом.';
    case 'auth/invalid-hash-rounds':
      return 'Раунды хеширования должны быть допустимым числом.';
    case 'auth/invalid-hash-salt-separator':
      return 'Поле разделителя соли алгоритма хеширования должно быть допустимым буферным объектом.';
    case 'auth/invalid-id-token':
      return 'Предоставленный ID-токен не является действительным токеном Firebase.';
    case 'auth/invalid-last-sign-in-time':
      return 'Последнее время входа в систему должно быть действительной строкой даты UTC.';
    case 'auth/invalid-page-token':
      return 'Предоставленный маркер следующей страницы в listUsers() недействителен. Он должен быть допустимой непустой строкой.';
    case 'auth/invalid-password':
      return 'Предоставленное значение для свойства пароля пользователя недействительно. Это должна быть строка с не менее чем шестью символами.';
    case 'auth/invalid-password-hash':
      return 'Хеш пароля должен быть допустимым буферным объектом.';
    case 'auth/invalid-password-salt':
      return 'Соль пароля должна быть допустимым буферным объектом.';
    case 'auth/invalid-phone-number':
      return 'Предоставленное значение для phoneNumber недействительно. Это должен быть непустой идентификатор, соответствующий стандарту E.164.';
    case 'auth/invalid-photo-url':
      return 'Предоставленное значение для свойства photoURL пользователя недействительно. Это должна быть строка URL.';
    case 'auth/invalid-provider-data':
      return 'providerData должен быть допустимым массивом объектов UserInfo.';
    case 'auth/weak-password':
      return 'Слабый пароль. Пароль должен содержать не менее 6 символов';
    default:
      return error.message;
  }
};
