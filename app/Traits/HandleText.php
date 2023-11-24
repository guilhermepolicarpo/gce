<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HandleText 
{
    public function formatName($name) 
    {
        $formattedName = Str::of($name)->title();

        $particulasMonossilabicas = ['de', 'da', 'e', 'o', 'a', 'em', 'dos', 'das', 'os', 'as'];

        foreach ($particulasMonossilabicas as $particula) {
            $formattedName = str_replace(' ' . ucfirst($particula) . ' ', ' ' . $particula . ' ', $formattedName);
        }

        return $formattedName;
    }

    public function formatEmail($email) 
    {
        return Str::lower($email);
    }
}