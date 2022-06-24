<?php

declare(strict_types=1);

namespace App\Model;

interface ModelInterface
{
    public function list(array $sort, int $pageSize, int $pageNumber): array;

    public function search(array $sort, int $pageSize, int $pageNumber, ?string $searchPhrase): array;

    public function count(): int;

    public function searchCount(string $searchPhrase): int;

    public function get(int $id): array;

    public function create(array $data): void;

    public function edit(int $id, array $data): void;

    public function delete(int $id): void;
}