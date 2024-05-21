@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifique sua caixa de entrada') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('O link de verificação foi enviado para seu endereço de email.') }}
                        </div>
                    @endif

                    {{ __('Antes de continuar, por favor verifique sua caixa de entrada para ver o lind de verificação.') }}
                    {{ __('Se você não recebeu o email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Clique aqui para reenviar') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
