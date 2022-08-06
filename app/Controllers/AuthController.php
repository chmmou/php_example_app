<?php
declare(strict_types=1);

namespace WorkshopTask\Controllers;

use WorkshopTask\Repositories\UserRepository;

class AuthController extends CoreController
{
    public function login(UserRepository $repository): void
    {
        if ($this->application->isUserLoggedIn()) {
            $this->application->getRequest()->redirect('/user');
        }

        $request = $this->application->getRequest()->getRequestParameters();

        if ($this->isRequestValid($request) === false) {
            echo $this->twig->render('login.twig');
            return;
        }

        $user = $repository->get([
            'name' => $request['name'],
        ]);

        if (count($user) === 0 || (int) $user['loggedin'] === 0) {
            $_SESSION['user_id'] = null;
            $_SESSION['user_name'] = null;

            $this->application->getRequest()->redirect('/login');
        }

        if (!password_verify($request['password'], $user['password'])) {
            $_SESSION['user_id'] = null;
            $_SESSION['user_name'] = null;

            $this->application->getRequest()->redirect('/login');
        }


        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        $success = $repository->update([
            'id' => $_SESSION['user_id'],
            'loggedin' => 1,
        ]);

        if ($success === false) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            $this->application->getRequest()->redirect('/login');
        }

        $this->application->getRequest()->redirect('/user');
    }

    public function logout(UserRepository $repository): void
    {
        $repository->update([
            'id' => $_SESSION['user_id'],
            'loggedin' => 0,
        ]);

        unset($_SESSION['user_id'], $_SESSION['user_name']);

        $this->application->getRequest()->redirect('/login');
    }

    public function register(UserRepository $repository): void
    {
        $request = $this->application->getRequest()->getRequestParameters();

        if ($this->isRequestValid($request) === false) {
            echo $this->twig->render('register.twig');
            return;
        }

        $userPassword = $request['password'];
        $userConfirmPassword = $request['confirm_password'];

        if ($userPassword !== $userConfirmPassword) {
            echo $this->twig->render('register.twig');
            return;
        }

        $user = $repository->store([
            'name' => $request['name'],
            'password' => password_hash($request['password'], PASSWORD_DEFAULT),
        ]);

        if (count($user) === 0) {
            $this->application->getRequest()->redirect('/register');
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        $this->application->getRequest()->redirect('/user');
    }

    private function isRequestValid(array $request): bool
    {
        $userName = $request['name'] ?? null;
        $userPassword = $request['password'] ?? null;
        $userConfirmPassword = $request['confirm_password'] ?? null;

        $loginValid = $userName !== null && $userName !== '' && $userPassword !== null && $userPassword !== '';
        $registrationValid = $loginValid
            && $userPassword !== null
            && $userPassword !== ''
            && $userConfirmPassword !== null
            && $userConfirmPassword !== ''
            && $userPassword === $userConfirmPassword;

        return $loginValid || $registrationValid;

    }
}
