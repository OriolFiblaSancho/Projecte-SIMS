<?php
// Simple i18n helper for English (en) and Catalan (ca)

if (session_status() !== PHP_SESSION_ACTIVE) {
    // index.php normally starts the session, but double-check here
    @session_start();
}

function get_project_root() {
    return dirname(__DIR__);
}

function set_locale() {
    if (isset($_GET['lang']) && in_array($_GET['lang'], ['en', 'ca'])) {
        $_SESSION['lang'] = $_GET['lang'];
    } elseif (!isset($_SESSION['lang'])) {
        // Default locale: Catalan
        $_SESSION['lang'] = 'ca';
    }

    return $_SESSION['lang'];
}

function get_locale() {
    return isset($_SESSION['lang']) ? $_SESSION['lang'] : 'ca';
}

function load_translations($locale) {
    static $cache = [];
    if (isset($cache[$locale])) return $cache[$locale];

    $file = get_project_root() . '/lang/' . $locale . '.php';
    if (file_exists($file)) {
        $cache[$locale] = include $file;
    } else {
        $cache[$locale] = [];
    }

    return $cache[$locale];
}

function t($key, $replace = []) {
    $locale = get_locale();
    $translations = load_translations($locale);

    $value = isset($translations[$key]) ? $translations[$key] : $key;

    // Simple placeholder replacement: {name}
    foreach ($replace as $k => $v) {
        $value = str_replace('{' . $k . '}', $v, $value);
    }

    return $value;
}
