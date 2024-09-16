<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Item;

class ImportItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import items from external API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://api.restful-api.dev/objects');
        $items = $response->json();

        foreach ($items as $itemData) {
            $item = Item::firstOrNew(['name' => $itemData['name']]);
            $item->sell_in = $itemData['sell_in'] ?? 0;
            $item->quality = $itemData['quality'] ?? 0;
            $item->save();
        }

        $this->info('Items imported successfully.');
    }
}
