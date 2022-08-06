<?php
declare(strict_types=1);

namespace WorkshopTask\Http;

interface RequestInterface
{
    public function getRequestParameters(): array;

    public function redirect(string $url): void;

}
