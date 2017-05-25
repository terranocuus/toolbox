<?php

class scan {
	public $list_ignore 			= array('.','..','_notes','tn','albumtn','fullsize', '-toolbox-');
	public $list_accept 			= "(.jpg|.jpeg|.gif|.png)";
	public $all_files				= false;
	public $preg_ignore				= NULL;
	
	public $depth					= 0;
	public $loop					= 0;

	private $dir_src				= NULL;
	private $dir_handle				= NULL;
	private $dir_list				= array();
	private $dir_list_only			= false;
	
	public $file_list				= array();

	/**
	 * @method dir_scan Scans a directory for files that match the filters.
	 * @param string $dir directory path; trailing slash will be added.
	 * @return array array of files inside directory.
	 */
	function dir_scan($dir, $loop = 0) {
		if (!is_dir($dir)) return false;
		
		if (substr($dir, -1) != "/") $dir .= "/";
		
		$this->dir_handle = @opendir($dir);
		
		while (($file = @readdir($this->dir_handle)) !== false) {
			if (!in_array($file, $this->list_ignore)) { // && ($this->preg_ignore != NULL && !preg_match('/'.$this->preg_ignore.'/', $file))) {
				if (is_file($dir.$file)) {
					if ($this->all_files) {
						$this->file_list[] = $dir.$file;
					} elseif (preg_match("/".$this->list_accept."/i",$file)) {
						$this->file_list[] = $dir.$file;
						}
				} else {
					$dirList[] = $dir.$file."/";
					$this->dir_list[] = $dir.$file."/";
					}
				}
			}
			
		$loop++;
		if ($this->depth == 0 || ($this->depth > 0 && $loop < $this->depth)) {
			if (isset($dirList)) {
				foreach ($dirList as $dir) {
					$this->dir_scan($dir, $loop);
					}
				}
			}

		@closedir($dir);
		
		natcasesort($this->file_list);
		
		return $this->file_list;
		}
		
	/**
	 * @method scan_dir($dir) Alias for dir_scan.
	 * @param string $dir
	 * @return array array of files within $dir
	 */
	function scan_dir($dir) { return $this->dir_scan($dir); }

	/**
	 * @method get_dirs($dir) Gathers list of directories inside $dir
	 * @param string $dir directory path to scan
	 * @return array array of directories inside $dir
	 */
	function get_dirs($dir) {
		$this->dir_scan($dir);
			natcasesort($this->dir_list);
		
		return $this->dir_list;
		}
		
		
	//DIRECT METHODS
	static function dirs($dir, $depth=0) {
		$scan = new scan();
		$scan->depth		= (int)$depth;
		
		return $scan->get_dirs($dir);
		}
		
	static function files($dir, $depth=0) {
		$scan = new scan();
		$scan->all_files	= true;
		$scan->depth		= (int)$depth;
		
		return $scan->dir_scan($dir);
		}
		
		
	}