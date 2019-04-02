<link rel="stylesheet" href="/Assets/Css/contact.css">
<link rel="stylesheet" href="/Assets/Css/contact_responsive.css">

<div class="newsletter">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if (isset($errorMsgForNewsLetter) && $errorMsgForNewsLetter !=""): ?>
                    <div class="alert alert-info">
                        <i class="fa fa-info"> <?php echo $errorMsgForNewsLetter ;?></i>
                    </div>
                <?php endif;?>
            </div>
            <div class="col-lg-5">
                <div class="newsletter_content">
                    <div class="section_title_container">
                        <div class="section_subtitle">Szellem Hotel</div>
                        <div class="section_title"><h2>Hírlevél</h2></div>
                    </div>
                    <div class="newsletter_text">
                        <p>Praesent fermentum ligula in dui imperdiet, vel tempus nulla ultricies. Phasellus at commodo
                            ligula. Nullam molestie volutp at sapien.</p>
                    </div>
                </div>
            </div>
            <?php
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;

            if (isset($_POST["newsLetterButton"])) {
                if (!empty($_POST["newsLetterInput"])) {

                    require root . '/Mailer/src/Exception.php';
                    require root . '/Mailer/src/PHPMailer.php';
                    require root . '/Mailer/src/SMTP.php';
                    $mail = new PHPMailer(true);
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 465;
                    $mail->SMTPSecure = "ssl";
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    $mail->SMTPAuth = true;
                    $mail->Username = 'hotelmorganinfo@gmail.com';
                    $mail->Password = 'morgan1998';
                    $mail->From = 'hotelmorganinfo@gmail.com';
                    $mail->FromName = 'Hotel Morgan*****';
                    $mail->AddAddress($_POST["newsLetterInput"]);
                    $mail->AddReplyTo('hotelmorganinfo@gmail.com', 'Information');
                    $mail->WordWrap = 80;
                    $mail->IsHTML(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->Subject = 'Morgan Hírlevél';
                    $mail->Body = '<h3>Ön sikeresen feliratkozott hírlevelünkre!</h3><br>A jelenlegi hírekről, eseményekről további email-t fogunk küldeni!<br>Köszönjük bizalmát!<br>Üdvözlettel:<br>Hotel Morgan Csapata';          // A level tartalma
                    if (!$mail->Send()) {
                        $errorMsgForNewsLetter = "Hiba a feliratkozás során kérjük próbálja meg később!";
                    }
                }
            }
            ?>

            <div class="col-lg-7">
                <div class="newsletter_form_container">
                    <form action="" method="post" id="newsletter_form" class="newsletter_form">
                        <input type="email" name="newsLetterInput" class="newsletter_input" placeholder="Email cím"
                               required="required">
                        <button class="newsletter_button" name="newsLetterButton" type="submit"><span>Iratkozz fel</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="newsletter_border_container">
        <div class="container">
            <div class="row border_row">
                <div class="col">
                    <div class="newsetter_border">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 footer_col">
                <div class="footer_logo_container">
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
                    <div class="copyright">
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                        <a> Minden jog fenntartva</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 footer_col">
                <div class="footer_menu">
                    <ul class="d-flex flex-row align-items-start justify-content-start">
                        <li><a href="/index">Főoldal</a></li>
                        <li><a href="/about">Rólunk</a></li>
                        <li><a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                Szolgáltatások
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/rooms">Szobák</a>
                                <a class="dropdown-item" href="/events">Hírek</a>
                            </div>
                        </li>
                    </ul>
                    <div class="footer_menu_text">
                        <p>Praesent fermentum ligula in dui imperdiet, vel tempus nulla ultricies. Phasellus at commodo
                            ligula.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 footer_col">
                <div class="footer_contact clearfix">
                    <div class="footer_contact_content float-lg-right">
                        <ul>
                            <li>Cím: <span>1100 Bp. Koss.67-80</span></li>
                            <li>Telefon: <span>+36307776665</span></li>
                            <li>Email: <span>hotel@morgan.com</span></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</footer>


<script src="/Assets/Js/jquery/jquery-2.2.4.min.js"></script>
<script src="/Assets/Js/bootstrap/popper.min.js"></script>
<script src="/Assets/Js/bootstrap/bootstrap.min.js"></script>
<script src="/Assets/Js/plugins/plugins.js"></script>
<script src="/Assets/Js/active.js"></script>

</body>

</html>