<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
Botble\Setting\Facades\Setting::set('api_enabled', 1)->save();
echo 'API enabled successfully';
