<?php

namespace App\Http;

class Request implements RequestInterface
{
    protected string $requestMethod;

    public function __construct()
    {
        $this->requestMethod = trim($_SERVER['REQUEST_METHOD']);
    }

    public function getRequestParameters(): array
    {
        if ($this->requestMethod !== 'POST') {
            return [];
        }

        $requestParameters = [];
        foreach ($_POST as $key => $value) {
            $requestParameters[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $requestParameters;
    }

    public function redirect(string $url): void
    {
        ob_start();
        header('Location: ' . $url);
        ob_end_flush();
        die();
    }

}
