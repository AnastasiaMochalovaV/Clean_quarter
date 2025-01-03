function init() {
    let map = new ymaps.Map('map', {
        center: [55.755864, 37.617698],
        zoom: 16
    });

    let placemark = new ymaps.Placemark([55.755864, 37.617698], {}, {
        iconLayout: 'default#image',
        iconImageHref: 'images/locator.png',
        iconImageSize: [30, 40],
        iconImageOffset: [-18, -20]
    });
    
    map.controls.remove('geolocationControl'); // удаляем геолокацию
    map.controls.remove('searchControl'); // удаляем поиск
    map.controls.remove('trafficControl'); // удаляем контроль трафика
    map.controls.remove('typeSelector'); // удаляем тип
    map.controls.remove('zoomControl'); // удаляем контрол зуммирования
    map.controls.remove('rulerControl'); // удаляем контрол правил

    map.geoObjects.add(placemark);
}

ymaps.ready(init);