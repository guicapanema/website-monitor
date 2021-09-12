<?php

namespace App\Jobs;

use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class TakeSnapshot implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $website;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::get($this->website->url);
        $response->throw();

        $newContent = $response->body();
        if (! $this->hasContentChanged($newContent)) {
            return;
        }

        return $this->website->snapshots()->create([
            'content' => $newContent,
        ]);
    }

    protected function hasContentChanged($newContent)
    {
        $latestContent = $this->website->latestSnapshot?->content;

        return $newContent !== $latestContent;
    }
}