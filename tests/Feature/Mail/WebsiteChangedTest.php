<?php

namespace Tests\Feature\Mail;

use App\Mail\WebsiteChanged;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteChangedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_contains_website_name_and_url()
    {
        $this->website = Website::factory()->create();

        $mailable = new WebsiteChanged($this->website);
        $mailable->assertSeeInHtml($this->website->name);
        $mailable->assertSeeInHtml($this->website->url);
    }
}
