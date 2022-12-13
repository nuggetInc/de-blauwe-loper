<?php

$game = Game::get($_GET["id"]);
$winner = ($game->getWinnerUserId() !== NULL) ? User::get($game->getWinnerUserId())->getName() : "";

if(!empty($_POST)){
    
    $game->delete();
    header("Location: ".ROOT."/employee/competities");
}
?>

<!-- Add Text -->
<div class="d-flex justify-content-center mt-5 text-dark">
        <h2>Game <snap class="text-danger">Verwijderen</snap></h2>
</div>

<!-- Add Form -->
<div class="container mt-2">
    <div class="d-flex align-items-center justify-content-center">
        <form style="width: 35%;" class="form-horizontal p-5 rounded" action="" method="POST">
            <label>Speler wit</label>
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <input type="text" name="whitePlayer" list="customers" class="form-control fs-4" value="<?=User::get($game->getWhiteUserId())->getName()?>"c required readonly>
            </div>
            <label>Speler zwart</label>
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <input type="text" name="blackPlayer" list="customers" class="form-control fs-4" value="<?=User::get($game->getBlackUserId())->getName()?>" required readonly>
            </div>
            <label>Winnaar</label>
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <input type="text" name="winner" list="customers" class="form-control fs-4" value="<?=$winner?>" required readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Start datum/tijd</label>
                <input type="datetime-local" class="form-control fs-4" name="startDate" value="<?=$game->getStartTime()?>" required readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Eind datum/tijd</label>
                <input type="datetime-local" class="form-control fs-4" name="endDate" value="<?=$game->getEndTime()?>" readonly>
            </div>
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <a href="<?=ROOT?>/employee/competities"><button type="button" class="btn btn-lg btn-secondary text-dark">Terug</button></a>
                <input type="submit" class="btn btn-lg btn-danger" value="Verwijderen">
            </div>
        </form>
    </div>
</div>