<?php
include 'database.php';

$result = $mysqli->query("SELECT * FROM houses");

?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Чистый квартал. Курсовой проект. Мочалова Анастасия Вячеславовна, 231-362</title>
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
                    <a href="#intro">Главная</a>
                    <a href="#map-block">Карта</a>
                    <a href="#">Статистика</a>
                    <a href="form.php">Обратиться</a>
                </nav>
            </div>
        </div>
    </header>

    <main>
        <section id="intro">
            <div class="container">
                <div class="intro_title_inner">
                    <h1>Контроль и мониторинг санитарного состояния жилых домов в Москве</h1>
                </div>
                <div class="intro_inner">
                    <div class="intro_text_inner">
                        <div class="intro_description">
                            <p>Сервис создан для того, чтобы помочь жителям города сообщать о случаях появления вредителей в жилых домах и видеть актуальные данные на карте.</p>
                            <p>Вы можете:</p>
                            <div class="tire">
                                <ul>
                                    <li>Сообщить о проблеме в вашем доме.</li>
                                    <li>Посмотреть на интерактивной карте районы, где уже были зафиксированы случаи появления вредителей.</li>
                                    <li>Получите доступ к статистическим данным о частоте жалоб и распространенности проблем в разных районах города.</li>
                                </ul>
                            </div>
                            <p>Уже более 100 тыс. пользователей оставили заявление</p>
                        </div>

                        <a href="form.php">
                            <button class="btn">Сообщить о проблеме</button>
                        </a>
                    </div>
                    <div class="intro_img_inner">
                        <img src="images/animation.gif" alt="GIF">
                    </div>
                </div>
            </div>
        </section>

        <section id="map-block">
            <div class="container">
                <h2>Карта</h2>
                <form action="search_results.html" method="GET">
                    <div class="form-group">
                        <input type="text" id="search" name="search" placeholder="Введите адрес">

                        <button class="btn-bright" type="submit">Найти</button>
                    </div>

                    <div class="form-group">
                        <div class="form">
                            <label for="period">За какой период:</label>
                            <select id="period" name="period" placeholder="За все время">
                                <option value="all">Все периоды</option>
                                <option value="week">За неделю</option>
                                <option value="month">За месяц</option>
                                <option value="year">За год</option>
                                <option value="year5">За 5 лет</option>
                                <option value="year10">За 10 лет</option>
                            </select>
                        </div>
                        <div class="form">
                            <label for="district">Район:</label>
                            <select id="district" name="district" placeholder="Все районы">
                                <option value="all">Все районы</option>
                                <option value="center">Центральный</option>
                                <option value="north">Северный</option>
                                <option value="south">Южный</option>
                                <option value="east">Восточный</option>
                                <option value="west">Западный</option>
                            </select>
                        </div>
                        <div class="form">
                            <label for="year_built">Год постройки:</label>
                            <select id="year_built" name="year_built" placeholder="Все года">
                                <option value="all">Все года</option>
                                <option value="before_2000">До 2000</option>
                                <option value="2000_2010">2000-2010</option>
                                <option value="after_2010">После 2010</option>
                            </select>
                        </div>
                        <div class="form">
                            <label for="insects">Насекомые:</label>
                            <select id="insects" name="insects" placeholder="Все виды">
                                <option value="all">Все виды</option>
                                <option value="cockroach">Тараканы</option>
                                <option value="bedbugs">Клопы</option>
                                <option value="ants">Муравьи</option>
                                <option value="mosquitoes">Комары</option>
                            </select>
                        </div>
                    </div>

                    <div id="map" class="map"></div>
                    <script src="https://api-maps.yandex.ru/2.1/?apikey=ВАШ_ДЕЙСТВИТЕЛЬНЫЙ_API_КЛЮЧ&lang=ru_RU"></script>
                    <script src="script.js"></script>
                </form>
            </div>
        </section>
    </main>

</body>

</html>