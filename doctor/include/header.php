<header class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <span class="fas fa-arrow-left btn-menu"></span>
            <a href="index.html" class="navbar-brand">Hospital management System</a>
        </div>
        <div class="profile">
            <strong>Welcome, <?=isset($doctor['docname']) ? $doctor['docname'] : "" ?></strong>
        </div>
    </div>
</header>