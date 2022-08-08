<?php
declare(strict_types=1);

namespace App\Repositories;

class UserRepository extends BaseRepository implements RepositoryInterface
{
    public function get(array $data): array
    {
        $stmt = $this->databaseConnection->prepare(
            'SELECT * FROM users WHERE name = :name'
        );

        $stmt->execute([
            ':name' => $data['name'],
        ]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $rows[0] ?? [];
    }

    public function getByUserId(int $userId): array
    {
        return [];
    }

    public function update(array $data): bool
    {
        $stmt = $this->databaseConnection->prepare(
            'UPDATE users SET loggedin = :loggedin WHERE id = :id'
        );

        return $stmt->execute([
            'id' => $data['id'],
            'loggedin' => $data['loggedin'],
        ]);
    }

    public function store(array $data): array
    {
        $user = $this->get([
            'name' => $data['name'],
        ]);

        if (count($user) !== 0) {
            return [];
        }

        $stmt = $this->databaseConnection->prepare(
            'INSERT INTO users (name, password, loggedin) VALUES (:name, :password, :loggedin)'
        );

        $stmt->execute([
            'name' => $data['name'],
            'password' => $data['password'],
            'loggedin' => 1,
        ]);

        return $this->get($data);
    }

    public function softDelete(array $data): bool
    {
        return false;
    }
}
