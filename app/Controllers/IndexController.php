<?php
declare(strict_types=1);

namespace WorkshopTask\Controllers;

use WorkshopTask\Repositories\TweetRepository;

class IndexController extends CoreController
{
    public function index(TweetRepository $repository): void
    {
        $tweets = $repository->get([]);

        echo $this->twig->render(
            'index.twig',
            [
                'title' => $this->application->getApplicationTitle(),
                'tweets' => $tweets
            ]
        );
    }

    public function user(TweetRepository $repository): void
    {
        if (!$this->application->isUserLoggedIn()) {
            $this->application->getRequest()->redirect('/login');
        }

        $userId = $this->application->getLoggedInUserId();

        echo $this->twig->render(
            'user.twig',
            [
                'tweets' => $repository->getByUserId($userId),
                'user_name' => $this->application->getLoggedInUserName()
            ]
        );
    }
}
