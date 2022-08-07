<?php

namespace WorkshopTask\Http;

class Request implements RequestInterface
{
    protected string $reqMethod;
    protected string $contentType;

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
