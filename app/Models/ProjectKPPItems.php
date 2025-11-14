<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectKPPItems extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','row_id','count_id','title','json'];
}
