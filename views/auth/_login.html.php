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
                <?php echo $auth::isAuth() ? '<li class="menu-item"><a class="menu-link" href="/trips">Trips</a></li>' : ""; ?>
                <?php echo $auth::isAuth() ? '<li class="menu-item"><a class="menu-link" href="/wishlist">Wishlist</a></li>' : ""; ?>
                <?php echo $auth::isAuth() ? '<li class="menu-item"><a class="menu-link" href="/airbnb-your-home"><i class="bi bi-house-heart"></i> Airbnb your home</a></li>' : ""; ?>
                <?php echo $auth::isAuth() ? '<li class="menu-item"><a class="menu-link" href="/logout">Log Out</a></li>' : ""; ?>
                <?php echo $auth::isAuth() ? "" : '<li class="menu-item" id="login-button"><a class="menu-link" href="/login">Log in</a></li>'; ?>
                <?php echo $auth::isAuth() ? "" : '<li class="menu-item"><a class="menu-link" href="/signup">Sign up</a></li>'; ?>
            </div>
        </nav>
        <div class="underline"></div>
    </div>

    <section class="page-container">
        <h1><?php echo $h1_tag; ?></h1>


        <?php if ($form_result && $form_result->hasError()) : ?>
            <div>
                <?php echo $form_result->getErrors()[0]->getMessage(); ?>
            </div>
        <?php endif; ?>

        <form method=post action="/loginPost" class="row g-3">

            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail4">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="inputPassword4">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-custom">Log in</button>
            </div>
        </form>
    </section>

    <footer>
        <script src="/script.js"></script>
    </footer>
    </div>
</body>

</html>