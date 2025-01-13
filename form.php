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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
  <script src="js/script.js" defer></script>
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
    <div class="container">
      <a href="index.php" class="back">На главную страницу</a>
    </div>

    <section id="statement">
      <div class="container">
        <div class="statement_title_inner pt-16">
          <h1 class="h1-main">Подача заявления</h1>
        </div>
        <form action="backend/statement_result.php" method="post" enctype="multipart/form-data">
          <div class="block">
            <h2 class="h2-green">Личные данные</h2>
            <div class="form-group pt-32">
              <div class="form">
                <label for="firstName">Имя</label>
                <input
                  type="text"
                  id="firstName"
                  class="field input"
                  name="firstName"
                  placeholder="Введите ваше имя"
                  required />
              </div>
              <div class="form">
                <label for="lastName">Фамилия</label>
                <input
                  type="text"
                  id="lastName"
                  class="field input"
                  name="lastName"
                  placeholder="Введите вашу фамилию"
                  required />
              </div>
            </div>
            <div class="form-group pt-32">
              <div class="form">
                <label for="patronymic">Отчество</label>
                <input
                  type="text"
                  id="patronymic"
                  class="field input"
                  name="patronymic"
                  placeholder="Введите ваше отчество" />
              </div>
              <div class="form">
                <label for="email">Электронная почта</label>
                <input
                  type="email"
                  id="email"
                  class="field input"
                  name="email"
                  placeholder="Введите ваш email"
                  required />
              </div>
            </div>
          </div>

          <div class="block">
            <h2 class="h2-green">Информация о проблеме</h2>

            <div class="form pt-32">
              <label for="address">Адрес с выявленной проблемой</label>
              <input
                type="text"
                id="address"
                class="field input"
                name="address"
                placeholder="Введите адрес"
                required />
            </div>

            <div class="form-select pt-16">
              <div class="form left-side">
                <label for="insects">Насекомые</label>
                <select
                  id="insects"
                  class="field select"
                  name="insects"></select>

                <input type="hidden" name="insects[]" id="hidden-insects">
              </div>
              <div class="right-side">
                <div id="selected-insects"></div>
              </div>
            </div>

            <div class="pt-16">
              <button type="button" id="add-insect" class="btn-add">Добавить</button>
            </div>

            <div class="pt-32">
              <hr />
            </div>

            <p class="o-70 pt-32">
              Опишите проблему подробнее в комментарии: как давно вы заметили
              вредителей, насколько серьёзна проблема (единичные случаи или
              массовое заражение), и какие меры вы уже предпринимали для её
              решения, если предпринимали. Ниже вы можете прикрепить фото или
              видео.
            </p>

            <div class="form pt-16">
              <label for="comment">Комментарий:</label>
              <textarea
                id="comment"
                class="field input textarea"
                name="comment"
                placeholder="Введите ваш комментарий"
                rows="5"
                cols="40"></textarea>
            </div>

            <div class="pt-16">
              <label for="file" class="btn-add">Прикрепить файл</label>
              <input
                type="file"
                id="file"
                class="btn-file"
                name="file"
                accept=".jpg,.jpeg,.png,.pdf" />
            </div>

            <div class="pt-32">
              <label>
                <input type="checkbox" id="confirm" name="confirm" />
                Уведомить ли вас о результатах обработки заявки?
              </label>
            </div>
          </div>

          <div class="right">
            <button class="btn-bright" type="submit">Отправить заявление</button>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>

</html>