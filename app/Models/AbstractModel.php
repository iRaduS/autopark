<?php


namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Arr;


abstract class AbstractModel extends EloquentModel
{
    protected $guarded = [];
    protected $perPage = 10;

    public function resolveRouteBinding($value, $field = null)
    {
        return Arr::exists(class_uses($this), SoftDeletes::class)
            ? $this->where($this->getRouteKeyName(), $value)->withTrashed()->first()
            : parent::resolveRouteBinding($value, $field);
    }
}
