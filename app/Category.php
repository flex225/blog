<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'post_category';

    public function subcategories() {
      return $this->hasMany(Subcategory::class, 'category_id');
    }

    public function subcategory() {
      return $this->hasMany('App\Subcategory');
    }
}
