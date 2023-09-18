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
                <div class="single-airbnb-estate-container" style="margin-bottom: 3rem;">
                    <div class="d-flex gap-3">
                        <div class="mb-3">
                            <img style="width: 150px;  border-radius: 10px;" src="/images/estate_img/<?php echo $estate->photos[0]; ?>" alt="">
                        </div>
                        <div>
                            <p>Location: <?php echo $estate->city; ?>, <?php echo $estate->country; ?></p>
                            <p>Price: <?php echo $estate->price; ?> €/nuit</p>
                            <a class="btn btn-custom-border" href="/details/<?php echo $estate->id ?>">See more</a>
                        </div>
                    </div>
                    <div>
                        <h2 style="font-size: 18px;">Your reservations:</h2>
                        <?php if (!$estate->reservations) : ?>
                            <p>No reservations yet! Sorry...</p>
                        <?php else : ?>
                            <?php $i = 1; ?>
                            <?php foreach ($estate->reservations as $reservation) : ?>
                                <div class="mb-3">
                                    <h3 style="font-size: 16px; font-weight: 700;">Reservation #<?php echo $i; ?></h3>
                                    <p style="font-size: 14px; margin-bottom: 0;">Dates: <strong><?php echo DateTime::createFromFormat('Y-m-d', $reservation->date_start)->format('d/m/Y'); ?> - <?php echo DateTime::createFromFormat('Y-m-d', $reservation->date_finish)->format('d/m/Y'); ?></strong></p>
                                    <p style="font-size: 14px; margin-bottom: 0;">Your guests stay:
                                        <?php
                                        $dateStart = new DateTime($reservation->date_start);
                                        $dateFinish = new DateTime($reservation->date_finish);
                                        $interval = $dateStart->diff($dateFinish);
                                        $numberOfNights = $interval->format('%a');
                                        ?>
                                        <strong><?php echo $numberOfNights; ?></strong> night(s)
                                    </p>
                                    <p style="font-size: 14px; margin-bottom: 0;">Number of guests: <strong><?php echo $reservation->num_guests; ?></strong></p>
                                    <p style="font-size: 14px; margin-bottom: 0;">Price total: <strong><?php echo intval($numberOfNights) * $estate->price; ?>€</strong></p>
                                    <p style="font-size: 14px; margin-bottom: 0;">Details: <?php echo $numberOfNights; ?> night(s) x <?php echo $estate->price; ?>€</p>
                                    <p style="font-size: 14px; margin-bottom: 0;">You come with an animal:<strong> <?php echo ($reservation->are_animals == 1) ? "yes" : "no"; ?></strong></p>
                                    <p style="font-size: 14px; margin-bottom: 0;">Contact person: <strong><?php echo $reservation->user->first_name; ?> <?php echo $reservation->user->second_name; ?></strong></p>
                                    <p style="font-size: 14px; margin-bottom: 0;">Send a message: <strong><?php echo $reservation->user->email; ?></strong></p>
                                </div>
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