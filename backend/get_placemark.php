<?php
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';

$period = $_GET['period'] ?? 'all';
$district = $_GET['district'] ?? 'all';
$year_built = $_GET['year_built'] ?? 'all';
$insects = $_GET['insects'] ?? 'all';

try {
    $params = [];
    $query = "SELECT DISTINCT geodata_center, SIMPLE_ADDRESS AS address, COUNT(*) AS complaints
              FROM houses h
              JOIN statements s USING(house_id)
              JOIN pests_statement ps USING(statement_id)
              WHERE 1=1";

    if ($period !== 'all') {
        if ($period === 'week') {
            $query .= " AND DATE(date) >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
        } elseif ($period === 'month') {
            $query .= " AND DATE(date) >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
        } elseif ($period === 'year') {
            $query .= " AND DATE(date) >= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
        } elseif ($period === 'year5') {
            $query .= " AND DATE(date) >= DATE_SUB(NOW(), INTERVAL 5 YEAR)";
        } elseif ($period === 'year10') {
            $query .= " AND DATE(date) >= DATE_SUB(NOW(), INTERVAL 10 YEAR)";
        }
    }

    if ($district !== 'all') {
        $query .= " AND ADM_AREA LIKE ?";
        $params[] = "$district";
    }

    if ($year_built !== 'all') {
        if ($year_built === 'before_2000') {
            $query .= " AND YEAR(h.DDOC) < 2000";
        } elseif ($year_built === '2000_2010') {
            $query .= " AND YEAR(h.DDOC) BETWEEN 2000 AND 2010";
        } elseif ($year_built === 'after_2010') {
            $query .= " AND YEAR(h.DDOC) > 2010";
        }
    }

    if ($insects !== 'all') {
        $query .= " AND ps.pest_id IN (SELECT pest_id FROM pests WHERE type LIKE ?)";
        $params[] = "%$insects%";
    }

    $query .= " GROUP BY geodata_center, SIMPLE_ADDRESS";

    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        throw new Exception("Ошибка подготовки запроса: " . $mysqli->error);
    }

    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

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
    echo json_encode(["error" => "Ошибка запроса данных о метках"]);
}

$mysqli->close();
