<?php
declare(strict_types=1);

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
        if ($this->application->isUserLoggedIn()) {
            echo $this->twig->render('user.twig');
            return;
        }

        $this->application->getRequest()->redirect('/login');
    }
}
