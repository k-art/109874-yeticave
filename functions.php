<?php
error_reporting( E_ALL);
date_default_timezone_set('Europe/Moscow');

function validate_form($rules) {
    $all_errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        foreach ($rules as $key => $rule) {

            foreach ($rule as $current_rule) {
                if ($current_rule === 'required') {
                    if (! isset($_POST[$key]) || $_POST[$key] == '') {
                        $all_errors[$key][] = 'Пожалуйста, заполните это поле';
                    }
                }

                if ($current_rule === 'email') {
                    if (isset($_POST[$key]) && !empty($_POST[$key])) {
                        if (! filter_var($_POST[$key], FILTER_VALIDATE_EMAIL)) {
                            $all_errors[$key][] = 'Введите корректный email';
                        }
                    }
                }

                if ($current_rule === 'numeric') {
                    if (isset($_POST[$key])) {
                        if (! filter_var($_POST[$key], FILTER_VALIDATE_FLOAT)) {
                            $all_errors[$key][] = 'Для данного поля предсмотрен ввод только чисел';
                        }
                    }
                }

                // функцию можно доработать для проверки других типов.

            }
        }
    }
    return $all_errors;
}

function set_lot_time_remaining () {
    $tomorrow = strtotime('tomorrow midnight');
    $now = strtotime('now');

    return gmdate('H:i',$tomorrow - $now);
}

function format_time ($time_stamp) {
    $now = strtotime('now');
    $past_time = $now - $time_stamp ;
    $time_24h = 86400;
    $time_1h = 3600;

    if ($past_time > $time_24h) {
        return gmdate('d.m.y в H:i', $time_stamp);
    }
    elseif ($past_time < $time_1h) {
        return gmdate('i минут назад', $past_time);
    }
    else {
        return gmdate('G часов назад', $past_time);
    }
}

function render_template ($file_name, $data) {
    $templates_dir = 'templates/';
    $template_ext = '.php';

    $path_to_template_file = $templates_dir . $file_name . $template_ext;

    if (file_exists($path_to_template_file)) {
        ob_start('ob_gzhandler');
        extract($data, EXTR_SKIP);
        require $path_to_template_file;
        return ob_get_clean();
    }
    return '';
}
function validate_number($value) {
    return filter_var($value, FILTER_VALIDATE_INT);
}
function filter_text($value) {
    return trim(htmlspecialchars($value));
}
function validate_email($value) {
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}
function searchUserByEmail($email, $users)
{
    $result = null;
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $result = $user;
            break;
        }
    }
    return $result;
}
function init_session() {
    if (!session_start()) {
        print "я закрылась";
        throw new Exeption('Can\'t start session');
    }
}
init_session();
