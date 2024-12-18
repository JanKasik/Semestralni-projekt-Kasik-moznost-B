<?php
session_start();

include 'Connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $username);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: forummain.php");
                exit();
            } else {
                echo "Nesprávné přihlašovací údaje!";
            }
        } else {
            echo "Nesprávné přihlašovací údaje!";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Chyba při přípravě dotazu.";
    }


    mysqli_close($conn);
}
?>
