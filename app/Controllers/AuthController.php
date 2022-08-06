<?php

namespace WorkshopTask\Controllers;

class AuthController extends CoreController
{
    public function login(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        $userName = $_SESSION['user_name'] ?? null;

        $request = $this->application->getRequest()->getRequestParameters();

        if (count($request) === 0 && $userId === null && $userName === null) {
            echo $this->twig->render(
                'login.twig',
                [
                    'title' => $this->application->getApplicationTitle()
                ]
            );

            return;
        }

        $this->application->getRequest()->redirect('/login');
    }

    public function logout(): void
    {
    }
}
