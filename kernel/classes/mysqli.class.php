<?php
class db {
    var $connid = 0;
    var $result;
    var $errormsg;
    var $sqlcount = 0;
    var $filecount = 0;
    var $totaltime = 0;
    var $works = 0;
    var $explain = '';
    var $save = '';
    var $cache = array('fields'=>array(),'data'=>array());
    var $file = '';
    var $initcache = true;
    var $incache = '';

    function dbtime()
    {
        list($usec,$sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }

    function __construct($server, $user, $password, $database) {
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $start = $this->dbtime();
        if ($this->connid == 0) {
            if (empty($password)) {
                $this->connid = @mysqli_connect($server, $user);
            } else {
                $this->connid = @mysqli_connect($server, $user, $password);
            }
			mysqli_set_charset($this->connid, 'utf8');
			
            if ($this->connid) {
                if ($database) {
                    if (@mysqli_select_db($this->connid, $database)) {
                        $this->totaltime += sprintf('%.5f', $this->dbtime() - $start);
                    } else {
                        $this->errormsg = 'Not selected DB ! Не возможно выбрать БД !';
                        $this->error();
                    }
                } else {
                    $this->errormsg = 'Not selected DB ! Не возможно выбрать БД !';
                    $this->error();
                }
            } else {
                $this->errormsg = 'Not connect server ! Нет соединения с базой данных !';
                $this->error();
            }
        }
    }

    function escape($query)
    {
        return @mysqli_real_escape_string($query);
    }

    function cachewrite($cacheresult)
    {
        $cachefile = @fopen($this->file,'w+');
        if ($cachefile) {
            @fwrite($cachefile, $cacheresult);
            @fclose($cachefile);
        }
    }

    function query( $query = '', $time = false, $in = '' ) {
        global $config;
        $this->result = $write = '';
        $nodb = 1;
        $start = $this->dbtime();
        if ($query) {
            if ( $time == false || $config['cache'] == "no" ) {
                $this->result = @mysqli_query($this->connid,$query);
            } else {
                $this->file = DIR_ROOT . "/cache/sql/" . ((empty($in)) ? '' : $in.'/').md5($query).'.txt';
                $this->initcache = true;
                if (($file = @file_get_contents($this->file)) && @filemtime($this->file) > (time() - $time)) {
					$this->result = unserialize($file);
                    $nodb = 0;
                    if (empty($this->result)) {
                        $this->initcache = false;
                        $nodb = 1;
                        $this->result = @mysqli_query($this->connid,$query);
                    }
                } else {
                    $this->result = mysqli_query($this->connid,$query);
                    $resurse = array();
                    while ($insert = $this->fetchrow($this->result, false)) {
                    	@array_push($resurse,$insert);
                    }
                    $write = @serialize($resurse);
                    $this->cachewrite($write);
                    $this->result = $resurse;
                }
            }
        }
        if ($this->result) {
            if ($config['debug'] == 'yes') {
                $this->totaltime += sprintf('%.5f',$this->dbtime() - $start);
                $this->explain.= ($nodb == 1) ? '<li>QUERY : <p>EXPLAIN '.$query.'</p><span>'.sprintf('%.5f',$this->dbtime() - $start).'</span></li>' : '<li>READ : <p>file '.md5($query).'.txt</p><span>'.sprintf('%.5f',$this->dbtime() - $start).'</span></li>';
            }
            if ($nodb == 1) {
            	++$this->sqlcount;
            } else {
            	++$this->filecount;
            }
            return $this->result;
        } else {
            if( $config['debug'] == 'yes' ) {
            	$this->errormsg = $query;
            	$this->error();
            } else {
            	false;
            }
        }
    }

    function numrows($query = 0, $cache = "no" )
    {
        if ( $cache == "yes" && $this->initcache == true) {
            return @sizeof($this->result);
        } else {
            return @mysqli_num_rows($query);
        }
    }

    function fetchrow($query = 0, $cache = "no" )
    {
        if ( $cache == "yes"  && $this->initcache == true ) {
            return @array_shift($this->result);
        } else {
            return @mysqli_fetch_array($query);
        }
    }

    function freerow($query = 0)
    {
    	return @mysqli_free_result($query);
    }

    function numfields($query = 0)
    {
    	return @mysqli_num_fields($query);
    }

    function fieldname($offset, $query = 0)
    {
    	return @mysqli_field_name($query, $offset);
    }

    function insertid()
    {
    	return @mysqli_insert_id($this->connid);
    }

    function affrows()
    {
    	return @mysqli_affected_rows($this->connid);
    }

    function geterrdesc()
    {
    	return $this->error = mysqli_error($this->connid);
    }

    function geterrno()
    {
    	return $this->errno = mysqli_errno($this->connid);
    }

    function error()
    {
        global $config;
        $langcharset = (isset($config['charset'])) ? $config['charset'] : 'utf-8';
        echo '<HTML>'
             .'<HEAD>'
             .'<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset='.$langcharset.'">'
             .'<TITLE>MySQL Debugging</TITLE>'
             .'</HEAD>'
             .'<div align="left" style="border:1px solid #999; font-size:11px; font-family:tahoma,verdana,arial; background-color:#f3f3f3; color:#A73C3C; margin:5px; padding:5px;">'
             .'<div align="left" style="border:1px solid #999; font-size:11px; background-color:#f9f9f9; color:#666; margin:0px; padding:5px;">'
             .'<strong>MySQL Debugging</strong></div><br />'
             .'<li><b>SQL.q :</b> <div style="color:#888;">' . $this->errormsg . '</div></li>'
             .'<li><b>MySQL.e :</b> <div style="color:#888;">' . $this->geterrdesc() . '</div></li>'
             .'<li><b>MySQL.e.№ :</b> <div style="color:#888;">' . $this->geterrno() . '</div></li>'
             .'<li><b>PHP.v :</b> <div style="color:#888;">' . phpversion() . '</div></li>'
             .'<li><b>Data :</b> <div style="color:#888;">' . date("d.m.Y H:i") . '</div></li>'
             .'<li><b>Script :</b> <div style="color:#888;">' . getenv("REQUEST_URI") . '</div></li>'
             .'<li><b>Refer :</b> <div style="color:#888;">' . getenv("HTTP_REFERER") . '</li></div>'
             .'</BODY>'
             .'</HTML>';
        exit();
    }

    function close()
    {
    	if ($this->connid) {
    		if ($this->result){
    			@mysqli_free_result($this->result);
    		}
    		return @mysqli_close($this->connid);
    	}
    }
}
?>