<?php

use PitouFW\Core\Persist;

?>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Active users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format(Persist::count('CoreUser', "WHERE active = ?", [1])) ?></div>
                    </div>
                    <div class="col-auto text-primary">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Clients</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format(Persist::count('CoreClientApp')) ?></div>
                    </div>
                    <div class="col-auto text-success">
                        <i class="fa fa-user-tie"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Subscribers</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format(Persist::count('CoreCustomer')) ?></div>
                    </div>
                    <div class="col-auto text-info">
                        <i class="fa fa-newspaper"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Accounts created</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format(Persist::count('CoreUserLogin')) ?></div>
                    </div>
                    <div class="col-auto text-warning">
                        <i class="fa fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Active developpers</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format(Persist::count('ConsoleUser', "WHERE email_token=1")) ?></div>
                    </div>
                    <div class="col-auto text-primary">
                        <i class="fa fa-user-graduate"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Developers organizations</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format(Persist::count('ConsoleOrganization')) ?></div>
                    </div>
                    <div class="col-auto text-success">
                        <i class="fa fa-user-friends"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Awaiting tickets</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                    </div>
                    <div class="col-auto text-danger">
                        <i class="fa fa-wrench"></i>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>
