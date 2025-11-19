<div id="header">
    <!-- Search bar -->
    <div id="search-bar">
            <img src="assets/icons/magnify.svg" class="icon">
        <form method="GET" autocomplete="off">
            <input type="text" class="search" placeholder="Search..." name="name" value="<?php echo isset($_GET['name']) ? htmlspecialchars($_GET['name']) : ''; ?>">
        </form>
    </div>


    <!-- User info -->
    <div class="user">
        <div class="profile-wrapper">
            <img src="assets/icons/profile.jpg" class="profile-pic">
        </div>
        <div class="user-text" style="font-size: small;">Hi there,</div>
        <div class="user-text" style="font-size: 25px;">JD Azurin (@jaytoodee)</div>
    </div>

    <!-- Action buttons -->
    <div class="button-container">
        <button class="button">New</button>
        <button class="button">Upload</button>
        <button class="button">Share</button>
    </div>
</div>
