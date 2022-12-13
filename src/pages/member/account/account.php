<?php

declare(strict_types=1);

if (!isset($_SESSION["user"])) {
    header("Location: " . ROOT . "/member/account/login-registreer");
    exit;
}

$user = $_SESSION["user"];
$member = Member::getByUser($user);

// If the edit information form was submitted.
if (isset($_POST["edit-account"], $_POST["name"], $_POST["birthdate"], $_POST["phone"], $_POST["email"])) {
    // Check if name only contains letters, spaces and "!"'s.
    if (!preg_match("/^[a-zA-Z0-9! ]+$/", $_POST["name"]))
        $_SESSION["name-error"] = "Naam mag alleen letters en spaties bevatten";

    // Check if birthdate is before today.
    if (strtotime($_POST["birthdate"]) > time())
        $_SESSION["birthdate-error"] = "Geboortedatum moet voor vandaag zijn";

    // Check if phone only contains numbers and an optional + at the start.
    if (!preg_match("/^\+?[0-9 ]+$/", $_POST["phone"]))
        $_SESSION["phone-error"] = "Telefoonnummer is incorrect";

    // Check if email is valid.
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
        $_SESSION["email-error"] = "Email is incorrect";

    // Save data en reload if any errors are set.
    if (isset($_SESSION["name-error"]) || isset($_SESSION["birthdate-error"]) || isset($_SESSION["phone-error"]) || isset($_SESSION["email-error"])) {
        $_SESSION["name"] = $_POST["name"];
        $_SESSION["birthdate"] = $_POST["birthdate"];
        $_SESSION["phone"] = $_POST["phone"];
        $_SESSION["email"] = $_POST["email"];

        header("Location: " . PATH);
        exit;
    }

    // Update database when all checks pass.
    $_SESSION["user"] = User::update($user->getId(), $_POST["name"], $user->getMember());
    Member::update($member->getId(), $user->getId(), $_POST["birthdate"], $_POST["phone"], $_POST["email"]);

    // Reload the page to clear POST.
    header("Location: " . PATH);
    exit;
}

// If the edit password form was submitted.
if (isset($_POST["edit-password"], $_POST["password"], $_POST["re-password"])) {
    // Check if passwords match
    if ($_POST["password"] !== $_POST["re-password"])
        $_SESSION["re-password-error"] = "Wachtwoorden komen niet overheen";

    // Check if password contains at least 4 characters
    if (strlen($_POST["password"]) < 4)
        $_SESSION["password-error"] = "Wachtwoord moet minstens vier characters bevatten";

    // Save data en reload if any errors are set.
    if (isset($_SESSION["password-error"]) || isset($_SESSION["re-password-error"])) {
        header("Location: " . PATH);
        exit;
    }

    // Update database when all checks pass.
    User::updatePassword($user->getId(), $_POST["password"]);

    // Reload the page to clear POST.
    header("Location: " . PATH);
    exit;
}

// If the delete account form was submitted.
if (isset($_POST["delete-account"])) {
    // Delete member and associated data.
    $member->delete();

    // Logout the user.
    unset($_SESSION["user"]);

    // Reload the page to clear POST.
    header("Location: " . ROOT . "/member/account/registreer");
    exit;
}

// Set form values to the database value if they aren't set by a previous submit.
$_SESSION["name"] = $_SESSION["name"] ?? $user->getName();
$_SESSION["birthdate"] = $_SESSION["birthdate"] ?? $member->getBirthdate();
$_SESSION["phone"] = $_SESSION["phone"] ?? $member->getPhone();
$_SESSION["email"] = $_SESSION["email"] ?? $member->getEmail();

// Set form placeholders to the database value.
$_SESSION["name-placeholder"] = $user->getName();
$_SESSION["phone-placeholder"] = $member->getPhone();
$_SESSION["email-placeholder"] = $member->getEmail();

?>
<section class="container mt-5">
    <div class="row justify-content-between gy-4">
        <!-- Edit account information form -->
        <form class="col-lg-5" method="POST">
            <h1 class="mb-3">Account wijzigen</h1>

            <!-- Name input -->
            <div class="mb-3">
                <label name="name" class="form-label" for="inputName">Naam</label>
                <?php if (isset($_SESSION["name-error"])) : ?>
                    <input type="text" name="name" class="form-control is-invalid" id="inputName" placeholder="<?= htmlspecialchars($_SESSION["name-placeholder"]) ?>" value="<?= htmlspecialchars($_SESSION["name"]) ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION["name-error"] ?></div>
                <?php else : ?>
                    <input type="text" name="name" class="form-control" id="inputName" placeholder="<?= htmlspecialchars($_SESSION["name-placeholder"]) ?>" value="<?= htmlspecialchars($_SESSION["name"]) ?>" required />
                <?php endif ?>
            </div>

            <!-- Birthdate input -->
            <div class="mb-3">
                <label name="birthdate" class="form-label" for="inputBirthdate">Geboortedatum</label>
                <?php if (isset($_SESSION["birthdate-error"])) : ?>
                    <input type="date" name="birthdate" class="form-control is-invalid" id="inputBirthdate" value="<?= $_SESSION["birthdate"] ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION["birthdate-error"] ?></div>
                <?php else : ?>
                    <input type="date" name="birthdate" class="form-control" id="inputBirthdate" value="<?= $_SESSION["birthdate"] ?>" required />
                <?php endif ?>
            </div>

            <!-- Phonenumber input -->
            <div class="mb-3">
                <label name="phone" class="form-label" for="inputPhone">Telefoonnummer</label>
                <?php if (isset($_SESSION["phone-error"])) : ?>
                    <input type="text" name="phone" class="form-control is-invalid" id="inputPhone" placeholder="<?= htmlspecialchars($_SESSION["phone-placeholder"]) ?>" value="<?= htmlspecialchars($_SESSION["phone"]) ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION["phone-error"] ?></div>
                <?php else : ?>
                    <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="<?= htmlspecialchars($_SESSION["phone-placeholder"]) ?>" value="<?= htmlspecialchars($_SESSION["phone"]) ?>" required />
                <?php endif ?>
            </div>

            <!-- Email input -->
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
            <!-- Edit account password form -->
            <form method="POST">
                <h1 class=" mb-3">Wachtwoord wijzigen</h1>

                <!-- Password input -->
                <div class="mb-3">
                    <label name="password" class="form-label" for="inputPassword">Wachtwoord</label>
                    <?php if (isset($_SESSION["password-error"])) : ?>
                        <input type="password" name="password" class="form-control is-invalid" id="inputPassword" required />
                        <div class="invalid-feedback"><?= $_SESSION["password-error"] ?></div>
                    <?php else : ?>
                        <input type="password" name="password" class="form-control" id="inputPassword" required />
                    <?php endif ?>
                </div>

                <!-- Repeat password input -->
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
            <!-- Delete account form -->
            <div class="mt-4">
                <h1>Account Verwijderen</h1>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    Verwijderen
                </button>
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Verwijderen</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Account permanent verwijderen?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                <form method="POST">
                                    <button type="submit" name="delete-account" class="btn btn-danger">Verwijderen</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php

// Clear all the sessions that where set.
// This is needed because errors can appear on other pages otherwise.

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