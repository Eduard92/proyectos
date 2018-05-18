<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//$route['proyectos/enviar/(:num)']			= 'proyectos_front/edit/$1';
//$route['proyectos/(:num)']			= 'proyectos_front/load/$1';

$route['proyectos/admin/(:num)/(:any)?']	= 'admin/load/$1/$2';
$route['proyectos/admin/(:num)']			= 'admin/load/$1';
$route['proyectos/admin(:any)?']			= 'admin$1';





?>