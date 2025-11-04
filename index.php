<?php
/**
 * Front Controller - index.php
 *
 * Punt d'entrada únic de l'aplicació. Carrega el router i les rutes
 * i deriva cada petició a l'acció corresponent.
 */

// Sessió per a missatges i autenticació
session_start();

function console_log($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('$output');</script>";
}

// Carrega el sistema de rutes existent
require_once __DIR__ . '/config/router.php';

// Instància del router
$router = new Router();

// Carrega les rutes (nou fitxer centralitzat)
require_once __DIR__ . '/routes/web.php';

// Despatxa la petició actual
try {
    $router->dispatch();
} catch (Exception $e) {
    $_SESSION['error'] = 'Error: ' . $e->getMessage();
    header('Location: /main');
    exit;
}
