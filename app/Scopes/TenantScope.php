<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope Implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if(session()->has('tenant_id') && !is_null(session()->get('tenant_id'))) {
            $builder->where('tenant_id', session()->get('tenant_id'));
        }
    }
}
