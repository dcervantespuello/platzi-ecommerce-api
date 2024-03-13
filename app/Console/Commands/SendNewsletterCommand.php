<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use \App\Notifications\NewsletterNotification;

class SendNewsletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter
                            {emails?* : Correos Electronicos a los cuales enviar directamente}
                            {--s|schedule : Si debe ser ejecutado directamente o no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un correo electrónico.';

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

        $builder->whereNotNull('email_verified_at');
        $count = $builder->count();

        if ($count) {
            $this->info("Se enviarán $count correos.");

            if ($this->confirm('¿Estás de acuerdo?') || $schedule) {
                $this->output->progressStart();

                $builder->each(function (User $user) {
                            $user->notify(new NewsletterNotification);
                            $this->output->progressAdvance();
                        });

                $this->output->progressFinish();
                $this->info("Correos enviados con éxito.");
            } else {
                $this->info("No se envió ningún correo.");
            }
        } else {
            $this->info("No se envió ningún correo.");
        }
    }
}
