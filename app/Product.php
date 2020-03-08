<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use Translatable;
    

    public $translatedAttributes = ['name','description'];
    protected $guarded = [];

    
    protected $appends=['image_path','profit_percent'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getImagePathAttribute($value)
    {
        return asset('uploads/product_images/'.$this->image);
    }
    
    public function getProfitPercentAttribute($value)
    {
        $profit=$this->sale_price - $this->purchase_price;
        $profit_percent=$profit * 100 / $this->purchase_price;
        return number_format($profit_percent,2);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'product_order');
    }
}
