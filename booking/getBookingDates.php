<?php
session_start();
require_once "../config/db.php";

header("Content-Type: application/json");

// security for fetching
// if (!isset($_SESSION['role'])) {
//     http_response_code(401);
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_GET['id'];
    $stmt = $con->prepare('SELECT * from bookings WHERE roomid = ?');
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = array();

    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    echo json_encode($rows);
    exit();
} else {
    http_response_code(401);
    exit();
}
