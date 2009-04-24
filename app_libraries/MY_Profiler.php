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
	    $output = '';
		if (isset(pqp_pi::$pqp_instance)) 
		{
		    pqp_pi::pqp_benchmark_results();
		    $output .= pqp_pi::$pqp_instance->display(pqp_pi::gen_pqp_db_results());
		}
	    
		/* UNCOMMENT TO STILL SHOW THE CI PROFILER
		
		$output .= "<div id='codeigniter_profiler' style='clear:both;background-color:#fff;padding:10px;'>";

		$output .= $this->_compile_uri_string();
		$output .= $this->_compile_controller_info();
		$output .= $this->_compile_memory_usage();
		$output .= $this->_compile_benchmarks();
		$output .= $this->_compile_get();
		$output .= $this->_compile_post();
		$output .= $this->_compile_queries();

		$output .= '</div>';
        */
        
		return $output;
	}
	
}
// END MY_Profiler class

/* End of file MY_Profiler.php */
/* Location: ./system/aplication/libraries/MY_Profiler.php */