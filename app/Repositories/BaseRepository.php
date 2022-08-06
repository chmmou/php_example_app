<?php
declare(strict_types=1);

namespace WorkshopTask\Repositories;

use WorkshopTask\Config\Config;
use WorkshopTask\Exceptions\FileNotFoundException;

class BaseRepository
{
    protected \PDO $databaseConnection;

    public function __construct()
    {
        $path = dirname(__DIR__);
        $resourcePath = $path . '/../resources/workshoptask.sql';
        $databasePath = $path . '/../' . Config::getEnv('DB_PATH');

        if (!file_exists($path)) {
            throw new FileNotFoundException("DB {$databasePath} not found");
        }

        $this->databaseConnection = new \PDO("sqlite:{$databasePath}");
        $this->databaseConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $content = file_get_contents($resourcePath);
        $this->databaseConnection->exec($content);
    }
}
