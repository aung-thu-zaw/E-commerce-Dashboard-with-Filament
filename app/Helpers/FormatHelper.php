<?php

namespace App\Helpers;

class FormatHelper
{
    public static function humanReadableFilesize(int $size): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $size > 1024; $i++) {
            $size /= 1024;
        }

        return round($size, 2).' '.$units[$i];
    }
}
