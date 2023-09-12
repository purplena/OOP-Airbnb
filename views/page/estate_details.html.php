<!-- <?php var_dump($estate->equiment); ?> -->
<div class="page-container">
    <section>
        <h1><i class="bi bi-house"></i> This <strong><?php echo $estate->typeEstate->label_estate; ?></strong> is for you!</h1>
        <p>Host: <?php echo $estate->user->first_name; ?> <?php echo $estate->user->second_name; ?></p>
        <p>Location: <?php echo $estate->city; ?>, <?php echo $estate->country; ?></p>
        <p>Size: <?php echo $estate->size; ?> m²</p>
        <div class="image-container-details-page">
            <img class="gallery__item gallery__item--1" src="/images/estate_img/<?php echo $estate->photos[2]; ?>" alt="">
            <img class="gallery__item gallery__item--2" src="/images/estate_img/<?php echo $estate->photos[1]; ?>" alt="">
            <img class="gallery__item gallery__item--3" src="/images/estate_img/<?php echo $estate->photos[0]; ?>" alt="">
            <img class="gallery__item gallery__item--4" src="/images/estate_img/<?php echo $estate->photos[3]; ?>" alt="">
            <img class="gallery__item gallery__item--5" src="/images/estate_img/<?php echo $estate->photos[4]; ?>" alt="">
        </div class="bottom-container">
        <div>
            <h2 class="mt-5">Description</h2>
            <p>Type of Estate: <?php echo $estate->typeEstate->label_estate; ?></p>
            <p><i class="fa-solid fa-bed" style="color: #000000;"></i> <?php echo $estate->num_rooms; ?> rooms, <?php echo $estate->num_beds; ?> beds</p>
            <p><?php echo $estate->description; ?></p>

            <div class="underline mt-5"></div>

            <h2 class="mt-5">What this place offers</h2>
            <div class="equipment-container">
                <?php foreach ($estate->equiment as $key => $value) : ?>
                    <ol><strong><?php echo $key; ?></strong>
                        <?php foreach ($value as $singleEquipment) : ?>
                            <li><?php echo $singleEquipment['label_equipment']; ?></li>
                        <?php endforeach; ?>
                    </ol>
                <?php endforeach; ?>

            </div>
        </div>
</div>
</section>
</div>