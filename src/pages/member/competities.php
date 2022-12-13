<?php

declare(strict_types=1);

?>
<section>
    <div class="container mt-5">
        <h3>Klant van wedstrijd zoeken</h3>
        <div style="width: 30%">
            <div class="input-group mb-5">
                <input type="text" class="form-control" id="customerInput" onkeyup="myFunction()" placeholder="Klant zoeken">
            </div>
        </div>
        <table class="table table-borderd fs-5" id="customerTable">
            <thead>
                <tr>
                    <th scope="col" class="border border-dark"></th>
                    <th scope="col" class="border border-dark">Speler wit <img src="../icon/whitePerson.svg"></th>
                    <th scope="col" class="border border-dark">Speler zwart <img src="../icon/blackPerson.svg"></th>
                    <th scope="col" class="border border-dark">Winnaar <img src="../icon/winner.svg"></th>
                    <th scope="col" class="border border-dark">Start <img src="../icon/clock.svg"></th>
                    <th scope="col" class="border border-dark">Einde <img src="../icon/clock.svg"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (Game::getAllGames() as $game) : ?>
                    <tr>
                        <td class="border border-dark"><img src="../img/ChessBoard.jpg" width="50px"></td>
                        <td class="border border-dark"><?= User::get($game["white_user_id"])->getName() ?></td>
                        <td class="border border-dark"><?= User::get($game["black_user_id"])->getName() ?></td>
                        <td class="border border-dark"><?= isset($game["winner_user_id"]) ?  User::get($game["winner_user_id"])->getName() : "Geen winnaar" ?></td>
                        <td class="border border-dark"><?= date("d-m-Y h:i", strtotime($game["start_time"])) ?></td>
                        <td class="border border-dark"><?= date("d-m-Y h:i", strtotime($game["end_time"])) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</section>

<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;

        input = document.getElementById("customerInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("customerTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td1 = tr[i].getElementsByTagName("td")[1];
            td2 = tr[i].getElementsByTagName("td")[2];
            if (td1) {
                txtValue1 = td1.textContent || td1.innerText;
                txtValue2 = td2.textContent || td2.innerText;
                txtValueCombi = txtValue1 + " " + txtValue2;

                if (
                    txtValue1.toUpperCase().indexOf(filter) > -1 ||
                    txtValue2.toUpperCase().indexOf(filter) > -1 ||
                    txtValueCombi.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>