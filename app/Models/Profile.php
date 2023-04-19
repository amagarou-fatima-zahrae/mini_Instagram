<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function profileImg()
    {
        return ($this->image) ? '/storage/' . $this->image : '/storage/profiles/index.png';
    }
    
    public function user()
    {
      return $this->belongsTo(User::class);
    }

    public function followers()
    {
      return $this->belongsToMany(User::class);
    }
    public function messages()
    {
      return $this->hasMany(Message::class)->orderBy('created_at','DESC');
    }
}
