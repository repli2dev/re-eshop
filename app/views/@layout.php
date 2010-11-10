<? 
/**
 *@package Base
 **/
?>
<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo Kohana::lang('index.lang'); ?>" lang="<?php echo Kohana::lang('index.lang'); ?>">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title><?php echo $title; ?></title>

	<link rel="stylesheet" type="text/css" href="/css/index.css">
	<?php echo html::stylesheet($this->css); ?>
	
	<?php echo html::script($this->javascript); ?>
	
	<?php echo html::link($this->feed,'alternate','application/rss+xml'); ?>
</head>
<body>
	<div id="main">
		<div id="header">
			<a href="/">
			<img src="/images/logo.png" alt="<?php echo Kohana::lang('index.recycleshop'); ?>" />
			</a>
			<h1>Re-eshop</h1>
			<?php base::blocks($this->blocks_top); ?>
		</div>
		<div id="content">
			<div id="breadcrumb">
                <?php echo $this->get_breadcrumbs();?>
            </div>
			<div id="side">
				<!-- first block -->
				<h3>Menu</h3>
					<ul>
						<? foreach($this->links as $row){?>
							<li><a <?php if(strpos($row[2],url::current(),0) !== FALSE AND $row[2] != "index") echo 'class="active"'; ?> href="<?php echo $row[2]; ?>"><?php echo $row[1]; ?></a></li>	
						<? } ?>
					</ul>
				<?php base::blocks($this->blocks_left); ?>
			</div>
			<div id="text"><div class="inner">
				<?php echo $content ?>
			</div></div>
			<div class="cleaner" />
		</div>
	</div>
	<p id="footer">
		Rendered in {execution_time} seconds, using {memory_usage} of memory<br />
		Copyright ©2009 Jan Drábek
	</p>
</body>
</html>
