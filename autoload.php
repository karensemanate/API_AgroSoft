<?php
spl_autoload_register(function ($class) {
    $paths = ['api/controllers/', 'api/models/'];
    foreach ($paths as $path) {
        $file = __DIR__ . '/' . $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
?>