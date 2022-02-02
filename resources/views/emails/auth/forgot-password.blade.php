@component('mail::message')
# Hello {{ $user->name }},

Your verification key: {{ $user->verification_key }}
<br>
Click on the following button to reset your password

{{-- @component('mail::button', ['url' => url('/password-reset?referral=' . $user->slug )]) --}}
@component('mail::button', ['url' => 'http://localhost:8080/password-reset?referral=' . $user->slug])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
