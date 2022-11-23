<?php 

if(!empty($_POST)){
    
    $tempPass = rand(0, getrandmax());
    mail($_POST['email'], "Nieuw acount aangemaakt", 
    "Uw inlog gegevens. \n Naam/Inlog-naam: " . $_POST['name'] . "\n Tijdelijk wachtwoord: " . $tempPass . 
    "\n U kunt uw wachtwoord aanpassen bij mijn account beheren, als u bent inlogd.", 
    "From: info@bontemps.nl");

    $user = User::register($_POST['name'], $tempPass, 1);
    Member::register($user->getId(), $_POST['birthdate'], $_POST['phone'], $_POST['email']);
    header("Location: ". ROOT ."employee/leden");
    
}

?>

<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModal">Lid Toevoegen</h5>
                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body">
                <form action="" method="POST" id="addForm">
                    <div class="mb-3">
                        <label class="form-label">Naam</label>
                        <input type="text" name="name" class="form-control" placeholder="Naam..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Geboortedatum</label>
                        <input type="date" name="birthdate" class="form-control" placeholder="Geboortedatum...">
                    </div> 
                    <div class="mb-3">
                        <label class="form-label">Telefoonnummer</label>
                        <input type="number" name="phone" class="form-control" placeholder="Telefoonnummer..." required>
                    </div> 
                    <div class="mb-3">
                        <label class="form-label">Email adres</label>
                        <input type="email" name="email"class="form-control" placeholder="Email..." required>
                    </div> 
                    <div class="form-text">Lid krijgt mailtje met tijdelijk wachtwoord</div>  
                    <input type="submit">     
                </form>
            </div>
            <hr>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-dark" data-bs-dismiss="modal">Terug</button>
                <button type="button" class="btn btn-dark" from="addForm" type="submit">Lid toevoegen</button>
            </div>
        </div>
    </div>