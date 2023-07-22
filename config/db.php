<?php
//change your password
$con = mysqli_connect("localhost", "root", "", "bookings");

if (!$con) {
    die('Connection failed!' . mysqli_connect_error());
}
