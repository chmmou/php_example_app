<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Config\Config;
use App\Exceptions\FileNotFoundException;

class BaseRepository
{
    protected \PDO $databaseConnection;

    public function __construct()
    {
        $path = dirname(__DIR__);
        $resourceFile = $path . '/../resources/workshoptask.sql';
        $databaseFile = $path . '/../' . Config::getEnv('DB_PATH');

        if (!file_exists($path)) {
            throw new FileNotFoundException("DB {$databaseFile} not found");
        }

        $this->databaseConnection = new \PDO("sqlite:{$databaseFile}");
        $this->databaseConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $content = file_get_contents($resourceFile);
        $this->databaseConnection->exec($content);
    }
}
