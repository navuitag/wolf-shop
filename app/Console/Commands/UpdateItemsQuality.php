<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\InventoryService;

class UpdateItemsQuality extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:update-quality';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the quality and sell_in values for all items';

    /**
     * The inventoryService object
     * @var
     */
    protected $inventoryService;

    /**
     * Summary of __construct
     * @param \App\Services\InventoryService $inventoryService
     */
    public function __construct(InventoryService $inventoryService)
    {
        parent::__construct();
        $this->inventoryService = $inventoryService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->inventoryService->updateQuality();
        $this->info('Items quality and sell_in values updated successfully.');
    }
}
