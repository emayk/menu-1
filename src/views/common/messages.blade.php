@if (count($errors))
    <p class="errors">
        @foreach ($errors->all() as $msg)
            {{ $msg }}
        @endforeach
@endif
@if (Session::has('errormsg'))
    <p class="errors">
        {{ Session::get('errormsg') }}
    </p>
@endif
@if (Session::has('message'))
    <p class="messages">
        {{ Session::get('message') }}
    </p>
@endif
