<?php
session_start();
include_once "./config/db.php";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  if (!isset($_POST['username']) || !isset($_POST['username'])) {
    echo "";
  } else {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare('SELECT * from users WHERE username = ?');
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $rowUserCount = $result->num_rows;
    if ($rowUserCount == 1) {
      $row = $result->fetch_assoc();
      if ($row['username'] === $username && $row['password'] === $password) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        if ($row['role'] === "user") {
          header("Location: home.php");
        } else {
          header("Location: admin");
        }
      } else {
        $errorMsg = "Wrong Password";
        header("Location: index.php?error=" . urlencode($errorMsg));
      }
    } else {
      $errorMsg = "Unauthorized";
      header("Location: index.php?error=" . urlencode($errorMsg));
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Blue Eagle Bookings</title>
  <link rel="stylesheet" href="./css/index.css" />
</head>

<body>
  <header>
    <img src="./assets/images/Ateneo_de_Manila_University_seal.svg" alt="logo" class="school-logo" />
    <div>
      <h1>BLUE EAGLE</h1>
      <h1 class="gold-text">BOOKINGS</h1>
    </div>
  </header>

  <main>
    <h1 class="gold-text">Welcome Back</h1>
    <form action="" method="post">
      <h1>Login With Email</h1>
      <p>
        <?php if (isset($_GET["error"])) {
          $errorMsg = urldecode($_GET['error']);
          echo $errorMsg;
        } ?>
      </p>
      <div class="login-input">
        <div class="input-container">
          <img src="./assets/images/username-icon.png" class="input-icon" />
          <input type="text" name="username" required />
        </div>

        <div class="input-container">
          <img src="./assets/images/lock-icon.png" class="input-icon" />
          <input type="password" name="password" required />
        </div>
      </div>
      <div class="remember-me">
        <div>
          <input type="checkbox" name="" id="" /><label for="">Remember me</label>
        </div>
        <a href="#" class="link">Forgot Password</a>
      </div>
      <button>LOGIN</button>
    </form>
  </main>
</body>

</html>