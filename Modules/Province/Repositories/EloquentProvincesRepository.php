<?php

namespace Modules\Province\Repositories;

use Modules\Core\Repositories\EloquentRepository;
use Modules\Province\Entities\Province;

class EloquentProvincesRepository extends EloquentRepository implements ProvincesRepositoryInterface
{
    public function model()
    {
        return Province::class;
    }
}
