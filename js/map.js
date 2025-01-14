function getComplaintsText(count) {
  let remainder10 = count % 10;
  let remainder100 = count % 100;

  if (remainder100 >= 11 && remainder100 <= 19) {
    return `${count} жалоб`;
  }
  if (remainder10 === 1) {
    return `${count} жалоба`;
  }
  if (remainder10 >= 2 && remainder10 <= 4) {
    return `${count} жалобы`;
  }
  return `${count} жалоб`;
}

async function init() {
  let map = new ymaps.Map("map", {
    center: [55.755864, 37.617698],
    zoom: 11,
  });

  await updateMap(map, "default");

  document
    .getElementById("form-change")
    .addEventListener("submit", async (event) => {
      event.preventDefault();
      let address = document.getElementById("address").value;

      if (address) {
        let geoResult = await ymaps.geocode(address);
        let geoObject = geoResult.geoObjects.get(0);

        if (geoObject) {
          let coordinates = geoObject.geometry.getCoordinates();
          map.setCenter(coordinates, 17); 
        } else {
          alert("Адрес не найден. Проверьте корректность ввода.");
        }
      }
    });

  document
    .getElementById("form-change")
    .addEventListener("change", async () => {
      let period = document.getElementById("period").value;
      let district = document.getElementById("district").value;
      let year_built = document.getElementById("year_built").value;
      let insects = document.getElementById("insects").value;

      let query = `period=${period}&district=${district}&year_built=${year_built}&insects=${insects}`;
      await updateMap(map, query);
    });
}

async function updateMap(map, filterValue) {
  map.geoObjects.removeAll();

  let response = await fetch(`backend/get_placemark.php?${filterValue}`);
  let data = await response.json();

  data.forEach((item) => {
    let placemark = new ymaps.Placemark(
      item.coordinates,
      {
        balloonContent: `
        <div class="balloon">
          <div class="balloon-address">${item.address}</div>
          <div class="balloon-footer">
            <p>${getComplaintsText(item.complaints)}</p>
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

  map.controls.remove("geolocationControl");
  map.controls.remove("searchControl");
  map.controls.remove("trafficControl");
  map.controls.remove("typeSelector");
  map.controls.remove("zoomControl");
  map.controls.remove("rulerControl");
}

ymaps.ready(init);
