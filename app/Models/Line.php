<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Summary;
use App\Models\Operation;

class Line extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function summary()
    {
    	return $this->belongsTo(Summary::class);
    }

    public function operations()
    {
    	return $this->hasMany(Operation::class);
    }
}
