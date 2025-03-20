@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Search Results') }}</span>
                        <form action="{{ route('movies.search') }}" method="GET" class="d-flex">
                            <input type="text" name="title" class="form-control me-2" placeholder="Search movies..." value="{{ $title ?? '' }}" required>
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

                    <h2>Search Results for "{{ $title }}"</h2>
                    
                    @if (isset($results['Search']) && count($results['Search']) > 0)
                        <div class="row">
                            @foreach ($results['Search'] as $movie)
                                <div class="col-md-3 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : 'https://via.placeholder.com/300x450?text=No+Poster' }}" 
                                            class="card-img-top" alt="{{ $movie['Title'] }}" style="height: 300px; object-fit: cover;">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $movie['Title'] }}</h5>
                                            <p class="card-text">{{ $movie['Year'] }}</p>
                                            <div class="mt-auto">
                                                <a href="{{ route('movies.details', $movie['imdbID']) }}" class="btn btn-info btn-sm">Details</a>
                                                
                                                @if (!in_array($movie['imdbID'], $favoriteMovies))
                                                    <form action="{{ route('favorites.add') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="movie_id" value="{{ $movie['imdbID'] }}">
                                                        <input type="hidden" name="movie_title" value="{{ $movie['Title'] }}">
                                                        <input type="hidden" name="poster_url" value="{{ $movie['Poster'] }}">
                                                        <button type="submit" class="btn btn-success btn-sm">Add to Favorites</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('favorites.remove', $movie['imdbID']) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Remove from Favorites</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if (isset($results['totalResults']) && $results['totalResults'] > 10)
                            <div class="d-flex justify-content-center mt-4">
                                <nav aria-label="Search results pages">
                                    <ul class="pagination">
                                        @if ($page > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ route('movies.search', ['title' => $title, 'page' => $page - 1]) }}">Previous</a>
                                            </li>
                                        @endif
                                        
                                        @php
                                            $totalPages = ceil($results['totalResults'] / 10);
                                            $maxPages = min($totalPages, 5);
                                            $startPage = max(1, min($page - 2, $totalPages - $maxPages + 1));
                                            $endPage = min($startPage + $maxPages - 1, $totalPages);
                                        @endphp

                                        @for ($i = $startPage; $i <= $endPage; $i++)
                                            <li class="page-item {{ $i == $page ? 'active' : '' }}">
                                                <a class="page-link" href="{{ route('movies.search', ['title' => $title, 'page' => $i]) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        @if ($page < $totalPages)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ route('movies.search', ['title' => $title, 'page' => $page + 1]) }}">Next</a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning">
                            No movies found for "{{ $title }}". Please try another search term.
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection