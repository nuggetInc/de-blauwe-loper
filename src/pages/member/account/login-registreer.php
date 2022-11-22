<?php 


$_SESSION["user"] = User::get(1);

header("Location: ".ROOT);


?>