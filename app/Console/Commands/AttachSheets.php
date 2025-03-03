<?php

namespace App\Console\Commands;

use App\Merlin\Import;
use App\Merlin\Tools;
use App\Models\Sale;
use App\Models\TechnicalSheet;
use App\Models\Visit;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class AttachSheets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:attach-sheets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach technical sheets to visits';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line("Attach sheets");

        $sheets = TechnicalSheet::all();

        foreach ($sheets as $sheet) {
            $visit = Visit::where('client_id', $sheet->client_id)
                ->whereBetween('visit_date', [$sheet->created_at, $sheet->created_at->addDay()])
                ->whereHas('sales', fn($sale) => $sale->whereHas('service', fn($service) => $service->whereIn('service_category_id', [4, 6])))
                ->first();
            if (!$visit) {
                $this->warn("$sheet->id: No visits found. client id: $sheet->client_id");
                continue;
            }
            $this->info("$sheet->id: attach to visit $visit->id");
            $sheet->visit_id = $visit->id;
            $sheet->save();
        }
    }
}
