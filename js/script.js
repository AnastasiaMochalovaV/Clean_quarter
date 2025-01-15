setTimeout(function () {
  const notification = document.querySelector(".notifications");
  if (notification) {
    notification.classList.remove("show");
  }
}, 2000);

document.addEventListener("DOMContentLoaded", function () {
  fetch("backend/get_pests.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        console.error(data.error);
      } else {
        const selectElement = document.getElementById("insects");

        data.forEach((pests) => {
          const option = document.createElement("option");
          option.value = pests;
          option.textContent = pests;
          selectElement.appendChild(option);
        });
      }
    })
    .catch(() => console.error("Ошибка запроса данных о вредителях."));
});

document.addEventListener("DOMContentLoaded", () => {
  const addressInput = document.getElementById("address");
  const suggestionsList = document.getElementById("suggestions");

  const showSuggestions = (data) => {
    suggestionsList.innerHTML = data.map((item) => `<li>${item}</li>`).join("");
    suggestionsList.style.display = data.length ? "block" : "none";
  };

  suggestionsList.addEventListener("click", (event) => {
    if (event.target.tagName === "LI") {
      addressInput.value = event.target.textContent;
      suggestionsList.style.display = "none";
    }
  });

  addressInput.addEventListener("input", () => {
    const query = addressInput.value;

    if (query.length < 2) {
      suggestionsList.style.display = "none";
      return;
    }

    fetch(`backend/get_houses.php?term=${encodeURIComponent(query)}`)
      .then((response) => (response.ok ? response.json() : Promise.reject()))
      .then(showSuggestions)
      .catch(() => {
        console.error("Ошибка получения данных.");
        suggestionsList.style.display = "none";
      });
  });

  document.addEventListener("click", (event) => {
    if (!event.target.closest(".form-group")) {
      suggestionsList.style.display = "none";
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  fetch("backend/get_districts.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.error) {
        console.error(data.error);
      } else {
        const selectElement = document.getElementById("district");
        selectElement.innerHTML = '<option value="all">Все округа</option>';

        data.forEach((district) => {
          const option = document.createElement("option");
          option.value = district;
          option.textContent = district;
          selectElement.appendChild(option);
        });
      }
    })
    .catch(() => console.error("Ошибка запроса данных о округах."));
});

document.addEventListener("DOMContentLoaded", function () {
  const insectsSelect = document.getElementById("insects");
  const defaultOption = insectsSelect.querySelector('option[value=""]');

  if (defaultOption) {
    defaultOption.disabled = true;
  }
});

document.getElementById("add-insect").addEventListener("click", function () {
  const insectsSelect = document.getElementById("insects");
  const selectedValue = insectsSelect.value;
  const selectedText = insectsSelect.options[insectsSelect.selectedIndex].text;

  if (selectedValue !== "") {
    const insectField = createInsectField(selectedText, selectedValue);
    document.getElementById("selected-insects").appendChild(insectField);

    const hiddenInsectsInput = document.getElementById("hidden-insects");
    const insectsArray = hiddenInsectsInput.value
      ? hiddenInsectsInput.value.split(",")
      : [];

    if (!insectsArray.includes(selectedValue)) {
      insectsArray.push(selectedValue);
      hiddenInsectsInput.value = insectsArray.join(",");
    }

    insectsSelect.removeChild(
      insectsSelect.querySelector(`option[value="${selectedValue}"]`)
    );
    insectsSelect.value = "";
  } else {
    alert("Выберите насекомое из списка перед добавлением.");
  }
});

function createInsectField(text, value) {
  const insectDiv = document.createElement("div");
  insectDiv.className = "field close";
  insectDiv.textContent = text;

  const removeButton = document.createElement("span");
  removeButton.textContent = ".....";
  removeButton.style.opacity = "0";
  removeButton.addEventListener("click", function () {
    removeInsectField(insectDiv, text, value);
  });

  insectDiv.appendChild(removeButton);

  return insectDiv;
}

function removeInsectField(field, text, value) {
  field.remove();

  const hiddenInsectsInput = document.getElementById("hidden-insects");
  const insectsArray = hiddenInsectsInput.value
    ? hiddenInsectsInput.value.split(",")
    : [];

  const updatedArray = insectsArray.filter((insect) => insect !== value);
  hiddenInsectsInput.value = updatedArray.join(",");

  const insectsSelect = document.getElementById("insects");
  const option = document.createElement("option");
  option.value = value;
  option.textContent = text;
  insectsSelect.appendChild(option);
}

document.getElementById("submit-form").addEventListener("click", function () {
  const insectsSelect = document.getElementById("insects");
  const hiddenInsectsInput = document.getElementById("hidden-insects");
  const selectedValue = insectsSelect.value;

  if (
    selectedValue !== "" &&
    !hiddenInsectsInput.value.includes(selectedValue)
  ) {
    const insectsArray = hiddenInsectsInput.value
      ? hiddenInsectsInput.value.split(",")
      : [];

    insectsArray.push(selectedValue);
    hiddenInsectsInput.value = insectsArray.join(",");

    insectsSelect.removeChild(
      insectsSelect.querySelector(`option[value="${selectedValue}"]`)
    );
    insectsSelect.value = "";
  }
});
