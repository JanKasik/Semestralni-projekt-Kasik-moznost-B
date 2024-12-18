<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: forum.html");
    exit();
}
include 'Connection.php';


$user_id = $_SESSION['user_id']; 
$headContent = $_POST['HeadContent']; 
$content = $_POST['content'];  

$query = "INSERT INTO posts (user_id, HeadContent, content) VALUES ('$user_id', '$headContent', '$content')";

if (mysqli_query($conn, $query)) {
    header("Location: forummain.php");
    exit();
} else {
    echo "Chyba při přidávání příspěvku: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
