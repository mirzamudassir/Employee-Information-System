<?php
require_once(realpath(dirname(__FILE__) . '/..') . '/modal/initialize.php');
require_once 'classes/Employee.class.php';
global $link;

class EmployeeController extends Employee{



  public function getEmployeesList(){
      return parent::getEmployeesList();
  }

}

  ?>