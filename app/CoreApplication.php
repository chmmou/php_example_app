<?php
declare(strict_types=1);

namespace App;

use DI\Container;
use DI\ContainerBuilder;
use App\Config\Config;
use App\Http\Request;
use App\Http\RequestInterface;
use App\Lib\Logger;

class CoreApplication
{
    protected ?Config $config = null;
    private Container $container;
    private RequestInterface $request;

    public function __construct(Config $config)
    {
        $this->config = $config;

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->addDefinitions($this->config->getDependencyInjection());

        $this->container = $containerBuilder->build();

        $this->request = new Request();

        Logger::enableSystemLogs();
    }

    public function getContainer(): ?Container
    {
        return $this->container;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function isUserLoggedIn(): bool
    {
        $userId = $_SESSION['user_id'] ?? null;
        $userName = $_SESSION['user_name'] ?? null;

        return $userId !== '' && $userId !== null && $userName !== '' && $userName !== null;
    }

    public function getLoggedInUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public function getLoggedInUserName(): ?string
    {
        return $_SESSION['user_name'] ?? null;
    }
}
