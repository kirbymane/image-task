@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md">
                                {{ __('Upload Local Image') }}
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            {!! Form::open(['url' => route("store.local"), 'method' => 'post', 'files' => true]) !!}
                            {{ Form::token() }}

                            <div class="form-group">
                                {{ Form::file('path') }}

                                @error('path')
                                <p class="alert alert-danger">{{$errors->first('path')}}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                {{ Form::date('available_at', \Carbon\Carbon::now()) }}

                                @error('available_at')
                                <p class="alert alert-danger">{{$errors->first('available_at')}}</p>
                                @enderror
                            </div>

                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
