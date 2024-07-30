<x-mail::message>
# Hello, {{ $user->first_name }}

An account has been created for you so that you can make use of the {{ config('app.name') }} application.

Your username is: <strong>{{ $user->username }}</strong>

Please click the button below to set your password.

<x-mail::button :url="$link">
Set password
</x-mail::button>

If the button does not work, copy and paste the following link into your browser:

{{ $link }}

Do not reply to this email. This account is not monitored.
</x-mail::message>
