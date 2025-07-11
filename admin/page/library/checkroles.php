<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config/baseURL.php';
include("auth.php");

function protectPathAccess() {
    global $baseURL;

    $auth = new Auth();
    
    if ($auth->is_logged_in()) {
        if ($_SESSION['role_id'] != 1) {
            header("Location: $baseURL/admin/page/include/no_access.php");
            exit;
        }
    } else {
        header("Location: $baseURL/login.php");
        exit;
    }
}
?>
