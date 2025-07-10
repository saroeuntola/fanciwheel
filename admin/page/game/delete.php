<?php
include('../library/game_lib.php');
include('../library/checkroles.php');
protectPathAccess();
$product = new Games();
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    if ($product->deleteGame($productId)) {
        echo "<script>alert('product deleted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: Unable to delete product!'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='index.php';</script>";
}
?>