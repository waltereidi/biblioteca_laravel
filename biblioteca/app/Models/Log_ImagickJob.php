<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_ImagickJob extends Model
{
    use HasFactory;
    protected $table = 'log_imagick_job';
    protected $primaryKey = 'id';

    protected $fillable = [
        'description',
        'severity'
    ];

    
    
}
