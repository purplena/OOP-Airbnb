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
        </div>
        <div class="bottom-container mt-5">
            <div>
                <h2>Description</h2>
                <p>Type of Estate: <?php echo $estate->typeEstate->label_estate; ?></p>
                <p><i class="fa-solid fa-bed" style="color: #000000;"></i> <?php echo $estate->num_rooms; ?> rooms, <?php echo $estate->num_beds; ?> beds</p>
                <p><i class="fa-solid fa-dog" style="color: #000000;"></i> & <i class="fa-solid fa-cat fa-flip-horizontal" style="color: #000000;"></i>: <?php echo ($estate->allowed_animals == 1) ? "Animals are allowed" : "Animals are not allowed"; ?></p>
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
            <form action="/reservationPost" method="post" id="reservation-form">
                <?php if ($form_result && $form_result->hasError()) : ?>
                    <div class="mb-3 p-2 text-danger border border-danger rounded-3" style="font-size: 12px;">
                        <?php echo $form_result->getErrors()[0]->getMessage(); ?>
                    </div>
                <?php endif; ?>
                <input type="hidden" name="estate_id" value=<?php echo $estate->id; ?>>
                <div class="mb-3">
                    <span>€ <span class="bold bold-price" id="price-span"><?php echo $estate->price; ?></span>/night</span>
                </div>
                <div class="mb-3 form-group form-reservation-dates-container">
                    <div>
                        <label for="date_start">CHECK IN:</label>
                        <input type="text" class="form-control datepicker" name="date_start" id="date_start">
                    </div>
                    <div>
                        <label for="date_finish">CHECK OUT:</label>
                        <input type="text" class="form-control datepicker" name="date_finish" id="date_finish">
                    </div>
                </div>
                <div class="mb-3">
                    <select class="form-select" name="num_guests">
                        <option selected>Guests</option>
                        <?php for ($i = 1; $i <= intval($estate->num_beds); $i++) : ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <span class="form-text">Max <?php echo $estate->num_beds; ?> guests</span>
                </div>
                <div class="mb-3">
                    <?php echo $estate->allowed_animals == 0 ? "<fieldset disabled>" : ""; ?>
                    <select class="form-select" name="are_animals">
                        <option selected>You come with an animal?</option>
                        <option value="1">YES</option>
                        <option value="0">NO</option>
                    </select>
                    <?php echo $estate->allowed_animals == 0 ? "</fieldset>" : ""; ?>

                    <?php if ($estate->allowed_animals == 1) : ?>
                        <span class="form-text">You can come with you animal</span>
                    <?php else : ?>
                        <span class="form-text">Animals are not allowed</span>
                    <?php endif; ?>
                </div>
                <div class="underline mb-3"></div>
                <div class="mb-3">
                    <span id="number_nights"></span><span> x <?php echo $estate->price; ?> €</span>
                </div>
                <div class="mb-3">
                    <span>Total: </span><span id="total">0 €</span>
                </div>
                <button type="submit" class="btn btn-custom">Reserve</button>
            </form>
        </div>
    </section>
</div>