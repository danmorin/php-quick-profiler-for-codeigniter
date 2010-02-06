<?php 

/**
 * Call pqp static functions since CI's hooks system can't handle static methods
 *
 * @param string - method to call
 * @return void
 * @author Dan Morin
 **/
function pqp_static($method)
{
    return call_user_func(array('pqp_pi',$method));
}

/**
 * PQP Plugin Class
 *
 * @package default
 * @author Dan Morin
 **/
class pqp_pi
{

    static $pqp_instance = NULL;

    static function load_pqp()
    {
        $dir = dirname(__FILE__);
        require_once $dir . '/pqp/classes/PhpQuickProfiler.php';
    
        pqp_pi::$pqp_instance = new PhpQuickProfiler(PhpQuickProfiler::getMicroTime());
    }

    static function pqp_pre_controller() {
        Console::logMemory(FALSE, 'CI PRE CONTROLLER');
        Console::logSpeed('CI PRE CONTROLLER');
    }

    static function pqp_post_controller_constructor() {
        Console::logMemory(FALSE, 'CI POST CONTROLLER CONSTRUCTOR');
        Console::logSpeed('CI POST CONTROLLER CONSTRUCTOR');
    }

    static function pqp_post_controller() {
        Console::logMemory(FALSE, 'CI POST CONTROLLER');
        Console::logSpeed('CI POST CONTROLLER');
    }

    /**
     * Generate the query results for the PQP Profiler
     *
     * @return object
     * @author Dan Morin
     **/
    static function gen_pqp_db_results()
    {
        $CI = get_instance();
    
        $db_obj = new stdClass();
        $db_obj->queries = array();
        $db_obj->queryCount = 0;
    
        $dbs = array();
	
    	if (isset($CI->write_db)) {
    	    unset($CI->write_db);
    	}

    	// Let's determine which databases are currently connected to
    	foreach (get_object_vars($CI) as $CI_object)
    	{
    		if (is_object($CI_object) && is_subclass_of(get_class($CI_object), 'CI_DB'))
    		{
    			$dbs[] = $CI_object;
    		}
    	}
	
    	if (count($dbs) == 0) {
    	    return $db_obj;
    	}
    
        foreach ($dbs as $db)
    	{
    	    $db_obj->queryCount += count($db->queries);
	    
    	    foreach ($db->queries as $key => $val)
    		{					
    			$time = number_format($db->query_times[$key], 4);

    			$query = array(
        				'sql' => $val,
        				'time' => $time
        			);
        		array_push($db_obj->queries, $query);
    		}
    	}
    	return $db_obj;
    }

    /**
     * Add in any Benchmark Results to the PQP Profiler
     *
     * @return void
     * @author Dan Morin
     **/
    static function pqp_benchmark_results()
    {
        $CI = get_instance();
        $profile = array();
    	foreach ($CI->benchmark->marker as $key => $val)
    	{
    		// We match the "end" marker so that the list ends
    		// up in the order that it was defined
    		if (preg_match("/(.+?)_end/i", $key, $match))
    		{ 			
    			if (isset($CI->benchmark->marker[$match[1].'_end']) AND isset($CI->benchmark->marker[$match[1].'_start']))
    			{
    				$profile[$match[1]] = $CI->benchmark->elapsed_time($match[1].'_start', $key);
    			}
    		}
    	}
	
    	foreach ($profile as $key => $val)
    	{
    		$key = ucwords(str_replace(array('_', '-'), ' ', $key));			
    		Console::log('CI BENCHMARK - '.$key.': '.$val);
    	}
	
    	Console::log('GET: '.print_r($_GET, TRUE));
    	Console::log('POST: '.print_r($_POST, TRUE));
    }
}

/* End of file pqp_pi.php */
/* Location: ./system/application/plugins/pqp_pi.php */