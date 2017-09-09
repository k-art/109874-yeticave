<?php
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
