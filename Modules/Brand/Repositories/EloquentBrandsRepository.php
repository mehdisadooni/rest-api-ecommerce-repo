<?php

namespace Modules\Brand\Repositories;

use Modules\Brand\Entities\Brand;
use Modules\Core\Repositories\EloquentRepository;

class EloquentBrandsRepository extends EloquentRepository implements BrandsRepositoryInterface
{
    public function model()
    {
        return Brand::class;
    }
}
