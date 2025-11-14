<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name','genre','format','timing','count_programs','count_changes','count_montaj','frequency_airing','total_amount'];
    
    public function calendar(){
        return $this->hasMany(ProjectCalendar::class);
    }

    public function schedule(){
        return $this->hasMany(Schedule::class);
    }
    public function expedition(){
        return $this->hasMany(ProjectExpedition::class);
    }

    public function limit(){
        return $this->hasMany(ProjectLimit::class);
    }
    
}
