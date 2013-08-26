<?php

if (!defined ("ARISTONA") || ARISTONA != 1)
        die ();

class Database
{
        //Amount of total Queries executed
        static $amountQueries = 0;
        //Amount of Queries successfully ran
        static $amountSuccesses = 0;
        //DBConnectionstate
        public $conn = FALSE;
        //Host to connect to
        public $my_host = null;
        //Database to select
        public $my_db = null;
        //User to connect
        public $my_user = null;
        //Password to connect
        public $my_pass = null;
        
        //Constructor
        //Sets several vars.
        function __construct($host, $db, $user, $pass)
        {
                $this->my_host = $host;
                $this->my_db   = $db;
                $this->my_user = $user;
                $this->my_pass = $pass;
        }
        
        //Connects to Database
        function doConnect ($host, $db, $user, $pass)
        {
                if (!$this->conn)
                {
                        $this->conn = @mysql_pconnect ($host, $user, $pass);
                        @mysql_select_db ($db, $this->conn);
                }
        }
        
        //Executes Query
        //Increases Querycounters
        function doQuery ()
        {
                $this->amountQueries++;
                
                $args = func_get_args ();
                
                $this->doConnect ($this->my_host, $this->my_db, $this->my_user, $this->my_pass);
                $fixcharset = mysql_query("SET CHARACTER SET utf8"); 
                if(!$fixcharset)
                {
                    echo 'Character set düzeltilemedi.';
                }
                
                if (sizeof ($args) > 0)
                {
                        $query = $args[0];
                        
                        for ($i = 1; $i < sizeof ($args); $i++)
                                $query = preg_replace ("/\?/",
                                                        "'" . mysql_real_escape_string ($args[$i]) . "'",
                                                        $query,
                                                        1);
                }
                else
                {
                        return FALSE;
                }
                
                if($this->result = mysql_query ($query, $this->conn))
                {
                    $this->amountSuccesses++;
                    if (@mysql_affected_rows ($this->result) > 0)
                    {
                        return @mysql_affected_rows ($this->result);
                    }
                    else
                    {
                        return @mysql_num_rows ($this->result);
                    }
                }
                else
                {
                    $this->getError();
                    return -1;
                }
        }
        
        //Mode 1: Fetch Array
        //Mode 2: Fetch Row
        //Returns Result of Query
        function doRead ($mode = 1)
        {
                switch ($mode)
                {
                        case 2:
                                return @mysql_fetch_row ($this->result);
                        default:
                                return @mysql_fetch_assoc ($this->result);
                }
        }
        
        function amountQueries()
        {
            return $this->amountQueries;
        }
		
		function _trace_print_var($var)
		{
			if (is_string($var))
				return('\''.str_replace(array("\x00", "\x0a", "\x0d", "\x1a", "\x09"), array('\0', '\n', '\r', '\Z', '\t'), $var).'\'');
			else if (is_int($var))
				return $var;
			else if (is_bool($var))
			{
				if ($var) return 'true';
				else return 'false';
			}
			else if (is_array($var))
			{
				$result = 'array(';
				$comma = '';
				foreach ($var as $key => $val)
				{
					$result .= $comma . $this->_trace_print_var($key) . ' => ' . $this->_trace_print_var($val);
					$comma = ', ';
				}
				$result .= ')';
				return $result;
			}
			return var_export($var, true);
		}
		
        function getTrace()
		{
			$trace = debug_backtrace();
			$trace = array_reverse($trace);
			array_pop($trace);
			array_pop($trace);
			$indent = '';
			$func = '';
			$result = "Stack trace:\r\n";
			foreach ($trace as $val)
			{
				$result .= $indent . $val['file'] . ' on line ' . $val['line'] . ($func ? ' in function ' . $func : NULL);
      
				if ($val['function'] == 'include' || $val['function'] == 'require' || $val['function'] == 'include_once' || $val['function'] == 'require_once')
					$func = '';
				else
				{
					$func = $val['function'] . '(';
					if (isset($val['args'][0]))
					{
						$comma = '';
						foreach ($val['args'] as $val)
						{
							$func .= $comma . $this->_trace_print_var($val);
							$comma = ', ';
						}
					}
					$func .= ')';
				}
				$result .= "\r\n";
				$indent .= "\t";
			}
			return $result;		
		}
		
        function getError()
        {
          if (@mysql_error($this->conn))
            $error = 'mysql_error() response: ' . @mysql_error($this->conn);
		  else
		    $error = 'non mysql error\r\n';

		
          $fp = @fopen('./cache/__site_errors.log', 'a');
          @fwrite($fp, "\r\nError: " . date('g.m.Y H:i:s') . " " . $error . "\r\n" . $this->getTrace());
          @fclose($fp);

          Template::doDisableCache();

          return $error;
         }
        
        //Destructor
        function __destruct () { }
}
?>