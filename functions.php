<?php
function render_template ($fileName, $data) {
    $templates_dir = 'templates/';
    $template_ext = '.php';

    $path_to_template_file = $templates_dir . $fileName . $template_ext;

    if (file_exists($path_to_template_file)) {
        ob_start('ob_gzhandler');
        extract($data, EXTR_SKIP);
        require $path_to_template_file;
        return ob_get_clean();
    }
    return '';
}
?>