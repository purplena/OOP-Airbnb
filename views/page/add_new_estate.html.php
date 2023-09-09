<div class="page-container">

    <section>
        <h1><?php echo $h1_tag; ?></h1>
        <h2>Ready to Airbnb?</h2>
        <?php

        use Core\Session\Session;
        //Here I get my connected user
        $user = Session::get(Session::USER);
        //Here I regroup my array of equipment to avoid additional sql queries
        $regroupedArray = [];
        foreach ($allEquipment as $equipment) {
            $equipmentType = $equipment->type_equipment;
            if (!isset($regroupedArray[$equipmentType])) {
                $regroupedArray[$equipmentType] = [];
            }
            $regroupedArray[$equipmentType][] = [
                "id" => $equipment->id,
                "label_equipment" => $equipment->label_equipment
            ];
        }
        ?>
        <form action="/addNewEstatePost" enctype="multipart/form-data" method="post">
            <input type="hidden" name="user_id" value=<?php echo $user->id; ?>>
            <div class="mt-5">
                <select class="form-select" name="type_estate_id">
                    <option selected>Which of these best describes your place?</option>
                    <?php foreach ($types_estate as $type_estate) : ?>
                        <option value="<?php echo $type_estate->id; ?>"><?php echo $type_estate->label_estate; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mt-3">
                <label for="country">Country: </label>
                <input id="inputCountry" name="country" required />
            </div>
            <div class="mt-3">
                <label for="city">City: </label>
                <input id="inputCity" name="city" required />
            </div>
            <div class="mt-3">
                <label for="price">Price: </label>
                <input id="inputPrice" name="price" type="number" step="0.01" min="0" required /><span> €/night</span>
            </div>
            <div class="mt-3">
                <label for="size">Size: </label>
                <input id="inputSize" name="size" type="number" step="1" min="0" required /><span> m²</span>
            </div>
            <div class="mt-3">
                <label for="num_rooms">How many rooms are you ready to Airbnb?</label>
                <input id="inputRooms" name="num_rooms" type="number" step="1" min="1" required />
            </div>
            <div class="mt-3">
                <label for="num_beds">How many beds are there?</label>
                <input id="inputBeds" name="num_beds" type="number" step="1" min="1" required />
            </div>
            <div class="mt-3">
                <select class="form-select" name="allowed_animals">
                    <option selected>Are animals allowed in your place?</option>
                    <option value="1">YES</option>
                    <option value="0">NO</option>
                </select>
            </div>
            <div class="form-floating mt-3">
                <textarea name="description" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                <label for="floatingTextarea2">Please tell us more about your place</label>
            </div>
            <div class="mb-3 mt-3">
                <label for="formFileSm" class="form-label">Please add pictures of your place</label>
                <input class="form-control form-control-sm" id="formFileSm" type="file" name="files[]" multiple>
            </div>
            <div>
                <?php foreach ($regroupedArray as $key => $value) : ?>
                    <div class="mt-5">
                        <p><?php echo $key; ?></p>
                        <?php foreach ($value as $type_equipment) : ?>
                            <div class="form-check">
                                <input name="equipment_id[]" class="form-check-input" type="checkbox" value="<?php echo $type_equipment['id']; ?>" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <?php echo $type_equipment['label_equipment']; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-3">
                <input type="submit" name="submit_form" value="Submit" class="btn btn-primary">
            </div>
        </form>
    </section>
</div>