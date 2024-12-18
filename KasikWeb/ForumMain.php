<?php
session_start();

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ForumMain.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volcanoids - Kašík</title>
    <link rel="stylesheet" href="stylesheet.css">
    <style>
        .home {
            flex: 1;
            display: flex;
            flex-direction: column; 
            align-items: center; 
            justify-content: center;
            text-align: center;
            height: 100%; 
            background-size: cover;
            background-position: center;
        }
        .home h2 {
            font-size: 68px; 
            margin-bottom: 30px; 
            color: rgb(255, 255, 255);
        }

        .home p {
            font-size: 16px; 
            margin-bottom: 300px;
            max-width: 500px;
            color: rgb(201, 201, 201);
        }

        .logout-btn, .login-btn {
            background-color: #f17d39;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
            margin-left: 20px;
            cursor: pointer;
        }

        .logout-btn:hover, .login-btn:hover {
            background-color: #66c0f4;
        }

        .login-btn {
            background-color: red;
        }
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

        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="?logout=true" class="logout-btn">Odhlásit uživatele</a>
        <?php else: ?>
            <a href="Forum.html" class="login-btn">Přihlásit</a>
        <?php endif; ?>
    </header>

    <div class="add-post-form">
        <h1>Přidat příspěvek</h1>
        <form action="addPost.php" method="POST">
            <textarea name="HeadContent" placeholder="Nadpis vašeho příspěvku" required></textarea>
            <br>
            <textarea name="content" placeholder="Obsah vašeho příspěvku..." required></textarea>
            <br>
            <button type="submit">Přidat příspěvek</button>
        </form>
    </div>

    <div class="post-container">
        <?php include 'getPost.php'; ?>
    </div>

    <footer>
        <p>&copy; 2024 Jan Kašík</p>
    </footer>
</body>
</html>
