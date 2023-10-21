<?php
session_start();
include_once 'dbconnect.php';
$username = $_SESSION['username'];
 if (isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
    if(isset($_POST['newEmail'])){
        $email = $_POST['newEmail'];
        $sql = "UPDATE users SET email = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        header('Location: profile.php');
    }
}
?>