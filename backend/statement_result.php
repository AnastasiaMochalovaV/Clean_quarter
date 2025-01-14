<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $mysqli->real_escape_string($_POST['firstName']);
    $lastName = $mysqli->real_escape_string($_POST['lastName']);
    $patronymic = $mysqli->real_escape_string($_POST['patronymic']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $onNotify = isset($_POST['confirm']) ? 1 : 0;

    $comment = !empty($_POST['comment']) ? $mysqli->real_escape_string($_POST['comment']) : null;

    if (!empty($_FILES['file']['name'])) {
        $uploadDir = '../uploads/';
        $filePath = $uploadDir . basename($_FILES['file']['name']);

        if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
            $filePath = $mysqli->real_escape_string($filePath);
        } else {
            $filePath = null;
        }
    } else {
        $filePath = null;
    }

    $houseQuery = "SELECT house_id FROM houses WHERE SIMPLE_ADDRESS = '$address'";
    $houseResult = $mysqli->query($houseQuery);

    if ($houseResult && $houseResult->num_rows > 0) {
        $houseRow = $houseResult->fetch_assoc();
        $house_id = $houseRow['house_id'];
    } else {
        echo "Ошибка: адрес '$address' не найден в таблице houses.";
        exit;
    }

    $query = "INSERT INTO statements (firstName, lastName, patronymic, email, house_id, comment, onNotify, file)
              VALUES ('$firstName', '$lastName', '$patronymic', '$email', '$house_id', "
        . ($comment ? "'$comment'" : "NULL") . ", $onNotify, "
        . ($filePath ? "'$filePath'" : "NULL") . ")";



    if ($mysqli->query($query)) {
        $statement_id = $mysqli->insert_id;

        $pestTypes = isset($_POST['insects'][0]) ? explode(',', $_POST['insects'][0]) : [];

        foreach ($pestTypes as $pestType) {
            $pestType = $mysqli->real_escape_string(trim($pestType));

            $pestQuery = "SELECT pest_id FROM pests WHERE type = '$pestType'";
            $pestResult = $mysqli->query($pestQuery);

            if ($pestResult && $pestResult->num_rows > 0) {
                $pestRow = $pestResult->fetch_assoc();
                $pest_id = $pestRow['pest_id'];

                $pestsQuery = "INSERT INTO pests_statement (statement_id, pest_id) VALUES (?, ?)";
                $stmt = $mysqli->prepare($pestsQuery);
                if ($stmt) {
                    $stmt->bind_param("ii", $statement_id, $pest_id);
                    if (!$stmt->execute()) {
                        echo "Ошибка при добавлении связи для вредителя '$pestType': " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Ошибка подготовки запроса: " . $mysqli->error;
                }
            } else {
                echo "Ошибка: указанный вредитель '$pestType' не найден в базе данных.";
            }
        }

        setcookie('status', 'success', time() + 3600, '/');
        header("Location: ../index.php");
        exit;
    } else {
        echo "Ошибка при добавлении заявления: " . $mysqli->error;
    }
}
