@component('mail::message')
# Change detected in {{ $website->name }}

@component('mail::button', ['url' => $website->url])
Visit website
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
