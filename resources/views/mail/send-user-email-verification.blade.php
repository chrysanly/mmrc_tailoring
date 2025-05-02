<p>Hello {{ $user->email }},</p>
<p>Click the link below to verify your email:</p>
<a href="{{ URL::signedRoute('verify.email', ['user' => $user, 'token' => $user->verification_token]) }}">Verify Email</a>