<?php

declare(strict_types=1);

namespace KoenHendriks\StrAcronym;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class StrServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Str::macro('acronym', function ($string, $delimiter = '', int $limit = null) {
            if (empty($string)) {
                return '';
            }

            $acronym = '';
            foreach (preg_split('/[^\p{L}]+/u', $string) as $word) {
                if(!empty($word)){
                    $first_letter = mb_substr($word, 0, 1);
                    $acronym .= $first_letter . $delimiter;
                }
            }

            // Trim the acronym if limit has been provided
            if ($limit !== null) {
                $acronym = mb_substr($acronym, 0, $limit);
            }

            return $acronym;
        });

        Stringable::macro('acronym', function (string $delimiter = '', int $limit = null) {
            return new Stringable (Str::acronym($this->value, $delimiter, $limit));
        });
    }
}
