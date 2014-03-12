<?php
class Theme_admin {
	function init(){
		/* Load functions for admin. */
		$this->functions();
		
		add_action('admin_notices',  array(&$this,'warnings'));
		
		/* Manage custom post type */
		$this->types();

		/* Create post type meta box. */
		$this->metaboxes();
		
		add_action('wp_ajax_theme-flush-rewrite-rules', array(&$this,'flush_rewrite_rules'));
		
		require_once (THEME_HELPERS . '/shortcodesGenerator.php');
		new shortcodesGenerator();

		require_once (THEME_ADMIN_FUNCTIONS . '/upgrade.php');
		new upgradeHelper();
		
		$this->fix();

		add_action('admin_init', array(&$this,'after_theme_activated'));
		add_action('admin_init', array(&$this,'after_theme_update'));
	}
	
	/**
	 * Check Whether the current environment is support for the theme.
	 * 
	 * The message will display in admin option page.
	 */
	function warnings(){
		global $wp_version;

		$errors = array();
		if(!theme_check_wp_version()){
			$errors[] = sprintf(__('Wordpress version(%1$s) is too low. Please upgrade to 3.1','striking_admin'), $wp_version);
		}
		if(!function_exists("imagecreatetruecolor")){
			$errors[] = __('GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library','striking_admin');
		}
		if(!is_writeable(THEME_CACHE_DIR)){
			$errors[] = sprintf(__('The cache folder (%1$s) is not writeable.','striking_admin'), str_replace( WP_CONTENT_DIR, '', THEME_CACHE_DIR ));
		}
		if(!is_writeable(THEME_CACHE_DIR.DIRECTORY_SEPARATOR.'images')){
			$errors[] = sprintf(__('The image folder (%1$s) is not writeable.','striking_admin'), str_replace( WP_CONTENT_DIR, '', THEME_CACHE_DIR ).'/images');
		}
		if(!is_multisite()){
			if(!is_writeable(THEME_CACHE_DIR.DIRECTORY_SEPARATOR.'skin.css')){
				$errors[] = sprintf(__('The skin style file (%1$s) is not writeable.','striking_admin'), str_replace( WP_CONTENT_DIR, '', THEME_CACHE_DIR ).'/skin.css');
			}
		}
		
		$str = '';
		if(!empty($errors)){
			$str = '<ul>';
			foreach($errors as $error){
				$str .= '<li>'.$error.'</li>';
			}
			$str .= '</ul>';
			echo "
				<div id='theme-warning' class='error fade'><p><strong>".sprintf(__('%1$s Error Messages','striking_admin'), THEME_NAME)."</strong><br/>".$str."</p></div>
			";
		}
		
	}
	
	function functions(){
		require_once(THEME_ADMIN_FUNCTIONS .'/common.php');
		require_once(THEME_ADMIN_FUNCTIONS .'/head.php');
		//enable option image uploader support
		require_once(THEME_ADMIN_FUNCTIONS .'/option-media-upload.php');
	}
	
	/**
	 * Manage custom post type.
	 */
	function types(){
		require_once (THEME_TYPES . '/portfolio.php');
		require_once (THEME_TYPES . '/slideshow.php');

		$this->_register_type('Theme_Post_Type_Portfolio');
		$this->_register_type('Theme_Post_Type_Slideshow');
	}

	function _register_type($type_class){
		$type = new $type_class;
		$type->admin_init();
	}

	/**
	 * Create post type metabox.
	 */
	function metaboxes(){
		require_once (THEME_HELPERS . '/metaboxes.php');

		$files = array(
			'page_general' => 'Theme_Metabox_PageGeneral',
			'slideshow' => 'Theme_Metabox_Slideshow',
			'portfolio' => 'Theme_Metabox_Portfolio',
			//'anything_slider' => 'Theme_Metabox_AnythingSlider',
			// 'gallery' => 'Theme_Metabox_Gallery',
			'single' => 'Theme_Metabox_Single',
		);

		foreach($files as $file => $metabox_class){
			include_once (THEME_ADMIN_METABOXES . "/" . $file.'.php');
			$metabox = new $metabox_class;
		}
	}
	
	function flush_rewrite_rules(){
		flush_rewrite_rules();
		die (1);
	}
	
	function after_theme_activated(){
		if ('themes.php' == basename($_SERVER['PHP_SELF']) && isset($_GET['activated']) && $_GET['activated']=='true' ) {
			if(is_multisite()){
				if(!is_dir(THEME_CACHE_IMAGES_DIR)){
					mkdir(THEME_CACHE_IMAGES_DIR);
				}
			}
			update_option(THEME_SLUG.'_version', THEME_VERSION);
			theme_save_skin_style();
			wp_redirect( admin_url('admin.php?page=theme_general') );
		}
	}
	
	function after_theme_update(){
		if(version_compare(THEME_VERSION, get_option(THEME_SLUG.'_version'), '!=')){
			update_option(THEME_SLUG.'_version', THEME_VERSION);
			theme_save_skin_style();
		}
		// wait to do mu 
		// http://codex.wordpress.org/Category:WPMU_Functions
	}

	function fix(){
		global $theme_options;
		if(!get_option(THEME_SLUG.'_meta_information_fixed')){
			$meta_items = array();
			if(theme_get_option('blog','meta_category')){
				$meta_items[] = 'category';
			}
			if(theme_get_option('blog','meta_tags')){
				$meta_items[] = 'tags';
			}
			if(theme_get_option('blog','meta_author')){
				$meta_items[] = 'author';
			}
			if(theme_get_option('blog','meta_date')){
				$meta_items[] = 'date';
			}
			if(theme_get_option('blog','meta_comment')){
				$meta_items[] = 'comment';
			}
			theme_set_option('blog','meta_items',$meta_items);
			$single_meta_items = array();
			if(theme_get_option('blog','single_meta_date')){
				$single_meta_items[] = 'date';
			}
			if(theme_get_option('blog','single_meta_category')){
				$single_meta_items[] = 'category';
			}
			if(theme_get_option('blog','single_meta_tags')){
				$single_meta_items[] = 'tags';
			}			
			if(theme_get_option('blog','single_meta_comment')){
				$single_meta_items[] = 'comment';
			}
			theme_set_option('blog','single_meta_items',$single_meta_items);
			update_option(THEME_SLUG.'_meta_information_fixed', true);
		}
		if(is_multisite()){
			global $blog_id;
			if(!get_option(THEME_SLUG.'_multisite_images_dir_fixed_'.$blog_id)){
				if(!is_dir(THEME_CACHE_IMAGES_DIR)){
					mkdir(THEME_CACHE_IMAGES_DIR);
				}
				update_option(THEME_SLUG.'_multisite_images_dir_fixed_'.$blog_id, true);
			}
		}
		if(!get_option(THEME_SLUG.'_page_for_posts_fixed')){
			update_option(THEME_SLUG.'_page_for_posts_fixed', true);

			$page_for_posts = get_option('page_for_posts');
			$show_on_front = get_option('show_on_front');
			$page_on_front = get_option('page_on_front');

			if(!empty($page_for_posts)){
				if($show_on_front == "posts"|| ($show_on_front == "page" && !empty($page_on_front))){
					if(empty($theme_options['blog']['blog_page'])){
						$theme_options['blog']['blog_page'] = $page_for_posts;
						update_option(THEME_SLUG . '_' . 'blog', $theme_options['blog']);
					}
					update_option('page_for_posts',0);
				}
			}
		}
		
		//change upload option from string to source array since ver.5.0.5
		if(!get_option(THEME_SLUG.'_upload_option_source_fixed')){
			update_option(THEME_SLUG.'_upload_option_source_fixed', true);
			$upload_options = array(
				array('page'=>'general', 'name'=>'logo'),
				array('page'=>'background', 'name'=>'box_image'),
				array('page'=>'background', 'name'=>'header_image'),
				array('page'=>'background', 'name'=>'feature_image'),
				array('page'=>'background', 'name'=>'page_image'),
				array('page'=>'background', 'name'=>'footer_image'),
			);
			foreach($upload_options as $option){
				if(isset($theme_options[$option['page']][$option['name']])){
					if(is_string($theme_options[$option['page']][$option['name']])){
						if(!empty($theme_options[$option['page']][$option['name']])){
							$theme_options[$option['page']][$option['name']] = array(
								'type'=>'url',
								'value'=>$theme_options[$option['page']][$option['name']]
							);
						}else{
							$theme_options[$option['page']][$option['name']] = array();
						}					
					}
				}
			}
			
			update_option(THEME_SLUG . '_' . 'general', $theme_options['general']);
			update_option(THEME_SLUG . '_' . 'background', $theme_options['background']);

			$posts = get_posts( array( 
				'post_type'   => 'portfolio', 
				'numberposts' => -1,
				'post_status' => 'publish'
			));
			foreach ( $posts as $post ) {
				$source = get_post_meta($post->ID, '_image', true);
				if(is_string($source)){
					if(!empty($source)){
						$source = array(
							'type'=>'url',
							'value'=>$source
						);
					}else{
						$source = array();
					}
					update_post_meta($post->ID, '_image', $source);
				}
			}
		}

		//change slideshow source b => p since version.5.0.2
		if(version_compare(get_option(THEME_SLUG.'_version'), "5.0.2", '<')){
			if(!get_option(THEME_SLUG.'_slideshow_source_fixed')){
				update_option(THEME_SLUG.'_slideshow_source_fixed', true);
				if(isset($theme_options['homepage']['slideshow_category'])){
					$theme_options['homepage']['slideshow_category'] = str_replace('{p','{b',$theme_options['homepage']['slideshow_category']);
					update_option(THEME_SLUG . '_' . 'homepage', $theme_options['homepage']);
				}

				$loop = new WP_Query( array('post_type'=> 'any', 'meta_key' => '_introduce_text_type', 'meta_value' => 'slideshow' ) );
				while ( $loop->have_posts() ) : $loop->the_post();
					$slideshow_category = get_post_meta(get_the_ID(), '_slideshow_category', true);
					$slideshow_category =  str_replace('{p','{b',$slideshow_category);
					
					update_post_meta(get_the_ID(), '_slideshow_category', $slideshow_category);
				endwhile;

				$posts = get_posts( array( 
					'post_type'   => 'any', 
					'numberposts' => -1,
					'post_status' => 'publish'
				));
				foreach ( $posts as $post ) {
					$post_content = $post->post_content;
					$pattern = '/\[slideshow\b(.*?)(?:(\/))?\]/s';
					if(preg_match_all($pattern, $post_content, $matches)){
						if(!empty($matches[0])){
							foreach($matches[0] as $string){
								$updated_string = str_replace('{p:','{b:',$string);
								$updated_string = str_replace('{p}','{b}',$updated_string);
								$post_content = str_replace($string,$updated_string,$post_content);
							}
						}
						
						$update_post = array();
						$update_post['ID'] = $post->ID;
						$update_post['post_content'] = $post_content;
						wp_update_post( $update_post );
					}
				}
			}
		}

		//change homepage'content to page_content since ver.3.0.1
		if(isset($theme_options['homepage']['content'])){
			if(!empty($theme_options['homepage']['content'])){
				if(empty($theme_options['homepage']['page_content'])){
					$theme_options['homepage']['page_content'] = $theme_options['homepage']['content'];
				}
			}
			unset($theme_options['homepage']['content']);
			update_option(THEME_SLUG . '_' . 'homepage', $theme_options['homepage']);
		}
		if(isset($theme_options['video'])){
			if(!empty($theme_options['video'])){
				if(empty($theme_options['video'])){
					$theme_options['media'] = $theme_options['video'];
				}
			}
			unset($theme_options['video']);
			update_option(THEME_SLUG . '_' . 'media', $theme_options['media']);
		}
		
		if(isset($theme_options['font']['enable_cufon'])){
			if(!empty($theme_options['font']['enable_cufon'])){
				if(empty($theme_options['cufon']['enable_cufon'])){
					$theme_options['cufon']['enable_cufon'] = $theme_options['font']['enable_cufon'];
				}
			}
			if(!empty($theme_options['font']['fonts'])){
				if(empty($theme_options['cufon']['fonts'])){
					$theme_options['cufon']['fonts'] = $theme_options['font']['fonts'];
				}
			}
			if(!empty($theme_options['font']['code'])){
				if(empty($theme_options['cufon']['code'])){
					$theme_options['cufon']['code'] = $theme_options['font']['code'];
				}
			}
			unset($theme_options['font']['enable_cufon']);
			unset($theme_options['font']['fonts']);
			unset($theme_options['font']['code']);
			update_option(THEME_SLUG . '_' . 'font', $theme_options['font']);
			update_option(THEME_SLUG . '_' . 'cufon', $theme_options['cufon']);
		}

		if(!get_option(THEME_SLUG.'_fontface_gfont_cufon_fixed')){
			$theme_options['font']['cufon_enabled'] = theme_get_option_from_db('cufon','enable_cufon');
			$theme_options['font']['cufon_code'] = theme_get_option_from_db('cufon','code');
			$cufon_used_array = theme_get_option_from_db('cufon','fonts');

			$theme_options['font']['cufon_used'] = array();
			if(!empty($cufon_used_array)){
				foreach ($cufon_used_array as $key => $value) {
					$theme_options['font']['cufon_used'][] = $key;
				}
			}
			if(!empty($theme_options['font']['cufon_used'])){
				$theme_options['font']['cufon_default'] = current($theme_options['font']['cufon_used']);
			}

			$theme_options['font']['gfont_code'] = theme_get_option_from_db('gfont','code');
			$theme_options['font']['gfont_used'] = theme_get_option_from_db('gfont','used_gfont');
			$theme_options['font']['gfont_default'] = theme_get_option_from_db('gfont','default_font');

			$theme_options['font']['fontface_enabled'] = theme_get_option_from_db('fontface','enable_fontface');
			$theme_options['font']['fontface_code'] = theme_get_option_from_db('fontface','code');
			$fontface_used_array = theme_get_option_from_db('fontface','fonts');

			$theme_options['font']['fontface_used'] = array();
			if(!empty($fontface_used_array)){
				foreach ($fontface_used_array as $key => $value) {
					$theme_options['font']['fontface_used'][] = $key;
				}
			}
			
			if(!empty($theme_options['font']['fontface_used']) && is_array($theme_options['font']['fontface_used'])){
				$theme_options['font']['fontface_default'] = current($theme_options['font']['fontface_used']);
			}

			update_option(THEME_SLUG . '_' . 'font', $theme_options['font']);
			delete_option(THEME_SLUG . '_' . 'cufon', array());
			delete_option(THEME_SLUG . '_' . 'fontface', array());
			delete_option(THEME_SLUG . '_' . 'gfont', array());
			update_option(THEME_SLUG.'_fontface_gfont_cufon_fixed', true);
		}

		if(!get_option(THEME_SLUG.'_advanced_fixed')){
			$theme_options['advanced'] = theme_get_option_from_db('advance');
			
			delete_option(THEME_SLUG . '_' . 'advance', array());
			update_option(THEME_SLUG . '_' . 'advanced', $theme_options['advanced']);

			update_option(THEME_SLUG.'_advanced_fixed', true);
		}
	}
}
