<?php
session_start();
include 'Connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ForumMain.php");
    exit();
}

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    
    $query = "SELECT * FROM posts WHERE id = $post_id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Chyba při získávání příspěvku: " . mysqli_error($conn);
        exit();
    }

    $post = mysqli_fetch_assoc($result);
    
} else {
    echo "Příspěvek nebyl nalezen.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save'])) {
    $updated_head_content = mysqli_real_escape_string($conn, $_POST['head_content']);
    $updated_content = mysqli_real_escape_string($conn, $_POST['content']);
    
    $update_query = "UPDATE posts SET HeadContent = '$updated_head_content', content = '$updated_content' WHERE id = $post_id";
    if (mysqli_query($conn, $update_query)) {
        header("Location: ForumMain.php");
        exit();
    } else {
        echo "Chyba při ukládání změn: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upravit příspěvek</title>
    <link rel="stylesheet" href="stylesheet.css">
    <style>
        footer {
            margin-top: auto; 
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Volcanoids</h1>
        <nav>
            <ul>
                <li><a href="Index.html">Domů</a></li>
                <li><a href="Galerie.html">Galerie</a></li>
                <li><a href="Trailer.html">Trailer</a></li>
                <li><a href="Obchod.html">Obchod</a></li>
                <li><a href="Recenze.html">Recenze</a></li>
                <li><a href="ForumMain.php" class="active">Diskuzní fórum</a></li>
            </ul>
        </nav>
    </header>

    <div class="add-post-form">
        <h1>Upravit příspěvek</h1>
        <form action="EditPost.php?post_id=<?php echo $post['id']; ?>" method="POST">
            <textarea name="head_content" required><?php echo htmlspecialchars($post['HeadContent']); ?></textarea><br>
            <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br>
            <button type="submit" name="save">Uložit změny</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Jan Kašík</p>
    </footer>
</body>
</html>
