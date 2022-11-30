<?php
// If the edit information form was submitted
if (isset($_POST["register"])) {
    // Check if there is already a user with this username
    $params = array(":name" => $_POST["name"]);
    $sth = getPDO()->prepare("SELECT 0 FROM `user` WHERE `name` = :name");
    $sth->execute($params);
    if (sizeof($sth->fetchAll()) > 0) {
        $_SESSION["name-error"] = "Er bestaat al een gebruiker met die gebruikersnaam";
    }
    // Check if name only contains letters, spaces and "!"'s
    if (!preg_match("/^[a-zA-Z0-9! ]+$/", $_POST["name"])) {
        $_SESSION["name-error"] = "Naam mag alleen letters en spaties bevatten";
        echo "test";
    }

    // Check if birthdate is before today
    if (strtotime($_POST["date"]) > time())
        $_SESSION["date-error"] = "Geboortedatum moet voor vandaag zijn";

    // Check if phone only contains numbers and an optional + at the start
    if (!preg_match("/^\+?[0-9 ]+$/", $_POST["phoneNumber"]))
        $_SESSION["phoneNumber-error"] = "Telefoonnummer is incorrect";

    // Check if there is already a user with this email
    if (in_array($_POST["mail"], User::getAllMembers())) {
        $_SESSION["mail-error"] = "Er bestaat al een gebruiker met die gebruikersnaam";
    }
    // Check if email is valid
    if (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL))
        $_SESSION["mail-error"] = "Email is incorrect";

    // Check if passwords match
    if (
        $_POST["password"] !== $_POST["passwordRepeat"]
    )
        $_SESSION["passwordRepeat-error"] = "Wachtwoorden komen niet overheen";

    // Check if password contains at least 4 characters
    if (strlen($_POST["password"]) < 4)
        $_SESSION["password-error"] = "Wachtwoord moet minstens vier characters bevatten";

    // Save data en reload if any errors are set
    if (
        isset($_SESSION["name-error"]) ||
        isset($_SESSION["date-error"]) ||
        isset($_SESSION["phoneNumber-error"]) ||
        isset($_SESSION["mail-error"]) ||
        isset($_SESSION["password-error"]) ||
        isset($_SESSION["passwordRepeat-error"]) ||
        isset($_SESSION["error"])
    ) {
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["date"] = $_POST["date"];
        $_SESSION["phoneNumber"] = $_POST["phoneNumber"];
        $_SESSION["mail"] = $_POST["mail"];

        header("Location: " . PATH);
        exit;
    }

    // Create account when all checks pass
    try {
        $_SESSION['user'] = User::register($_POST['name'], $_POST['password'], 1);
    } catch (PDOException $pdoException) {
        $_SESSION['error'] = "Er ging iets mis bij het aanmaken van je account ({$pdoException->getMessage()}). Ons excuses!";
        header("Location: " . PATH);
        exit();
    }
    try {
        Member::register($_SESSION['user']->getId(), $_POST['date'], $_POST['phoneNumber'], $_POST['mail']);
    } catch (PDOException $pdoException) {
        User::delete($_SESSION['user']->getId());
        $_SESSION['error'] = "Er ging iets mis bij het aanmaken van je account ({$pdoException->getMessage()}). Ons excuses!";
    }

    // Reload the page to clear POST
    header("Location: " . "../start");
    exit;
}
?>
<section class="container mt-5">
    <div class="row justify-content-center gy-4">
        <form class="col-lg-5" method="post">
            <div class="mb-3">
                <h1 class="mb-0">Registreren</h1>
                <?php
                if (isset($_SESSION['error'])) :
                ?>
                    <p class="text-danger mb-0"><?= $_SESSION['error'] ?></p>
                <?php
                    unset($_SESSION['error']);
                endif
                ?>
            </div>
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
            $frontendName = "E-mail";
            $backendName = "mail";
            ?>
            <div class="mb-3">
                <label name=<?= $backendName ?> class="form-label" for="<?= $backendName ?>-id"><?= $frontendName ?></label>
                <?php if (isset($_SESSION[$backendName . "-error"])) : ?>
                    <input type="text" name="<?= $backendName ?>" class="form-control is-invalid" id="<?= $backendName ?>-id" placeholder="<?= $frontendName ?>" value="<?= htmlspecialchars(isset($_SESSION[$backendName]) ? $_SESSION[$backendName] : '') ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION[$backendName . "-error"] ?></div>
                    <?php unset($_SESSION[$backendName . "-error"]); ?>
                <?php else : ?>
                    <input type="text" name="<?= $backendName ?>" class="form-control" id="<?= $backendName ?>-id" placeholder="<?= $frontendName ?>" value="<?= htmlspecialchars(isset($_SESSION[$backendName]) ? $_SESSION[$backendName] : '') ?>" required />
                <?php endif ?>
            </div>

            <?php
            $frontendName = "Geboortedatum";
            $backendName = "date";
            ?>
            <div class="mb-3">
                <label name=<?= $backendName ?> class="form-label" for="<?= $backendName ?>-id"><?= $frontendName ?></label>
                <?php if (isset($_SESSION[$backendName . "-error"])) : ?>
                    <input type="date" name="<?= $backendName ?>" class="form-control is-invalid" id="<?= $backendName ?>-id" placeholder="<?= $frontendName ?>" value="<?= htmlspecialchars(isset($_SESSION[$backendName]) ? $_SESSION[$backendName] : '') ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION[$backendName . "-error"] ?></div>
                    <?php unset($_SESSION[$backendName . "-error"]); ?>
                <?php else : ?>
                    <input type="date" name="<?= $backendName ?>" class="form-control" id="<?= $backendName ?>-id" placeholder="<?= $frontendName ?>" value="<?= htmlspecialchars(isset($_SESSION[$backendName]) ? $_SESSION[$backendName] : '') ?>" required />
                <?php endif ?>
            </div>

            <?php
            $frontendName = "Telefoonnummer";
            $backendName = "phoneNumber";
            ?>
            <div class="mb-3">
                <label name=<?= $backendName ?> class="form-label" for="<?= $backendName ?>-id"><?= $frontendName ?></label>
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

            <?php
            $frontendName = "Wachtwoord herhalen";
            $backendName = "passwordRepeat";
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
            <button type="submit" name="register" class="btn btn-primary">Registreren</button>
        </form>
    </div>
</section>