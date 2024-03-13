<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendNewsletterCommand;
use App\Console\Commands\SendReminderCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('send:newsletter')
        ->evenInMaintenanceMode() // Ejecutar el comando aunque la app esté en modo mantenimiento (php artisan down)
        ->sendOutputTo(storage_path(storage_path('newsletter.log'))) // Guardar logs en una carpeta específica
        ->everyMinute();

        $schedule->command('send:reminder')
        ->withoutOverlapping() // Que si ya se está ejecutando el comando no se sobreescriba
        ->onOneServer() // Por si la aplicación se ejecuta en más de un servidor, que solo se ejecute en uno de ellos
        ->everyTwoMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
