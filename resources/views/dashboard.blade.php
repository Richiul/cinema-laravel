<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="search-container">
      <input type="text" placeholder="Search" id="search">
    </div>
    <script>
      $(document).ready(function () {
            $('#search').on('keyup', function () {
                var query = $(this).val();

                if (query.trim().length >= 2) {
                    $.ajax({
                        url: "{{ route('search') }}",
                        type: "GET",
                        data: { query: query },
                        success: function (response) {
                            var results = $('#results');
                            results.empty();
                            
                            if (response.length > 0) {
                                $.each(response, function (index, movie) {
                                var movieItem = $('<div>').addClass('movie-item');
                                var movieTitle = $('<h3>').text(movie.title);
                                var movieOverview = $('<p>').text(movie.overview);
                                var movieLink = $('<a>').attr('href', '/movie/' + movie.id);
                                var movieImage = $('<img>').attr('src', 'https://image.tmdb.org/t/p/w500' + movie.poster_path);

                                movieLink.append(movieImage, movieTitle, movieOverview);
                                movieItem.append(movieLink);

                                if (movie.poster_path != null) {
                                    results.append(movieItem);
                                }
                            
                            });
                            } else {
                                var noMoviesFound = $('<h1>').text("No movies found");
                                results.append(noMoviesFound);
                            }

                        }
                    });
                }

                if (query.trim().length == 0) {
                    location.reload();
                }
            });
        });
    </script>
    <div class="grid grid-cols-3 gap-4 mx-auto mt-5" style="width:1200px;" id="results">
        @foreach ($movies as $key => $movie)
            <div class="max-w-sm rounded overflow-hidden shadow-lg p-4 w-400">
                <a href="movie/{{ $movie['id'] }}">
                <img src="https://image.tmdb.org/t/p/w500/{{ $movie['poster_path'] ?? ''}}" alt="movie_poster" style="height:528px;">
                <div class="px-6 py-4 overflow-hidden" style="height:200px;">
                  <div class="font-bold text-xl mb-2">{{ $movie['title'] ?? $movie['name']}}</div>
                  <p class="text-gray-700 text-base">
                    {{ $movie['overview'] ?? ''}}
                  </p>
                </div>
                 
                <div class="px-6 pt-4 pb-2 text-center">
                  <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : '2017'}}</span>
                  <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $movie['vote_count'] ?? ''}}</span>
                  <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $movie['vote_average'] ?? ''}}/10</span>
                </div></a>
            </div>
        @endforeach
    </div>
</x-app-layout>
