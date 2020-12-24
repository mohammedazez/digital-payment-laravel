@extends('layouts.member')
@section('content')
    <form action="https://www.paypal.com/cgi-bin/webscr" method="POST" id="form" name="form">
    @foreach($formData as $key => $val)
        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
    @endforeach
    </form>
    <script>
        window.onload = document.form.submit();
    </script>
@endsection