<?php

declare(strict_types=1);

namespace App\Enums;

class FilterParamsEnum
{
    public const NAME = 'name';
    public const CATEGORY_ID = 'categoryId';
    public const CATEGORY_NAME = 'categoryName';
    public const PRICE_FROM = 'priceFrom';
    public const PRICE_TO = 'priceTo';
    public const PUBLISHED = 'published';
    public const REMOVED = 'removed';

    public const PARAMS = [
        self::NAME,
        self::CATEGORY_ID,
        self::CATEGORY_NAME,
        self::PRICE_FROM,
        self::PRICE_TO,
        self::PUBLISHED,
        self::REMOVED,
    ];
}
