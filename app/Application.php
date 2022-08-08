<?php
declare(strict_types=1);

namespace App;

class Application extends CoreApplication
{
    public function getApplicationTitle(): string
    {
        return $this->config->getEnv('APP_NAME') ?? 'Example App';
    }
}
