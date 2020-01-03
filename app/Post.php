<?php

namespace App;

use App\User;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $fillable = ['id', 'body', 'title', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    } //-- end getUser function
}//-- end of model
