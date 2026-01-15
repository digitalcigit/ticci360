<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('ec_product_categories');
    echo "Columns in ec_product_categories:\n";
    foreach ($columns as $column) {
        echo "- " . $column . "\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
