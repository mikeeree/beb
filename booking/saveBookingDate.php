<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['role'])) {
    http_response_code(401);
    exit();
}

function generateId()
{
    $randomCharacters = "";
    for ($i = 0; $i < 4; $i++) {
        $randomInt = random_int(97, 122); // ASCII range for lowercase letters (97-122)
        $randomCharacter = chr($randomInt); // Convert the random integer to ASCII character
        $randomCharacters .= $randomCharacter;
    }
    return $randomCharacter;
}


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $roomid = $_POST['roomid'];
    $date = $_POST['date'];

    $targetDir = "../uploads/"; // Directory to save the uploaded file
    $targetFile = $targetDir . generateId() . basename($_FILES["file_src"]["name"]);

    if (move_uploaded_file($_FILES["file_src"]["tmp_name"], $targetFile)) {
        $stmt = $con->prepare('INSERT INTO bookings (date, userid, roomid, status, file_src) values (?, ?, ?, "pending", ?)');
        $stmt->bind_param("siis", $date, $_SESSION['id'], $roomid, $targetFile);
        $stmt->execute();
        http_response_code(200);
        exit();
    } else {
        http_response_code(400);
        exit();
    }
} else {
    http_response_code(404);
    exit();
}
