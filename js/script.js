$(document).ready(function () {
  $.ajax({
    url: "backend/get_pests.php",
    dataType: "json",
    success: function (data) {
      if (data.status === "success") {
        const pests = data.data;
        const selectElement = $("#insects");

        pests.forEach(function (pest) {
          const option = $("<option></option>")
            .attr("value", pest.type)
            .text(pest.type);
          selectElement.append(option);
        });
      } else {
        console.error("Ошибка получения данных о вредителях:", data.message);
      }
    },
    error: function () {
      console.error("Ошибка запроса данных о вредителях.");
    },
  });
});

$(document).ready(function () {
  $("#address").autocomplete({
    source: function (request, response) {
      $.ajax({
        url: "backend/get_houses.php",
        dataType: "json",
        data: {
          term: request.term,
        },
        success: function (data) {
          response(data);
        },
        error: function () {
          console.error("Ошибка получения данных.");
        },
      });
    },
    minLength: 2,
  });
});

$(document).ready(function () {
  $.ajax({
    url: "backend/get_districts.php",
    dataType: "json",
    success: function (data) {
      if (data.error) {
        console.error(data.error);
      } else {
        const selectElement = $("#district");

        selectElement.empty();

        selectElement.append('<option value="all">Все округа</option>');

        data.forEach(function (district) {
          const option = $("<option></option>")
            .attr("value", district)
            .text(district);
          selectElement.append(option);
        });
      }
    },
    error: function () {
      console.error("Ошибка запроса данных о округах.");
    },
  });
});







document.getElementById("add-insect").addEventListener("click", function () {
  const insectsSelect = document.getElementById("insects");
  const selectedValue = insectsSelect.value;
  const selectedText = insectsSelect.options[insectsSelect.selectedIndex].text;

  if (selectedValue !== "all") {
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

    const optionToRemove = insectsSelect.querySelector(
      `option[value="${selectedValue}"]`
    );
    optionToRemove.remove();

    insectsSelect.value = "all";
  } else {
    alert("Выберите насекомое из списка перед добавлением.");
  }
});

function createInsectField(text) {
  const insectDiv = document.createElement("div");
  insectDiv.className = "field close";
  insectDiv.textContent = text;

  const removeButton = document.createElement("span");
  removeButton.textContent = ".....";
  removeButton.style.opacity = "0";
  removeButton.addEventListener("click", function () {
    removeInsectField(insectDiv, text);
  });

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

  const updatedArray = insectsArray.filter((value) => value !== text);
  hiddenInsectsInput.value = updatedArray.join(",");

  const insectsSelect = document.getElementById("insects");
  const option = document.createElement("option");
  option.value = value;
  option.textContent = text;
  insectsSelect.appendChild(option);
}