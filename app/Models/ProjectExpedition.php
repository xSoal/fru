<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectExpedition extends Model
{
    use HasFactory;
    protected $fillable = ['project_id','route','distance','count_work_days','count_days','count_nights'];
}
