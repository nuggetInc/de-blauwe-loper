<?php

declare(strict_types=1);

$user = User::get(1);
$member = Member::getByUser($user);

$_SESSION["name-placeholder"] = $_SESSION["name"] = $user->getName();
$_SESSION["birthdate"] = $member->getBirthdate();
$_SESSION["phone-placeholder"] = $_SESSION["phone"] = $member->getPhone();
$_SESSION["email-placeholder"] = $_SESSION["email"] = $member->getEmail();








?>
<section class="container mt-5">
    <div class="row justify-content-between gy-4">
        <form class="col-lg-5">
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
                    <input type="date" name="birtdate" class="form-control is-invalid" id="inputBirthdate" value="<?= date("Y-m-d", $_SESSION["birthdate"]) ?>" required />
                    <div class="invalid-feedback"><?= $_SESSION["birthdate-error"] ?></div>
                <?php else : ?>
                    <input type="date" name="birtdate" class="form-control" id="inputBirthdate" value="<?= date("Y-m-d", $_SESSION["birthdate"]) ?>" required />
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

            <button type="submit" name="account" class="btn btn-primary">Wijzigen</button>
        </form>
        <div class="d-flex flex-column col-lg-5">
            <form>
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

                <button type="submit" name="password" class="btn btn-primary">Wijzigen</button>
            </form>
            <form class="mt-4">
                <h1>Account Verwijderen</h1>
                <button type="submit" name="delete" class="btn btn-primary">Verwijderen</button>
            </form>
        </div>
    </div>
</section>