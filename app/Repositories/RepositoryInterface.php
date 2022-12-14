<?php
declare(strict_types=1);

namespace App\Repositories;

interface RepositoryInterface
{
    public function get(array $data): array;
    public function getByUserId(int $userId): array;
    public function update(array $data): bool;
    public function store(array $data): array;
    public function softDelete(array $data): bool;
}
