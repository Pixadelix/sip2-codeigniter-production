<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'dashboard/dashboard';
$route['404_override'] = 'ST_404';
$route['translate_uri_dashes'] = FALSE;

$route['users']                                     = '/auth/auth';
$route['users/(:any)']                              = '/auth/auth/$1';
$route['users/(:any)/(:any)']                       = '/auth/auth/$1/$2';

$route['auth']                                      = '/auth/auth';
$route['auth/(:any)']                               = '/auth/auth/$1';
$route['auth/(:any)/(:any)']                        = '/auth/auth/$1/$2';

$route['editorial/workspace/(:num)']                = '/editorial/workspace/index/$1';

$route['project_status/(:num)']                     = '/project_status/index/$1';

$route['get_task_notification']                     = 'dashboard/dashboard/get_task_notification';

$route['my/my_task/(:num)']                         = 'my/my_task/index/$1';
$route['task/(:num)']                               = 'task/index/$1';

$route['profile/(:num)']                            = 'profile/index/$1';

//$route['contents/(:any)']                         = 'contents/contents/$1';
//$route['contents/splash/get']                     = 'contents/splash/get';
$route['splash/(:num)/(:num)/(:num)/(:num)/(:any)'] = 'contents/splash/index/$1/$2/$3/$4/$5';
$route['post/(:num)/(:num)/(:num)/(:num)/(:any)']   = 'contents/post/index/$1/$2/$3/$4/$5';

