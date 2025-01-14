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
    <script src="js/script.js" defer></script>
    <script src="js/map.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <a href="#statistic">Статистика</a>
                    <a href="form.php">Обратиться</a>
                </nav>
            </div>
        </div>
    </header>

    <?php
    if (isset($_COOKIE['status']) && $_COOKIE['status'] == 'success') {
        echo "<div class='notifications show'>
                <p>Заявление успешно отправлено!</p>
            </div>";
        setcookie('status', '', time() - 3600, '/');
    }
    ?>

    <main>
        <section id="intro">
            <div class="container">

                <div class="intro_inner">

                    <div class="intro_text_inner">
                        <div class="intro_title_inner">
                            <h1 class="h1-main">Контроль и мониторинг санитарного состояния жилых домов в Москве</h1>
                        </div>
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
                <h2 class="h2-main">Карта</h2>
                <form id="form-change" action="backend/get_placemark.php" method="GET">
                    <div class="form-group">
                        <div class="input">
                            <input
                                type="search"
                                id="address"
                                class="field input"
                                name="address"
                                autocomplete="off"
                                placeholder="Введите адрес">
                            <ul id="suggestions" class="suggestions"></ul>
                        </div>

                        <button class="btn-bright" type="submit">Найти</button>
                    </div>

                    <div class="form-group pt-16">
                        <div class="form">
                            <label for="period">За какой период</label>
                            <select id="period" class="field select" name="period" placeholder="За все время">
                                <option value="all">Все периоды</option>
                                <option value="week">За неделю</option>
                                <option value="month">За месяц</option>
                                <option value="year">За год</option>
                                <option value="year5">За 5 лет</option>
                                <option value="year10">За 10 лет</option>
                            </select>
                        </div>
                        <div class="form">
                            <label for="district">Округ</label>
                            <select
                                id="district"
                                class="field select"
                                name="district">
                                <option value="all">Все округа</option>
                            </select>
                        </div>
                        <div class="form">
                            <label for="year_built">Год постройки</label>
                            <select id="year_built" class="field select" name="year_built" placeholder="Все года">
                                <option value="all">Все года</option>
                                <option value="before_2000">До 2000</option>
                                <option value="2000_2010">2000-2010</option>
                                <option value="after_2010">После 2010</option>
                            </select>
                        </div>
                        <div class="form">
                            <label for="insects">Насекомые</label>
                            <select
                                id="insects"
                                class="field select"
                                name="insects">
                                <option value="all">Все виды</option>
                            </select>
                        </div>
                    </div>

                    <div id="map" class="map pt-32"></div>
                    <script src="https://api-maps.yandex.ru/2.1/?apikey=22b04afd-ac73-42fa-a1ec-06a4af1c98fe&lang=ru_RU"></script>
                </form>
            </div>
        </section>

        <section id="statistic">
            <div class="container">
                <h2 class="h2-main">Статистика</h2>
                <div class="form-group">
                    <div class="block">
                        <img src="images/statement.png" alt="Заявления">
                        <p id="total-statements"></p>
                    </div>
                    <div class="block">
                        <img src="images/house.png" alt="Округ">
                        <p id="top-district"></p>
                    </div>
                    <div class="block">
                        <img src="images/pest.png" alt="Насекомое">
                        <p id="top-insect"></p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer class="footer">
        <div class="container">
            <p>
                Используются <a href="https://data.mos.ru/opendata/60562?pageSize=50&pageIndex=0&isDynamic=false&version=3&release=1251"
                    aria-label="Ссылка на открытые данные Правительства Москвы">открытые данные</a> с портала открытых данных Правительства Москвы.
            </p>
        </div>
    </footer>
</body>

</html>