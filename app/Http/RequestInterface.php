<?php
declare(strict_types=1);

namespace App\Http;

interface RequestInterface
{
    public function getRequestParameters(): array;

    public function redirect(string $url): void;

}
