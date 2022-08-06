<?php

namespace WorkshopTask\Repositories;

interface RepositoryInterface
{
    public function get(string $query): array;
    public function store(array $data): void;
}
