<?php

namespace App\Observers;

use App\Models\Property;
use Illuminate\Support\Facades\Storage;

class PropertyObserver
{
    /**
     * Handle the Property "deleting" event.
     *
     * @param  \App\Models\Property  $property
     * @return void
     */
    public function deleting(Property $property)
    {
        // Verifique se o relacionamento 'propertyImages' existe e apague as imagens
        if ($property->propertyImages) {
            foreach ($property->propertyImages as $image) {
                // Apague o arquivo do disco
                Storage::disk('public')->delete($image->photos);

                // Apague o registro da imagem do banco de dados
                $image->delete();
            }
        }
    }
}
