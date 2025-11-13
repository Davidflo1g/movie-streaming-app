<?php
function htc($text) {
    return htmlspecialchars($text);
}

function addJS($text) {
    return "<script>".$text."</script>";
}
?>

<script>
function searchMovies() {
    var searchTerm = document.getElementById('searchInput').value;
    if(searchTerm.trim() !== '') {
        window.location.href = 'search.php?q=' + encodeURIComponent(searchTerm);
    }
}

function addToWatchlist(movieId) {
    window.location.href = 'addToWatchlist.php?movie_id=' + movieId;
}

function removeFromWatchlist(movieId) {
    if(confirm('Remove this movie from your watchlist?')) {
        window.location.href = 'removeFromWatchlist.php?movie_id=' + movieId;
    }
}
</script>
