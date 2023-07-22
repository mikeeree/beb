<?php

session_start();
require_once "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $stmt = $con->prepare('UPDATE bookings set status = ? WHERE id = ? ');
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    http_response_code(200);
    header("Location: index.php");
    exit();
}
