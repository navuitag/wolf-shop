<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item;
use App\Services\InventoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateQualityTest extends TestCase
{
    use RefreshDatabase;

    protected $inventoryService;

    /**
     * Initializes the InventoryService before each test.
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->inventoryService = new InventoryService();
    }

    /**
     * Tests that a normal item’s sell_in and quality decrease by 1 before the sell-in date.
     * @return void
     */
    public function test_normal_item_before_sell_in_date()
    {
        $item = Item::create(['name' => 'Normal Item', 'sell_in' => 10, 'quality' => 20]);

        $this->inventoryService->updateQuality();

        $item->refresh();
        $this->assertEquals(9, $item->sell_in);
        $this->assertEquals(19, $item->quality);
    }

    /**
     * Tests that a normal item’s quality decreases by 2 after the sell-in date.
     * @return void
     */
    public function test_normal_item_after_sell_in_date()
    {
        $item = Item::create(['name' => 'Normal Item', 'sell_in' => 0, 'quality' => 20]);

        $this->inventoryService->updateQuality();

        $item->refresh();
        $this->assertEquals(-1, $item->sell_in);
        $this->assertEquals(18, $item->quality);
    }

    /**
     * Ensures that the quality of an item never goes negative.
     * @return void
     */
    public function test_quality_never_negative()
    {
        $item = Item::create(['name' => 'Normal Item', 'sell_in' => 10, 'quality' => 0]);

        $this->inventoryService->updateQuality();

        $item->refresh();
        $this->assertEquals(9, $item->sell_in);
        $this->assertEquals(0, $item->quality);
    }

    /**
     * Verifies that “Apple AirPods” quality increases as it ages.
     * @return void
     */
    public function test_apple_airpods_quality_increases()
    {
        $item = Item::create(['name' => 'Apple AirPods', 'sell_in' => 10, 'quality' => 20]);

        $this->inventoryService->updateQuality();

        $item->refresh();
        $this->assertEquals(9, $item->sell_in);
        $this->assertEquals(21, $item->quality);
    }

    /**
     * Ensures that the quality of an item never exceeds 50.
     * @return void
     */
    public function test_quality_never_more_than_50()
    {
        $item = Item::create(['name' => 'Apple AirPods', 'sell_in' => 10, 'quality' => 50]);

        $this->inventoryService->updateQuality();

        $item->refresh();
        $this->assertEquals(9, $item->sell_in);
        $this->assertEquals(50, $item->quality);
    }

    /**
     * Verifies that “Samsung Galaxy S23” quality remains constant.
     * @return void
     */
    public function test_samsung_galaxy_s23_quality_constant()
    {
        $item = Item::create(['name' => 'Samsung Galaxy S23', 'sell_in' => 10, 'quality' => 80]);

        $this->inventoryService->updateQuality();

        $item->refresh();
        $this->assertEquals(10, $item->sell_in);
        $this->assertEquals(80, $item->quality);
    }

    /**
     * Tests that “Apple iPad Air” quality increases by 2 when there are 10 days or less.
     * @return void
     */
    public function test_apple_ipad_air_quality_increases()
    {
        $item = Item::create(['name' => 'Apple iPad Air', 'sell_in' => 10, 'quality' => 20]);

        $this->inventoryService->updateQuality();

        $item->refresh();
        $this->assertEquals(9, $item->sell_in);
        $this->assertEquals(22, $item->quality);
    }

    /**
     * Ensures that “Xiaomi Redmi Note 13” degrades twice as fast.
     * @return void
     */
    public function test_xiaomi_redmi_note_13_degrades_twice_as_fast()
    {
        $item = Item::create(['name' => 'Xiaomi Redmi Note 13', 'sell_in' => 10, 'quality' => 20]);

        $this->inventoryService->updateQuality();

        $item->refresh();
        $this->assertEquals(9, $item->sell_in);
        $this->assertEquals(18, $item->quality);
    }

    /**
     * Verifies that “Apple iPad Air” quality drops to 0 after the concert.
     * @return void
     */
    public function test_apple_ipad_air_quality_drops_to_0_after_concert()
    {
        $item = Item::create(['name' => 'Apple iPad Air', 'sell_in' => 0, 'quality' => 20]);

        $this->inventoryService->updateQuality();

        $item->refresh();
        $this->assertEquals(-1, $item->sell_in);
        $this->assertEquals(0, $item->quality);
    }

    /**
     * Ensures that normal items degrade twice as fast after the sell-in date.
     * @return void
     */
    public function test_quality_degrades_twice_as_fast_after_sell_in_date()
    {
        $item = Item::create(['name' => 'Normal Item', 'sell_in' => 0, 'quality' => 20]);

        $this->inventoryService->updateQuality();

        $item->refresh();
        $this->assertEquals(-1, $item->sell_in);
        $this->assertEquals(18, $item->quality);
    }
}
