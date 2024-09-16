<?php

namespace App\Services;

use App\Models\Item;
class InventoryService
{
    /**
     * Handle the inventory function
     * @return void
     */
    public function updateQuality()
    {
        $items = Item::all();

        foreach ($items as $item) {
            if ($item->name != 'Samsung Galaxy S23') {
                if ($item->sell_in > 0) {
                    $this->updateNormalItem($item);
                } else {
                    $this->updateExpiredItem($item);
                }
            }
        }
    }

    private function updateNormalItem($item)
    {
        if ($item->name == 'Apple AirPods' || $item->name == 'Apple iPad Air') {
            $this->increaseQuality($item);
        } else {
            $this->decreaseQuality($item);
        }

        if ($item->name == 'Xiaomi Redmi Note 13') {
            $this->decreaseQuality($item);
        }

        $item->sell_in -= 1;
        $item->save();
    }

    private function updateExpiredItem($item)
    {
        if ($item->name == 'Apple AirPods') {
            $this->increaseQuality($item);
        } elseif ($item->name == 'Apple iPad Air') {
            $item->quality = 0;
        } else {
            $this->decreaseQuality($item);
            $this->decreaseQuality($item);
        }

        if ($item->name == 'Xiaomi Redmi Note 13') {
            $this->decreaseQuality($item);
            $this->decreaseQuality($item);
        }

        $item->sell_in -= 1;
        $item->save();
    }

    private function increaseQuality($item)
    {
        if ($item->quality < 50) {
            $item->quality += 1;

            if ($item->name == 'Apple iPad Air') {
                if ($item->sell_in <= 10) {
                    $item->quality += 1;
                }
                if ($item->sell_in <= 5) {
                    $item->quality += 1;
                }
            }
        }
    }

    private function decreaseQuality($item)
    {
        if ($item->quality > 0) {
            $item->quality -= 1;
        }
    }
}
