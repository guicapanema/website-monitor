<?php

namespace Tests\Feature\Models;

use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    function get_base_url_attribute_returns_base_url()
    {
        $url = 'http://' . $this->faker->domainName();

        $website = Website::factory()->create([
            'url' => $url . '/test?test=test&test2=test2',
        ]);

        $this->assertEquals($url, $website->base_url);
    }
}
