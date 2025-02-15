<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPoint extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_graphql_id',
        'point',
    ];
}
