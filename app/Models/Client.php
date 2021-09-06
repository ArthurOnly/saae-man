<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Client extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'name',
        'phone',
        'subscription'
    ];

    public $sortable = [
        'name',
        'phone',
        'subscription'
    ];
}
