<form method="post">
    <label>
        gebruikersnaam:
        <input type="text" name="name" required>
    </label>
    <label>
        wachtwoord:
        <input type="password" name="password" required>
    </label>   <label>
        wachtwoord herhalen:
        <input type="password" name="passwordRepeat" required>
    </label>
    <input type="submit" name="register" value="registreren" required>
</form>

<?php
if(isset($_POST)){
    if($_POST['password'] == $_POST['passwordRepeat']){
        User::register($_POST['name'], $_POST['password'], 1);
        echo "Uw account is succesvol aangemaakt";
        header("Location".ROOT);
    }
}
unset($_POST);

?>