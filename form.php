<?php
include 'database.php';
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Подача заявления</title>
  </head>
  <body>
    <header>
      <nav>
        <a href="#main">
          <img src="images/logo.svg" alt="Логотип" />
        </a>
        <ul>
          <li><a href="#main">Главная</a></li>
          <li><a href="#map">Карта</a></li>
          <li><a href="#">Статистика</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <a href="index.php">На главную страницу</a>
      <h1>Подача заявления</h1>

      <section id="statement">
        <form action="/submit" method="post" enctype="multipart/form-data">
          <div class="block">
            <h2>Личные данные</h2>

            <label for="firstName">Имя:</label>
            <input
              type="text"
              id="firstName"
              name="firstName"
              placeholder="Введите ваше имя"
              required
            />

            <label for="lastName">Фамилия:</label>
            <input
              type="text"
              id="lastName"
              name="lastName"
              placeholder="Введите вашу фамилию"
              required
            />

            <label for="middleName">Отчество:</label>
            <input
              type="text"
              id="middleName"
              name="middleName"
              placeholder="Введите ваше отчество"
            />

            <label for="email">Электронная почта:</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Введите ваш email"
              required
            />
          </div>

          <div class="block">
            <h2>Информация о проблеме</h2>

            <label for="address">Адрес с выявленной проблемой:</label>
            <input
              type="text"
              id="address"
              name="address"
              placeholder="Введите адрес"
              required
            />

            <label for="insects">Тип вредителя:</label>
            <select id="insects" name="insects" required>
              <option value="all">Все виды</option>
              <option value="ants">Муравьи</option>
              <option value="cockroaches">Тараканы</option>
              <option value="rats">Крысы</option>
            </select>

            <button type="button">Добавить еще</button>

            <hr />

            <p>
              Опишите проблему подробнее в комментарии: как давно вы заметили
              вредителей, насколько серьёзна проблема (единичные случаи или
              массовое заражение), и какие меры вы уже предпринимали для её
              решения, если предпринимали. Ниже вы можете прикрепить фото или
              видео.
            </p>

            <label for="comment">Комментарий:</label>
            <textarea
              id="comment"
              name="comment"
              placeholder="Введите ваш комментарий"
              rows="5"
              cols="40"
              required
            ></textarea>

            <label for="file">Прикрепить файл:</label>
            <input
              type="file"
              id="file"
              name="file"
              accept=".jpg,.jpeg,.png,.pdf"
            />

            <label>
              <input type="checkbox" id="confirm" name="confirm" required />
              Уведомить ли вас о результатах обработки заявки?
            </label>
          </div>

          <!-- Кнопка отправки -->
          <button type="submit">Отправить заявление</button>
        </form>
      </section>
    </main>
  </body>
</html>