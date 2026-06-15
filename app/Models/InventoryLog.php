<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'user_id', 'event', 'type', 'remarks', 'user_level', 'note'];

    public function products()
    {
        return $this->hasMany('App\Models\InventoryLogProduct');
    }
}
