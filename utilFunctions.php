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
</script>