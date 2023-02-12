<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Operation;

class Stage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function operation()
    {
    	return $this->belongsTo(Operation::class);
    }
}
