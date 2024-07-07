<?php
    session_start();

    if (isset($_GET['id'])) {
        $_SESSION['id'] = $_GET['id'];
        echo "Session set successfully";
    } else {
        echo "Invalid request";
    }
?>