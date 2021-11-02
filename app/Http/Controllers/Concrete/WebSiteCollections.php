<?php


namespace App\Http\Controllers\Concrete;


use App\Http\Controllers\Interfaces\Collections;
use App\Models\Product;

class WebSiteCollections implements Collections
{
    public function products($limit): object
    {
        return Product::select(['id','name','price','qty','description','image'])->paginate($limit);
    }
}
