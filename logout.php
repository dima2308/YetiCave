<?php
session_start();

if (isset($_SESSION['user'])) {
    $_SESSION = [];
    header('Location: /example');
}
