<?php
$connect = mysqli_connect('localhost','root', '', 'CRUD1');
if (!$connect) {
    die('Error connect to database!');
}