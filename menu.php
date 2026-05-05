<div class="row">
    <div class="col-md-12">
        <?php
        // Deteksi halaman aktif
        $current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item <?php echo ($current_page == 'home') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php">Home
          <?php if($current_page == 'home'): ?>
          <span class="sr-only">(current)</span>
          <?php endif; ?>
        </a>
      </li>
      <li class="nav-item <?php echo ($current_page == 'about_me') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php?page=about_me">About Me</a>
      </li>
      <li class="nav-item <?php echo ($current_page == 'contact_me') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php?page=contact_me">Contact Me</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">My Studies</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">Level</a>
          <a class="dropdown-item" href="#">Studies</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Login</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
    </div>
</div>