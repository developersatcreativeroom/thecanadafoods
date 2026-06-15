<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryStatusHistory extends Model
{
    use HasFactory;
    protected $table = "enquiry_status_history";

    
    protected $fillable = [
        'status', 'type', 'note', 'action_by'
    ];
}
