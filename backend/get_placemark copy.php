<?php
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';

$address = $_GET['address'] ?? null;
$period = $_GET['period'] ?? 'all';
$district = $_GET['district'] ?? 'all';
$year_built = $_GET['year_built'] ?? 'all';
$insects = $_GET['insects'] ?? 'all';

try {
    $query = "SELECT DISTINCT geodata_center, SIMPLE_ADDRESS as address, COUNT(*) as complaints
              FROM houses h
              JOIN statements s USING(house_id)
              JOIN pests_statement ps USING(statement_id)
              WHERE 1=1
              GROUP BY geodata_center, SIMPLE_ADDRESS";
    $result = $mysqli->query($query);

    if (!$result) {
        throw new Exception("Ошибка выполнения запроса: " . $mysqli->error);
    }

    $coordinates = [];

    while ($row = $result->fetch_assoc()) {
        if (preg_match('/coordinates=\[([0-9\.\-]+), ([0-9\.\-]+)\]/', $row['geodata_center'], $matches)) {
            $latitude = (float)$matches[2];
            $longitude = (float)$matches[1];

            $coordinates[] = [
                'coordinates' => [$latitude, $longitude],
                'address' => $row['address'],
                'complaints' => (int)$row['complaints']
            ];
        }
    }

    echo json_encode($coordinates);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

$mysqli->close();
