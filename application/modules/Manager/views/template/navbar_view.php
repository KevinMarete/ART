<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url() . 'manager/dashboard'; ?>">
            <i class="fa fa-dashboard fa-fw"></i> Commodity Manager
        </a> 
    </div>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <li>
            <small>
                <b><?php echo ucwords($this->session->userdata('role')); ?>: </b> <?php echo ucwords($this->session->userdata('scope_name')); ?>
            </small> 
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?php echo $this->session->userdata('firstname') . ' ' . $this->session->userdata('lastname'); ?> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li>
                    <a href="<?php echo base_url() . 'manager/profile'; ?>">
                        <i class="fa fa-user fa-fw"></i>  Profile
                    </a>                   
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?php echo base_url() . 'manager/logout'; ?>">
                        <i class="fa fa-sign-out fa-fw"></i> Logout
                    </a>
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
                    <a class="dashboard" href="<?php echo base_url() . 'manager/dashboard'; ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <?php
                foreach ($this->session->userdata('modules') as $module => $value) {
                    echo "<li><a href='#'><i class='" . $value['icon'] . "'></i> " . ucwords($module) . "<span class='fa arrow'></span></a><ul class='nav nav-second-level' id='settings_nav_links'>";
                    foreach ($value['submodules'] as $orig_submodule) {
                        $submodule = str_replace(' ', '_', $orig_submodule);
                        echo "<li><a class='" . str_replace(' ', '_', $orig_submodule) . "' href='" . base_url() . "manager/" . $module . "/" . $submodule . "'>" . ucwords(str_replace('_',' ', $orig_submodule)) . "</a></li>";
                    }
                    echo "</ul> </li>";
                }
                ?>
            </ul>
        </div>
        <!--/.sidebar-collapse -->
    </div>
    <!--/.navbar-static-side -->
</nav>
<script>
//sort settings_nav links alphabetically
    var mylist = $('#settings_nav_links');
    var listitems = mylist.children('li').get();

    listitems.sort(function (a, b) {
        return $(a).text().toUpperCase().localeCompare($(b).text().toUpperCase());
    })

    mylist.empty().append(listitems)
</script>