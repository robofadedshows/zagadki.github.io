<?php
// Ustawiamy odpowiedni nagłówek dla kodowania treści
header("Content-Type: text/html; charset=UTF-8");
// Rozpoczynamy sesję
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['login'])) {
        // można dodatkowo wyświetlić odpowiedni komunikat jeżeli hasło jest puste
        $pass = $_POST['pass'] ?? null;
        $admin_hash = require_once 'haslo.php';
        // możemy nadpisać tablicę samym hasłem
        $admin_hash = array_key_exists('pass', $admin_hash) ? $admin_hash['pass'] : null;
        if (!empty($pass) && password_verify($pass, $admin_hash)) {
            $_SESSION['admin'] = true;
            echo '<p>Poprawnie zalogowano.</p>';
        } else {
            echo '<p>Hasło nie pasuje!</p>';
        }
    } elseif (isset($_POST['logout'])) {
        $_SESSION['admin'] = false;
        session_regenerate_id();
    }
}

$is_admin = $_SESSION['admin'] ?? false;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <title>Podaj dane logowania</title>
</head>
<body>
    <main>
        <?php if (!$is_admin): ?>
        <p>Aby kontynuować musisz podać hasło:</p>
        <form action="" method="POST">
            <input name="pass" type="password" placeholder="Podaj hasło"/>
            <button name="login" type="submit">Zaloguj się</button>
        </form>
    <?php else: ?>
        <form action="" method="POST">
            <button name="logout" type="submit">Wyloguj się</button>
        </form>
    <?php endif; ?>
    </main>
</body>
</html>
