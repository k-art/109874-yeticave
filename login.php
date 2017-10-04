<?php
require_once ('functions.php');
require_once ('init.php');
require_once ('vendor/autoload.php');

$title = 'Вход';
$categories = get_all_categories($connect);
$fields_required = ['email', 'password'];
$errors = [];
$user = '';
$validationRules = [
    'email' => [
        'required',
        'email',
        'text'
    ],
    'password' => [
        'required',
        'text'
    ]
];

if (isset($_SESSION['user'])) {
    header("Location: /index.php");
}

$errors = validate_form($validationRules);

if (($_SERVER['REQUEST_METHOD'] == 'POST') && empty($errors)) {
    $email_received = $_POST['email'];
    $password_received = $_POST['password'];

    if ($user = search_user_by_email($connect, $email_received)) {
        $password_hash = $user['password'];

        if (password_verify($password_received, $password_hash)) {
            $_SESSION['user'] = $user;
            header("Location: /index.php");
        }
        else {
            $errors['password']['message'] = 'Вы ввели неверный пароль';
            $content = render_template('login', ['categories' => $categories, 'errors' => $errors]);
            $layout_template = render_template('layout', ['title' => $title, 'categories' => $categories, 'content' => $content]);
            print ($layout_template);
            exit();
        }
    }
    else {
        $errors['email']['message'] = 'Пользователя с таким email не существует';
        $content = render_template('login', ['categories' => $categories, 'errors' => $errors]);
        $layout_template = render_template('layout', ['title' => $title, 'categories' => $categories, 'content' => $content]);
        print ($layout_template);
        exit();
    }
}

$content = render_template('login', [
    'categories' => $categories,
    'errors' => $errors
]);
$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];
$layout_template = render_template('layout', $layout_data);

print ($layout_template);
