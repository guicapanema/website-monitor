<?php

namespace Tests\Feature\Models;

use App\Mail\WebsiteChanged;
use App\Models\Snapshot;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SnapshotTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function notifies_user_when_snapshot_is_created()
    {
        $website = Website::factory()
            ->has(Snapshot::factory()->count(1))
            ->create();

        Mail::fake();

        $snapshot = Snapshot::factory()
            ->for($website)
            ->create();

        Mail::assertQueued(WebsiteChanged::class, 1);
    }

    /** @test */
    function does_not_notify_user_when_first_snapshot_is_created()
    {
        $website = Website::factory()->create();

        Mail::fake();

        $snapshot = Snapshot::factory()
            ->for($website)
            ->create();

        Mail::assertNotQueued(WebsiteChanged::class, 1);
    }
}
