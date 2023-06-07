@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Tickets') }}</div>

                    <div class="card-group m-auto">
                        @foreach ($tickets as $ticket)
                            <div class="card m-3" style="width: 18rem;">
                                <img class="card-img-top"  src="{{ url('storage/' . $ticket->image) }}"
                                    alt="Card image cap">
                                <div class="card-body">
                                    <p class="card-text">{{ $ticket->name }}</p>
                                    <form action="{{ route('show_ticket', $ticket) }}" method="get">
                                        <button type="submit" class="btn btn-primary">Show detail</button>
                                    </form>
                                    @if (Auth::check() && Auth::user()->is_admin)
                                        <form action="{{ route('delete_ticket', $ticket) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger mt-2">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection