<?php

require_once root."/DB/db.php";
$db = db::get();

//user role
if (isset($_SESSION["id"])):
    $selectRoleString = 'SELECT userrole.role_id FROM `users`  LEFT JOIN userrole ON userrole.user_id = users.user_id LEFT JOIN role ON userrole.role_id = role.role_id WHERE users.user_id = "' . $_SESSION["id"] . '"';
    $userrole = $db->getRow($selectRoleString);
endif;
//count active accounts

if (isset($_SESSION["id"])):
    $activeAccounts = "INSERT INTO sessions (session_id, date) VALUES ('" . $_SESSION["id"] . "',now()) ON duplicate KEY UPDATE date=now()";
    $query = $db->query($activeAccounts);
endif;

?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Hotel Morgan*****</title>

    <!-- css -->
    <link rel="icon" href="/Assets/Img/core-img/manisonico.ico">

    <link rel="stylesheet" href="/Assets/Css/hr.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <link rel="stylesheet" href="/Assets/Css/style.css">
</head>

<body style="font-family:'Palatino Linotype', 'Book Antiqua', Palatino, serif;">

<div class="preloader d-flex align-items-center justify-content-center">
    <div class="cssload-container">
        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
    </div>
</div>
<?php

if ($userrole["role_id"] ==4){

    header("location: /error");
}
?>
<header class="header-area">

    <div class="top_bar">
        <div class="container">

            <div class="row">
                <div class="col d-flex flex-row">
                    <div class="phone"> 1014 Budapest, BN2 oGJ, HU - Foglalás (+36)30 456 789 56</div>
                    <div class="mmline"></div>
                    <div class="social">
                        <ul class="social_list">
                            <li title="Facebook" class="social_list_item"><a href="https://www.facebook.com/"
                                                                             target="_blank"><i
                                            class="fab fa-facebook-square"></i></a></li>
                            <li title="Instagram" class="social_list_item"><a href="https://www.instagram.com/"
                                                                              target="_blank"><i
                                            class="fab fa-instagram"></i></a></li>
                            <li title="Twitter" class="social_list_item"><a href="https://www.twitter.com/"
                                                                            target="_blank"><i
                                            class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                    <div class="user_box ml-auto">
                        <?php if (!isset($_SESSION["id"])): ?>
                            <div id="mobileUser" class="user_box_login user_box_link"><a title="Bejelentkezés"
                                                                                         href="/login"><i
                                            class="far fa-user-circle"></i> Bejelentkezés</a></div>
                        <?php else: ?>

                            <?php if ($userrole["role_id"] == 1): ?>

                                <div class="user_box_login user_box_link"><a href="/dashboard"><i
                                                class="fa fa-line-chart"></i>Irányítópult</a>
                                </div>
                            <?php else: ?>

                                    <a href="/profile"><i class="fa fa-user-circle" style="color: #4c4c4c">

                                        </i> <?php echo $_SESSION["name"]; ?> </a> |

                                <div class="user_box_login user_box_link"><a href="/logout"
                                                                             title="Kijelentkezés">Kijelentkezés</a>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="palatin-main-menu">
        <div class="classy-nav-container breakpoint-off">
            <div class="container">
                <nav class="classy-navbar justify-content-between" id="palatinNav">
                    <a href="/Views/Index/index.php" class="nav-brand"><h1>MORGAN</h1></a>

                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>
                    <div class="classy-menu">

                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>

                        <div class="classynav">
                            <ul>
                                <li><a href="/index">Főoldal</a></li>
                                <li><a href="/about">Rólunk</a></li>
                                <li><a>Szolgáltatások</a>
                                    <ul class="dropdown">
                                        <li><a href="/rooms">Szobák</a></li>
                                        <li><a href="/events">Hírek</a></li>
                                    </ul>
                                </li>
                                <li><a href="/booking">Foglalás</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
