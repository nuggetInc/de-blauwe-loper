<?php

if(!empty($_POST)){
    
    $whitePlayer = User::getByName($_POST["whitePlayer"]);
    $blackPlayer = User::getByName($_POST["blackPlayer"]);

    Game::register($whitePlayer->getId(), $blackPlayer->getId(), NULL, $_POST["startDate"], $_POST["endDate"]);
    header("Location: ".ROOT."/employee/competities");
}
?>

<!-- Add Text -->
<div class="d-flex justify-content-center mt-5 text-dark">
        <h2>Game <snap class="text-success">Aanmaken</snap></h2>
</div>

<!-- Add Form -->
<div class="container mt-2">
    <div class="d-flex align-items-center justify-content-center">
        <form style="width: 35%;" class="form-horizontal p-5 rounded" action="" method="POST">
            <label>Speler wit</label>
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <input type="text" name="whitePlayer" list="customers" class="form-control fs-4" required>
                <datalist id="customers">
                    <?php foreach (User::getAllMembers() as $member) : ?>
                        <option class="form-control fs-4" value="<?= $member["name"] ?>"></option>
                    <?php endforeach; ?>
                </datalist>
                <a href="<?= ROOT ?>/employee/leden/add"><button type="button" class="btn btn-lg btn-success m-2"><strong>+</strong></button></a>
            </div>
            <label>Speler zwart</label>
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <input type="text" name="blackPlayer" list="customers" class="form-control fs-4" required>
                <datalist id="customers">
                    <?php foreach (User::getAllMembers() as $member) : ?>
                        <option class="form-control fs-4" value="<?= $member["name"] ?>"></option>
                    <?php endforeach; ?>
                </datalist>
                <a href="<?= ROOT ?>/employee/leden/add"><button type="button" class="btn btn-lg btn-success m-2"><strong>+</strong></button></a>
            </div>
            <div class="mb-3">
                <label class="form-label">Start datum/tijd</label>
                <input type="datetime-local" class="form-control fs-4" name="startDate" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Eind datum/tijd</label>
                <input type="datetime-local" class="form-control fs-4" name="endDate">
            </div>
            <div class="form-text mb-3">*Start en Eind datum kunnen later altijd bijgewerkt worden</div>
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <a href="<?=ROOT?>/employee/competities"><button type="button" class="btn btn-lg btn-secondary text-dark">Terug</button></a>
                <input type="submit" class="btn btn-lg btn-success" value="Aanmaken">
            </div>
        </form>
    </div>
</div>