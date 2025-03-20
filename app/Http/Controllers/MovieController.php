<?php

namespace App\Http\Controllers;

use App\Models\FavoriteMovie;
use App\Services\OmdbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    protected $omdbService;

    /**
     * Create a new controller instance.
     *
     * @param OmdbService $omdbService
     * @return void
     */
    public function __construct(OmdbService $omdbService)
    {
        $this->middleware('auth');
        $this->omdbService = $omdbService;
    }

    /**
     * Display the dashboard with favorite movies.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $favoriteMovies = Auth::user()->favoriteMovies;
        return view('home', compact('favoriteMovies'));
    }

    /**
     * Search for movies by title
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2',
            'page' => 'sometimes|integer|min:1',
        ]);

        $title = $request->input('title');
        $page = $request->input('page', 1);
        $results = $this->omdbService->searchMovies($title, $page);
        
        $favoriteMovies = Auth::user()->favoriteMovies->pluck('movie_id')->toArray();

        return view('movies.search', compact('results', 'title', 'page', 'favoriteMovies'));
    }

    /**
     * Add a movie to favorites
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToFavorites(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|string',
            'movie_title' => 'required|string',
            'poster_url' => 'nullable|string',
        ]);

        // Check if movie is already in favorites
        $exists = FavoriteMovie::where('user_id', Auth::id())
            ->where('movie_id', $request->movie_id)
            ->exists();

        if (!$exists) {
            FavoriteMovie::create([
                'user_id' => Auth::id(),
                'movie_id' => $request->movie_id,
                'movie_title' => $request->movie_title,
                'poster_url' => $request->poster_url,
            ]);

            return back()->with('status', 'Movie added to favorites!');
        }

        return back()->with('error', 'Movie is already in your favorites!');
    }

    /**
     * Remove a movie from favorites
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeFromFavorites($id)
    {
        FavoriteMovie::where('user_id', Auth::id())
            ->where('movie_id', $id)
            ->delete();

        return back()->with('status', 'Movie removed from favorites!');
    }

    /**
     * Show movie details
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function showDetails($id)
    {
        $movie = $this->omdbService->getMovieDetails($id);
        
        if (!$movie) {
            return redirect()->route('home')->with('error', 'Movie not found!');
        }

        $isFavorite = FavoriteMovie::where('user_id', Auth::id())
            ->where('movie_id', $id)
            ->exists();

        return view('movies.details', compact('movie', 'isFavorite'));
    }
}