<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
| There area two reserved routes:
|	$route['default_controller'] = 'welcome';
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "login/home";
$route['404_override'] = 'common/index/not_found';
//$route['404_override'] = '';

$route['install.jsp'] = 'install/index';
$route['install/index'] = '';

$route['home.jsp'] = 'login/home';
$route['login/home']    = ''; //bloqueando ruta

$route['editprofile.jsp'] = 'login/home/edit_profile';
$route['login/home/edit_profile']    = ''; //bloqueando ruta

$route['logout.jsp'] = 'login/home/logout';
$route['login/home/logout'] = '';

/**
 * Modulo Mensajeria
 */

$route['infor_mjs.jsp'] = "msjs/index/infor_mjs";
$route['envio_report.jsp'] = "msjs/index/envio_report";
$route['subir_msjs.jsp'] = "msjs/index/subir_msjs";

$route['credit_details_f.jsp'] = "cobranzas/index/credit_details_filtro";
$route['credit_details_f.jsp/(:any)'] = "cobranzas/index/credit_details_filtro/$1";
$route['cobranzas/index/credit_details_filtro'] = '';

/**
 * Modulo de reportes
 */
$route['reports/report_date.jsp'] = "reports/index/report_by_date";
$route['reports/index/report_date'] = '';

$route['reports/report_oficial.jsp'] = "reports/index/report_by_oficial";
$route['reports/index/report_by_oficial'] = '';

$route['reports/report_agencia.jsp'] = "reports/index/report_by_agencia";
$route['reports/index/report_by_agencia'] = '';
$route['reports/report_general.jsp'] = "reports/index/report_by_general";
$route['reports/index/report_by_general'] = '';

/**
 * Modulo Admin
 */
$route['admin.jsp'] = "admin/index";
$route['admin/index'] = '';
$route['admin/index/index'] = '';

$route['uploadinfo.jsp'] = "cobranzas/index/index";
$route['cobranzas/index'] = '';
$route['cobranzas/index/index'] = '';

$route['credit_details.jsp'] = "cobranzas/index/credit_details";
$route['credit_details.jsp/(:any)'] = "cobranzas/index/credit_details/$1";
$route['cobranzas/index/credit_details'] = '';

$route['company.jsp/create'] = 'admin/empresa/save';
$route['admin/empresa/save'] = '';

$route['company.jsp/new'] = "login/home/open_ml_empresa_view2";

$route['edittemplate.jsp/(:any)'] = "admin/index/edit_template/$1";
$route['admin/index/edit_template'] = '';

$route['companyadmin.jsp'] = "admin/index/companyadmin";
$route['salepointadmin.jsp'] = "admin/index/salepointadmin";
$route['directory.jsp'] = "admin/index/directory";
$route['productadmin.jsp'] = "admin/index/productadmin";
$route['socialclient.jsp'] = "admin/index/socialclient";
$route['checkuser.jsp'] = "login/verifylogin/index";

/* Simplificacion de rutas hacia metodos comunes */
$route['modal/(:any)/(:any)/(:num)'] = "common/index/open_modal/$1/$2/$3";
// routes ws tcobro
$route['tcobro']['get']= 'tcobro/index';
$route['tcobro/(:num)']['get']= 'tcobro/find/$valor';
$route['tcobro/(:num)/(:any)/(:any)']['get']= 'tcobro/abono/$numeropagare/$monto/$fecha';
$route['tcobro']['post']= 'tcobro/abonos';
$route['tcobro/(:num)']['put']= 'tcobro/index/$valor';
$route['tcobro/(:num)']['delete']= 'tcobro/index/$valor';

//$route['AdminWs']['get']= 'AdminWs/ingresarDatos';

/* End of file routes.php */
/* Location: ./application/config/routes.php */