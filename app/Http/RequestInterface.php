<?php

namespace WorkshopTask\Http;

interface RequestInterface
{
    public function getRequestParameters(): array;

    public function redirect(string $url): void;

}
