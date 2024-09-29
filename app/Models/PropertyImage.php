<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory; // Usando a trait para suporte a factories

    // Campos que podem ser preenchidos em massa
    protected $fillable = ['property_id', 'photos'];

    // Cast para garantir que 'photos' seja tratado como um array
    protected $casts = [
        'photos' => 'array',
    ];

    // Relacionamento: Muitas imagens pertencem a um imóvel


}
