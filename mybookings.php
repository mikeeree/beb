<?php
session_start();
require_once "./config/db.php";


if (!isset($_SESSION['id'])) {
    header("Location: index.php");
}
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $stmt = $con->prepare('DELETE FROM bookings where id = ?');
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="./css/home.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body class="bg-bookings">
    <header>
        <div class="logo">
            <img src="./assets/images/Ateneo_de_Manila_University_seal.svg" alt="logo" class="school-logo" />
            <div>
                <h1>BLUE EAGLE</h1>
                <h1 class="gold-text">BOOKINGS</h1>
            </div>
        </div>
        <div class="profile">
            <h1></h1>
            <div class="dropdown">
                <span><i class="fa-solid fa-bars burger"></i></span>
                <div class="dropdown-content">
                    <!-- Dropdown options -->
                    <a href="home.php">Home</a>
                    <a href="mybookings.php">My Bookings</a>
                    <form action="./logout.php" method="post">
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="booking-container">
        <h3><span class="home-text">Home</span> / My bookings</h3>
        <h1>My Bookings</h1>
        <table>
            <thead>
                <tr>
                    <th>Venue Name</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $con->prepare('SELECT b.id, b.date, b.file_src, b.status, u.name 
                AS user_name, r.room_name
                FROM bookings AS b
                JOIN users AS u ON b.userid = u.id
                JOIN rooms AS r ON b.roomid = r.id
                WHERE b.userid = ?');
                $stmt->bind_param("i", $_SESSION['id']);
                $stmt->execute();
                $result = $stmt->get_result();

                function determineStatus($status)
                {
                    if ($status === "pending") {
                        return "pending-t";
                    } else if ($status === "booked") {
                        return "booked-t";
                    } else {
                        return "rejected-t";
                    }
                }
                function showCancelBtn($status)
                {
                    if ($status === 'pending') {
                        return true;
                    }
                    return false;
                }


                while ($row = $result->fetch_assoc()) :
                ?>
                    <tr>
                        <td><?= $row['room_name'] ?></td>
                        <td><?= $row['date'] ?></td>
                        <td style="display: flex; align-items: center;">
                            <p class="booking-status <?= determineStatus($row['status']) ?>">
                                <?= ucfirst($row['status']) ?>
                            </p>
                            <form method="post">
                                <input type="hidden" value="<?= $row['id'] ?>" name="id">
                                <?= showCancelBtn($row['status']) ? '<button class="booking-status cancel" onclick="return confirmation()">Cancel</button>' : '' ?>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>

                <?php
                if ($result->num_rows === 0) :
                ?>
                    <tr>
                        <td></td>
                        <td>No Result</td>
                        <td></td>
                    </tr>
                <?php
                endif;
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function confirmation() {
            return confirm('Are you sure you want to cancel this booking?');
        }
    </script>
</body>

</html>