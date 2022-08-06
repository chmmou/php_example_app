<?php

namespace WorkshopTask\Controllers;

use WorkshopTask\Application;
use Twig\Environment;

class CoreController
{
    protected Application $application;
    protected Environment $twig;

    public function __construct(Application $application, Environment $twig)
    {
        $this->application = $application;
        $this->twig = $twig;
    }

    public function isLoggedIn(): bool
    {
        $userId = $_SESSION['user_id'] ?? null;
        $userName = $_SESSION['user_name'] ?? null;

        return $userId !== '' && $userId !== null && $userName !== '' && $userName !== null;
    }
}
