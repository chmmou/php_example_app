<?php

namespace App\Controllers;

use App\Application;
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
}
