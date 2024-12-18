<?php
session_start();
include 'Connection.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];


    $query = "UPDATE posts SET HeadContent = ?, content = ? WHERE id = ? AND user_id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "ssii", $title, $content, $post_id, $_SESSION['user_id']);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: forummain.php"); 
        } else {
            echo "Chyba při aktualizaci příspěvku.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>
