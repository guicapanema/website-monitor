<?php

namespace App\Jobs;

use App\Models\Website;
use DOMDocument;
use DOMNode;
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
        $response = Http::accept('text/html')->get($this->website->url);
        $response->throw();

        $newContent = mb_convert_encoding($response->body(), 'UTF-8');
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

        return $this->getCleanBody($newContent) !== $this->getCleanBody($latestContent);
    }

    protected function getCleanBody($content)
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        @$dom->loadHTML($content);

        $body = $dom->getElementsByTagName('body')->item(0);

        $this->removeElements($body, [
            'script',
            'noscript',
            'link'
        ]);

        return $dom->saveHTML($body);
    }

    protected function removeElements(&$dom, $tagNames)
    {
        if (! is_array($tagNames)) {
            $tagNames = [$tagNames];
        }

        foreach ($tagNames as $tagName) {
            $elements = $dom->getElementsByTagName($tagName);

            for ($i = ($elements->length - 1); $i >= 0; $i--) {
                $element = $elements->item($i);
                $element->parentNode->removeChild($element);
            }
        }
    }
}
