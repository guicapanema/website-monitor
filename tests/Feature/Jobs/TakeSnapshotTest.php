<?php

namespace Tests\Feature\Jobs;

use App\Jobs\TakeSnapshot;
use App\Models\Snapshot;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TakeSnapshotTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->website = Website::factory()
             ->has(Snapshot::factory()->count(1))
             ->create();
    }

    /** @test */
    public function creates_snapshot_when_content_has_changed()
    {
        $content = $this->faker->randomHtml();

        Http::fake([
            $this->website->url => Http::response($content, 200),
        ]);

        TakeSnapshot::dispatchSync($this->website);

        $this->assertCount(2, $this->website->snapshots);
        $this->assertEquals($this->website->latestSnapshot->content, $content);
    }

    /** @test */
    function does_not_create_snapshot_when_content_has_not_changed()
    {
        $content = $this->website->latestSnapshot->content;

        Http::fake([
            $this->website->url => Http::response($content, 200),
        ]);

        TakeSnapshot::dispatchSync($this->website);

        $this->assertCount(1, $this->website->snapshots);
    }
}
