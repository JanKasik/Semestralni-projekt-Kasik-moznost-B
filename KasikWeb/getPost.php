<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Příspěvky</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body></body>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'Connection.php';

$current_user_id = $_SESSION['user_id'] ?? null;

$query = "SELECT posts.*, users.username FROM posts 
          JOIN users ON posts.user_id = users.id 
          ORDER BY posts.created_at DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Chyba při získávání příspěvků: " . mysqli_error($conn);
    exit();
}

while ($post = mysqli_fetch_assoc($result)) {
    echo "<div class='post'>";
    echo "<h2>" . htmlspecialchars($post['HeadContent']) . "</h2>"; 
    echo "<p><strong>Autor:</strong> " . htmlspecialchars($post['username']) . "</p>"; 
    echo "<p><strong>Vytvořeno:</strong> " . $post['created_at'] . "</p>"; 
    echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>"; 

    if ($current_user_id && $post['user_id'] == $current_user_id) {
        echo "<form action='RemovePost.php' method='POST' style='display: inline;'>"; 
        echo "<input type='hidden' name='post_id' value='" . $post['id'] . "'>";
        echo "<button type='submit' name='delete' class='second-btn'>Smazat</button>";

        echo "<a href='EditPost.php?post_id=" . $post['id'] . "' class='second-btn'>Upravit</a>";
        echo "</form>";
    }
    echo "</div>";
}

mysqli_close($conn);
?>
