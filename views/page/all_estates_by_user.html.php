<?php

// var_dump($estates);
foreach ($estates as $estate) {
    // var_dump($estate);
    foreach ($estate->reservations as $reservation) {
        // var_dump($reservation->user);
    };
} ?>
<div class="page-container">
    <h1><?php echo $h1_tag; ?></h1>
    <?php if ($estates) : ?>
        <section class="estates-section">
            <?php foreach ($estates as $estate) : ?>
                <div class="single-airbnb-estate-container">
                    <div>
                        <div>
                            <img src="/images/estate_img/<?php echo $estate->photos[0]; ?>" alt="">
                        </div>
                        <div>
                            <p>Location: <?php echo $estate->city; ?>, <?php echo $estate->country; ?></p>
                            <p>Price: <?php echo $estate->price; ?> €/nuit</p>
                            <a class="btn btn-custom-border" href="/details/<?php echo $estate->id ?>">See more</a>
                        </div>
                    </div>
                    <div>
                        <h2>List of reservations:</h2>
                        <?php if (!$estate->reservations) : ?>
                            <p>No reservations yet! Sorry...</p>
                        <?php else : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($estate->reservations as $reservation) : ?>
                                <h3>Reservation #<?php echo $i; ?></h3>
                                <p>Dates: <strong><?php echo DateTime::createFromFormat('Y-m-d', $reservation->date_start)->format('d/m/Y'); ?> - <?php echo DateTime::createFromFormat('Y-m-d', $reservation->date_finish)->format('d/m/Y'); ?></strong></p>
                                <p>Your guests stay:
                                    <?php
                                    $dateStart = new DateTime($reservation->date_start);
                                    $dateFinish = new DateTime($reservation->date_finish);
                                    $interval = $dateStart->diff($dateFinish);
                                    $numberOfNights = $interval->format('%a');
                                    ?>
                                    <strong><?php echo $numberOfNights; ?></strong> night(s)
                                </p>
                                <p>Number of guests: <strong><?php echo $reservation->num_guests; ?></strong></p>
                                <p>Price total: <strong><?php echo intval($numberOfNights) * $estate->price; ?>€</strong></p>
                                <p>Details: <?php echo $numberOfNights; ?> night(s) x <?php echo $estate->price; ?>€</p>
                                <p>You come with an animal:<strong> <?php echo ($reservation->are_animals == 1) ? "yes" : "no"; ?></strong></p>
                                <p>Contact person: <?php echo $reservation->user->first_name; ?> <?php echo $reservation->user->second_name; ?></p>
                                <p>Send a message: <?php echo $reservation->user->email; ?></p>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php else : ?>
        <div>
            <h2>You have no Airbnbs yet! Sorry ...</h2>
            <p>You can upload you Airbnb anytime</p>
            <a href="/airbnb-your-home" class="btn btn-custom">Airbnb your home</a>
        </div>
    <?php endif; ?>
</div>