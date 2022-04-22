<?php

namespace Modules\City\Repositories;

use Modules\City\Entities\City;
use Modules\Core\Repositories\EloquentRepository;

class EloquentCitiesRepository extends EloquentRepository implements CitiesRepositoryInterface
{
    public function model()
    {
        return City::class;
    }
}
