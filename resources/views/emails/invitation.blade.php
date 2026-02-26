<x-mail::message>
# Invitation à rejoindre une colocation

Bonjour,

Vous avez été invité à rejoindre la colocation **{{ $invitation->colocation->name }}** sur **EasyColoc**.

Pour accepter l'invitation, cliquez sur le bouton ci-dessous :

<x-mail::button :url="route('invitations.choose', ['token' => $invitation->token])">
Accepter l'invitation
</x-mail::button>

Si vous n'avez pas de compte, vous devrez en créer un avec cette adresse email ({{ $invitation->email }}) pour pouvoir rejoindre.

Si vous souhaitez refuser cette invitation, vous pouvez cliquer ici :
[Refuser l'invitation]({{ route('invitations.refuse', ['token' => $invitation->token]) }})

Cette invitation expirera le {{ $invitation->expires_at->format('d/m/Y à H:i') }}.

Merci,<br>
L'équipe {{ config('app.name') }}
</x-mail::message>
