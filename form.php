<?php
include 'database.php';
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Подача заявления</title>
  <link rel="stylesheet" href="styles/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
  <header class="header">
    <div class="container">
      <div class="header_inner">
        <div class="logo">
          <img src="images/logo.svg" alt="Логотип">
        </div>
        <nav class="nav">
          <a href="index.php">Главная</a>
          <a href="#map">Карта</a>
          <a href="#">Статистика</a>
          <a href="form.php">Обратиться</a>
        </nav>
      </div>
    </div>
  </header>

  <main>
    <a href="index.php">На главную страницу</a>
    <h1>Подача заявления</h1>

    <section id="statement">
      <div class="container">
        <form action="/submit" method="post" enctype="multipart/form-data">
          <div class="block">
            <h2 class="h2-green">Личные данные</h2>
            <div class="form-group">
              <div class="form">
                <label for="firstName">Имя:</label>
                <input
                  type="text"
                  id="firstName"
                  name="firstName"
                  placeholder="Введите ваше имя"
                  required />
              </div>
              <div class="form">
                <label for="lastName">Фамилия:</label>
                <input
                  type="text"
                  id="lastName"
                  name="lastName"
                  placeholder="Введите вашу фамилию"
                  required />
              </div>
            </div>
            <div class="form-group">
              <div class="form">
                <label for="middleName">Отчество:</label>
                <input
                  type="text"
                  id="middleName"
                  name="middleName"
                  placeholder="Введите ваше отчество" />
              </div>
              <div class="form">
                <label for="email">Электронная почта:</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  placeholder="Введите ваш email"
                  required />
              </div>
            </div>
          </div>

          <div class="block">
            <h2 class="h2-green">Информация о проблеме</h2>

            <label for="address">Адрес с выявленной проблемой:</label>
            <input
              type="text"
              id="address"
              name="address"
              placeholder="Введите адрес"
              required />

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
              required></textarea>

            <label for="file">Прикрепить файл:</label>
            <input
              type="file"
              id="file"
              name="file"
              accept=".jpg,.jpeg,.png,.pdf" />

            <label>
              <input type="checkbox" id="confirm" name="confirm" required />
              Уведомить ли вас о результатах обработки заявки?
            </label>
          </div>

          <!-- Кнопка отправки -->
          <button class="btn-bright" type="submit">Отправить заявление</button>
        </form>
      </div>
    </section>
  </main>
</body>

</html>