<?php
//menu code
$mainMenu= "
<li class='active'>
<a href='dashboard'><i class='fa fa-plus fa-fw'></i>Dashboard</a>
</li>
<li>
<a href='attendanceManager'><i class='fa fa-plus fa-fw'></i>Attendance Manager</a>
</li>
<li>
<a href='leaveManager'><i class='fa fa-eye fa-fw'></i>Leave Manager</a>
</li>
<li>
<a href='payroll'><i class='fa fa-money fa-fw'></i>Payroll</a>
</li>
<li>
<a href='settings'><i class='fa fa-users fa-fw'></i>User Management</a>
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