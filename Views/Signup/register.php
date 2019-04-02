<?php require_once "header.php"; ?>

    <div class="limiter">
        <div class="container-login100">
            <div class="login100-more"
                 style="background: url('/Assets/Img/bg-img/haunted-house-bg1.jpg') fixed; background-size: cover"></div>

            <div class="wrap-login100 p-l-50 p-r-50 p-t-72 p-b-50">
                <form class="login100-form " action="" method="POST">
					<span class="login100-form-title p-b-59">
						<div class="footer_logo">
                            <a href="#" class="text-center">
                                <div class="footer_logo_subtitle">HOTEL</div>
                                <div class="footer_logo_title">MORGAN</div>
                                <div class="footer_logo_stars">
                                    <ul class="d-flex flex-row align-items-start justfy-content-start">
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                        <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                    </ul>
                                </div>
                            </a>
                        </div>
					</span>

                   <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                   <?php require_once root . "/Views/Alerts/successMessage.php"; ?>

                    <div class="wrap-input100 validate-input" data-validate="Üres mező">
                        <span class="label-input100">Teljes név</span>
                        <input class="input100" type="text" name="name" id="name" placeholder="Név...">
                        <span class="focus-input100"></span>
                    </div>


                    <div class="wrap-input100 validate-input" data-validate="Az email formátum ex@abc.xyz">
                        <span class="label-input100">Email</span>
                        <input class="input100" type="text" name="email" id="email" placeholder="Email cím...">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Üres mező">
                        <span class="label-input100">Jelszó</span>
                        <input class="input100" type="password" name="password" id="password"
                               placeholder="*************">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Üres mező">
                        <span class="label-input100">Jelszó mégegyszer</span>
                        <input class="input100" type="password" id="rePassword" name="rePassword"
                               placeholder="*************">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" name="registerButton" type="submit">
                                Regisztráció
                            </button>
                        </div>

                        <a href="/login" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10 p-l-30">
                            Bejelentkezés
                            <i class="fa fa-long-arrow-right m-l-5"></i>
                        </a>
                    </div>
                </form>
                <div class="text-center p-t-72">
                    <p style="color: #c1c1c1;">Ha van már meglévő fiókja akkor a bejelentkezés gombra kattintva tud
                        bejelentkezni.</p>
                </div>
                <a href="/index" class="dis-block txt3 hov1 p-r-30 p-t-10 p-b-10">
                    <i class="fa fa-long-arrow-left m-l-5"></i>
                    Vissza a főoldalra
                </a>
            </div>
        </div>
    </div>

<?php
require_once "footer.php";
?>