<?php
// In app/Console/Commands/UpdateExpiredVouchers.php

namespace App\Console\Commands;

use App\Models\Voucher;
use Illuminate\Console\Command;

class UpdateExpiredVouchers extends Command
{
    protected $signature = 'vouchers:update-expired';
    protected $description = 'Update status of expired vouchers';

    public function handle()
    {
        $updated = Voucher::where('status', 'active')
            ->whereNotNull('expiration_date')
            ->where('expiration_date', '<', now())
            ->update(['status' => 'expired']);

        $this->info("Updated {$updated} expired vouchers");
    }
}