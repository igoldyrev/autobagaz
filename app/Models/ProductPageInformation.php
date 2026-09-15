<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPageInformation extends Model
{
    protected $table = 'product_page_information';

    protected $fillable = [
        'delivery_content',
        'payment_content',
        'warranty_content',
    ];
}
