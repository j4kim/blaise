<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config("logging.log_db_queries")) {
            DB::listen(function (QueryExecuted $query) {
                $log = log10($query->time) + 1;
                $magnitude = $log < 0 ? 0 : round($log);
                $warnChars = str_pad(str_repeat(">", $magnitude), 5, " ");
                $seconds = number_format($query->time / 1000, 3);
                $sql = $query->toRawSql();
                Log::channel("db")->info(
                    "$warnChars ($seconds) | $sql"
                );
            });
        }
    }
}
