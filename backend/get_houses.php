<?php
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';

try {
    $searchTerm = isset($_GET['term']) ? $mysqli->real_escape_string($_GET['term']) : '';

    $terms = explode(' ', $searchTerm);

    $conditions = [];
    foreach ($terms as $term) {
        $conditions[] = "SIMPLE_ADDRESS LIKE '%" . $mysqli->real_escape_string($term) . "%'";
    }

    $whereClause = implode(' AND ', $conditions);

    $query = "SELECT SIMPLE_ADDRESS FROM houses WHERE $whereClause LIMIT 30";
    $result = $mysqli->query($query);

    if (!$result) {
        throw new Exception("Ошибка выполнения запроса: " . $mysqli->error);
    }

    $addresses = [];
    while ($row = $result->fetch_assoc()) {
        $addresses[] = $row['SIMPLE_ADDRESS'];
    }

    echo json_encode($addresses);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

$mysqli->close();
