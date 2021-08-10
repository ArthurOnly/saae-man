<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{
    use HasFactory;

    public function operation(){
        return $this->hasMany(Operation::class, "operation_type", "id");
    }
}
