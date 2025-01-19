const submit_btn = document.getElementById("submit");
const data_table = document.getElementById("data");
//Добавил переменную селектора
const user_select = document.getElementById("user");
submit_btn.onclick = function (e) {
  e.preventDefault();
  data_table.style.display = "block";
  //для обновления страницы без перезагрузки и сторонних фреймворков использую класс XMLHttpRequest
  var xhr = new XMLHttpRequest();
  //запрос гет, указываю параметром айдишку пользователя
  xhr.open("GET", "/data.php?user=" + user_select.value, true);
  //функция на получение ответа
  xhr.onload = function () {
    //проверяем что ответ успешный
    if (xhr.status >= 200 && xhr.status < 300) {
      //устанавливаю значение в таблицу
      data_table.innerHTML = xhr.responseText;
    } else {
      //вывод если страница ответила ошибкой
      console.error("Request failed with status:", xhr.status);
    }
  };
  //Отправка запроса
  xhr.send();
};
