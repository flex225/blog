<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model {

    protected $table = 'post_subcategory';

    public function category() {
      return $this->belongsTo(Category::class, 'id');
    }

    public function posts() {
      return $this->hasMany(Post::class, 'id');
    }

}
