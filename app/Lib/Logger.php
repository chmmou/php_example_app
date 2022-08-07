<?php
declare(strict_types=1);

namespace WorkshopTask\Lib;

use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use WorkshopTask\Config\Config;

class Logger extends \Monolog\Logger
{
    protected static array $loggers;

    public function __construct($key = "app", array $config = [])
    {
        parent::__construct($key);

        if (count($config) === 0) {
            $log_path = __DIR__ . '/../../' . Config::getEnv('LOG_PATH');
            $config = [
                'logFile' => "{$log_path}/{$key}.log",
                'logLevel' => Level::Debug
            ];
        }

        $this->pushHandler(new StreamHandler($config['logFile'], $config['logLevel']));
    }

    public static function enableSystemLogs()
    {
        $log_path = __DIR__ . '/../../' . Config::getEnv('LOG_PATH');

        // Error Log
        self::$loggers['error'] = new Logger('errors');
        self::$loggers['error']->pushHandler(new StreamHandler("{$log_path}/errors.log"));
        ErrorHandler::register(self::$loggers['error']);

        // Request Log
        $data = [
            $_SERVER,
            $_REQUEST,
            trim(file_get_contents("php://input"))
        ];

        self::$loggers['request'] = new Logger('request');
        self::$loggers['request']->pushHandler(new StreamHandler("{$log_path}/request.log"));
        self::$loggers['request']->info("REQUEST", $data);
    }
}
