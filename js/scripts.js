function switchStyle() {
    // Отправляем POST-запрос, чтобы вызвать функцию switch_style()
    fetch('your-script.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        // Обновляем стиль на странице
        document.documentElement.setAttribute('data-style', data.style);
    })
    .catch(error => console.error(error));
}
