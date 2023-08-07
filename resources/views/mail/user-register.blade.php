<x-mail::message>
# Thank you for joining with us.

You have successfully done registation with {{ config('app.name') }}.

You have to verify the email address by clicking the below button.

<x-mail::button :url="route('verify', ['email' => $user->email ])">
Verify
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
