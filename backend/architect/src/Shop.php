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
            $this->updateItemQuality($item);
            $this->updateItemSellIn($item);
        }
    }

    /**
     * @param Item $item
     * @return void
     */
    private function updateItemQuality(Item $item): void
    {
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
    }

    /**
     * @param Item $item
     * @return void
     */
    private function updateBlueCheeseQuality(Item $item): void
    {
        $item->quality = ($item->sell_in > 0) ? $item->quality + 1 : $item->quality + 2;
    }

    /**
     * @param Item $item
     * @return void
     */
    private function updateMjolnirQuality(Item $item): void
    {
        $item->quality = 80;
    }

    /**
     * @param Item $item
     * @return void
     */
    private function updateTicketQuality(Item $item): void
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
    private function updateMagicQuality(Item $item): void
    {
        $item->quality -= ($item->sell_in > 0) ? 2 : 4;
    }

    /**
     * @param Item $item
     * @return void
     */
    private function updateDefaultQuality(Item $item): void
    {
        $item->quality -= ($item->sell_in > 0) ? 1 : 2;
    }

    /**
     * @param Item $item
     * @return void
     */
    private function updateItemSellIn(Item $item): void
    {
        if (!in_array($item->name, $this->exceptUpdatingSellIn())) {
            $item->sell_in--;
        }
    }

    /**
     * @return array
     */
    private function exceptUpdatingSellIn(): array
    {
        return [
            Item::ITEM_MJOLNIR
        ];
    }

    /**
     * @param Item $item
     * @return void
     */
    private function checkQualityScopes(Item $item): void
    {
        $minQuality = $this->getMinQuality($item);
        $maxQuality = $this->getMaxQuality($item);

        $item->quality = max($minQuality, min($maxQuality, $item->quality));
    }

    /**
     * @param Item $item
     * @return int
     */
    private function getMinQuality(Item $item): int
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
    private function getMaxQuality(Item $item): int
    {
        switch ($item->name) {
            case Item::ITEM_MJOLNIR:
                return 80;
            default:
                return 50;
        }
    }
}
