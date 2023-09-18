<?php

use Core\Session\Session; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airbnb</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/awesomplete/1.1.5/awesomplete.min.css" integrity="sha512-RT/9M3vzjYojy97YiNTZbyrQ4nJ+gNoinZKTGSVvLITijfQIAIDNicUe+U2KaeOWo9j7IbRzRisx/7eglOc+wA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <div class="page-container">
        <nav id="navbar" class="navbar-container">
            <a href="/"><img src="/images/logo_airbnb.png" alt="airbnb logo"></a>
            <div class="menu-burger-container" id="menu-burger-container">
                <i class="bi bi-list" style="font-size: 18px;"></i>
                <div class="avatar-container">
                    <?php if ($auth::isAuth()) :  ?>
                        <?php $avatar = Session::get(Session::USER)->photo_user; ?>
                        <?php if ($avatar) : ?>
                            <img class="user-image" src="/images/avatars/<?php echo $avatar; ?>" alt="user avatar">
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="no-user-image"></div>
                    <?php endif; ?>
                </div>
            </div>
            <div id="menu-items-container" class="shadow bg-body-tertiary rounded">
                <?php echo $auth::isAuth() ? '<li class="menu-item"><a class="menu-link" href="/trips/' . Session::get(Session::USER)->id . '">Trips</a></li>' : ""; ?>
                <?php echo $auth::isAuth() ? '<li class="menu-item"><a class="menu-link" href="/myAirbnbs/' . Session::get(Session::USER)->id . '">My Airbnbs</a></li>' : ""; ?>
                <?php echo $auth::isAuth() ? '<li class="menu-item"><a class="menu-link" href="/wishlist/' . Session::get(Session::USER)->id . '"><i class="fa-solid fa-heart" style="color: #ff385c; font-size: 14px;"></i> Wishlist</a></li>' : ""; ?>
                <?php echo $auth::isAuth() ? '<li class="menu-item"><a class="menu-link" href="/airbnb-your-home"><i class="bi bi-house-heart"></i> Airbnb your home</a></li>' : ""; ?>
                <?php echo $auth::isAuth() ? '<li class="menu-item"><a class="menu-link" href="/logout">Log Out</a></li>' : ""; ?>
                <?php echo $auth::isAuth() ? "" : '<li class="menu-item" id="login-button"><a class="menu-link" href="/login">Log in</a></li>'; ?>
                <?php echo $auth::isAuth() ? "" : '<li class="menu-item"><a class="menu-link" href="/signup">Sign up</a></li>'; ?>
            </div>
        </nav>
        <div class="underline"></div>
    </div>