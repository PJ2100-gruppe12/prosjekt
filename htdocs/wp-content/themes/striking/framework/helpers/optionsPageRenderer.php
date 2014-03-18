<?php
/**
 * The `optionsPageRenderer` class help generate the html code for theme options page.
 */
class optionsPageRenderer {
	var $name;
	var $options;
	var $saved_options;
	var $generator;
	var $page;
	
	/**
	 * Constructor
	 * 
	 * @param string $name
	 * @param array $options
	 */
	function optionsPageRenderer($page) {
		include_once (THEME_HELPERS . '/baseOptionsGenerator.php');
		$this->generator = new baseOptionsGenerator();
		$this->page = $page;
		$this->name = $page->name;
		$this->options = $page->options();

		$options = get_option(THEME_SLUG . '_' . $this->name);
		$options = $this->_maybe_save_process($options);
		$this->saved_options = $options;

		$this->render();
	}
	
	function _maybe_save_process($options){
		if (isset($_POST['save_theme_options'])) {
			foreach($this->options as $value) {
				if (isset($value['id']) && ! empty($value['id'])) {
					if (isset($_POST[$value['id']])) {
						switch($value['type']){
							case 'color':
								if(!empty($_POST[$value['id']]) && $_POST[$value['id']]=='transparent'){
									$options[$value['id']] = '';
								}else{
									$options[$value['id']] = $_POST[$value['id']];
								}
								break;
							case 'multiselect':
								if(isset($value['chosen_order']) && $value['chosen_order']){
									if(empty($_POST['_'.$value['id']])){
										$options[$value['id']] = array();
									}else{
										$options[$value['id']] = explode(",",$_POST['_'.$value['id']]);
									}
								}else{
									if(empty($_POST[$value['id']])){
										$options[$value['id']] = array();
									}else{
										$options[$value['id']] = $_POST[$value['id']];
									}
								}							
								break;
							case 'ddmultiselect':
								if(empty($_POST[$value['id']])){
									$options[$value['id']] = array();
								}else{
									$options[$value['id']] = array_unique(explode(',', $_POST[$value['id']]));
								}
								break;
							case 'multidropdown':
								if(empty($_POST[$value['id']])){
									$options[$value['id']] = array();
								}else{
									$options[$value['id']] = array_unique(explode(',', $_POST[$value['id']]));
								}
								break;
							case 'toggle':
								if($_POST[$value['id']] == 'true'){
									$options[$value['id']] = true;
								}else{
									$options[$value['id']] = false;
								}
								break;
							case 'tritoggle':
								if($_POST[$value['id']] == 'true'){
									$options[$value['id']] = true;
								}elseif($_POST[$value['id']] == 'false'){
									$options[$value['id']] = false;
								}else{
									$options[$value['id']] = 'default';
								}
								break;
							case 'upload':
								if(!empty($_POST[$value['id']])){
									$options[$value['id']] = (array) json_decode(stripslashes($_POST[$value['id']]),true);
								}else{
									$options[$value['id']] = array();
								}
								break;
							default:
								$options[$value['id']] = $_POST[$value['id']];
						}
					} else {
						if ($value['type'] == 'multiselect') {
							$options[$value['id']] = array();
						} else {
							$options[$value['id']] = false;
						}
					}
				}
				if (isset($value['process'])) {
					if(function_exists($value['process'])){
						$options[$value['id']] = $value['process']($value,$options[$value['id']]);
					}elseif(method_exists($this->page,$value['process'])){
						$options[$value['id']] = $this->page->$value['process']($value,$options[$value['id']]);
					}
				}
			}
			
			if ($options != $this->options) {
				update_option(THEME_SLUG . '_' . $this->name, $options);
				global $theme_options;
				$theme_options[$this->name] = $options;
				
				theme_save_skin_style();
			}
			echo '<div id="message" class="updated fade"><p><strong>Updated Successfully</strong></p></div>';
		}
		return $options;
	}
	
	function render() {
		foreach($this->options as $option) {
			$this->renderOption($option);
		}
	}
	
	function renderOption($option){
		
		global $post;
		if(isset($option['id'])){
			if (isset($this->saved_options[$option['id']])) {
				if( is_string($this->saved_options[$option['id']])){
					$option['value'] = stripslashes($this->saved_options[$option['id']]);
				}else{
					$option['value'] = $this->saved_options[$option['id']];
				}
			}else{
				if(isset($option['default'])){
					$option['value'] = $option['default'];
				}else{
					$option['value'] = '';
					$option['default'] = '';
				}
			}
		}
		if (isset($option['prepare'])) {
			if( function_exists($option['prepare'])){
				$option = $option['prepare']($option);
			}elseif(method_exists($this->page,$option['prepare'])){
				$option = $this->page->$option['prepare']($option);
			}
		}
		if (method_exists($this, $option['type'])) {
			$this->$option['type']($option);
		}elseif (method_exists($this->generator, $option['type'])) { 
			echo '<tr><th scope="row"><h4><label for="'.$option['id'].'">' . $option['name'] . '</label></h4></th><td>';
			if(isset($option['desc'])){
				echo '<p class="description">' . $option['desc'] . '</p>';
			}
			$this->generator->$option['type']($option);
			echo '</td></tr>';
		}
	}
	
	/**
	 * prints the options page title
	 */
	function title($item) {
		echo '<h2>' . $item['name'] . '</h2>';
		if (isset($item['desc'])) {
			echo '<p>' . $item['desc'] . '</p>';
		}
	}
	
	/**
	 * begins the group section
	 */
	function start($item) {
		echo '<div class="theme-options-group">';
		echo '<table cellspacing="0" class="widefat theme-options-table">';
		echo '<thead><tr>';
		echo '<th scope="row" colspan="2">' . $item['name'] . '</th>';
		echo '</tr></thead><tbody>';
	}
	
	function desc($item) {
		echo '<tr><td scope="row" colspan="2">' . $item['desc'] . '</td></tr>';
	}
	
	/**
	 * closes the group section
	 */
	function end($item) {
		echo '</tbody></table></div><p class="submit"><input type="submit" name="save_theme_options" class="button-primary autowidth" value="Save Changes" /></p>';
	}
	
	/**
	 * displays a editor
	 */
	function editor($item) {
		
		$rows = isset($item['rows']) ? $item['rows'] : '7';
		if (isset($this->saved_options[$item['id']])) {
			$item['default'] = stripslashes($this->saved_options[$item['id']]);
		}
		
		echo '<tr><td>';
		if(isset($item['desc'])){
			echo '<p class="description">' . $item['desc'] . '</p>';
		}
		echo '<div id="poststuff"><div id="post-body"><div id="post-body-content"><div class="postarea" id="postdivrich">';
		global $wp_version;
		
		if(version_compare($wp_version, "3.3", '>=')){
			wp_editor($item['value'],$item['id']);
		}else{
			the_editor($item['value'],$item['id']);
		}
		echo '<table id="post-status-info" cellspacing="0">';
		echo '<tbody><tr>';
		echo '<td>&nbsp;</td>';
		echo '<td>&nbsp;</td>';
		echo '</tr></tbody>';
		echo '</table>';
		echo '</div></div></div></div>';
		echo '</td></tr>';
	}
	
	/**
	 * displays a custom field
	 */
	function custom($item) {
		if (isset($this->saved_options[$item['id']])) {
			$default = $this->saved_options[$item['id']];
		} else {
			$default = $item['default'];
		}
		if(isset($item['layout']) && $item['layout']==false){
			if (isset($item['function'])) {
				if(function_exists($item['function'])){
					$item['function']($item, $default);
				}elseif(method_exists($this->page,$item['function'])){
					$this->page->$item['function']($item, $default);
				}
			}else{
				echo $item['html'];
			}
		}else{
			echo '<tr><th scope="row"><h4>' . $item['name'] . '</h4></th><td>';
			if(isset($item['desc'])){
				echo '<p class="description">' . $item['desc'] . '</p>';
			}
			if (isset($item['function'])) {
				if(function_exists($item['function'])){
					$item['function']($item, $default);
				}elseif(method_exists($this->page,$item['function'])){
					$this->page->$item['function']($item, $default);
				}
			}else{
				echo $item['html'];
			}
			echo '</td></tr>';
		}
	}
}
