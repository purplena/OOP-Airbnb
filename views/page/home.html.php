<div class="page-container">

    <!-- <h1><?php echo $h1_tag; ?></h1> -->
    <section class="home-section-container">
        <?php ?>
        <?php foreach ($estates as $estate) : ?>
            <a href="/details/<?php echo $estate->id; ?>">
                <div class="card card-custom" style="max-width: 18rem;">
                    <div id="carouselExample<?php echo $estate->id; ?>" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/images/estate_img/<?php echo $estate->photos[0]; ?>" class="d-block w-100 card-img-top object-fit-cover border rounded" style="height: 14rem;" alt="...">
                            </div>
                            <?php
                            for ($i = 1; $i < count($estate->photos); $i++) : ?>
                                <div class="carousel-item">
                                    <img src="/images/estate_img/<?php echo $estate->photos[$i]; ?>" class="d-block w-100 card-img-top object-fit-cover border rounded" alt="..." style="height: 14rem;">
                                </div>
                            <?php endfor; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample<?php echo $estate->id; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample<?php echo $estate->id; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <div class="card-body">
                        <h3 class="card-title"><?php echo $estate->city; ?>, <?php echo $estate->country; ?></h3>
                        <p style="font-size: 14px;" class="card-text"><strong>€ <?php echo $estate->price; ?></strong> night</p>
                    </div>
                </div>
            </a>

        <?php endforeach; ?>
    </section>
</div>