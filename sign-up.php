<?php
require_once ('functions.php');
require_once ('init.php');

if (isset($_SESSION['user'])) {
    header("Location: /index.php");
}

$title = 'Регистрация';
$categories = get_all_categories($connect);
$errors = [];
$url_file = '';
$validationRules = [
    'email' => [
        'required',
        'email',
        'text'
    ],
    'password' => [
        'required',
        'text'
    ],
    'name' => [
        'required',
        'text'
    ],
    'contacts' => [
        'required',
        'text'
    ]
];
//print_r($validationRules);
//print_r('<br>');

$errors = validate_form($validationRules);

if (($_SERVER['REQUEST_METHOD'] == 'POST') && empty($errors)) {
    $date = date('Y-m-d H:i:s',$_POST['date']);
    $email_received = $_POST['email'];
    $password_received = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name_received = $_POST['password'];
    $contacts_received = $_POST['password'];

    //проверка на email
    if (search_user_by_email($connect, $email_received)) {
        $errors['email']['message'] = 'Пользователь с таким email уже существует';
        $content = render_template('sign-up', ['categories' => $categories, 'errors' => $errors]);
        $layout_template = render_template('layout', ['title' => $title, 'categories' => $categories, 'content' => $content]);
        print ($layout_template);
        exit();
    }

    if (isset($_FILES['avatar'])) {
        $file_name = $_FILES['avatar']['name'];
        $file_path = __DIR__ . '/img/';
        $file_type = $_FILES['avatar']['type'];
        $file_size = $_FILES['avatar']['size'];

        if ($file_type !== 'image/jpeg') {
            $errors['avatar']['message'] = 'Загрузите фото в формате jpg';
        } elseif ($file_size > MAX_FILE_SIZE) {
            $errors['avatar']['message'] = 'Максимальный размер файла: 200кб';
        } else {
            move_uploaded_file($_FILES['avatar']['tmp_name'], $file_path . $file_name);
            $new_file_url = '/img/' . $file_name;
        }

        $url_file = '/img/' . $file_name;
    }

    db_insert_data($connect, 'users', [
        'creation_date' => $date,
        'email' => $email_received,
        'name' => $name_received,
        'password' => $password_received,
        'user_contacts' => $contacts_received,
        'avatar' => $url_file
    ]);
    header("Location: /login.php?new_user=ok");
}

$content = render_template('sign-up',
    [
        'categories' => $categories,
        'errors' => $errors
    ]
);

$layout_template = render_template('layout',
    [
        'title' => $title,
        'categories' => $categories,
        'content' => $content
    ]
);

print ($layout_template);
