<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toggl extends Model
{
    use HasFactory;

    protected $table = 'toggl';
    protected $fillable = [
        'public_id',
        'uid',
        'ticket_id',
        'description',
        'duration',
        'start_time',
        'end_time',
        'updated',
    ];
}
