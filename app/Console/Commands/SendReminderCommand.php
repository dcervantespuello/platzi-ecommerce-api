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
    protected $signature = 'send:reminder {emails?*}';

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

        $builder = User::query();

        if ($emails) {
            $builder->whereIn('email', $emails);
        }

        $count = $builder->count();

        if ($count) {
            $this->output->progressStart();

            $builder->whereNull('email_verified_at')
            ->whereDate('created_at', '<', Carbon::now()->subWeek())
            ->each(function(User $user) {
                $user->notify(new NewsletterNotification);
                $this->output->progressAdvance();
            });

            $count = $builder->count();
            $this->output->progressFinish();
        }

        $this->info($count ? "Se enviaron {$count} correos." : "No se envió ningún correo.");
    }
}
