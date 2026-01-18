<?php

// Leadership Setup Script
// Run this script to create the leadership table and populate it with dummy data

echo "=== Leadership Management Setup ===\n\n";

// Step 1: Run migration
echo "Step 1: Running migration...\n";
try {
    $output = shell_exec('php artisan migrate --force');
    echo "Migration output:\n$output\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}

// Step 2: Run seeder
echo "\nStep 2: Running seeder...\n";
try {
    $output = shell_exec('php artisan db:seed --class=LeadershipItemSeeder');
    echo "Seeder output:\n$output\n";
} catch (Exception $e) {
    echo "Seeder failed: " . $e->getMessage() . "\n";
}

// Step 3: Link storage
echo "\nStep 3: Linking storage...\n";
try {
    $output = shell_exec('php artisan storage:link');
    echo "Storage link output:\n$output\n";
} catch (Exception $e) {
    echo "Storage link failed: " . $e->getMessage() . "\n";
}

echo "\n=== Setup Complete ===\n";
echo "You can now:\n";
echo "1. Access Leadership Management: http://localhost:3000/admin/leadership\n";
echo "2. View Leadership Page: http://localhost:3000/about/leadership\n";
echo "3. Upload images for each leader through the CMS\n";

?>
