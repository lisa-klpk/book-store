<?php

declare(strict_types=1);

namespace App\DTO;

class BookSearchCriteria
{
    public int $limit = 20;

    public int $page = 1;

    public ?float $startingPrice = null;

    public ?float $endingPrice = null;

    public ?string $name = null;

    public string $orderBy = 'createdAt';

    public string $direction = 'ASC';
}
