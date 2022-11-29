


<section>
    <div class="container mt-5">
        <h3>Klant zoeken</h3>
        <div style="width: 30%">
            <div class="input-group mb-5">
                <input type="text" class="form-control" id="customerInput" onkeyup="myFunction()" placeholder="Klant zoeken">
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <a href="<?=ROOT . ROUTE?>/add">
                <button type="button" class="btn btn-lg btn-light text-success border border-dark mb-2">
                    <?php require("../public/icon/addMember.html"); ?>
                </button>
            </a>
        </div>
        <table class="table table-borderd fs-5" id="customerTable">
            <thead>
                <tr>
                    <th scope="col" class="border border-dark">Naam</th>
                    <th scope="col" class="border border-dark">Birthdate</th>
                    <th scope="col" class="border border-dark">Telefoonnummer</th>
                    <th scope="col" class="border border-dark">Email</th>
                    <th scope="col" class="border border-dark">Wijzigen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach(User::getAllMembers() as $member): ?>
                    <tr>
                        <?php for($i = 0; $i < (count($member)/2)-1; $i++): ?>
                            <td class="border border-dark"><?=$member[$i]?></td>
                        <?php endfor ?>
                        <td class="border border-dark pt-2">
                            <div class="d-flex justify-content-center text-dark pt-1">
                            <a href="<?=ROOT . ROUTE?>/edit?id=<?=$member["id"]?>">
                                <button type="button" class="btn btn-lg btn-light text-info">
                                    <?php require("../public/icon/editMember.html"); ?>
                                </button>
                            </a>
                            <a href="<?=ROOT . ROUTE?>/delete?id=<?=$member["id"]?>">
                                <button type="button" class="btn btn-lg btn-light text-danger">
                                    <?php require("../public/icon/deleteMember.html"); ?>
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
        td = tr[i].getElementsByTagName("td")[0];
        if (td) 
        {
            txtValue = td.textContent || td.innerText;

            if (txtValue.toUpperCase().indexOf(filter) > -1) 
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


