<?php
session_start();
include 'Connection.php';

$current_user_id = $_SESSION['user_id'];

if (isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    $query = "SELECT user_id FROM posts WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $post_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $post_user_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($post_user_id == $current_user_id) {
        $delete_query = "DELETE FROM posts WHERE id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, 'i', $post_id);
        if (mysqli_stmt_execute($delete_stmt)) {
            header("Location: forummain.php");
        } else {
            echo "Došlo k chybě při mazání příspěvku: " . mysqli_error($conn);
        }
        mysqli_stmt_close($delete_stmt);
    } else {
        echo "Nemáte oprávnění smazat tento příspěvek.";
    }
} else {
    echo "Neplatný požadavek. Příspěvek nebyl nalezen.";
}

mysqli_close($conn);
?>
