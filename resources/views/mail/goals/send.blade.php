@component('mail::message')
# Hey there Geek Runner,

You still need to complete these goals:

{{ $calcs['duration_progress'] < 100 ?  "1. Duration: " . $calcs['duration_progress'] . " % completed" : "" }}
{{ $calcs['distance_progress'] < 100 ?  "2. Distance: " . $calcs['distance_progress'] . " % completed" : "" }}
{{ $calcs['frequency_progress'] < 100 ?  "3. Frequency: " . $calcs['frequency_progress'] . " % completed" : "" }}

Check it out.

@component('mail::button', ['url' => env('APP_URL'))])
Keep Running
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
