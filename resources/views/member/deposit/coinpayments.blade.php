@extends('layouts.member')
@section('content')
    <form action="https://www.coinpayments.net/index.php" method="post" id="coinpayments_form" name="coinpayments_form">
    @foreach($formData as $key => $val)
        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
    @endforeach
    </form>
    <script>
        window.onload = document.coinpayments_form.submit();
    </script>
@endsection