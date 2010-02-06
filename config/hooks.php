<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://www.codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_system'][] = array(
                                'class'    => NULL,
                                'function' => 'pqp_static',
                                'filename' => 'pqp_pi.php',
                                'filepath' => 'plugins',
                                'params'   => 'load_pqp'
                                );

$hook['pre_controller'][] = array(
                                'class'    => NULL,
                                'function' => 'pqp_static',
                                'filename' => 'pqp_pi.php',
                                'filepath' => 'plugins',
                                'params'   => 'pqp_pre_controller'
                                );

$hook['post_controller_constructor'][] = array(
                                'class'    => NULL,
                                'function' => 'pqp_static',
                                'filename' => 'pqp_pi.php',
                                'filepath' => 'plugins',
                                'params'   => 'pqp_post_controller_constructor'
                                );

$hook['post_controller'][] = array(
                                'class'    => NULL,
                                'function' => 'pqp_static',
                                'filename' => 'pqp_pi.php',
                                'filepath' => 'plugins',
                                'params'   => 'pqp_post_controller'
                                );

/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */