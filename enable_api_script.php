<?php
try {
    Botble\Setting\Facades\Setting::set('api_enabled', 1);
    Botble\Setting\Facades\Setting::save();
    echo "API enabled successfully\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
