<?php

namespace WorkshopTask\Lib;

use Monolog\ErrorHandler;
use Monolog\Handler\StreamHandler;
use WorkshopTask\Config\Config;

class Logger extends \Monolog\Logger
{
    protected static array $loggers;

    public function __construct($key = "app", $configs = null)
    {
        parent::__construct($key);

        if (empty($config)) {
            $log_path = __DIR__ . '/../../' . Config::getEnv('LOG_PATH');
            $config = [
                'logFile' => "{$log_path}/{$key}.log",
                'logLevel' => \Monolog\Logger::DEBUG
            ];
        }

        $this->pushHandler(new StreamHandler($config['logFile'], $config['logLevel']));
    }

    public static function getInstance($key = "app", $config = null)
    {
        if (empty(self::$loggers[$key])) {
            self::$loggers[$key] = new Logger($key, $config);
        }

        return self::$loggers[$key];
    }

    public function enableSystemLogs()
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
