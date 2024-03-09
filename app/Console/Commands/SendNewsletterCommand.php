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
    protected $signature = 'send:newsletter {emails?*}';

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

        $builder = User::query();

        if ($emails) {
            $builder->whereIn('email', $emails);
        }

        $count = $builder->count();

        if ($count) {
            $this->output->progressStart();

            $builder->whereNotNull('email_verified_at')
                    ->each(function (User $user) {
                        $user->notify(new NewsletterNotification);
                        $this->output->progressAdvance();
                    });

            $count = $builder->count();
            $this->output->progressFinish();
        }

        $this->info($count ? "Se enviaron {$count} correos." : "No se envió ningún correo.");
    }
}
