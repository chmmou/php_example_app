<?php

namespace WorkshopTask;

class Application extends CoreApplication
{
    public function getApplicationTitle(): string
    {
        return $this->config->getEnv('APP_NAME') ?? 'WorkshopTask - Probeaufgabe';
    }
}
