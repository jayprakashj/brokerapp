<x-mail::message>
# Hello team.

You have received the notification for the new lead <b>{{ $lead->title }}</b>

Customer details:
<x-mail::table>
|                   |                                   |
|:-----------------:|:---------------------------------:|
|   Customer Name   | {{ $lead->customer_name }}        |
|Customer Mobile    |  {{ $lead->customer_mobile }}     |
|Customer Email     |   {{ $lead->customer_email }}     |
|Customer City      | {{ $lead->customer_city }}        |
|Lead Source        |  {{ $lead->lead_source }}         |
|Interest In        |  {{ $lead->interest_in ?? '-' }}  |
|Budget             |   {{ $lead->budget ?? '-' }}      |
|Purpose            |  {{ $lead->purpose ?? '-' }}      |
</x-mail::table>

<x-mail::button :url="route('vue_app', [ 'lead', 'view', $lead->id])">
View in Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
