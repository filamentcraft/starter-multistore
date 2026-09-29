<?php

declare(strict_types=1);

namespace App\Support;

use App\Enums\Currency;
use Illuminate\Support\Number;

final class Money
{
    public static function format(int $minor, Currency $currency): string
    {
        return (string) Number::currency($minor / 100, in: $currency->value, locale: app()->getLocale());
    }
}
