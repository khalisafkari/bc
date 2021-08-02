<?php
  // MAIN CONTROLLER
  include '../../controllers/cont.main.php';
 
  // INCLUDE INDEX IN [THEME] 

   $c_manga['list_title'] = preg_replace('/{site_title}/i', $c_manga['site_title'], $c_manga['list_title']);
   include 'themes/'.$c_manga['theme'].'/cpanel.php';

   $m_id = isset($_GET['mid']) ? (int)$_GET['mid'] : NULL;
   $c_id = isset($_GET['cid']) ? (int)$_GET['cid'] : NULL;