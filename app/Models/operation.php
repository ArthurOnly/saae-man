<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        "order",
        "lat",
        "long",
        "address",
        "subscription",
        "completed",
        "operation_type"
    ];

    public function operationType(){
        return $this->hasOne(OperationType::class, "id", "operation_type");
    }

}
