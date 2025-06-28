<?php
$conn = mysqli_connect('localhost','root','root','real_estate');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


