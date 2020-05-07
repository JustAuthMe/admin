<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Persist;
use PitouFW\Core\Request as R;
use PitouFW\Model\AdminPermission as P;
use PitouFW\Model\AdminUser;

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel=icon type="image/png" href="<?= IMG ?>icon.png">
    <title><?= NAME . (isset($TITLE) ? ' - ' . $TITLE : '') ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= ASSETS ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= ASSETS ?>css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= CSS ?>style.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="<?= ASSETS ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= ASSETS ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= ASSETS ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= ASSETS ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= ASSETS ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= WEBROOT ?>">
            <img src="<?= IMG ?>logo_big.png" width="75%" />
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <?php if (P::p('home')): ?>
        <li class="nav-item <?= R::r('home') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= WEBROOT ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <?php endif ?>

        <!--
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Interface
        </div> -->

        <!-- Nav Item - Utilities Collapse Menu -->
        <?php if (P::p(['core/users','core/apps'])): ?>
        <li class="nav-item <?= R::r('core') ? 'active' : '' ?>">
            <a class="nav-link <?= !R::r('core') ? 'collapsed' : '' ?>" href="#" data-toggle="collapse" data-target="#collapseOne"
               aria-expanded="<?= R::r('core') ? 'true' : 'false' ?>" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Core backend</span>
            </a>
            <div id="collapseOne" class="collapse <?= R::r('core') ? 'show' : '' ?>" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= R::r('core/users') ? 'active' : '' ?>" href="<?= WEBROOT ?>core/users">Users</a>
                    <a class="collapse-item <?= R::r('core/apps') ? 'active' : '' ?>" href="<?= WEBROOT ?>core/apps">Apps</a>
                    <a class="collapse-item <?= R::r('core/alert') ? 'active' : '' ?>" href="<?= WEBROOT ?>core/alert">Alert banner</a>
                </div>
            </div>
        </li>
        <?php endif ?>

        <!-- Nav Item - Pages Collapse Menu -->
        <?php if(P::p(['console/users','console/teams','console/invitation'])): ?>
        <li class="nav-item <?= R::r('console') ? 'active' : '' ?>">
            <a class="nav-link <?= !R::r('console') ? 'collapsed' : '' ?>" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="<?= R::r('console') ? 'true' : 'false' ?>" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-code"></i>
                <span>Developers console</span>
            </a>
            <div id="collapseTwo" class="collapse <?= R::r('console') ? 'show' : '' ?>" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= R::r('console/users') ? 'active' : '' ?>" href="<?= WEBROOT ?>console/users">Users</a>
                    <a class="collapse-item <?= R::r('console/teams') ? 'active' : '' ?>" href="<?= WEBROOT ?>console/teams">Teams</a>
                    <a class="collapse-item <?= R::r('console/invitations') ? 'active' : '' ?>" href="<?= WEBROOT ?>console/invitations">Invitations</a>
                </div>
            </div>
        </li>
        <?php endif ?>

        <!-- Nav Item - Pages Collapse Menu -->
        <?php if (P::p(['website/pages'])): ?>
        <li class="nav-item <?= R::r('website') ? 'active' : '' ?>">
            <a class="nav-link <?= !R::r('website') ? 'collapsed' : '' ?>" href="#" data-toggle="collapse" data-target="#collapseThree"
               aria-expanded="<?= R::r('website') ? 'true' : 'false' ?>>" aria-controls="collapseThree">
                <i class="fas fa-fw fa-image"></i>
                <span>Commercial website</span>
            </a>
            <div id="collapseThree" class="collapse <?= R::r('website') ? 'show' : '' ?>" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= R::r('website/pages') ? 'active' : '' ?>" href="<?= WEBROOT ?>website/pages">Static pages</a>
                </div>
            </div>
        </li>
        <?php endif ?>

        <!-- Nav Item - Pages Collapse Menu -->
        <?php if (P::p(['prospects/manage'])): ?>
            <li class="nav-item <?= R::r('prospects') ? 'active' : '' ?>">
                <a class="nav-link <?= !R::r('prospects') ? 'collapsed' : '' ?>" href="#" data-toggle="collapse" data-target="#collapseFour"
                   aria-expanded="<?= R::r('prospects') ? 'true' : 'false' ?>>" aria-controls="collapseFour">
                    <i class="fas fa-fw fa-user-tie"></i>
                    <span>Prospects</span>
                </a>
                <div id="collapseFour" class="collapse <?= R::r('prospects') ? 'show' : '' ?>" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= R::r('prospects/pitch-mails') ? 'active' : '' ?>" href="<?= WEBROOT ?>prospects/pitch-mails">Pitch e-mails</a>
                        <a class="collapse-item <?= R::r('prospects/manager') ? 'active' : '' ?>" href="<?= WEBROOT ?>prospects/manager">Management</a>
                    </div>
                </div>
            </li>
        <?php endif ?>

        <!-- Nav Item - Pages Collapse Menu -->
        <?php if (P::p('support')): ?>
        <!-- <li class="nav-item <?= R::r('support') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= WEBROOT ?>support">
                <i class="fas fa-fw fa-hands-helping"></i>
                <span>Support</span>
            </a>
        </li> -->
        <?php endif ?>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Pages Collapse Menu -->
        <?php if (P::p(['admin/users','admin/roles','admin/permission','admin/invitations'])): ?>
        <li class="nav-item <?= R::r('admin') ? 'active' : '' ?>">
            <a class="nav-link <?= !R::r('admin') ? 'collapsed' : '' ?>" href="#" data-toggle="collapse" data-target="#collapseAdmin"
               aria-expanded="<?= R::r('admin') ? 'ture' : 'false' ?>" aria-controls="collapseAdmin">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Admin panel</span>
            </a>
            <div id="collapseAdmin" class="collapse <?= R::r('admin') ? 'show' : '' ?>" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= R::r('admin/users') ? 'active' : '' ?>" href="<?= WEBROOT ?>admin/users">Users</a>
                    <a class="collapse-item <?= R::r('admin/roles') ? 'active' : '' ?>" href="<?= WEBROOT ?>admin/roles">Roles</a>
                    <a class="collapse-item <?= R::r('admin/permissions') ? 'active' : '' ?>" href="<?= WEBROOT ?>admin/permissions">Permissions</a>
                    <a class="collapse-item <?= R::r('admin/invitations') ? 'active' : '' ?>" href="<?= WEBROOT ?>admin/invitations">Invitations</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <?php endif ?>

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Search -->
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - Messages
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-envelope fa-fw"></i>
                            <span class="badge badge-danger badge-counter">7</span>
                        </a>
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">
                                Message Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                                    <div class="status-indicator"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                                    <div class="small text-gray-500">Jae Chun · 1d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                                    <div class="status-indicator bg-warning"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div> -->

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= AdminUser::get()->getFirstname() . ' ' . AdminUser::get()->getLastname() ?></span>
                            <img class="img-profile rounded-circle" src="<?= AdminUser::get()->getAvatar() ?>">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?= WEBROOT ?>profile">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                <?= isset($_SESSION['imp']) && Persist::exists('AdminUser', 'id', $_SESSION['imp']) ? 'Stop impersonation' : 'Logout' ?>
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <?php if (isset($TITLE)): ?>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?= $TITLE  ?></h1>
                </div>
                <?php endif;
                echo Alert::handle();
                require_once @$appView; ?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; 2019<?= date('Y') > 2019 ? ' - ' . date('Y') : '' ?> JustAuthMe SAS - <?= DEPLOYED_REF; ?></span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= WEBROOT ?>logout">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Custom scripts for all pages-->
<script src="<?= ASSETS ?>js/sb-admin-2.min.js"></script>
<script src="<?= JS ?>markdown.min.js"></script>
<script src="<?= JS ?>script.js"></script>

</body>

</html>
