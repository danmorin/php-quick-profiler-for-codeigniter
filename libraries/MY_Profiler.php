<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Profiler extends CI_Profiler {

 	function MY_Profiler()
 	{
 	    parent::CI_Profiler();
 	}

 	// --------------------------------------------------------------------

	/**
	 * Overriding the default "Run the Profiler"
	 *
	 * @access	private
	 * @return	string
	 */	
	function run()
	{
		// Uncomment to still show the CI Profiler
		// ---------------------------------------
		// $output = parent::run();
		// return $output;

	    $output = '';

		if (class_exists('pqp_pi') && isset(pqp_pi::$pqp_instance)) 
		{
		    pqp_pi::pqp_benchmark_results();
		    $output .= pqp_pi::$pqp_instance->display(pqp_pi::gen_pqp_db_results());
		}

		return $output;
	}

}

/* End of file MY_Profiler.php */
/* Location: ./system/aplication/libraries/MY_Profiler.php */