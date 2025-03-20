

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Dashboard') }}</span>
                        <form action="{{ route('movies.search') }}" method="GET" class="d-flex">
                            <input type="text" name="title" class="form-control me-2" placeholder="Search movies..." required>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>

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

                    <h2>Your Favorite Movies</h2>

                    @if ($favoriteMovies->count() > 0)
                        <div class="row">
                            @foreach ($favoriteMovies as $movie)
                                <div class="col-md-3 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ $movie->poster_url !== 'N/A' ? $movie->poster_url : 'https://via.placeholder.com/300x450?text=No+Poster' }}" 
                                            class="card-img-top" alt="{{ $movie->movie_title }}" style="height: 300px; object-fit: cover;">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $movie->movie_title }}</h5>
                                            <div class="mt-auto">
                                                <a href="{{ route('movies.details', $movie->movie_id) }}" class="btn btn-info btn-sm">Details</a>
                                                <form action="{{ route('favorites.remove', $movie->movie_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            You haven't added any favorite movies yet. <a href="{{ route('movies.search') }}?title=star">Search for movies</a> to add them to your favorites!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection