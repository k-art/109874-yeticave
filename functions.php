<?php
function render_template ($template_path, $data) {
    if (file_exists($template_path)) {
        ob_start();
        require $template_path;
        $html = ob_get_clean();
        return $html;
    }
    return '';
}
?>