<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'manager_id',
        'image',    
        'commission',
        'price',
        'store_type'
    ];


    public function tags(){

        return $this->hasMany(StoreTags::class);
    }
}
