<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'tax', 'state_tax_name', 'state_tax', 'central_tax_name', 'central_tax', 'integrated_tax_name', 'integrated_tax', 'description', 'status'
    ];
}
