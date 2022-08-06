<?php

namespace WorkshopTask\Http;

use JetBrains\PhpStorm\NoReturn;

class Request implements RequestInterface
{
    public string $reqMethod;
    public string $contentType;

    public function __construct()
    {
        $this->reqMethod = trim($_SERVER['REQUEST_METHOD']);
        $this->contentType = !empty($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    }

    public function getRequestParameters(): array
    {
        if ($this->reqMethod !== 'POST') {
            return [];
        }

        $body = [];
        foreach ($_POST as $key => $value) {
            $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $body;
    }

    public function redirect(string $url): void
    {
        ob_start();
        header('Location: ' . $url);
        ob_end_flush();
        die();
    }

}
