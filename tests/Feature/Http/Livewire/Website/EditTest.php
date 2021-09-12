<?php

namespace Tests\Feature\Http\Livewire\Website;

use App\Http\Livewire\Website\Edit;
use App\Models\User;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /** @test */
    public function can_create_website()
    {
        $this->assertCount(0, Website::all());

        $this->actingAs($this->user);

        Livewire::test(Edit::class)
            ->set('website.name', 'Sample website')
            ->set('website.url', 'https://test.website')
            ->call('save');

        $this->assertCount(1, Website::all());
    }

    /** @test */
    public function can_edit_website()
    {
        $this->actingAs($this->user);

        $website = Website::factory()->create();

        $this->assertCount(1, Website::all());

        Livewire::test(Edit::class, ['website' => $website])
            ->set('website.name', 'Sample website')
            ->set('website.url', 'https://test.website')
            ->call('save');

        $website->refresh();

        $this->assertCount(1, Website::all());
        $this->assertEquals('Sample website', $website->name);
        $this->assertEquals('https://test.website', $website->url);
    }
}
