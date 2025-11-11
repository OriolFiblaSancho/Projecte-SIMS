<?php

session_start();

function console_log($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('$output');</script>";
}

require_once __DIR__ . '/config/router.php';

$router = new Router();

require_once __DIR__ . '/routes/web.php';

try {
    $router->dispatch();
} catch (Exception $e) {
    $_SESSION['error'] = 'Error: ' . $e->getMessage();
    header('Location: /main');
    exit;
}
