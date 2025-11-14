<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = ['name','sex','post_id','project','pasport','inn','zagran_pasport','birthday','email','phone','education','address','residential_addresses','family_status','children','preferential_documents','reservist','iban','employment'];
}
