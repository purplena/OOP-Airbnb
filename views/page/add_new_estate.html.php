<div class="page-container">

    <section>
        <h1><?php echo $h1_tag; ?></h1>
        <?php

        use Core\Repository\AppRepoManager;
        use Core\Session\Session;
        use App\Model\User;

        // var_dump($auth::isAuth());
        // var_dump(Session::get(Session::USER)->photo_user);
        ?>
        <form action="/addNewEstatePost" enctype="multipart/form-data" method="post">
            <!-- <label for="country">Country: </label>
            <input id="inputCountry" name="country" />
            <label for="city">City: </label>
            <input id="inputCity" name="city" />
            <label for="price">Price: </label>
            <input id="inputPrice" name="price" type="number" step="0.01" min="0" required /> -->


            <label for="upload" class="label">
                Upload a file
                <input type="file" name="files[]" id="upload" multiple />
            </label>

            <!-- <input name="files[]" type="file" multiple class="custom-file-input" /> -->
            <input type="submit" name="upload" value="Submit">
        </form>
    </section>
</div>