<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table='comments';
    protected $fillable=[
        'post_id',
        'name',
        'email',
        'comment',
    ];
    public function posts_s(){
        return $this->belongsTo(Posts::class,'post_id');
    }
}
