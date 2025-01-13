<?php
include 'database.php';

$districts = $mysqli->query("SELECT DISTINCT ADM_AREA FROM houses");

if ($districts) {
    $districts_array = [];
    while ($row = $districts->fetch_assoc()) {
        $districts_array[] = $row['ADM_AREA'];
    }

    echo json_encode($districts_array); 
} else {
    echo json_encode(["error" => "Ошибка запроса данных о округах"]);
}
?>
