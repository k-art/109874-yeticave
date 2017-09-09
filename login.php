<?php
error_reporting( E_ALL);
require_once ('functions.php');
require_once ('lots_data.php');
require_once ('user_data.php');

$title = 'Вход';
$fields_required = ['email', 'password'];
$errors = [];
$err_messages = [];
$user = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (in_array($key, $fields_required) && $value == '') {
            $errors[] = $key;
            $err_messages[$key] = 'Заполните это поле';
        }
        elseif (!validate_email($_POST['email'])) {
            $errors[] = 'email';
            $err_messages['email'] = 'Введите корректный e-mail';
        }
    }
    if ($_POST['password'] && $_POST['email'] == '') {
        $errors[] = 'email';
        $err_messages['email'] = 'Вы забыли про e-mail';
        $err_messages['password'] = 'Заполните это поле';
    }
    if ($_POST['email'] && $_POST['password'] == '') {
        $errors[] = 'email';
        $err_messages['password'] = 'Вы забыли про пароль';
        $err_messages['email'] = 'Заполните это поле';
    }


    $email_received = $_POST['email'];
    $password_received = $_POST['password'];


    if (empty($errors)) {
        session_start();

        if ($user = searchUserByEmail($email_received, $users)) {
            $password_hash = $user['password'];

            if (password_verify($password_received, $password_hash)) {
                $_SESSION['user'] = $user;
                header("Location: /index.php");
            }
            else {
                $errors[] = 'password';
                $err_messages['password'] = 'Вы ввели неверный пароль';
            }
        }
    }

    $content = render_template('login',
        [
            'categories' => $categories,
            'errors' => $errors,
            'err_messages' => $err_messages
        ]
    );
}

else {
    $content = render_template('login',
        [
            'categories' => $categories,
            'errors' => $errors
        ]
    );
}

$layout_data = [
    'title' => $title,
    'categories' => $categories,
    'content' => $content
];

$layout_template = render_template('layout', $layout_data);

print ($layout_template);