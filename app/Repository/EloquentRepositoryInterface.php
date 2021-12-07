<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface EloquentRepositoryInterface
{
    public function create(array $attributes): Model;

    public function all(): Collection;

    public function find(int $id): ?Model;
}
