<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'price',
        'bedrooms',
        'bathrooms',
        'garage_spaces',
        'total_area',
        'usable_area',
        'description',
        'featured',
        'neighborhood',
        'city',
        'category_id',
        'user_id',
        'CEP',
        'slug'
    ];

    // Relacionamento: Um imóvel pertence a uma categoria
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    // Relacionamento: Um imóvel pode ter muitas imagens
    public function propertyImages()
    {
        return $this->hasMany(PropertyImage::class);
    }

    // Relacionamento: Um imóvel pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
