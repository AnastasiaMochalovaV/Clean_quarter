let myMap;

async function init() {
  ymaps.ready(() => {
    if (!myMap) {
      myMap = new ymaps.Map("map", {
        center: [55.751574, 37.573856],
        zoom: 11,
      });

      myMap.controls.remove("geolocationControl");
      myMap.controls.remove("searchControl");
      myMap.controls.remove("trafficControl");
      myMap.controls.remove("typeSelector");
      myMap.controls.remove("zoomControl");
      myMap.controls.remove("rulerControl");
    }
  });
}

async function updateMap(initial = false) {
  const formData = initial
    ? new FormData() // Пустая форма для запроса всех данных
    : new FormData(document.querySelector("form"));

  const params = new URLSearchParams(formData).toString();

  try {
    const response = await fetch(`backend/get_placemark.php?${params}`);
    if (!response.ok) {
      throw new Error("Ошибка запроса к серверу");
    }
    const data = await response.json();

    if (!data || data.length === 0) {
      alert("Нет данных для отображения");
      document.getElementById("coordinatesList").innerHTML =
        "Нет данных для отображения.";
      return;
    }

    myMap.geoObjects.removeAll();
    const coordinatesList = document.getElementById("coordinatesList");
    coordinatesList.innerHTML = "";

    data.forEach((item) => {
      if (!item.geodata_center || !item.address || !item.complaints) {
        console.warn("Пропущены некорректные данные:", item);
        return;
      }

      const [latitude, longitude] = item.geodata_center
        .split(",")
        .map((coord) => parseFloat(coord));

      if (isNaN(latitude) || isNaN(longitude)) {
        console.warn("Некорректные координаты:", item.geodata_center);
        return;
      }

      const coordItem = document.createElement("div");
      coordItem.textContent = `Адрес: ${item.address}, Координаты: [${latitude}, ${longitude}]`;
      coordinatesList.appendChild(coordItem);

      const placemark = new ymaps.Placemark([latitude, longitude], {
        balloonContent: `
              <div class="balloon">
                <div class="balloon-address">${item.address}</div>
                <div class="balloon-footer">
                  <p>${item.complaints} жалоб</p>
                </div>
              </div>`,
      });

      myMap.geoObjects.add(placemark);
    });
  } catch (error) {
    console.error("Ошибка обновления карты:", error);
    alert("Произошла ошибка при загрузке данных");
  }
}

// Добавляем обработчик события на форму (при отправке формы)
document.querySelector("form").addEventListener("submit", function (e) {
  e.preventDefault();
  updateMap();
});

// Добавляем обработчики событий для всех выпадающих списков
document.querySelectorAll("form select").forEach((select) => {
  select.addEventListener("change", updateMap);
});

// Инициализация карты
ymaps.ready(() => {
    init();
    updateMap(true); // Вызов с `true`, чтобы загрузить данные по умолчанию
  });