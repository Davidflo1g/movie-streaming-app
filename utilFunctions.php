<?php
function htc($text) {
    return htmlspecialchars($text);
}

// Extract YouTube ID from full URL
function extractYouTubeID($url) {
    if (preg_match('/v=([^&]+)/', $url, $matches)) {
        return $matches[1];
    }
    return null;
}

// Save or update progress_secs
function saveProgress($conn, $user_id, $movie_id, $progress_secs) {
    // Check if row exists
    $check = $conn->prepare("
        SELECT history_id 
        FROM play_history 
        WHERE user_id = ? AND movie_id = ?
    ");
    $check->bind_param("ii", $user_id, $movie_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Update
        $update = $conn->prepare("
            UPDATE play_history 
            SET progress_secs = ?, last_watched = NOW() 
            WHERE user_id = ? AND movie_id = ?
        ");
        $update->bind_param("iii", $progress_secs, $user_id, $movie_id);
        $update->execute();
    } else {
        // Insert
        $insert = $conn->prepare("
            INSERT INTO play_history (user_id, movie_id, progress_secs, last_watched)
            VALUES (?, ?, ?, NOW())
        ");
        $insert->bind_param("iii", $user_id, $movie_id, $progress_secs);
        $insert->execute();
    }
}

// JS injection
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