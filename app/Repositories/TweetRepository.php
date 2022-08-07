<?php
declare(strict_types=1);

namespace WorkshopTask\Repositories;

class TweetRepository extends BaseRepository implements RepositoryInterface
{
    public function get(array $data): array
    {
        $tweetId = $data['id'] ?? null;

        if ($tweetId === null) {
            $stmt = $this->databaseConnection->query(
                'SELECT tweets.id,
                                 u.name as user_name,
                                 tweets.title,
                                 tweets.content,
                                 datetime(tweets.created, \'localtime\') as created,
                                 datetime(tweets.updated, \'localtime\') as updated
                           FROM tweets
                               INNER JOIN users u ON u.id = tweets.users_id
                           WHERE tweets.deleted IS NULL
                           ORDER BY tweets.created DESC'
            );

            $stmt->execute();

        } else {
            $stmt = $this->databaseConnection->query(
                'SELECT tweets.id,
                                 u.name as user_name,
                                 tweets.title,
                                 tweets.content,
                                 datetime(tweets.created, \'localtime\') as created,
                                 datetime(tweets.updated, \'localtime\') as updated
                           FROM tweets
                               INNER JOIN users u ON u.id = tweets.users_id
                           WHERE tweets.id = :id
                             AND tweets.deleted IS NULL
                           ORDER BY tweets.created DESC'
            );

            $stmt->execute([
                ':id' => $tweetId,
            ]);
        }


        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getByUserId(int $userId): array
    {
        $stmt = $this->databaseConnection->prepare(
            'SELECT tweets.id,
                          u.name as user_name,
                          tweets.title,
                          tweets.content
                    FROM tweets
                        INNER JOIN users u ON u.id = tweets.users_id
                    WHERE tweets.users_id = :users_id
                      AND tweets.deleted IS NULL
                    ORDER BY tweets.created DESC'
        );

        $stmt->execute([
            ':users_id' => $userId,
        ]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update(array $data): bool
    {
        $stmt = $this->databaseConnection->prepare(
            'UPDATE tweets SET title = :title, content = :content, updated = CURRENT_TIMESTAMP 
                   WHERE id = :id
                     AND users_id = :users_id'
        );

        $stmt->bindParam('title', $data['title']);
        $stmt->bindParam('content', $data['content']);
        $stmt->bindParam('id', $data['id'], \PDO::PARAM_INT);
        $stmt->bindParam('users_id', $data['users_id'], \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function store(array $data): array
    {
        $stmt = $this->databaseConnection->prepare(
            'INSERT INTO tweets (users_id, title, content) VALUES (:users_id, :title, :content)'
        );

        $stmt->execute([
            ':users_id' => $data['users_id'],
            ':title' => $data['title'],
            ':content' => $data['content'],
        ]);

        return [];
    }

    public function softDelete(array $data): bool
    {
        $stmt = $this->databaseConnection->prepare(
            'UPDATE tweets SET deleted = CURRENT_TIMESTAMP WHERE id = :id AND users_id = :users_id'
        );

        return $stmt->execute([
            ':id' => $data['id'],
            ':users_id' => $data['users_id'],
        ]);
    }
}
