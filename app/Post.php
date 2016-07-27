<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    protected $table = 'posts';

    public function images() {
      return $this->hasMany(Image::class, 'post_id');
    }

    public function user() {
      return $this->belongsTo(User::class, 'user_id');
    }

    public function subcategories() {
      return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }
}
