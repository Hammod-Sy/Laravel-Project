<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Adjust this path according to your User model location

class RehashPasswords extends Command
{
    protected $signature = 'rehash:passwords';
    protected $description = 'Rehash passwords using Bcrypt algorithm';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch all users
        $users = User::all();

        foreach ($users as $user) {
            // Check if the password is already hashed
            if (!Hash::needsRehash($user->password)) {
                // Assuming passwords are stored as plain numbers
                $user->password = Hash::make($user->password);
                $user->save();
                $this->info("Password for user {$user->id} rehashed.");
            }
        }

        $this->info('All passwords rehashed successfully.');
    }
}
