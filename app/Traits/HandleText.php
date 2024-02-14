<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HandleText
{
    public function formatName($name)
    {
        $formattedName = Str::of($name)->title();

        $exeptions = ['de', 'da', 'do', 'e', 'o', 'a', 'em', 'dos', 'das', 'os', 'as', 'I', 'II', 'III', 'IV'];

        foreach ($exeptions as $exeption) {
            $formattedName = str_replace(' ' . ucfirst($exeption) . ' ', ' ' . $exeption . ' ', $formattedName);
        }

        return $formattedName;
    }

    public function formatEmail($email)
    {
        return Str::lower($email);
    }
}
