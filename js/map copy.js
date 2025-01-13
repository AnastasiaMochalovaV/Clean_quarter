async function init() {
  let map = new ymaps.Map("map", {
    center: [55.755864, 37.617698],
    zoom: 11,
  });

  // Загружаем данные из PHP-скрипта
  let response = await fetch("backend/get_placemark copy.php"); 
  let data = await response.json();
  
  // Добавляем метки для каждого элемента данных
  data.forEach((item) => {
    let placemark = new ymaps.Placemark(
      item.coordinates,
      {
        balloonContent: `
        <div class="balloon">
          <div class="balloon-address">${item.address}</div>
          <div class="balloon-footer">
            <p>${item.complaints} жалоб</p>
          </div>
        </div>`,
      },
      {
        iconLayout: "default#image",
        iconImageHref: "images/locator.png",
        iconImageSize: [30, 40],
        iconImageOffset: [-15, -20],
      }
    );

    map.geoObjects.add(placemark);
  });

  // Удаление стандартных контролов карты
  map.controls.remove("geolocationControl");
  map.controls.remove("searchControl");
  map.controls.remove("trafficControl");
  map.controls.remove("typeSelector");
  map.controls.remove("zoomControl");
  map.controls.remove("rulerControl");
}

ymaps.ready(init);
