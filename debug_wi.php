<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\wi;

$wi = wi::latest()->first();
if ($wi) {
    echo "ID: " . $wi->id . "\n";
    echo "File: " . $wi->file . "\n";
    echo "Video: " . $wi->video . "\n";
} else {
    echo "No WI found.\n";
}
