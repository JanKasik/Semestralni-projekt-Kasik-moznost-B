<?php
include 'Connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $check_query = "SELECT * FROM users WHERE username = ? OR email = ?";
    
    if ($stmt = mysqli_prepare($conn, $check_query)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['username'] == $username) {
                    echo "<script>
                            alert('Uživatelské jméno již existuje.');
                            window.location.href = 'Registrace.html'; // Přesměrování na stránku registrace
                          </script>";
                }
                if ($row['email'] == $email) {
                    echo "<script>
                            alert('E-mail již existuje.');
                            window.location.href = 'Registrace.html'; // Přesměrování na stránku registrace
                          </script>";
                }
            }
        } else {
            $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            if ($stmt = mysqli_prepare($conn, $query)) {
                mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: forummain.php");
                    exit(); 
                } else {
                    echo "Chyba při přípravě dotazu: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        }
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($conn);
}
?>
