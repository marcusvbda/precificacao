<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\Http\Models\Scopes\OrderByScope;

class ExpenseCenter extends DefaultModel
{
    protected $table = "expense_centers";

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
    }
}
