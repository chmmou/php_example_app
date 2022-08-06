<?php

namespace WorkshopTask\Repositories;

interface RepositoryInterface
{
    public function get(array $data): array;
    public function update(array $data): bool;
    public function store(array $data): array;
}
