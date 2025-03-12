<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateStockStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-stock-status';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    protected $description = 'Update stock entries status to In-Stock when In-Stock date is today';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->toDateString();

        $updatedRows = DB::table('stock_entries')
            ->where('quantity', 0)
            ->where('status', '!=', 'Out-Of-Stock')
            ->update(['status' => 'Out-Of-Stock']);

        $this->info("Stock status updated for {$updatedRows} entries for Out-Of-Stock");

        $updatedRows = DB::table('stock_entries')
            ->whereDate('in_stock_date', $today)
            ->where('quantity', '!=' , 0)
            ->where('status', '!=', 'In-Stock')
            ->update(['status' => 'In-Stock']);

        $this->info("Stock status updated for {$updatedRows} entries for In-Stock.");

    }
}
