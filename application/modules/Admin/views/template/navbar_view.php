<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url() . 'Admin/home' ?>">ART DASHBOARD v1.0</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> Profile</a>
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url() . 'Admin/Auth/Auth_login/user_logout'; ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?php echo base_url() . 'Admin/home' ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="<?php echo base_url() . 'Admin/sites'; ?>"><i class="fa fa-edit fa-fw"></i> Sites</a>
                </li>
                <li>
                    <a href="<?php echo base_url('Admin/Backup');?>"><i class="fa fa-files-o fa-fw"></i> Backups</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-wrench fa-fw"></i> Settings<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level" id="list">
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/County'); ?>">County</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Subcounty'); ?>">Subcounty</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Facility'); ?>">Facility</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Generic'); ?>">Generic</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Formulation'); ?>">Formulation</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Service'); ?>">Service</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Category'); ?>">Category</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Line'); ?>">Line</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Status'); ?>">Status</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Change_reason'); ?>">Change Reason</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Purpose'); ?>">Purpose</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Regimen'); ?>">Regimen</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/Drug'); ?>">Drug</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('Admin/Settings/User'); ?>">User</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Reports</a>
                </li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>

<!---script to sort settings nav links alphabetically--->
<script src="<?php echo base_url() . 'public/admin/js/settings_sort_nav_links.js'; ?>"></script>