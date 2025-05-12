<?php

if (!function_exists('waktuJam')) {
    function waktuJam($waktu)
    {
        return match ($waktu) {
            'pagi' => '08:00',
            'siang' => '13:00',
            'malam' => '18:00',
            default => '00:00',
        };
    }
}
