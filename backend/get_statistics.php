<?php
header("Content-Type: application/json; charset=UTF-8");

include 'database.php';

$count_statement = $mysqli->query("SELECT COUNT(statement_id) total_statements FROM statements;");
$popular_pests = $mysqli->query("SELECT type FROM pests
                                            JOIN pests_statement USING (pest_id)
                                        GROUP BY type
                                        ORDER BY COUNT(pest_id) DESC
                                        LIMIT 1;");
$dirty_district = $mysqli->query("SELECT ADM_AREA FROM houses
                                            JOIN statements USING(house_id)
                                        GROUP BY ADM_AREA
                                        ORDER BY COUNT(statement_id) DESC
                                        LIMIT 1;");

if ($count_statement && $popular_pests && $dirty_district) {
    $total_statements_row = $count_statement->fetch_assoc();
    $total_statements = $total_statements_row['total_statements'];

    $popular_pests_row = $popular_pests->fetch_assoc();
    $popular_pest = $popular_pests_row['type'];

    $dirty_district_row = $dirty_district->fetch_assoc();
    $dirty_district_name = $dirty_district_row['ADM_AREA'];

    $statistics = [
        "total_statements" => $total_statements,
        "popular_pest" => $popular_pest,
        "dirty_district" => $dirty_district_name
    ];

    echo json_encode($statistics);
} else {
    echo json_encode(["error" => "Ошибка запроса данных статистики"]);
}

$mysqli->close();
