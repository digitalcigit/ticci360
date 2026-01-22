<?php

use Botble\Setting\Facades\Setting;
use Illuminate\Database\Migrations\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Setting::set(['ecommerce_api_layer_api_key' => setting('ecommerce_currencies_api_key')]);
    }

    public function down(): void
    {
        Setting::set(['ecommerce_currencies_api_key' => setting('ecommerce_api_layer_api_key')]);
    }
};
