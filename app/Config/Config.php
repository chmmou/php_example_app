<?php

namespace WorkshopTask\Config;

use WorkshopTask\Application;
use WorkshopTask\CoreApplication;
use WorkshopTask\Exceptions\FileNotFoundException;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use WorkshopTask\Repositories\TweetRepository;
use WorkshopTask\Repositories\UserRepository;
use function DI\create;

class Config
{
    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
        $dotenv = new Dotenv();
        $envFile = dirname(__DIR__) . '/../.env';
        if (!file_exists($envFile)) {
            throw new FileNotFoundException("File '${envFile}' was not found!");
        }

        $dotenv->loadEnv($envFile);
    }

    public function getDependencyInjection(): array
    {
        return [
            // DI
            Config::class => create(Config::class),
            CoreApplication::class => create(Application::class),
            UserRepository::class => create(UserRepository::class),
            TweetRepository::class => create(TweetRepository::class),

            // Configure Twig
            Environment::class => function () {
                $loader = new FilesystemLoader(__DIR__ . '/../Views');
                return new Environment($loader);
            },
        ];
    }

    public static function getEnv(string $key): ?string
    {
        return $_ENV[$key] ?? null;
    }
}
