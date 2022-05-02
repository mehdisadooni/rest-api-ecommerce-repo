<?php

namespace Modules\Province\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\City\Entities\City;

class Province extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    protected static function newFactory()
    {
        return \Modules\Province\Database\factories\ProvinceFactory::new();
    }
}
