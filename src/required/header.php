<nav class="navbar bg-light navbar-expand-md navbar-light shadow-sm">
    <div class="container">
        <img src="<?= ROOT ?>/img/Logo.png" width="60px">
        <a href="<?= ROOT ?>" class="text-decoration-none ms-5">
            <h2 class="text-dark p-2">De Blauwe Loper</span></h2>
        </a>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="nav nav-pills nav-fill ms-auto">
                <?php foreach (Pages::getPagesFileNames() as $value) : ?>
                    <?php if ($route == $value) : ?>
                        <a class="text-decoration-none" href="<?= ROOT . "/$value" ?>">
                            <div class="bg-dark rounded m-1" style="padding: 10px">
                                <li class="text-light"><?= (!empty($value)) ? ucfirst($value) : "start" ?></li>
                            </div>
                        </a>
                    <?php else : ?>
                        <a class="text-decoration-none" href="<?= ROOT . "/$value" ?>">
                            <div class="bg-secondary rounded m-1" style="padding: 10px">
                                <li class="text-dark"><?= (!empty($value)) ? ucfirst($value) : "start" ?></li>
                            </div>
                        </a>
                    <?php endif ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>