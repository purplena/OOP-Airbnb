<div class="page-container">
    <h1><?php echo $h1_tag; ?></h1>
    <?php if ($reservations) : ?>
        <section class="reservation-section">
            <?php foreach ($reservations as $reservation) : ?>
                <div class="reservation-container">
                    <div class="reservation-photo-container">
                        <img class="reservation-photo" src="/images/estate_img/<?php echo $reservation->estate->photos[3]; ?>" alt="">
                        <a class="btn btn-custom-border" href="/details/<?php echo $reservation->estate_id ?>">See more</a>
                    </div>
                    <div>
                        <div class="your-trip-container">
                            <h2 class="reservation-h2">Your trip</h2>
                            <p>Dates: <strong><?php echo DateTime::createFromFormat('Y-m-d', $reservation->date_start)->format('d/m/Y'); ?> - <?php echo DateTime::createFromFormat('Y-m-d', $reservation->date_finish)->format('d/m/Y'); ?></strong></p>
                            <p>You stay:
                                <?php
                                $dateStart = new DateTime($reservation->date_start);
                                $dateFinish = new DateTime($reservation->date_finish);
                                $interval = $dateStart->diff($dateFinish);
                                $numberOfNights = $interval->format('%a');
                                ?>
                                <strong><?php echo $numberOfNights; ?></strong> night(s)
                            </p>
                            <p>Number of guests: <strong><?php echo $reservation->num_guests; ?></strong></p>
                            <p>Price total: <strong><?php echo intval($numberOfNights) * $reservation->estate->price; ?>€</strong></p>
                            <p>Details: <?php echo $numberOfNights; ?> night(s) x <?php echo $reservation->estate->price; ?>€</p>
                            <p>You come with an animal:<strong> <?php echo ($reservation->are_animals == 1) ? "yes" : "no"; ?></strong></p>
                        </div>
                        <div class="your-estate-container">
                            <h2 class="reservation-h2">Your Airbnb</h2>
                            <p>Location: <?php echo $reservation->estate->city; ?>, <?php echo $reservation->estate->country; ?></p>
                            <p>Size: <?php echo $reservation->estate->size; ?> m²</p>
                        </div>
                        <div class="your-host-container">
                            <h2 class="reservation-h2">Your Host</h2>
                            <p>Name: <?php echo $reservation->host['first_name']; ?> <?php echo $reservation->host['second_name']; ?></p>
                            <p>Email: <?php echo $reservation->host['email']; ?></p>
                        </div>

                        <a class="btn btn-delete" href="/trips/deleteReservation/<?php echo $reservation->id ?>">Delete reservation</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php else : ?>
        <div>
            <h2>You have no reservations yet! Sorry ...</h2>
            <p>You can start planning your next trip now</p>
            <a href="/" class="btn btn-custom">Our Airbnbs</a>
        </div>
    <?php endif ?>
</div>