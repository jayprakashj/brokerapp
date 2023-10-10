<x-mail::message>
# Hello team.

You have received the notification for the Property: <b>{{ $property->name }}</b>

@if( $property->notification_message )

{{ $property->notification_message }}

@endif

About Property:
<x-mail::table>
|                           |                                           |
|:-----------------:        |:---------------------------------:        |
|   Property Name           | {{ $property->name }}                     |
|   Property Type           | {{ $property->property_type }}            |
|   Property Transaction    | {{ $property->property_transaction }}     |
|  Address                  | {{ $property->address ?? '-' }}           |
|  City                     | {{ $property->city ?? '-' }}              |
|  Suitable For             | {{ $property->suitable_for ?? '-' }}      |
|  Price                    | {{ $property->price ?? '-' }}             |
|  Lease Period             | {{ $property->lease_period ?? '-' }}      |
|  Lease Expiry Date        | {{ $property->lease_expiry_date ?? '-' }} |

</x-mail::table>

<x-mail::button :url="route('vue_app', [ 'property', 'view', $property->id])">
View in Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
