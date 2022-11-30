<?php

$user = User::get($_GET["id"]);
$member = Member::getByUser($user);

if(!empty($_POST)){
    
    $member->delete();
    header("Location: ".ROOT."/employee/leden");
}
?>

<!-- Add Text -->
<div class="d-flex justify-content-center mt-5 text-dark">
        <h2>Lid <snap class="text-danger">Verwijderen</snap></h2>
</div>

<!-- Add Form -->
<div class="container mt-2">
    <div class="d-flex align-items-center justify-content-center">
        <form style="width: 35%;" class="form-horizontal p-5 rounded" action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Naam</label>
                <input type="text" class="form-control fs-4" name="name" value="<?=$user->getName()?>" required readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Geboortedatum</label>
                <input type="date" class="form-control fs-4" name="date" value="<?=$member->getBirthdate()?>" required readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Telefoonnummer</label>
                <input type="number" class="form-control fs-4" name="phone" value="<?=$member->getPhone()?>" required readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control fs-4" name="email" value="<?=$member->getEmail()?>" required readonly>
            </div>
            <div class="mt-4 d-flex align-items-center justify-content-between">
                <a href="<?=ROOT?>/employee/leden"><button type="button" class="btn btn-lg btn-secondary text-dark">Terug</button></a>
                <input type="submit" class="btn btn-lg btn-danger" value="Verwijdern">
            </div>
        </form>
    </div>
</div>