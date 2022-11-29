<?php

if(!empty($_POST)){
    
    $code = rand(0, getrandmax());

    mail($_POST['email'], "Nieuw acount aangemaakt", 
    "Uw inlog gegevens. \n Email: " . $_POST['email'] . "\n Tijdelijk wachtwoord: " . $code . 
    "\n U kunt uw wachtwoord aanpassen bij mijn account beheren, als u bent inlogd.", 
    "From: info@deblauweloper.nl");

    $user = User::register($_POST['name'], $code, 1);
    Member::register($user->getId(), $_POST['date'], $_POST['phone'], $_POST['email']);
    header("Location: ".ROOT."/employee/leden");
    
}
?>

<!-- Add Text -->
<div class="d-flex justify-content-center mt-5 text-dark">
        <h2>Lid <snap class="text-success">Toevoegen</snap></h2>
</div>

<!-- Add Form -->
<div class="container mt-2">
    <div class="d-flex align-items-center justify-content-center">
        <form style="width: 35%;" class="form-horizontal p-5 rounded" action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Naam</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Geboortedatum</label>
                <input type="date" class="form-control fs-4" name="date"  required>
            </div>
            <div class="mb-3">
                <label class="form-label">Telefoonnummer</label>
                <input type="number" class="form-control fs-4" name="phone" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control fs-4" name="email" required>
            </div>
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <a href="<?=ROOT?>/employee/leden"><button type="button" class="btn btn-lg btn-secondary text-dark">Terug</button></a>
                <input type="submit" class="btn btn-lg btn-success" value="Toevoegen">
            </div>
        </form>
    </div>
</div>