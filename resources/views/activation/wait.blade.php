<!-- resources/views/activation/wait.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Activation Pending</h1>
    <p>Your account is almost ready. Please check your email and click the activation link to complete your registration.</p>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('activation.resend') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Resend Activation Email</button>
    </form>
</div>
@endsection
