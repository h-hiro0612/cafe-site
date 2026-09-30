<?php
// XSS対策
function h($str) {

    if ($str === null) {
        return '';
    }

    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// CSRF対策
function set_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * CSRF対策：トークンのチェック
 */
function check_csrf_token($token) {
    if (empty($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}