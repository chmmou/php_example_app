<?php

namespace WorkshopTask\Controllers;

class IndexController extends CoreController
{
    public function index(): void
    {
        echo $this->twig->render(
            'index.twig',
            [
                'title' => $this->application->getApplicationTitle()
            ]
        );
    }

    public function user(): void
    {
        echo $this->twig->render('user.twig');
    }
}
