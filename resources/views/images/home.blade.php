@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                {{ __('All Images') }}
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('upload.local') }}" class="btn btn-link float-right">Upload Local</a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('upload.remote') }}" class="btn btn-link float-right">Upload Remote</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @forelse($images as $img)
                            <div class="card">
                                <div class="card-header">
                                    <p>Uploaded by: {{$img->uploaded_by}}</p>
                                    <p>Available since: {{$img->available_at}}</p>
                                </div>

                                <div class="card-body m-auto">
                                    <img width="100%"
                                         height="100%"
                                         src="{{ URL::asset('images/' . $img->id) }}">
                                </div>
                            </div>
                            <br>
                        @empty
                            <div class="alert">
                                <p>No images exist.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="m-auto">
                        {{$images->links('pagination::bootstrap-4')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
