<?php
include 'database.php';

$address = $_GET['address'] ?? null;
$period = $_GET['period'] ?? 'all';
$district = $_GET['district'] ?? 'all';
$year_built = $_GET['year_built'] ?? 'all';
$insects = $_GET['insects'] ?? 'all';

$query = "SELECT DISTINCT geodata_center, SIMPLE_ADDRESS as address, COUNT(*) as complaints
          FROM houses h
          JOIN statements s USING(house_id)
          JOIN pests_statement ps USING(statement_id)
          WHERE 1=1";

$params = [];

if ($address) {
    $query .= " AND SIMPLE_ADDRESS LIKE :address";
    $params[':address'] = "$address";
}

if ($period !== 'all') {
    $dateFilter = match ($period) {
        'week' => date('Y-m-d', strtotime('-1 week')),
        'month' => date('Y-m-d', strtotime('-1 month')),
        'year' => date('Y-m-d', strtotime('-1 year')),
        'year5' => date('Y-m-d', strtotime('-5 years')),
        'year10' => date('Y-m-d', strtotime('-10 years')),
        default => null
    };
    if ($dateFilter) {
        $query .= " AND date >= :dateFilter";
        $params[':dateFilter'] = $dateFilter;
    }
}

if ($district  !== 'all') {
    $query .= " AND pest_id IN (SELECT ps.pest_id FROM pests_statement ps
                    	            JOIN pests p USING(pest_id)
                                WHERE type LIKE :district)";
    $params[':district'] = $district;
}

if ($year_built !== 'all') {
    if ($year_built === 'before_2000') {
        $query .= " AND YEAR(DDOC) < 2000";
    } elseif ($year_built === '2000_2010') {
        $query .= " AND YEAR(DDOC) BETWEEN 2000 AND 2010";
    } elseif ($year_built === 'after_2010') {
        $query .= " AND YEAR(DDOC) > 2010";
    }
}

error_reporting(E_ALL);
ini_set('display_errors', 1);


$query .= " GROUP BY geodata_center, SIMPLE_ADDRESS";
