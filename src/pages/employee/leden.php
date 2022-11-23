<section>
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-lg btn-light text-dark border border-dark mb-2" data-bs-toggle="modal" data-bs-target="#addModal">
                <?php require("../public/icon/addMember.html"); ?>
            </button>
        </div>
        <table class="table table-borderd fs-5">
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
                            <a href="?edit=<?=$member["id"]?>">
                                <button type="button" class="btn btn-lg btn-light text-dark">
                                    <?php require("../public/icon/editMember.html"); ?>
                                </button>
                            </a>
                            <a href="?delete=<?=$member["id"]?>">
                                <button type="button" class="btn btn-lg btn-light text-dark">
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

<!-- addModal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <?php require("ledenModals/addModal.php") ?>
</div>

<!-- editModal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <?php require("ledenModals/editModal.php") ?>
</div>

<!-- deleteModal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <?php require("ledenModals/deleteModal.php") ?>
</div>

<script>
    // const getDelete = new ;
    // const getEdit = new ;
    if(new URLSearchParams(window.location.search).get('delete') != null)
    {
        console.log("delete");
        showModal('deleteModal');
    }
    if(new URLSearchParams(window.location.search).get('edit') != null)
    {
        console.log("edit");
        showModal('editModal');
    }
    

    function showModal(modalId)
    {
        var myModal = new bootstrap.Modal(document.getElementById(modalId), {
        keyboard: false
        })
        myModal.toggle();
    }
</script>


