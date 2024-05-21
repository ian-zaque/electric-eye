@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <app-user :user="{{$user}}" />
    </div>
</div>
@endsection

