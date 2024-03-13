<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\NewsletterNotification;
use Illuminate\Support\Carbon;

class SendReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder
                            {emails?* : Correos a los que se debe enviar directamente.}
                            {--s|schedule : Opción para saber si se debe ejecutar directamente o no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un recordatorio a los usuarios que no han confirmado su correo electrónico.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emails = $this->argument('emails');
        $schedule = $this->option('schedule');

        $builder = User::query();

        if ($emails) {
            $builder->whereIn('email', $emails);
        }

        $builder->whereNull('email_verified_at')
        ->whereDate('created_at', '<=', Carbon::now()->subWeek());

        $count = $builder->count();

        if ($count) {
            $this->info("Se enviarán $count correos.");

            if ($this->confirm("¿Está de acuerdo?") || $schedule) {
                $this->output->progressStart();

                $builder->each(function(User $user) {
                    $user->notify(new NewsletterNotification);
                    $this->output->progressAdvance();
                });

                $this->output->progressFinish();
                $this->info("Se enviaron los correos con éxito.");
            } else {
                $this->info("No se envió ningún correo.");
            }
        } else {
            $this->info("No se envió ningún correo.");
        }
    }
}
