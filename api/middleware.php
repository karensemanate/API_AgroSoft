<?php
require_once __DIR__ . './controllers/AuthController';

class Middleware {
    public static function checkAuth() {
        $auth = new AuthController();
        return $auth->checkAuth();
    }
}
?>
