<?php
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';

$pests = $mysqli->query("SELECT type FROM pests");

if ($pests) {
    $pests_array = [];
    while ($row = $pests->fetch_assoc()) {
        $pests_array[] = $row['type'];
    }

    echo json_encode($pests_array);
} else {
    echo json_encode(["error" => "Ошибка запроса данных о насекомых"]);
}

$mysqli->close();
