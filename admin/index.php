<?php
session_start();
require_once "../config/db.php";


if (!isset($_SESSION['id']) || $_SESSION['role'] === "user") {
    header("Location: ../index.php");
}

function getTotalBookings($con)
{
    $stmt = $con->prepare('SELECT COUNT(*) as count from bookings;');
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div id="dashboard">
        <nav>
            <ul>
                <li>
                    <i class="fa-solid fa-book"></i>
                    <span>Bookings</span>
                </li>
            </ul>
        </nav>
        <header>
            <div class="logo">
                <img src="../assets/images/Ateneo_de_Manila_University_seal.svg" alt="logo" class="school-logo" />
                <div>
                    <h1>BLUE EAGLE</h1>
                    <h1 class="gold-text">BOOKINGS</h1>
                </div>
            </div>
            <div class="profile">
                <h1>ADMIN</h1>
                <div class="dropdown">
                    <span><i class="fa-solid fa-bars burger"></i></span>
                    <div class="dropdown-content">
                        <!-- Dropdown options -->
                        <form action="../logout.php" method="post">
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="booking-list">
                <div class="booking-header">
                    <h1 class="gold-text">Bookings</h1>
                    <h3><?= getTotalBookings($con) ?> bookings found</h3>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Booking ID</th>
                                <th>Venue</th>
                                <th>Date</th>
                                <th>Requested By</th>
                                <th>Uploaded File</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $con->prepare('SELECT b.id, b.date, b.file_src, b.status, u.name 
                            AS user_name, r.room_name
                            FROM bookings AS b
                            JOIN users AS u ON b.userid = u.id
                            JOIN rooms AS r ON b.roomid = r.id;');
                            // $stmt->bind_param("s", " ");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $no = 1;

                            function determineStatus($status)
                            {
                                if ($status === "pending") {
                                    return "pending";
                                } else if ($status === "booked") {
                                    return "accepted";
                                } else {
                                    return "rejected";
                                }
                            }


                            while ($row = $result->fetch_assoc()) :
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['room_name'] ?></td>
                                    <td><?= $row['date'] ?></td>
                                    <td><?= $row['user_name'] ?></td>
                                    <td><a href="<?= $row['file_src'] ?>" target="_blank">Request File</a></td>
                                    <td>

                                        <div class="dropdown">
                                            <div class="status <?= determineStatus($row['status']) ?>">
                                                <?= ucfirst($row['status']); ?>
                                            </div>
                                            <?php
                                            if ($row['status'] === 'pending') :
                                            ?>
                                                <div class="dropdown-content">
                                                    <!-- Dropdown options -->
                                                    <form action="changeStatus.php" method="post">
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <input type="hidden" name="status" value="booked">
                                                        <button type="submit">Accept</button>
                                                    </form>
                                                    <form action="changeStatus.php" method="post">
                                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit">Reject</button>
                                                    </form>
                                                </div>
                                            <?php
                                            endif
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            endwhile
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>