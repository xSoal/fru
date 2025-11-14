<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCalendar extends Model
{
    use HasFactory;
    protected $fillable = ['project_id','production_periods','start_production','end_production','day_count'];
}
