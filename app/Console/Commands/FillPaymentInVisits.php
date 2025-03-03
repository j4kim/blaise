<?php

namespace App\Console\Commands;

use App\Merlin\Import;
use App\Models\Visit;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FillPaymentInVisits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fill-payment-in-visits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve payment method for each ticket in Merlin data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line("Fill payment in visits");

        $byCashIds = collect();
        $byCardIds = collect();
        new Import('CaisseLigPaiement.csv', function (array $row) use ($byCashIds, $byCardIds) {
            if ($row['IdCaisseMoyPaiement'] == '0') {
                $byCashIds->push(intval($row['IdCaisseTicket']));
            } else if ($row['IdCaisseMoyPaiement'] == '2') {
                $byCardIds->push(intval($row['IdCaisseTicket']));
            }
        });
        $byCardVisits = Visit::whereIn('id', $byCardIds);
        $byCashVisits = Visit::whereIn('id', $byCashIds);
        Visit::withoutTimestamps(fn() => $byCardVisits->update(['card_payment' => DB::raw('`billed`')]));
        Visit::withoutTimestamps(fn() => $byCashVisits->update(['cash_payment' => DB::raw('`billed`')]));
    }
}
