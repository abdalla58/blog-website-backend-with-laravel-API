<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table='posts';
    protected $fillable=[
        'cat_id',
        'title',
        'description',
        'image',
        'views'
    ];
    public function categories(){
        return $this->belongsTo(Category::class,'cat_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
