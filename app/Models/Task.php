<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable =['name','description','user_id','deadline','accept','state','report','evaluation'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function isReported()
    {
        return $this->report ==null;
        
    }
    
}
