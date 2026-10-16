<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

#[Signature('make:admin {--name= : Nama lengkap admin} {--email= : Email admin} {--password= : Password admin}')]
#[Description('Membuat akun administrator pertama untuk sistem JOGO Kopi secara aman')]
class CreateAdminCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('=== Pembuatan Akun Administrator JOGO Kopi ===');

        $name = $this->option('name') ?: $this->ask('Masukkan Nama Admin', 'Admin JOGO Kopi');
        $email = $this->option('email') ?: $this->ask('Masukkan Email Admin', 'admin@jogokopi.com');
        $password = $this->option('password') ?: $this->secret('Masukkan Password Admin (minimal 8 karakter)');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return self::FAILURE;
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->isAdmin()) {
                $this->warn("User dengan email {$email} sudah ada dan sudah berstatus Admin.");
                if ($this->confirm('Apakah Anda ingin memperbarui passwordnya?')) {
                    $user->password = Hash::make($password);
                    $user->save();
                    $this->info("Password untuk Admin {$email} berhasil diperbarui.");
                }
                return self::SUCCESS;
            }

            if ($this->confirm("User dengan email {$email} sudah ada. Ingin mengubah rolenya menjadi Admin?")) {
                $user->role = 'admin';
                $user->password = Hash::make($password);
                $user->save();
                $this->info("Role user {$email} berhasil diubah menjadi Administrator.");
                return self::SUCCESS;
            }

            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->info("Akun Administrator {$email} berhasil dibuat!");
        return self::SUCCESS;
    }
}
