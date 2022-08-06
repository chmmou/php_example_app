<?php

namespace WorkshopTask\Config;

use WorkshopTask\Application;
use WorkshopTask\CoreApplication;
use WorkshopTask\Exceptions\FileNotFoundException;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use WorkshopTask\Http\Request;
use WorkshopTask\Http\RequestInterface;
use WorkshopTask\Repositories\TweetRepository;
use WorkshopTask\Repositories\UserRepository;
use function DI\create;

class Config
{
    private Dotenv $dotenv;

    public function __construct(public string $path)
    {
        $this->dotenv = new Dotenv();
    }

    public function init(): void
    {
        $envFile = $this->path . '/.env';
        if (!file_exists($envFile)) {
            throw new FileNotFoundException("File '${envFile}' was not found!");
        }

        $this->dotenv->loadEnv($envFile);
    }

    public function getDependencyInjection(): array
    {
        return [
            // DI
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
