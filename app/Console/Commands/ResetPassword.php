<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for user identified by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::firstWhere('email', $this->argument('email'));

        $user->password = Hash::make($this->argument('password'));

        $user->save();

        $this->info("Password reset for user $user->name");
    }
}
