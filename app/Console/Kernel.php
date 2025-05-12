<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Di App\Console\Kernel.php
        $schedule->call(function () {
            $pelanggan = Pelanggan::where('layanan', 'Internet')->get();
            foreach ($pelanggan as $p) {
                PengingatTagihan::create([
                    'pelanggan_id' => $p->id,
                    'layanan_id' => 1, // ID Internet
                    'tanggal_jatuh_tempo' => now()->addDays(30),
                ]);
            }
        })->monthly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
