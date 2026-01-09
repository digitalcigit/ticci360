<?php

use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Setting\Facades\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;

return new class () extends Migration {
    public function up(): void
    {
        if (get_ecommerce_setting('make_phone_field_at_the_checkout_optional')) {
            Setting::set(
                'ecommerce_mandatory_form_fields_at_checkout',
                json_encode(array_keys(Arr::except(EcommerceHelper::getMandatoryFieldsAtCheckout(), 'phone')))
            );
        }

        Setting::save();
    }

    public function down(): void
    {
        Setting::set(
            'ecommerce_make_phone_field_at_the_checkout_optional',
            ! in_array('phone', EcommerceHelper::getEnabledMandatoryFieldsAtCheckout())
        )->save();
    }
};
