function fetchMovies(category) {
    const apiUrl = `https://www.omdbapi.com/?s=${category}&apikey=3567105e&type=movie`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            displayMovies(data.Search, category.toLowerCase() + 'Movies');
        })
        .catch(error => {
            console.error('Error fetching movies:', error);
        });
}

function displayMovies(movies, containerId) {
    const movieListContainer = document.getElementById(containerId);
    movieListContainer.innerHTML = '';

    movies.forEach(movie => {
        const movieDetails = `
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="${movie.Poster}" class="card-img-top" alt="${movie.Title}">
                    <div class="card-body">
                        <h5 class="card-title">${movie.Title}</h5>
                        <p class="card-text">${movie.Year}</p>
                        <a href="booking.html?movie=${encodeURIComponent(movie.Title)}" class="btn btn-primary">Book Ticket</a> 
                    </div>
                </div>
            </div>
        `;

        movieListContainer.innerHTML += movieDetails;
    });
}


document.addEventListener("DOMContentLoaded", function() {
    const categories = ['action', 'romantic', 'horror', 'anime'];

    categories.forEach(category => {
        fetchMovies(category);
    });
});
