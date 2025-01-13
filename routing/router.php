<?php
session_start();


function isAuthenticated() {
    return isset($_SESSION['token']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

function isTeacher() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'teacher';
}

function isStudent() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'student';
}


$routes = [
    '/' => 'home',
    '/login' => 'login',
    '/signup' => 'signup',
    '/admin' => 'admin',
    '/admin/users' => 'adminUsers',
    '/admin/courses' => 'adminCourses',
    '/teacher' => 'teacher',
    '/teacher/courses' => 'teacherCourses',
    '/teacher/stats' => 'teacherStats',
    '/student' => 'student',
    '/student/courses' => 'studentCourses',
    '/student/catalog' => 'courseCatalog'
];

// Get the current path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Check if route exists
if (!isset($routes[$path])) {
    render404();
    exit;
}

// Check auth and role requirements
if (strpos($path, '/admin') === 0 && !isAdmin()) {
    navigateToLogin();
    exit;
}
if (strpos($path, '/teacher') === 0 && !isTeacher()) {
    navigateToLogin();
    exit;
}
if (strpos($path, '/student') === 0 && !isStudent()) {
    navigateToLogin();
    exit;
}

// Load and render the appropriate view
$viewName = $routes[$path];
loadView($viewName);

function loadView($viewName) {
    $viewFile = __DIR__ . "/views/{$viewName}.php";
    if (file_exists($viewFile)) {
        include $viewFile;
    } else {
        render404();
    }
}

function render404() {
    include __DIR__ . '/views/404.php';
}

function navigateToLogin() {
    header('Location: /login');
    exit;
}
?>