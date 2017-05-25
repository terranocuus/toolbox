<?php

include '-toolbox-/scan.php';

if (isset($_GET['dir']) && $_GET['dir'] != '') {
	$src = $_GET['dir'];
	
	$dirs = scan::dirs($src, 1);
	$files = scan::files($src, 1);
	
	echo '<ul class="list" data-src="'.$src.'" style="display:none;">';	
	if (is_array($dirs)) {
		foreach ($dirs as $dir) {
			$display = str_replace($src, '', $dir);
			
			echo '<li class="dir" data-dir="'.$dir.'">
				<span class="icon-left icon-folder-close">'.$display.'</span>
				<a class="button" href="'.$dir.'" target="_blank"><i class="icon-share"></i></a>
				<a class="button refresh" href="#"><i class="icon-refresh"></i></a>
			</li>';
			}
		}
	
	if (is_array($files)) {
		foreach ($files as $file) {
			$display = str_replace($src, '', $file);
			
			$ext = substr($file, strrpos($file, '.')+1);
			echo '<li class="file '.$ext.'" data-dir="./"><a href="'.$file.'" target="_blank">'.$display.'</a></li>';
			}
		}
	echo '</ul>';
		
	exit;
	}

$dirs = scan::dirs('.', 1);
$files = scan::files('.', 1);


?><!doctype html>
<html>
	<head>
		<title>Toolbox v.2</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<script src="-toolbox-/modernizr-2.5.3.min.js"></script>
		<link href="-toolbox-/font-awesome.css" rel="stylesheet">
		<style>
			
			html { background:#eee; font-family:Arial; }
				body > p { width:700px; margin:0 auto 10px; color:#393; background:#9F9; border:1px solid #393; padding:10px; }
				
				ul.list { display:block; overflow:hidden; clear:left; list-style:none; padding:5px; margin:5px; background:#eee; }
					ul.list ul.list { border-left:1px solid #bbb; margin-left:20px; }
					
					li.dir { display:block; overflow:hidden; /* padding-left:20px; */ }
						li.dir span { float:left; min-width:300px; display:block; /* margin:0 50px 0 0; */ padding:5px; border:1px solid #bbb; cursor:pointer; border-radius:5px; }
							li.dir span:hover { background:#bbb; border:1px solid #999; clear:right; }
						li.dir + li.dir { margin-top:5px; }
						li.dir + li.file { margin-top:5px; }
					
					li.file { display:block; margin:0px; padding:5px; /* padding-left:20px; */ }
						li.file a { text-decoration:none; }
						li.file a:hover { text-decoration:underline; }
						li.file + li.file { margin-top:5px; }
						
					/* li.file.php { background:url(-toolbox-/php.png) left 6px no-repeat; }
					li.file.html,
					li.file.htm { background:url(-toolbox-/htm.png) left 6px no-repeat; } */
						
				a.button { display:block; float:left; margin:0px; padding:4px; background:#bbb; border:1px solid #999; text-decoration:none; color:#fff; border-radius:5px; }
					/* a.button:hover { text-decoration:underline; }
					a.button + */ a.button { margin-left:10px; }
					
				ul.list li.dir > a.button,
				ul.list li.dir > a.button.refresh { display:none; }
					ul.list li.dir:hover > a.button { display:block; }
					
				.icon-folder-close.icon-left, .icon-folder-open.icon-left { text-align:left; }
				.icon-folder-close::before, .icon-folder-open::before { margin-right:5px; }
		
		</style>
	</head>
	
	<body>
		<ul class="list">
		<?php
			
			foreach ($dirs as $dir) {
				$dir = substr($dir, 2);
				
				echo '<li class="dir" data-dir="'.$dir.'">
					<span class="icon-left icon-folder-close">'.$dir.'</span>
					<a class="button" href="'.$dir.'" target="_blank"><i class="icon-share"></i></a>
					<a class="button refresh" href="#"><i class="icon-refresh"></i></a>
				</li>';
				}
			
			foreach ($files as $file) {
				$ext = substr($file, strrpos($file, '.')+1);
				echo '<li class="file '.$ext.'" data-dir="./"><a href="'.$file.'" target="_blank">'.substr($file, 2).'</a></li>';
				}
		
		
		?>		
		</ul>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="-toolbox-/jquery-1.7.1.min.js"><\/script>')</script>
		<script src="-toolbox-/jquery.color.js"></script>
		
		<script src="-toolbox-/toolbox.js"></script>
	
	</body>
</html>