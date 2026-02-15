<?php
session_start();

// Détruire la session
session_destroy();

// Nettoyer les cookies de session
if(ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Supprimer le cookie "remember me" s'il existe
setcookie('remember_token', '', time() - 3600, '/');

// Redirection
header("Location: ../connexion.html?logout=success");
exit();
?>
