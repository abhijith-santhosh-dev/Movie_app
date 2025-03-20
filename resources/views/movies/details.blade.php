@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Movie Details') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450?text=No+Poster' }}" 
                                class="img-fluid" alt="{{ $movie['Title'] }}">
                            
                            <div class="mt-3">
                                @if (!$isFavorite)
                                    <form action="{{ route('favorites.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="movie_id" value="{{ $movie['imdbID'] }}">
                                        <input type="hidden" name="movie_title" value="{{ $movie['Title'] }}">
                                        <input type="hidden" name="poster_url" value="{{ $movie['Poster'] }}">
                                        <button type="submit" class="btn btn-success">Add to Favorites</button>
                                    </form>
                                @else
                                    <form action="{{ route('favorites.remove', $movie['imdbID']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remove from Favorites</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h1>{{ $movie['Title'] }} ({{ $movie['Year'] }})</h1>
                            
                            <div class="movie-info">
                                <p><strong>Released:</strong> {{ $movie['Released'] }}</p>
                                <p><strong>Runtime:</strong> {{ $movie['Runtime'] }}</p>
                                <p><strong>Genre:</strong> {{ $movie['Genre'] }}</p>
                                <p><strong>Director:</strong> {{ $movie['Director'] }}</p>
                                <p><strong>Writer:</strong> {{ $movie['Writer'] }}</p>
                                <p><strong>Actors:</strong> {{ $movie['Actors'] }}</p>
                                <p><strong>Plot:</strong> {{ $movie['Plot'] }}</p>
                                <p><strong>Language:</strong> {{ $movie['Language'] }}</p>
                                <p><strong>Country:</strong> {{ $movie['Country'] }}</p>
                                <p><strong>Awards:</strong> {{ $movie['Awards'] }}</p>
                                
                                @if (isset($movie['Ratings']) && count($movie['Ratings']) > 0)
                                    <h4>Ratings</h4>
                                    <ul class="list-group mb-3">
                                        @foreach ($movie['Ratings'] as $rating)
                                            <li class="list-group-item">
                                                <strong>{{ $rating['Source'] }}:</strong> {{ $rating['Value'] }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection