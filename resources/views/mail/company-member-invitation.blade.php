<x-mail::message>
# Invitation.

You have requested to join the company <b>{{ $companyMember->company->name ?? ''}}</b> from the <b>{{ $companyMember->createdUser->name ?? ''}}</b>.

If you want to accept or join the requested company then click the below link.

<x-mail::button :url="route('member.view_invitation', ['token' => $companyMember->token ])">
Accept Invitation
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
