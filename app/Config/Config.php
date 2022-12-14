<?php
declare(strict_types=1);

namespace App\Config;

use App\Application;
use App\CoreApplication;
use App\Exceptions\FileNotFoundException;
use App\Repositories\TweetRepository;
use App\Repositories\UserRepository;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
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
            CoreApplication::class => create(Application::class),
            UserRepository::class => create(UserRepository::class),
            TweetRepository::class => create(TweetRepository::class),

            // Configure Twig
            Environment::class => function () {
                $loader = new FilesystemLoader(__DIR__ . '/../Views');
                $env = new Environment($loader);
                $env->getExtension(\Twig\Extension\CoreExtension::class)->setTimezone('Europe/Berlin');

                $env->addFilter(
                    new \Twig\TwigFilter('time', function () {
                        return time();
                    })
                );

                return $env;
            },
        ];
    }

    public static function getEnv(string $key): ?string
    {
        return $_ENV[$key] ?? null;
    }
}
