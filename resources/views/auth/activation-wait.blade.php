<x-guest-layout>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="mt-4 text-center">
        <p>Estamos esperando que verifiques tu correo electrónico.</p>
        <form method="POST" action="{{ route('activation.resend') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                Reenviar correo de activación
            </button>
        </form>
    </div>
</x-guest-layout>
