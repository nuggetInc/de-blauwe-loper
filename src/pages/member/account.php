<?php

declare(strict_types=1);

// Temparay until login works
$_SESSION["user"] = User::get(1);

$user = $_SESSION["user"];
$member = Member::getByUser($user);

if (isset($_POST["edit-account"], $_POST["name"], $_POST["birthdate"], $_POST["phone"], $_POST["email"])) {
    if (!preg_match("/^[a-zA-Z! ]+$/", $_POST["name"]))
        $_SESSION["name-error"] = "Naam mag alleen letters en spaties bevatten";

    if (strtotime($_POST["birthdate"]) > time())
        $_SESSION["birthdate-error"] = "Geboortedatum moet voor vandaag zijn";

    if (!preg_match("/^[0-9 +]+$/", $_POST["phone"]))
        $_SESSION["phone-error"] = "Telefoonnummer is incorrect";

    if (!preg_match("/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+$/", $_POST["email"]))
        $_SESSION["email-error"] = "Email is incorrect";

    if (isset($_SESSION["name-error"]) || isset($_SESSION["birthdate-error"]) || isset($_SESSION["phone-error"]) || isset($_SESSION["email-error"])) {
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["birthdate"] = $_POST["birthdate"];
        $_SESSION["phone"] = $_POST["phone"];
        $_SESSION["email"] = $_POST["email"];

        header("Location: " . PATH);
        exit;
    }

    User::update($user->getId(), $_POST["name"], $user->getMember());
    Member::update($member->getId(), $user->getId(), $_POST["birthdate"], $_POST["phone"], $_POST["email"]);

    header("Location: " . PATH);
    exit;
}

if (isset($_POST["edit-password"], $_POST["password"], $_POST["re-password"])) {
    if ($_POST["password"] !== $_POST["re-password"])
        $_SESSION["re-password-error"] = "Wachtwoorden komen niet overheen";

    if (strlen($_POST["password"]) < 4)
        $_SESSION["password-error"] = "Wachtwoord moet minstens vier characters bevatten";

    if (isset($_SESSION["password-error"]) || isset($_SESSION["re-password-error"])) {
        header("Location: " . PATH);
        exit;
    }

    User::updatePassword($user->getId(), $_POST["password"]);

    header("Location: " . PATH);
    exit;
}

if (isset($_POST["delete-account"])) {
    User::delete($user->getId());
    Member::delete($member->getId());

    header("Location: " . PATH);
    exit;
}

$_SESSION["name"] = $_SESSION["name"] ?? $user->getName();
$_SESSION["birthdate"] = $_SESSION["birthdate"] ?? $member->getBirthdate();
$_SESSION["phone"] = $_SESSION["phone"] ?? $member->getPhone();
$_SESSION["email"] = $_SESSION["email"] ?? $member->getEmail();

$_SESSION["name-placeholder"] = $user->getName();
$_SESSION["phone-placeholder"] = $member->getPhone();
$_SESSION["email-placeholder"] = $member->getEmail();

?>
<section class="container mt-5">
    <div class="row justify-content-between gy-4">
        <form class="col-lg-5" method="POST">
            <h1 class="mb-3">Account wijzigen</h1>

            <div class="mb-3">
                <label name="name" class="form-label" for="inputName">Naam</label>
                <?php if (isset($_SESSION["name-error"])) : ?>
                    <input type="text" name="name" class="form-control is-invalid" id="inputName" placeholder="<?= htmlspecialchars($_SESSION["name-placeholder"]) ?>" value="<?= htmlspecialchars($_SESSION["name"]) ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION["name-error"] ?></div>
                <?php else : ?>
                    <input type="text" name="name" class="form-control" id="inputName" placeholder="<?= htmlspecialchars($_SESSION["name-placeholder"]) ?>" value="<?= htmlspecialchars($_SESSION["name"]) ?>" required />
                <?php endif ?>
            </div>

            <div class="mb-3">
                <label name="birthdate" class="form-label" for="inputBirthdate">Geboortedatum</label>
                <?php if (isset($_SESSION["birthdate-error"])) : ?>
                    <input type="date" name="birthdate" class="form-control is-invalid" id="inputBirthdate" value="<?= $_SESSION["birthdate"] ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION["birthdate-error"] ?></div>
                <?php else : ?>
                    <input type="date" name="birthdate" class="form-control" id="inputBirthdate" value="<?= $_SESSION["birthdate"] ?>" required />
                <?php endif ?>
            </div>

            <div class="mb-3">
                <label name="phone" class="form-label" for="inputPhone">Telefoonnummer</label>
                <?php if (isset($_SESSION["phone-error"])) : ?>
                    <input type="text" name="phone" class="form-control is-invalid" id="inputPhone" placeholder="<?= htmlspecialchars($_SESSION["phone-placeholder"]) ?>" value="<?= htmlspecialchars($_SESSION["phone"]) ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION["phone-error"] ?></div>
                <?php else : ?>
                    <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="<?= htmlspecialchars($_SESSION["phone-placeholder"]) ?>" value="<?= htmlspecialchars($_SESSION["phone"]) ?>" required />
                <?php endif ?>
            </div>

            <div class="mb-3">
                <label name="email" class="form-label" for="inputEmail">Email</label>
                <?php if (isset($_SESSION["email-error"])) : ?>
                    <input type="email" name="email" class="form-control is-invalid" id="inputEmail" placeholder="<?= htmlspecialchars($_SESSION["email-placeholder"]) ?>" value="<?= htmlspecialchars($_SESSION["email"]) ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION["email-error"] ?></div>
                <?php else : ?>
                    <input type="email" name="email" class="form-control" id="inputEmail" placeholder="<?= htmlspecialchars($_SESSION["email-placeholder"]) ?>" value="<?= htmlspecialchars($_SESSION["email"]) ?>" required />
                <?php endif ?>
            </div>

            <button type="submit" name="edit-account" class="btn btn-primary">Wijzigen</button>
        </form>
        <div class="d-flex flex-column col-lg-5">
            <form method="POST">
                <h1 class=" mb-3">Wachtwoord wijzigen</h1>

                <div class="mb-3">
                    <label name="password" class="form-label" for="inputPassword">Wachtwoord</label>
                    <?php if (isset($_SESSION["password-error"])) : ?>
                        <input type="password" name="password" class="form-control is-invalid" id="inputPassword" required />
                        <div class="invalid-feedback"><?= $_SESSION["password-error"] ?></div>
                    <?php else : ?>
                        <input type="password" name="password" class="form-control" id="inputPassword" required />
                    <?php endif ?>
                </div>

                <div class="mb-3">
                    <label name="re-password" class="form-label" for="inputRePassword">Email</label>
                    <?php if (isset($_SESSION["re-password-error"])) : ?>
                        <input type="password" name="re-password" class="form-control is-invalid" id="inputRePassword" required />
                        <div class="invalid-feedback"><?= $_SESSION["re-password-error"] ?></div>
                    <?php else : ?>
                        <input type="password" name="re-password" class="form-control" id="inputRePassword" required />
                    <?php endif ?>
                </div>

                <button type="submit" name="edit-password" class="btn btn-primary">Wijzigen</button>
            </form>
            <form class="mt-4" method="POST">
                <h1>Account Verwijderen</h1>
                <button type="submit" name="delete-account" class="btn btn-primary">Verwijderen</button>
            </form>
        </div>
    </div>
</section>
<?php

unset($_SESSION["name"]);
unset($_SESSION["birthdate"]);
unset($_SESSION["phone"]);
unset($_SESSION["email"]);

unset($_SESSION["name-placeholder"]);
unset($_SESSION["phone-placeholder"]);
unset($_SESSION["email-placeholder"]);

unset($_SESSION["name-error"]);
unset($_SESSION["birthdate-error"]);
unset($_SESSION["phone-error"]);
unset($_SESSION["email-error"]);
unset($_SESSION["password-error"]);
unset($_SESSION["re-password-error"]);

?>