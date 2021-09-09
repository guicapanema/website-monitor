<?php

namespace App\Console\Commands;

use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TakeSnapshot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snapshot:take {website}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Take a new snapshot of a website';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $website = Website::find($this->argument('website'));

        if (! $website) {
            $this->error('Could not find website');

            return 1;
        }

        $response = Http::get($website->url);

        if (! $response->successful()) {
            $this->error('Could not fetch website');

            return 1;
        }

        $latestSnapshotContent = $website->latestSnapshot?->content;

        if ($response->body() === $latestSnapshotContent) {
            $this->error('Content hasn\'t changed');

            return 0;
        }

        $website->snapshots()->create([
            'content' => $response->body(),
        ]);

        return 0;
    }
}
