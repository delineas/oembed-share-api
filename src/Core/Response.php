<?php

namespace Src\Core;

class Response {

    private $status = 200;
    private $message;

    public function status($status) {
        $this->status = $status;
    }

    public function message($message) {
        $this->message = $message;
    }

    public function sendError($error, $status) {
        $this->message(['error' => $error]);
        $this->status($status);
        $this->send();
    }

    public function sendMessage($message) {
        $this->message($message);
        $this->send();
    }

    public function sendEmpty($status) {
        http_response_code($status);
        die;
    }

    public function send() {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        //$this->addAccessControlHeaders();
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
        header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
        http_response_code($this->status);
        echo json_encode($this->message);
        die;
    }

    protected function addAccessControlHeaders() {
        $possibleOrigins = explode(',', env('ALLOW_ORIGINS', '*'));

        if (env('APP_ENV') == 'development') {
            $possibleOrigins[] = 'https://localhost:8080';
        }

        if (in_array(Request::getOrigin(), $possibleOrigins)) {
            $origin = Request::getOrigin();
        } else {
            $origin = 'https://example.com';
        }

        header("Access-Control-Allow-Origin: {$origin}");

        return;
    }

}