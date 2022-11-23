<?php if(!empty($_GET["delete"])) :?>
<?php $member = Member::getByUserId((int)$_GET["delete"]); ?>

<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModal">Lid verwijderen</h5>
                
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <hr>
            <div class="modal-body">
                <form action="" method="POST">
                <div class="mb-3">
                        <label class="form-label">Naam</label>
                        <input type="email" class="form-control" value="<?=User::get($member->getUserId())->getName();?>" required readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Geboortedatum</label>
                        <input type="email" class="form-control" value="<?=$member->getBirthdate();?>" required readonly>
                    </div> 
                    <div class="mb-3">
                        <label class="form-label">Telefoonnummer</label>
                        <input type="email" class="form-control" value="<?=$member->getPhone();?>" required readonly>
                    </div> 
                    <div class="mb-3">
                        <label class="form-label">Email adres</label>
                        <input type="email" class="form-control" value="<?=$member->getEmail();?>" required readonly> 
                    </div>        
                </form>
            </div>
            <hr>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-dark" data-bs-dismiss="modal">Terug</button>
                <button type="button" class="btn btn-dark">Lid toevoegen</button>
            </div>
        </div>
    </div>
<?php endif ?>