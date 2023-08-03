<?php

namespace App\Fixtures\Providers;

class TelephoneProvider
{
    public function generateNomTel(): string
    {
        $nomTel = [
            'Iphone 10',
            'Iphone 11',
            'Iphone 12',
            'Iphone 14',
            'Galaxy A40',
            'Galaxy A41',
            'Galaxy A42',
            'Note One',
            'Perle 7',
            'Xmst 3',
            'Xmst 4',
            'Xmst 5',
        ];
        return $nomTel[array_rand($nomTel)];
    }
}
