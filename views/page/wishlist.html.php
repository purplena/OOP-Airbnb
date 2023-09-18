<!-- <?php var_dump($favorites); ?> -->
<div class="page-container">
    <h1><?php echo $h1_tag; ?></h1>
    <?php if ($favorites) : ?>
        <section class="reservation-section">
            <?php foreach ($favorites as $favorite) : ?>
                <div class="reservation-container">
                    <div class="reservation-photo-container">
                        <img class="reservation-photo" src="/images/estate_img/<?php echo $favorite->photos[3]; ?>" alt="">
                        <a class="btn btn-custom-border" href="/details/<?php echo $favorite->estate_id ?>">See more</a>
                    </div>
                    <div>
                        <div class="your-estate-container">
                            <h2 class="reservation-h2">Your FUTURE Airbnb</h2>
                            <p>Location: <strong><?php echo $favorite->estate->city; ?>, <?php echo $favorite->estate->country; ?></strong></p>
                            <p>Max guests: <strong><?php echo $favorite->estate->num_beds; ?></strong></p>
                            <p>Price: <strong><?php echo $favorite->estate->price; ?> €/night</strong></p>
                            <p>You can come with an animal:<strong> <?php echo ($favorite->estate->allowed_animals == 1) ? "yes" : "no"; ?></strong></p>
                        </div>
                        <a class="btn btn-delete" href="/wishlist/deleteFromFavorites/<?php echo $favorite->id ?>">Remove from Wishlish</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php else : ?>
        <div>
            <h2>You have nothing in you wishlist yet! Sorry ...</h2>
            <p>Check all the variety of places where you can spend your next holiday!</p>
            <a href="/" class="btn btn-custom">Our Airbnbs</a>
        </div>
    <?php endif ?>
</div>