<?php

require_once(__DIR__ . '/../../Modele/messages.php');

$nombreNonLus = getNombreMessagesNonLus(
    $bdd,
    (int) $_SESSION['id']
);

?>

<nav class="pcoded-navbar  ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div " >
            <div class="">

                <div class="collapse" id="nav-user-link">
                    <ul class="list-unstyled">
                        <li class="list-group-item"><a href="user-profile.html"><i class="feather icon-user m-r-5"></i>Voir le profil</a></li>
                        <li class="list-group-item"><a href="auth-normal-sign-in.html"><i class="feather icon-log-out m-r-5"></i>Déconnexion</a></li>
                    </ul>
                </div>
            </div>
            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption">
                    <label>Profil</label>
                </li>
                <li class="nav-item">
                    <a href="../../Controleur/compte/profil.php" class="nav-link ">
							<span class="pcoded-micon">
								<i class="feather icon-home"></i>
							</span><span class="pcoded-mtext">Mes informations</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../Controleur/compte/editionprofil.php" class="nav-link ">
							<span class="pcoded-micon">
								<i class="feather icon-layout"></i></span>
                        <span class="pcoded-mtext">Modifier mes informations</span>
                    </a>
                </li>
                <li class="nav-item pcoded-menu-caption">
                    <label>Publications</label>
                </li>
                <li class="nav-item">
                    <a href="../../Controleur/publications/publication.php" class="nav-link ">
							<span class="pcoded-micon">
								<i class="feather icon-box"></i>
							</span><span class="pcoded-mtext">Mes publications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../../Controleur/publications/actu.php" class="nav-link ">
							<span class="pcoded-micon">
								<i class="feather icon-box"></i>
							</span><span class="pcoded-mtext">Fil d'actualité</span>
                    </a>
                </li>
                <li class="nav-item pcoded-menu-caption">
                    <label>Messages</label>
                </li>

                <li class="nav-item">
                    <a href="../../Controleur/messages/reception.php" class="nav-link ">
						<span class="pcoded-micon">
							<i class="feather icon-file-text"></i>
						</span>
                        <span class="pcoded-mtext">
                            Mes messages

                            <?php if ($nombreNonLus > 0): ?>
                                <span class="badge badge-danger ml-1">
                                    <?= $nombreNonLus ?>
                                </span>
                            <?php endif; ?>

                        </span>
                    </a>
                </li>

                <li class="nav-item pcoded-menu-caption">
                    <label>Deconnexion</label>
                </li>
                <li class="nav-item">
                    <a href="../../Controleur/compte/deconnexion.php" class="nav-link ">
							<span class="pcoded-micon">
								<i class="feather icon-file-text"></i>
							</span>
                        <span class="pcoded-mtext">Me déconnecter</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>