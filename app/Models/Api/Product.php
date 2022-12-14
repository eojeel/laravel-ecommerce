<?php

namespace App\Models\Api;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends \App\Models\Product
{
     public function getRouteKeyName()
     {
        return 'id';
     }
}
