<?php

declare(strict_types=1);

namespace Shop;

final class Item
{
    public const ITEM_MJOLNIR = 'Mjolnir';
    public const ITEM_BLUE_CHEESE = 'Blue cheese';
    public const ITEM_TICKET = 'Concert tickets';
    public const ITEM_MAGIC = 'Magic cake';

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $sell_in;

    /**
     * @var int
     */
    public $quality;

    public function __construct(string $name, int $sell_in, int $quality)
    {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    public function __toString(): string
    {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }
}
