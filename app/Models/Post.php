<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $dates = ['published_at'];

    public function getImagePathAttribute()
    {
        return 'storage/'.$this->image;
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function hasTag(int $tag_id):bool
    {
        return in_array($tag_id, $this->tags->pluck('id')->toArray());
    }

    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    public function scopePublished($query)
    {
        return $query->where('published_at','<=',now());
    }

    public function scopeSearch($query)
    {
        $search = request('search');
        if($search)
        {
            return $query->where('title', 'like', "%$search%");
        }

        return $query;
    }
}
