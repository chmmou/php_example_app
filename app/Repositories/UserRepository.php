<?php

namespace WorkshopTask\Repositories;

class UserRepository extends BaseRepository implements RepositoryInterface
{
    public function get(string $query): array
    {
        return [];
    }

    public function store(array $data): void
    {
    }
}
