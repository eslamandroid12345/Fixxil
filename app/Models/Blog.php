<?php

namespace App\Models;

use App\Http\Traits\LanguageToggle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory,LanguageToggle;

    protected $table = 'blogs';
    protected $guarded = [];

    public function getUserNameAttribute()
    {
        if (is_null($this->user_id))
        {
            return 'admin';
        }
        return $this->user ? $this->user->name : 'admin';
    }
    public function user()
    {
        return $this->belongsTo(User::class );
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    public function images()
    {
        return $this->hasMany(BlogImage::class, 'blog_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_id');
    }
}
