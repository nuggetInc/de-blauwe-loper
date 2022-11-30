<?php
// If the edit information form was submitted
if (isset($_POST["sign-in"])) {
    
    $_SESSION['user'] = User::login($_POST['name'],$_POST['password']);
    if ($_SESSION['user'] == null){
        $_SESSION['name-error'] = "Gebruikersnaam en wachtwoord komen niet overeen"; 
    }

    if (isset($_SESSION['name-error'])) {
        $_SESSION["name"] = $_POST["name"];
        header("Location: " . PATH);
        exit();
    }

    // Reload the page to clear POST
    header("Location: " . "../start");
    exit;
}
?>
<section class="container mt-5">
    <div class="row justify-content-center gy-4">
        <form class="col-lg-5" method="post">
            <h1 class="mb-3">Inloggen</h1>
            <?php

            $frontendName = "Gebruikersnaam";
            $backendName = "name";
            ?>
            <div class="mb-3">
                <label name="name" class="form-label" for="<?= $backendName ?>-id"><?= $frontendName ?></label>
                <?php if (isset($_SESSION[$backendName . "-error"])) : ?>
                    <input type="text" name="<?= $backendName ?>" class="form-control is-invalid" id="<?= $backendName ?>-id" placeholder="<?= $frontendName ?>" value="<?= htmlspecialchars(isset($_SESSION[$backendName]) ? $_SESSION[$backendName] : '') ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION[$backendName . "-error"] ?></div>
                    <?php unset($_SESSION[$backendName . "-error"]); ?>
                <?php else : ?>
                    <input type="text" name="<?= $backendName ?>" class="form-control" id="<?= $backendName ?>-id" placeholder="<?= $frontendName ?>" value="<?= htmlspecialchars(isset($_SESSION[$backendName]) ? $_SESSION[$backendName] : '') ?>" required />
                <?php endif ?>
            </div>

            <?php
            $frontendName = "Wachtwoord";
            $backendName = "password";
            ?>
            <div class="mb-3">
                <label name=<?= $backendName ?> class="form-label" for="<?= $backendName ?>-id"><?= $frontendName ?></label>
                <?php if (isset($_SESSION[$backendName . "-error"])) : ?>
                    <input type="password" name="<?= $backendName ?>" class="form-control is-invalid" id="<?= $backendName ?>-id" placeholder="<?= $frontendName ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION[$backendName . "-error"] ?></div>
                    <?php unset($_SESSION[$backendName . "-error"]); ?>
                <?php else : ?>
                    <input type="password" name="<?= $backendName ?>" class="form-control" id="<?= $backendName ?>-id" placeholder="<?= $frontendName ?>" required />
                <?php endif ?>
            </div>
            <button type="submit" name="sign-in" class="btn btn-primary">Inloggen</button>
        </form>
    </div>
</section>