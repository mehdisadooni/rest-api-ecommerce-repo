<?php

namespace Modules\Core\Repositories;

abstract class BaseRepository
{
    abstract function all();

    abstract function paginate($limit = 10);

    abstract function getBy($col, $value, $limit = 15);

    abstract function create(array $data);

    abstract function find($id);

    abstract function findOrFail($id);

    abstract function update($model, array $data);

    abstract function delete($model);

    abstract function exists($id);
}
