<div class="row">
    <div class="col-md-12">
        <?php
        // Deteksi halaman aktif
        $current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
        ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">NABILA</a>
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
          <a class="dropdown-item" href="index.php?page=level">Level</a>
          <a class="dropdown-item" href="index.php?page=studies">Studies</a>
        </div>
      </li>
    </ul>
    
    <!-- Login/Logout Button di sebelah kanan -->
    <div class="form-inline my-2 my-lg-0">
      <?php if(!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true): ?>
      <!-- Tampilkan Login jika belum login -->
      <a href="login.php" class="btn btn-outline-light my-2 my-sm-0">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
          <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
        </svg>
        Login
      </a>
      <?php else: ?>
      <!-- Tampilkan info user dan Logout jika sudah login -->
      <div class="dropdown">
        <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php 
          // Tentukan foto yang akan ditampilkan
          $foto_user = (!empty($_SESSION['foto']) && file_exists($_SESSION['foto'])) 
                       ? $_SESSION['foto'] 
                       : 'images/logo_sttnf.png';
          ?>
          <img src="<?php echo $foto_user; ?>" alt="User Photo" 
               style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; margin-right: 5px;">
          <?php echo $_SESSION['fullname']; ?>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUser">
          <a class="dropdown-item disabled" href="#">
            <small class="text-muted">Role: <?php echo ucfirst($_SESSION['role']); ?></small>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
              <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
            </svg>
            Logout
          </a>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</nav>
    </div>
</div>