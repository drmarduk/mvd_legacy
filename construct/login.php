<?php

$error = '';

$user = isset($_POST['user']) ? $_POST['user'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';

if (isset($_POST['submit'])) {
    $login = new login($user, $pass);
    if (!$login->checkLogin()) {
        $error = 'Login gescheitert';
    } else {
        // login done
        session_start();
        $_SESSION[''];
        header('Set-Cookie: user=' . $user);
        header('Location: ' . URL);
    }
}

$temp = new template('login');
$temp->setContent('###ERROR###', $error);

$temp->display();
?>
