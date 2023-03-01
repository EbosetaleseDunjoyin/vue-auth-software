<h1>Mazer Email Verification Mail</h1>
  
Please verify your email with bellow link: 
<a href="{{ env('FRONTEND_URL')/$token }}">Verify Email</a><br>

Or use this token {{ $token }}