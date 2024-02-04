<?php

/** 
 * Get the header
 * @param string $title The title of the page 
 * @param string $layout The layout to use
 * @return void
 */
function get_header(string $title, string $layout = 'public'): void
{
    global $router;
    require_once '../src/views/layouts/' . $layout . '/header.php';
}

/** 
 * Get the footer
 * @param string $layout The layout to use
 * @return void
 */
function get_footer(string $layout = 'public'): void
{
    require_once '../src/views/layouts/' . $layout . '/footer.php';
}

/**
 * Get the alert
 * @param string $message The message to save in alert
 * @param string $type The type of alert
 * @return void
 */
function alert(string $message, string $type = 'danger'): void
{
    $_SESSION['alert'] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Display alert session
 * @return void
 */
function displayAlert()
{
    if (!empty($_SESSION['alert'])) {
        echo '<div class="alert alert-' . $_SESSION['alert']['type'] . '" role="alert">' . $_SESSION['alert']['message'] . '</div>';

        unset($_SESSION['alert']);
    }
}

/**
 * Check if users is logged in 
 * @param array $ matche The match array from Altorouter
 * @param AltoRouter $router The router
 */
function checkAdmin(array $match, AltoRouter $router)
{
    $existAdmin = strpos($match['target'], 'admin_');
    if ($existAdmin !== false && empty($_SESSION['user']['id'])) {
        header('Location: ' . $router->generate('login'));
    }
}

function logoutTimer()
{
    global $router;

    if (!empty($_SESSION['user']['lastLogin'])) {
        $expireHour = 120;

        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('Europe/Paris'));

        $lastLogin = new DateTime($_SESSION['user']['lastLogin']);
        $lastLogin->setTimezone(new DateTimeZone('Europe/Paris'));

        if ($now->diff($lastLogin)->i >= $expireHour) {
            unset($_SESSION['user']);
            alert('vous avez été déconnecté', 'Danger');
            header('Location: ' . $router->generate('login'));
            die;
        }
    }
}
