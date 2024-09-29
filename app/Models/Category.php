<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

//    protected $table = 'categories'; // Tabela categories

    // Campos que podem ser preenchidos
    protected $fillable = ['name'];

//    // Relacionamento: Uma categoria pode ter várias propriedades
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

}
