<?php
//menu code
$mainMenu= "
<li class='active'>
<a href='dashboard'><i class='fa fa-gear fa-fw'></i>Dashboard</a>
</li>
<li>
<a href='settings'><i class='fa fa-gear fa-fw'></i>User Management</a>
</li>

";

$dropDownMenu= "
<ul class='dropdown-menu dropdown-user'>
    <li><a href='javascript:void(0)' data-toggle='modal' data-target='#userProfile'><i class='fa fa-user fa-fw'></i>Profile</a>
    </li>
    <li><a href='settings'><i class='fa fa-gear fa-fw'></i>Settings</a>
    </li>
    <li class='divider'></li>
    <li><a href='../core/modal/Auth/logout'><i class='fa fa-sign-out fa-fw'></i>Logout</a>
    </li>
</ul>
";




?>