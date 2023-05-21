<?php

declare(strict_types=1);

namespace Shop;

final class Shop
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return void
     */
    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            switch ($item->name) {
                case Item::ITEM_BLUE_CHEESE:
                    $this->updateBlueCheeseQuality($item);
                    break;
                case Item::ITEM_MJOLNIR:
                    $this->updateMjolnirQuality($item);
                    break;
                case Item::ITEM_TICKET:
                    $this->updateTicketQuality($item);
                    break;
                case Item::ITEM_MAGIC:
                    $this->updateMagicQuality($item);
                    break;
                default:
                    $this->updateDefaultQuality($item);
            }

            $this->checkQualityScopes($item);
            $this->updateSellIn($item);
        }
    }

    /**
     * @param Item $item
     * @return void
     */
    protected function updateBlueCheeseQuality(Item $item): void
    {
        $item->quality = ($item->sell_in > 0) ? $item->quality + 1 : $item->quality + 2;
    }

    /**
     * @param Item $item
     * @return void
     */
    protected function updateMjolnirQuality(Item $item): void
    {
        $item->quality = 80;
    }

    /**
     * @param Item $item
     * @return void
     */
    protected function updateTicketQuality(Item $item): void
    {
        if ($item->sell_in <= 0) {
            $item->quality = 0;
        } elseif ($item->sell_in <= 5) {
            $item->quality += 3;
        } elseif ($item->sell_in <= 10) {
            $item->quality += 2;
        } else {
            $item->quality += 1;
        }
    }

    /**
     * @param Item $item
     * @return void
     */
    protected function updateMagicQuality(Item $item): void
    {
        $item->quality -= ($item->sell_in > 0) ? 2 : 4;
    }

    /**
     * @param Item $item
     * @return void
     */
    protected function updateDefaultQuality(Item $item): void
    {
        $item->quality -= ($item->sell_in > 0) ? 1 : 2;
    }

    /**
     * @param Item $item
     * @return void
     */
    protected function updateSellIn(Item $item): void
    {
        if (!in_array($item->name, self::exceptUpdatingSellIn())) {
            $item->sell_in--;
        }
    }

    /**
     * @return array
     */
    protected static function exceptUpdatingSellIn(): array
    {
        return [
            Item::ITEM_MJOLNIR
        ];
    }

    /**
     * @param Item $item
     * @return void
     */
    protected function checkQualityScopes(Item $item): void
    {
        $minQuality = self::getMinQuality($item);
        $maxQuality = self::getMaxQuality($item);

        $item->quality = max($minQuality, min($maxQuality, $item->quality));
    }

    /**
     * @param Item $item
     * @return int
     */
    protected static function getMinQuality(Item $item): int
    {
        switch ($item->name) {
            case Item::ITEM_MJOLNIR:
                return 80;
            default:
                return 0;
        }
    }

    /**
     * @param Item $item
     * @return int
     */
    protected static function getMaxQuality(Item $item): int
    {
        switch ($item->name) {
            case Item::ITEM_MJOLNIR:
                return 80;
            default:
                return 50;
        }
    }
}
