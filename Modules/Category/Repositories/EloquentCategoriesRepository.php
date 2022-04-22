<?php

namespace Modules\Category\Repositories;

use Modules\Category\Entities\Category;
use Modules\Core\Repositories\EloquentRepository;

class EloquentCitiesRepository extends EloquentRepository implements CategoriesRepositoryInterface
{
    public function model()
    {
        return Category::class;
    }
}
