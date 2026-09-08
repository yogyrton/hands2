<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoogleAdsTagTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_ads_tag_and_conversion_render_when_configured(): void
    {
        Setting::query()->updateOrCreate(['key' => 'google_ads_id'], ['value' => 'AW-18436540373']);
        Setting::query()->updateOrCreate(['key' => 'google_ads_conversion_label'], ['value' => 'SNklCLbN1fAcENWPnddE']);

        $this->get('/')
            ->assertOk()
            ->assertSee('googletagmanager.com/gtag/js?id=AW-18436540373', false)
            ->assertSee('gtag(\'config\', "AW-18436540373")', false)
            ->assertSee('AW-18436540373\/SNklCLbN1fAcENWPnddE', false)
            ->assertSee('yclients', false);
    }

    public function test_no_tag_when_not_configured(): void
    {
        Setting::query()->where('key', 'google_ads_id')->delete();

        $this->get('/')
            ->assertOk()
            ->assertDontSee('googletagmanager.com/gtag/js', false);
    }

    public function test_base_tag_without_conversion_label(): void
    {
        Setting::query()->updateOrCreate(['key' => 'google_ads_id'], ['value' => 'AW-18436540373']);
        Setting::query()->where('key', 'google_ads_conversion_label')->delete();

        $this->get('/')
            ->assertOk()
            ->assertSee('googletagmanager.com/gtag/js?id=AW-18436540373', false)
            ->assertDontSee('\'conversion\'', false);
    }
}
