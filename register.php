<?php
session_start();

// Jika sudah login, redirect ke home
if(isset($_SESSION['is_login']) && $_SESSION['is_login'] === true) {
    header('Location: index.php');
    exit();
}

// Proses register dari controller
require_once 'koneksi.php';
require_once 'controllers/MemberController.php';
$controller = new MemberController($dbh);
$controller->register();

// Cek jumlah admin untuk disable option admin
require_once 'models/Member.php';
$memberModel = new Member($dbh);
$adminCount = $memberModel->countAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Personal Page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px 0;
        }
        
        /* Video Background */
        #video-background {
            position: fixed;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translateX(-50%) translateY(-50%);
            z-index: -1;
        }
        
        /* Overlay gelap di atas video */
        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
        
        /* Card Register */
        .register-card {
            max-width: 550px;
            width: 100%;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .logo-container {
            text-align: center;
            padding: 30px 0 20px 0;
        }
        
        .logo-container img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-bottom: 15px;
        }
        
        .card-title-custom {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .card-subtitle-custom {
            font-size: 14px;
            color: #666;
        }
        
        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .form-group label {
            font-size: 13px;
            color: #555;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 14px;
            font-weight: bold;
            font-size: 15px;
            border-radius: 8px;
            transition: transform 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .custom-file-input {
            cursor: pointer;
        }
        
        .custom-file-label {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 15px;
            background-color: white;
        }
        
        .custom-file-label::after {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 0 8px 8px 0;
            padding: 12px 20px;
            content: "Pilih File";
        }
        
        .text-link {
            color: #667eea;
            font-weight: bold;
            text-decoration: none;
        }
        
        .text-link:hover {
            text-decoration: underline;
        }
        
        .btn-outline-custom {
            border: 2px solid #999;
            color: #666;
            border-radius: 8px;
            padding: 8px 20px;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .btn-outline-custom:hover {
            background: #f0f0f0;
            border-color: #666;
            color: #333;
        }
        
        /* Responsive untuk Mobile */
        @media (max-width: 576px) {
            body {
                padding: 12px 0;
            }
            
            .register-card {
                border-radius: 8px;
            }
            
            .logo-container {
                padding: 6px 0 4px 0;
            }
            
            .logo-container img {
                width: 40px;
                height: 40px;
                margin-bottom: 4px;
            }
            
            .card-title-custom {
                font-size: 14px;
                margin-bottom: 0;
            }
            
            .card-subtitle-custom {
                font-size: 8px;
            }
            
            .card-body {
                padding: 8px 14px 10px 14px !important;
            }
            
            .row {
                margin-left: -3px;
                margin-right: -3px;
            }
            
            .row > [class*="col-"] {
                padding-left: 3px;
                padding-right: 3px;
            }
            
            .form-group {
                margin-bottom: 4px;
            }
            
            .form-group label {
                font-size: 8px;
                margin-bottom: 2px;
            }
            
            .form-group label svg {
                width: 10px;
                height: 10px;
            }
            
            .form-control, select.form-control {
                padding: 5px 7px;
                font-size: 11px;
                border-radius: 5px;
            }
            
            .btn-register {
                padding: 6px;
                font-size: 11px;
                margin-top: 4px !important;
                border-radius: 5px;
            }
            
            .btn-register svg {
                width: 12px;
                height: 12px;
            }
            
            .custom-file-label {
                padding: 5px 7px;
                font-size: 10px;
                border-radius: 5px;
            }
            
            .custom-file-label::after {
                padding: 5px 8px;
                font-size: 9px;
                border-radius: 0 5px 5px 0;
            }
            
            small {
                font-size: 7px;
            }
            
            hr {
                margin: 8px 0;
            }
            
            .text-center p {
                font-size: 10px;
                margin-bottom: 5px;
            }
            
            .btn-outline-custom {
                font-size: 9px;
                padding: 5px 10px;
                border-radius: 5px;
            }
            
            .btn-outline-custom svg {
                width: 12px;
                height: 12px;
            }
            
            .alert {
                font-size: 10px;
                padding: 6px 8px;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <!-- Video Background -->
    <video id="video-background" autoplay loop muted playsinline>
        <source src="images/background-login.mp4" type="video/mp4">
    </video>
    <div class="video-overlay"></div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-9 col-sm-8 col-md-9 col-lg-7">
                <div class="card register-card shadow-lg">
                    <!-- Logo dan Title -->
                    <div class="logo-container">
                        <img src="images/logo_sttnf.png" alt="Logo STTNF">
                        <h4 class="card-title-custom">Buat Akun Baru</h4>
                        <p class="card-subtitle-custom">Daftar untuk membuat akun</p>
                    </div>
                    
                    <div class="card-body px-5 pb-4">
                        <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                            ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <!-- Fullname Input -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullname">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                            </svg>
                                            Nama Lengkap
                                        </label>
                                        <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Nama lengkap" required>
                                    </div>
                                </div>
                                
                                <!-- Email Input -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                            </svg>
                                            Email
                                        </label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- Password Input -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                                            </svg>
                                            Password
                                        </label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                    </div>
                                </div>
                                
                                <!-- Role Select -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16">
                                                <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                                                <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                            </svg>
                                            Role
                                        </label>
                                        <select name="role" id="role" class="form-control" required>
                                            <option value="">-- Pilih Role --</option>
                                            <option value="admin" <?php echo ($adminCount > 0) ? 'disabled' : ''; ?>>
                                                Admin <?php echo ($adminCount > 0) ? '(Sudah ada)' : ''; ?>
                                            </option>
                                            <option value="mahasiswa" selected>Mahasiswa</option>
                                            <option value="tamu">Tamu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Foto Upload -->
                            <div class="form-group">
                                <label for="foto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-camera" viewBox="0 0 16 16">
                                        <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                        <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                                    </svg>
                                    Foto Profile (Opsional)
                                </label>
                                <div class="custom-file">
                                    <input type="file" name="foto" id="foto" class="custom-file-input" accept="image/*">
                                    <label class="custom-file-label" for="foto">Pilih foto...</label>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, JPEG (Max 2MB)</small>
                            </div>
                            
                            <!-- Register Button -->
                            <button type="submit" name="register" class="btn btn-primary btn-block btn-register mt-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus" viewBox="0 0 16 16">
                                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                    <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                Daftar
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <!-- Links -->
                        <div class="text-center">
                            <p class="mb-3">Sudah punya akun? <a href="login.php" class="text-link">Login di sini</a></p>
                            <a href="index.php" class="btn btn-outline-custom">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                </svg>
                                Kembali ke Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        // Update custom file input label dengan nama file yang dipilih
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    </script>
</body>
</html>
