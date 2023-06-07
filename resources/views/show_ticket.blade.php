@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Ticket Detail') }}</div>

                    <div class="card-body">
                        <div class="d-flex justify-content-around">
                            <div class="">
                                <img src="{{ url('storage/' . $ticket->image) }}" alt="" width="200px">
                            </div>
                            <div class="">
                                <h1>{{ $ticket->name }}</h1>
                                <h2>{{ $ticket->description }}</h2>
                                <h3>Rp {{ $ticket->price }}</h3>
                                <hr>
                                <p>{{ $ticket->stock }} left</p>
                                @if(!Auth::user()->is_admin)
                                <form action="{{ route('add_to_cart', $ticket) }}" method="post">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="number" class="form-control" aria-describedby="basic-addon2" 
                                            name="amount" value=1>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit">Add to cart</button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <form action="{{ route('edit_ticket', $ticket) }}" method="get">
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            @endif
                                
                            </div>
                        </div>

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection