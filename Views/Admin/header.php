<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/Assets/Img/core-img/manisonico.ico">
    <link rel="stylesheet" type="text/css" href="/Assets/Css/font-awesome.min.css">
    <link rel="stylesheet" href="/Assets/Css/bootstrap.min.css">
    <link rel="stylesheet" href="/Views/Admin/style.css">


    <title>Hotel Morgan***** - Admin</title>
</head>
<body>

<div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <span class="login100-form-title p-b-59">
                <div class="footer_logo">
                    <a href="#" class="text-center">
                        <div class="footer_logo_subtitle">HOTEL</div>
                        <div class="footer_logo_title">MORGAN</div>
                        <div class="footer_logo_stars">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
            </span>
        </div>
        <ul class="list-unstyled components">
            <p>Lehetőségek</p>
            <li class="active">
                <a href="/dashboard">Főoldal</a>
            </li>

            <?php if ($userrole["role_id"] == 1): ?>
                <li>
                    <a href="/inservice">Termékek</a>
                </li>
            <?php endif; ?>
        </ul>
        <ul>
            <button type="button" style="width: 80%" onclick="reloadFunction()" class="btn btn-outline-secondary">
                Frissítés
            </button>
            <script>
                function reloadFunction() {
                    location.reload();
                }
            </script>
        </ul>
    </nav>

    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="navbar-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-align-justify"></i>

                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto">
                        <?php if ($userrole["role_id"] == 1): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/index">Főoldal(felhasználói nézet) </a>
                            </li>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <li class="nav-item">
                                <button type="submit" name="logOutButton" class="nav-link logOutBtn">Kijelentkezés
                                </button>
                            </li>
                        </form>
                    </ul>
                </div>
            </div>
        </nav>