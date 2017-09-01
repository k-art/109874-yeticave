<?php
function render_template ($template_path, $data) {
    if (file_exists($template_path)) {
        ob_start('ob_gzhandler');
        extract($data, EXTR_SKIP);
        require $template_path;
        return ob_get_clean();
    }
    return '';
}
?>