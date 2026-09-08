<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Подключение Google Рекламы: идентификатор тега и ярлык конверсии
     * «Отправка формы для потенциальных клиентов». Вставляем ключи только если
     * их ещё нет, чтобы не затереть возможные правки в админке.
     *
     * @var array<string, string>
     */
    private array $settings = [
        'google_ads_id' => 'AW-18436540373',
        'google_ads_conversion_label' => 'SNklCLbN1fAcENWPnddE',
    ];

    public function up(): void
    {
        foreach ($this->settings as $key => $value) {
            if (! DB::table('settings')->where('key', $key)->exists()) {
                DB::table('settings')->insert([
                    'key' => $key,
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', array_keys($this->settings))->delete();
    }
};
