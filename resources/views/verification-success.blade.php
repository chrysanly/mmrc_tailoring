@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<h1>Your email has been verified successfully!</h1>
<h1>You may Close this window</h1>