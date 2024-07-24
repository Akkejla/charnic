<?php

$userData = getUserData($_SESSION['login']);

if ($userData) {
    // Выводим данные пользователя в HTML
    echo "<table>";
    echo "<tr><th>Наименование</th><th>Значение</th></tr>";
    foreach ($userData as $key => $value) {
        echo "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "Пользователь не найден.";
}
?>