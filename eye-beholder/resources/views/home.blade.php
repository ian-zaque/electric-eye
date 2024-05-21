@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <app-container :user="{{$user}}" />
    </div>
</div>
@endsection

