<section>
    <div class="container mt-5">
        <h3>Klant van wedstrijd zoeken</h3>
        <div style="width: 30%">
            <div class="input-group mb-5">
                <input type="text" class="form-control" id="customerInput" onkeyup="myFunction()" placeholder="Klant zoeken">
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <a href="<?=ROOT . ROUTE?>/add">
                <button type="button" class="btn btn-lg btn-light text-success border border-dark mb-2">
                    <img src="../icon/addGame.svg">
                </button>
            </a>
        </div>
        <table class="table table-borderd fs-5" id="customerTable">
            <thead>
                <tr>
                    <th scope="col" class="border border-dark">.</th>
                    <th scope="col" class="border border-dark">Speler wit <img src="../icon/whitePerson.svg"></th>
                    <th scope="col" class="border border-dark">Speler zwart <img src="../icon/blackPerson.svg"></th>
                    <th scope="col" class="border border-dark">Winnaar <img src="../icon/winner.svg"></th>
                    <th scope="col" class="border border-dark">Start <img src="../icon/clock.svg"></th>
                    <th scope="col" class="border border-dark">Einde <img src="../icon/clock.svg"></th>
                    <th scope="col" class="border border-dark">Wijzigen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach(Game::getAllGames() as $game): ?>
                    <tr>
                    <td class="border border-dark"><img src="../img/ChessBoard.jpg" width="50px"></td>
                        <td class="border border-dark"><?=User::get($game["white_user_id"])->getName()?></td>
                        <td class="border border-dark"><?=User::get($game["black_user_id"])->getName()?></td>
                        <td class="border border-dark"><?=isset($game["winner_user_id"]) ?  User::get($game["winner_user_id"])->getName() : "Geen winnaar"?></td>
                        <td class="border border-dark"><?=date("d-m-Y h:m", strtotime($game["start_time"])) ?></td>
                        <td class="border border-dark"><?=date("d-m-Y h:m", strtotime($game["end_time"])) ?></td>
                        <td class="border border-dark pt-2">
                            <div class="d-flex justify-content-center text-dark pt-1">
                            <a href="<?=ROOT . ROUTE?>/edit?id=<?=$game["id"]?>">
                                <button type="button" class="btn btn-lg btn-light text-info">
                                    <img src="../icon/editMember.svg">
                                </button>
                            </a>
                            <a href="<?=ROOT . ROUTE?>/delete?id=<?=$game["id"]?>">
                                <button type="button" class="btn btn-lg btn-light text-danger">
                                    <img src="../icon/deleteMember.svg">
                                </button>
                                </div>
                            </a>
                        </td>
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

    for (i = 0; i < tr.length; i++) 
    {
        td1 = tr[i].getElementsByTagName("td")[1];
        td2 = tr[i].getElementsByTagName("td")[2];
        if (td1) 
        {
            txtValue1 = td1.textContent || td1.innerText;
            txtValue2 = td2.textContent || td2.innerText;

            if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1) 
            {
                tr[i].style.display = "";
            }     
            else 
            {
                tr[i].style.display = "none";
            }
        }  
    }
}
</script>


