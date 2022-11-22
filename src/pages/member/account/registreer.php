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
if(!empty($_POST)){
    if($_POST['password'] == $_POST['passwordRepeat']){
        $user = User::register($_POST['name'], $_POST['password'], 1);

        Member::register($user->getId(), );
        echo "Uw account is succesvol aangemaakt";
        header("Location: ".ROOT);
    }
}
unset($_POST);

?>