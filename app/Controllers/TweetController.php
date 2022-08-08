<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\TweetRepository;

class TweetController extends CoreController
{
    public function detail(int $id, TweetRepository $repository): void
    {
        $tweets = $repository->get(['id' => $id]);

        echo $this->twig->render(
            'tweets/detail.twig',
            [
                'tweets' => $tweets
            ]
        );
    }

    public function create(TweetRepository $repository): void
    {
        if (!$this->application->isUserLoggedIn()) {
            $this->application->getRequest()->redirect('/login');
        }

        $userId = $this->application->getLoggedInUserId();

        $request = $this->application->getRequest()->getRequestParameters();
        $request['users_id'] = $userId;

        $repository->store($request);

        $this->application->getRequest()->redirect('/user');
    }

    public function edit(TweetRepository $repository): void
    {
        if (!$this->application->isUserLoggedIn()) {
            $this->application->getRequest()->redirect('/login');
        }

        $userId = $this->application->getLoggedInUserId();
        $request = $this->application->getRequest()->getRequestParameters();
        $request['users_id'] = $userId;

        $repository->update($request);

        $this->application->getRequest()->redirect('/user');
    }

    public function delete(TweetRepository $repository): void
    {
        if (!$this->application->isUserLoggedIn()) {
            $this->application->getRequest()->redirect('/login');
        }

        $userId = $this->application->getLoggedInUserId();
        $request = $this->application->getRequest()->getRequestParameters();
        $request['users_id'] = $userId;

        $repository->softDelete([
            'id' => $request['tweet_id'],
            'users_id' => $request['users_id'],
        ]);

        $this->application->getRequest()->redirect('/user');
    }
}
