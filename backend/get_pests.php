<?php
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';

try {
    $query = "SELECT type FROM pests";
    $result = $mysqli->query($query);

    if (!$result) {
        throw new Exception("Ошибка выполнения запроса: " . $mysqli->error);
    }

    $pests = [];

    while ($row = $result->fetch_assoc()) {
        $pests[] = [
            'type' => $row['type']
        ];
    }

    echo json_encode([
        'status' => 'success',
        'data' => $pests
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

$mysqli->close();
?>
