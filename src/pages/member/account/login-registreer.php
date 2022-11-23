<form method="post">
    <div>   
        <label>Naam</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Wachtwoord</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit" name="login" value="login">Inloggen</button>
</form>
<?php
if (!empty($_POST)) 
{
    $user = User::login($_POST['name'],$_POST['password']);

    if(isset($user))
    {
        $_SESSION['user'] = $user;
        header('Location:'.ROOT );
    }
}

?>