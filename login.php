<?php
session_start();

if(isset($_SESSION['is_login']) && $_SESSION['is_login'] === true) {
    header('Location: index.php');
    exit();
}

require_once 'koneksi.php';
require_once 'controllers/MemberController.php';
$controller = new MemberController($dbh);
$controller->login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Personal Page</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        
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
        
        .video-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
        
        /* Card Login */
        .login-card {
            max-width: 450px;
            width: 100%;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .logo-container {
            text-align: center;
            padding: 20px 0;
        }
        
        .logo-container img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        
        .card-title-custom {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        
        .card-subtitle-custom {
            font-size: 14px;
            color: #666;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: bold;
            transition: transform 0.2s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .input-group-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: 1px solid #667eea;
            border-right: none;
            color: white;
        }
        
        .form-control {
            border-left: none;
        }

        @media (max-width: 576px) {
            .login-card {
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
            
            .form-group {
                margin-bottom: 5px;
            }
            
            .form-group label {
                font-size: 9px;
                margin-bottom: 2px;
            }
            
            .form-control {
                padding: 5px 7px;
                font-size: 11px;
                border-radius: 5px;
            }
            
            .input-group-text {
                padding: 5px 7px;
                border-radius: 5px 0 0 5px;
            }
            
            .input-group-text svg {
                width: 12px;
                height: 12px;
            }
            
            .btn-login {
                padding: 6px;
                font-size: 11px;
                border-radius: 5px;
                margin-top: 4px;
            }
            
            .btn-login svg {
                width: 12px;
                height: 12px;
            }
            
            hr {
                margin: 8px 0;
            }
            
            .text-center p {
                font-size: 10px;
                margin-bottom: 5px;
            }
            
            .btn-outline-secondary {
                font-size: 9px;
                padding: 5px 10px;
                border-radius: 5px;
            }
            
            .btn-outline-secondary svg {
                width: 12px;
                height: 12px;
            }
            
            .alert {
                font-size: 10px;
                padding: 6px 8px;
                margin-bottom: 6px;
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
            <div class="col-9 col-sm-8 col-md-7 col-lg-5">
                <div class="card login-card shadow-lg">
                    <!-- Logo dan Title -->
                    <div class="logo-container">
                        <img src="images/logo_sttnf.png" alt="Logo STTNF">
                        <h1 class="card-title-custom">LOGIN</h1>
                    </div>
                    
                    <div class="card-body px-4 pb-4">
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
                        
                        <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> <?php 
                            echo $_SESSION['success']; 
                            unset($_SESSION['success']);
                            ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        
                        
                        <form method="POST">
                            <!-- Email Input -->
                            <div class="form-group">
                                <label for="email" class="font-weight-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                    </svg>
                                    Email Address
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email Anda" required>
                                </div>
                            </div>
                            
                            <!-- Password Input -->
                            <div class="form-group">
                                <label for="password" class="font-weight-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
                                    </svg>
                                    Password
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                                                <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
                                                <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
                                </div>
                            </div>
                            
                            <!-- Login Button -->
                            <button type="submit" name="login" class="btn btn-primary btn-block btn-login">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                Login
                            </button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <!-- Links -->
                        <div class="text-center">
                            <p class="mb-2">Belum punya akun? <a href="register.php" class="font-weight-bold">Daftar di sini</a></p>
                            <a href="index.php" class="btn btn-outline-secondary btn-sm">
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
</body>
</html>
