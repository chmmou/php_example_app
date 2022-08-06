<?php

namespace WorkshopTask;

use DI\Container;
use DI\ContainerBuilder;
use WorkshopTask\Config\Config;
use WorkshopTask\Http\Request;
use WorkshopTask\Http\RequestInterface;
use WorkshopTask\Lib\Logger;

class CoreApplication
{
    protected ?Config $config = null;
    private Container $container;
    private RequestInterface $request;
    private Logger $logger;

    public function __construct(Config $config)
    {
        $this->config = $config;

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->addDefinitions($this->config->getDependencyInjection());

        $this->container = $containerBuilder->build();

        $this->request = new Request();

        $this->logger = Logger::getInstance();
        $this->logger->enableSystemLogs();
    }

    public function getContainer(): ?Container
    {
        return $this->container;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
