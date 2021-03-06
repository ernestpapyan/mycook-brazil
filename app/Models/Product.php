<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @var array
     */
    protected $appends = ['photo_full_url'];

    /**
     * @var array
     */
    protected $fillable = [
        'seller_id', 'name', 'active', 'desc', 'serve', 'photo', 'price', 'comments', 'category_id', 
    ];

    /**
     * @return null|string
     */
    public function getPhotoFullUrlAttribute()
    {
        if (isset($this->attributes['photo'])) {
            return 'https://s3-' . env('AWS_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/avatar/products/' . $this->attributes['photo'] ?? '/assets/img/no_image_01.jpg';
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function extras()
    {
        return $this->hasMany(ProductExtra::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(SystemCategory::class, 'id', 'category_id');
    }
}
