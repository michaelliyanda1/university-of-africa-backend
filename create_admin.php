<?php
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::create([
    'name' => 'Michael Admin',
    'email' => 'michael@keystoneuoa.com',
    'password' => \Illuminate\Support\Facades\Hash::make('805011Mic'),
    'role' => 'admin',
    'is_active' => true,
]);

echo "Admin user created successfully!\n";
echo "Email: michael@keystoneuoa.com\n";
echo "Password: 805011Mic\n";
echo "User ID: " . $user->id . "\n";
