<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="w3-container w3-black">
    <div class="w3-bar w3-theme-d5">
        <a href="index.php" class="w3-bar-item w3-button w3-hover-cyan">
            <img src="images/logo.png" style="height: 80px; width: 250px; vertical-align: middle;">
        </a>
        
        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
            <!-- Show these menus only when logged in -->
            <div class="w3-dropdown-hover w3-right">
                <button class="w3-button w3-hover-cyan">Admin</button>
                <div class="w3-dropdown-content w3-bar-block w3-border w3-card-4">
                    <a href="adminMovies.php" class="w3-bar-item w3-button">Manage Movies</a>
                    <a href="adminMembers.php" class="w3-bar-item w3-button">Manage Members</a>
                    <a href="adminReports.php" class="w3-bar-item w3-button">View Reports</a>
                </div>
            </div>

            <div class="w3-dropdown-hover w3-right">
                <button class="w3-button w3-hover-cyan">Movies</button>
                <div class="w3-dropdown-content w3-bar-block w3-border w3-card-4">
                    <a href="browse.php" class="w3-bar-item w3-button">Browse All</a>
                    <a href="search.php" class="w3-bar-item w3-button">Search</a>
                    <a href="genres.php" class="w3-bar-item w3-button">By Genre</a>
                    <a href="actors.php" class="w3-bar-item w3-button">By Actors</a>
                </div>
            </div>

            <div class="w3-dropdown-hover w3-right">
                <button class="w3-button w3-hover-cyan">My Account</button>
                <div class="w3-dropdown-content w3-bar-block w3-border w3-card-4">
                    <a href="watchlist.php" class="w3-bar-item w3-button">My Watchlist</a>
                    <a href="history.php" class="w3-bar-item w3-button">Viewing History</a>
                    <a href="reviews.php" class="w3-bar-item w3-button">My Reviews</a>
                    <a href="reset-password.php" class="w3-bar-item w3-button">Reset Password</a>
                </div>
            </div>

            <span class="w3-bar-item w3-right" style="padding-top: 8px;">
                Welcome, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>
            </span>
            <a href="logout.php" class="w3-bar-item w3-button w3-right w3-hover-cyan">Logout</a>
        <?php else: ?>
            <!-- Show login/register when not logged in -->
            <a href="login.php" class="w3-bar-item w3-button w3-right w3-hover-cyan">Login</a>
            <a href="register.php" class="w3-bar-item w3-button w3-right w3-hover-cyan">Register</a>
        <?php endif; ?>
    </div>
</div>
