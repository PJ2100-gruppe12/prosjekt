<?php

function theme_generator($slug){
	do_action( "theme_generator_{$slug}", $slug);
	$slug = apply_filters("theme_generator_{$slug}",$slug);

	$template = "{$slug}.php";

	theme_load_section($template);

	$args = array_slice( func_get_args(), 1 );

	$function = "theme_section_{$slug}";

	return call_user_func_array($function, $args );
}

function theme_load_section($template_name){
	if( file_exists(THEME_SECTIONS.'/'.$template_name)){
		require_once(THEME_SECTIONS.'/'.$template_name);
	}
}

/**
 * Retrieve option value based on name of option.
 * 
 * If the option does not exist or does not have a value, then the return value will be false.
 * 
 * @param string $page page name
 * @param string $name option name
 */
function theme_get_option($page, $name = null) {
	global $theme_options;

	if($theme_options === null){
		return theme_get_option_from_db($page, $name);
	}

	if ($name == null) {
		if (isset($theme_options[$page])) {
			return $theme_options[$page];
		} else {
			return null;
		}
	} else {
		if (isset($theme_options[$page][$name])) {
			return $theme_options[$page][$name];
		} else {
			return null;
		}
	}
}

function theme_get_option_from_db($page, $name = null){
	$options = get_option('theme_' . $page);

	if($name == null){
		return $options;
	}else{
		if(is_array($options) && isset($options[$name])){
			return $options[$name];
		}
		return null;
	}
}

function theme_get_inherit_option($post_id, $meta_name, $page, $option_name) {
	$value = get_post_meta($post_id, $meta_name, true);

	if($value === 'false'){
		return false;
	}
	if($value===""|| $value == 'default'){
		$value=theme_get_option($page, $option_name);
	}
	return $value;
}

function theme_set_option($page, $name, $value) {
	global $theme_options;
	$theme_options[$page][$name] = $value;
	
	update_option('theme_' . $page, $theme_options[$page]);
}

function theme_get_sidebar_default(){
	if(theme_is_post_type('post')){
		return theme_get_option('sidebar','single_post');
	}
	if(theme_is_post_type('portfolio')){
		return theme_get_option('sidebar','single_portfolio');
	}
	if(theme_is_post_type('page')){
		return theme_get_option('sidebar','single_page');
	}
	return '';
}

function theme_get_sidebar_options(){
	$sidebars = theme_get_option_from_db('sidebar','sidebars');
	if(!empty($sidebars)){
		$sidebars_array = explode(',',$sidebars);
		
		$options = array();
		foreach ($sidebars_array as $sidebar){
			$options[$sidebar] = $sidebar;
		}
		return $options;
	}else{
		return array();
	}
}

function theme_get_icon_sets(){
	$icons = theme_get_option('font', 'icons');
	$array = array();
	if(!empty($icons)){
		$sets = include(THEME_ICONS_DIR.'/'.$icons.'/sets.php');
		foreach($sets as $group => $items){
			$array[$group] = array();
			foreach ($items as $item) {
				$array[$group][$item] = $item;
			}
		}
	}
	return $array;
}

/**
 * It will return a boolean value.
 * If the value to be checked is empty, it will use default value instead of.
 * 
 * @param mixed $value
 * @param mixed $default
 */
function theme_is_enabled($value, $default = false) {
	if(is_bool($value)){
		return $value;
	}
	switch($value){
		case '1'://for theme compatibility
		case 'true':
			return true;
		case '-1'://for theme compatibility
		case 'false':
			return false;
		case '0':
		case '':
		default:
			return $default;
	}
}

function theme_get_excluded_pages(){
	$excluded_pages = theme_get_option('general', 'excluded_pages');
	$excluded_pages_with_childs = '';
	$home = theme_get_option('homepage','home_page');
	/* if('page' == get_option('show_on_front') ){
		$home = get_option('page_on_front');

		if(!$home){
			$home = get_option('page_for_posts');
		}
	}*/
	if (! empty($excluded_pages)) {
		//Exclude a parent and all of that parent's child Pages
		foreach($excluded_pages as $parent_page_to_exclude) {
			if ($excluded_pages_with_childs) {
				$excluded_pages_with_childs .= ',' . $parent_page_to_exclude;
			} else {
				$excluded_pages_with_childs = $parent_page_to_exclude;
			}
			$descendants = get_pages('child_of=' . $parent_page_to_exclude);
			if ($descendants) {
				foreach($descendants as $descendant) {
					$excluded_pages_with_childs .= ',' . $descendant->ID;
				}
			}
		}
		if($home){
			$excluded_pages_with_childs .= ',' .$home;
		}
	} else {
		$excluded_pages_with_childs = $home;
	}
	return $excluded_pages_with_childs;
}

if(!function_exists("get_queried_object_id")){
	/**
	* Retrieve ID of the current queried object.
	*/
	function get_queried_object_id(){
		global $wp_query;
		return $wp_query->get_queried_object_id();
	}
}
if(!function_exists("get_the_author_posts_link")){
	function get_the_author_posts_link(){
		return '<a href="' . get_author_posts_url(get_the_author_meta( 'ID' )) . '" title="' . esc_attr( sprintf(__('Visit %s&#8217;s all posts','theme_front'), get_the_author()) ) . '" rel="author">' . get_the_author() . '</a>';
	}
}
// use for template_blog.php
function is_blog() {
	global $is_blog;
	
	if($is_blog == true){return true;}
	$blog_page_id = theme_get_option('blog','blog_page');
	
	if(empty($blog_page_id)){
		return false;
	}
	//polylang compatibility
	if(function_exists('pll_get_post')){
		if(pll_get_post($blog_page_id) == get_queried_object_id()){
			$is_blog = true;
			return true;
		}
	}

	if(wpml_get_object_id($blog_page_id,'page') == get_queried_object_id()){
		$is_blog = true;
		return true;
	}
	
	return false;
}
function is_shortcode_dialog() {
	if(isset($_GET['action']) && $_GET['action']=='theme-shortcode-dialog'){
		return true;
	}else{
		return false;
	}
}
function is_shortcode_preview() {
	if(defined('DOING_AJAX') && isset($_GET['action']) && $_GET['action']=='theme-shortcode-preview'){
		return true;
	}else{
		return false;
	}
}

function is_slide_preview() {
	if(isset($_GET['layerpreview']) && $_GET['layerpreview']=='true' && isset($_GET['sliderid'])){
		return true;
	}else{
		return false;
	}
}
if(!function_exists("wp_basename")){
	function wp_basename( $path, $suffix = '' ) {
		return urldecode( basename( str_replace( '%2F', '/', urlencode( $path ) ), $suffix ) );
	}
}

function theme_color_fallback($rule, $color, $important=false){
	if($important){
		$important = ' !important';
	}else{
		$important = '';
	}
	if(preg_match('/rgba\(\s*(\d{1,3}%?)\s*,\s*(\d{1,3}%?)\s*,\s*(\d{1,3}%?)\s*,\s*(\d?(?:\.\d+)?)\s*\)/i',$color,$matches)){
		$rgb = 'rgb('.$matches[1].','.$matches[2].','.$matches[3].')';
		if($matches[4]==='1'){
			return <<<CSS

	{$rule}: {$rgb}{$important};

CSS;
		}else{
			return <<<CSS

	{$rule}: {$rgb}{$important};
	{$rule}: {$color}{$important};

CSS;
		}
	}elseif(empty($color)){
		return <<<CSS

	{$rule}: transparent{$important};

CSS;
	}else{
		return <<<CSS

	{$rule}: {$color}{$important};

CSS;
	}
}

/**
 * Fix the image src for MultiSite
 * 
 * @param string $src the full path of image
 */
function get_image_src($src) {
	if(is_multisite()){
		global $blog_id;
		$upload_path = get_blog_option($blog_id,'upload_path');
		if(!empty($upload_path) && strpos($src, $upload_path) !== false){
			return str_replace(get_option('siteurl'), '', $src);
		}
		if(is_subdomain_install()){
			if ( defined( 'DOMAIN_MAPPING' ) ){
				if(function_exists('get_original_url')){ //WordPress MU Domain Mapping
					if(false !== strpos($src, str_replace(get_original_url('siteurl'),site_url(),get_blog_option($blog_id,'fileupload_url')))){
						return site_url().'/'.str_replace(str_replace(get_original_url('siteurl'),site_url(),get_blog_option($blog_id,'fileupload_url')),get_blog_option($blog_id,'upload_path'),$src);
					}
				}else { //VHOST and directory enabled Domain Mapping plugin
					global $dm_map;
					if(isset($dm_map)){
						static $orig_urls = array();
						if ( ! isset( $orig_urls[ $blog_id ] ) ) {
							remove_filter( 'pre_option_siteurl', array(&$dm_map, 'domain_mapping_siteurl') );
							$orig_url = get_option( 'siteurl' );
							$orig_urls[ $blog_id ] = $orig_url;
							add_filter( 'pre_option_siteurl', array(&$dm_map, 'domain_mapping_siteurl') );
						}
						if(false !== strpos($src, str_replace($orig_urls[$blog_id],site_url(),get_blog_option($blog_id,'fileupload_url')))){
							return site_url().'/'.str_replace(str_replace($orig_urls[$blog_id],site_url(),get_blog_option($blog_id,'fileupload_url')),get_blog_option($blog_id,'upload_path'),$src);
						}
					}
				}
			}
			if(false !== strpos($src, get_blog_option($blog_id,'fileupload_url'))){
				return site_url().'/'.str_replace(get_blog_option($blog_id,'fileupload_url'),get_blog_option($blog_id,'upload_path'),$src);
			}
		}else{
			if ( defined( 'DOMAIN_MAPPING' ) ){
				if(function_exists('get_original_url')){ //WordPress MU Domain Mapping
					if(false !== strpos($src, get_blog_option($blog_id,'fileupload_url'))){
						return site_url().'/'.str_replace(str_replace(get_original_url('siteurl'),site_url(),get_blog_option($blog_id,'fileupload_url')),get_blog_option($blog_id,'upload_path'),$src);
					}
				}
			}
			$curSite =  get_current_site(1);

			if(false !== strpos($src, get_blog_option($blog_id,'fileupload_url'))){
				return $curSite->path.str_replace(get_blog_option($blog_id,'fileupload_url'),get_blog_option($blog_id,'upload_path'),$src);
			}
		}
		if(defined('DOMAIN_CURRENT_SITE')){
			if(false !== strpos($src, DOMAIN_CURRENT_SITE)){
				$src = preg_replace('/^https?:\/\//i', '', $src);
				return str_replace(DOMAIN_CURRENT_SITE, '', $src);
			}
		}
	}else{
		if(0 === strpos($src, get_option('siteurl'))){
			return str_replace(get_option('siteurl'), '', $src);
		}
	}
	return $src;
	
}

function theme_get_image_src($source, $size = 'full', $quality=''){
	if(empty($source)){
		return '';
	}
	if(!is_array($size)){
		switch($source['type']){
			case 'attachment_id':
				if(empty($source['value'])){
					return '';
				}
				if(stripos($source['value'],'ngg-') !== false && class_exists('nggdb')) {
					$nggMeta = new nggMeta(str_replace('ngg-','',$source['value']));
					return $nggMeta->image->imageURL;
				}else{
					$src = wp_get_attachment_image_src($source['value'], 'full');
					return $src[0];
				}
			case 'url':
			default:
				return $source['value'];
		}
	}
	
	switch($source['type']){
		case 'attachment_id':
			if(empty($source['value'])){
				return '';
			}
			$resizer = new ImageResizerByAttachmentId($source['value'], $size);
			return $resizer->src();
		case 'url':
		default:
			$resizer = new ImageResizerByUrl($source['value'], $size);
			return $resizer->src();
	}
}

class ThemeImageResizer {
	protected $width;
	protected $height;
	protected $src;
	protected $cache_dir;
	protected $cache_uri;
	public function __construct($size, $quality = 90) {
		$this->width = $size[0];
		$this->height = $size[1];
		$this->cache_dir = THEME_CACHE_IMAGES_DIR.'/';
		$this->cache_uri = THEME_CACHE_IMAGES_URI.'/';
		$this->quality = $quality;

		if(!$this->cache_exists()){
			$this->resize();
		}
	}
	protected function get_file_basename($file, $suffix = ''){
		return wp_basename($file, $suffix);
	}
	protected function resize(){}
	protected function cache_exists(){}
	public function src(){}
	protected function resize_process($file,$width,$height,$suffix = null,$dest_path = null,$jpeg_quality = 90){
		global $wp_version;
		
		$image = imagecreatefromstring( file_get_contents( $file ) );
		
		if ( !is_resource( $image ) )
			return new WP_Error( 'error_loading_image', $image, $file );
		
		$size = @getimagesize( $file );
		if ( !$size )
			return new WP_Error('invalid_image', __('Could not read image size','theme_front'), $file);

		list($orig_w, $orig_h, $orig_type) = $size;

		if($height == ''){
			$height = round($orig_h * $width/$orig_w);
			if ( !$suffix )
			$suffix = "{$width}";
		}
		$dims = $this->resize_dimensions($orig_w, $orig_h, $width, $height);
		if ( !$dims )
			return new WP_Error( 'error_getting_dimensions', __('Could not calculate resized image dimensions','theme_front') );
		list($dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) = $dims;

		$newimage = wp_imagecreatetruecolor( $width, $height );
		
		if ( IMAGETYPE_PNG == $orig_type || IMAGETYPE_GIF == $orig_type ){
			imagealphablending($newimage, false);
			$color = imagecolorallocatealpha ($newimage, 255, 255, 255, 127);
			imagefill ($newimage, 0, 0, $color);
			imagesavealpha($newimage, true);
		}
		
		imagecopyresampled( $newimage, $image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

		// convert from full colors to index colors, like original PNG.
		if ( IMAGETYPE_PNG == $orig_type && function_exists('imageistruecolor') && !imageistruecolor( $image ) )
			imagetruecolortopalette( $newimage, false, imagecolorstotal( $image ) );
		
		// we don't need the original in memory anymore
		imagedestroy( $image );
		if ( !$suffix )
			$suffix = "{$width}x{$height}";
		
		$info = pathinfo($file);
		$dir = $info['dirname'];
		$ext = $info['extension'];
		$name = $this->get_file_basename($file, ".$ext");

		if ( !is_null($dest_path) and $_dest_path = realpath($dest_path) )
			$dir = $_dest_path;

		$destfilename = "{$dir}/{$name}-{$suffix}.{$ext}";

		if ( IMAGETYPE_GIF == $orig_type ) {
			if ( !imagegif( $newimage, $destfilename ) )
				return new WP_Error('resize_path_invalid', __('Resize path invalid','theme_front'));
		} elseif ( IMAGETYPE_PNG == $orig_type ) {
			if ( !imagepng( $newimage, $destfilename ) )
				return new WP_Error('resize_path_invalid', __('Resize path invalid','theme_front'));
		} else {
			// all other formats are converted to jpg
			$destfilename = "{$dir}/{$name}-{$suffix}.jpg";
			if ( !imagejpeg( $newimage, $destfilename, apply_filters( 'jpeg_quality', $jpeg_quality, 'image_resize' ) ) )
				return new WP_Error('resize_path_invalid', __('Resize path invalid','theme_front'));
		}

		imagedestroy( $newimage );

		// Set correct file permissions
		$stat = stat( dirname( $destfilename ));
		$perms = $stat['mode'] & 0000666; //same permissions as parent folder, strip off the executable bits
		@ chmod( $destfilename, $perms );

		return $destfilename;
	}

	protected function resize_dimensions($orig_w, $orig_h, $dest_w, $dest_h){
		if ($orig_w <= 0 || $orig_h <= 0)
			return false;
		// at least one of dest_w or dest_h must be specific
		if ($dest_w <= 0 && $dest_h <= 0)
			return false;
		$src_x=0;
		$src_y=0;
		$src_w = $orig_w;
		$src_h = $orig_h;

		$cmp_x = $orig_w / $dest_w;
		$cmp_y = $orig_h / $dest_h;
		if ($cmp_x > $cmp_y) {

			$src_w = round ($orig_w / $cmp_x * $cmp_y);
			$src_x = round (($orig_w - ($orig_w / $cmp_x * $cmp_y)) / 2);

		} else if ($cmp_y > $cmp_x) {

			$src_h = round ($orig_h / $cmp_y * $cmp_x);
			$src_y = round (($orig_h - ($orig_h / $cmp_y * $cmp_x)) / 2);

		}
		return array( 0, 0, $src_x,  $src_y, $dest_w,  $dest_h,  $src_w,  $src_h );
	}
}

class ImageResizerByAttachmentId extends ThemeImageResizer {
	protected $attachment_id;
	protected $metadata;
	protected $size_name;
	public function __construct($attachment_id, $size,$quality = 90) {
		if(empty($attachment_id)){
			return;
		}
		$this->attachment_id = $attachment_id;
		$this->metadata = wp_get_attachment_metadata($attachment_id);
		
		if(empty($size[1])){
			$size[1] = floor(($this->metadata['height'] * $size[0])/$this->metadata['width']);
			$this->size_name = "{$size[0]}";
		}else{
			$this->size_name = "{$size[0]}x{$size[1]}";
		}

		parent::__construct($size);
	}
	protected function get_file_basename($file, $suffix = ''){
		return $this->attachment_id.'_'.wp_basename($file, $suffix);
	}

	protected function resize(){
		if(stripos($this->attachment_id,'ngg-') !== false && class_exists('nggdb')) {
			$nggMeta = new nggMeta(str_replace('ngg-','',$this->attachment_id));
			$file = $nggMeta->image->imagePath;
		}else{
			if ( !preg_match('!^image/!', get_post_mime_type( $this->attachment_id ))) {
				return new WP_Error('attachment_is_not_image', __('Attachment is not image','theme_front'));
			}
			$file = get_attached_file($this->attachment_id);
		}
		
		
		$info = @getimagesize($file);
		if ( empty($info) || !in_array($info[2], array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) // only gif, jpeg and png images can reliably be displayed
			return new WP_Error('image_type_is_not_correctly', __('Image type is not correctly','theme_front'));
		
		$resized_file = $this->resize_process($file, $this->width, $this->height, $this->size_name, $this->cache_dir, $this->quality);
		// update attachment metadata to make it store custom sizes infos
		$this->metadata['custom_sizes'][$this->size_name] = array(
			'file' => wp_basename($resized_file),
			'width' => $this->width,
			'height' => $this->height,
		);
		wp_update_attachment_metadata($this->attachment_id, $this->metadata);

		$this->src = $this->cache_uri.$this->metadata['custom_sizes'][$this->size_name]['file'];

	}

	public function cache_exists(){
		if($this->src){
			return true;
		}

		if ( !is_array( $this->metadata ) )
			return false;
		if (isset($this->metadata['custom_sizes'][$this->size_name] )){
			$this->src = $this->cache_uri.$this->metadata['custom_sizes'][$this->size_name]['file'];
			//$this->file = $this->metadata['custom_sizes'][$this->size_name]['file'];
			return true;
		}
		if ( !empty($this->metadata['sizes']) ) {
			foreach ( $this->metadata['sizes'] as $_size => $data ) {
				// already cropped to width or height; so use this size
				if ( $data['width'] == $this->width && $data['height'] == $this->height ) {
					$src_array = wp_get_attachment_image_src($this->attachment_id, $_size);
					$this->src = $src_array[0];
					//$this->file = $data['file'];
					return true;
				}
			}
		}
		
		return false;
	}

	public function src(){
		if($this->src){
			return $this->src;
		}
		return false;
	}
}

class ImageResizerByUrl extends ThemeImageResizer {
	protected $path;
	protected $url;
	protected $external = false;
	protected $size_name;
	public function __construct($url, $size) {
		$this->url = $url;
		$url_info = parse_url($url);
		
		if(isset($url_info['host']) && preg_replace('/^www\./i', '', strtolower($url_info['host'])) != strtolower(preg_replace('/^www\./i', '', $_SERVER['HTTP_HOST']))){
			$this->external = true;
		}
		if($this->external){
			$this->src = $url;
		}else{
			$this->path = get_image_src($url);
			if($size[1] == ''){
				$this->size_name = "{$size[0]}";
			}else{
				$this->size_name = "{$size[0]}x{$size[1]}";
			}
		}
		parent::__construct($size);		
	}
	public function resize(){
		$path = ltrim($this->path, '/\\');
		$file = ABSPATH. $path;
		
		if(!is_file($file)){
			return new WP_Error('file_is_not_exists', __('File is not exists','theme_front'));
		}
		$resized_file = $this->resize_process($file, $this->width, $this->height,$this->size_name,$this->cache_dir,$this->quality);
		if ( is_wp_error($resized_file) ){
			return $resized_file;
		}
		$this->src =  $this->cache_uri . wp_basename($resized_file);
	}
	public function cache_exists(){
		if($this->external){
			return true;
		}
		if($this->src){
			return true;
		}
		if($this->path){
			$info = pathinfo($this->path);
			$ext = $info['extension'];
			$name = wp_basename($this->path, ".$ext");
			$filename = "{$name}-{$this->size_name}.{$ext}";
			$cached_file = $this->cache_dir . $filename;
			if(is_file($cached_file)){
				$this->src = $this->cache_uri . $filename;
				return true;
			}
		}
		return false;
	}
	public function src(){
		if($this->src){
			return $this->src;
		}
		return $this->url;
	}
}

function theme_add_cufon_code(){
	$code = stripslashes(theme_get_option('font','cufon_code'));
	//$fonts = theme_get_option('font','cufon_used');
	$default_font = theme_get_option('font','cufon_default');
	if(!empty($default_font)){
		$file_content = file_get_contents(THEME_FONT_DIR.'/'.$default_font);
		if(preg_match('/font-family":"(.*?)"/i',$file_content,$match)){
			$font_name = $match[1];
		}
		if($font_name){
			$default_code = <<<CODE
Cufon.replace("#site_name,#site_description,.kwick_title,.kwick_detail h3,#footer h3,#copyright,.dropcap1,.dropcap2,.dropcap3,.dropcap4", {fontFamily : "{$font_name}"}); 
Cufon.replace("#feature h1,#introduce",{fontFamily : "{$font_name}"});
Cufon.replace('.portfolio_title,h1,h2,h3,h4,h5,h6,#navigation a, .entry_title a', {
	hover: true,
	fontFamily : "{$font_name}"
});
CODE;
		}
	}else{
		$default_code = '';
	}
	
	
	echo <<<HTML
<script type='text/javascript'>
{$default_code}
{$code}
</script>
HTML;
}

function theme_add_cufon_code_footer(){
	echo <<<HTML
<script type='text/javascript'>
HTML;
if(theme_get_option('font','cufon_enabled')){
	echo <<<HTML
Cufon.now();
HTML;
}
	echo <<<HTML
if(typeof jQuery != 'undefined'){
if(jQuery.browser.msie && parseInt(jQuery.browser.version, 10)==8){
	jQuery(".jqueryslidemenu ul li ul").css({display:'block', visibility:'hidden'});
}
}
</script>
HTML;
}

function theme_get_superlink($link, $default=false){
	if(!empty($link)){
		$link_array = explode('||',$link);
		switch($link_array[0]){
			case 'page':
				return get_page_link($link_array[1]);
			case 'cat':
				return get_category_link($link_array[1]);
			case 'post':
				return get_permalink($link_array[1]);
			case 'portfolio':
				return get_permalink($link_array[1]);
			case 'manually':
				return $link_array[1];
		}
	}
	return $default;
}

function theme_portfolio_ajax_init(){
	if ( 'POST' != $_SERVER['REQUEST_METHOD'] || !isset( $_POST['portfolioAjax'] ) ){
		return;
	}
	if($_POST['portfolioAjax'] != 'true'){
		return;
	}
	
	$options = array();
	if(isset($_POST['portfolioOptions']))
		$options =  $_POST['portfolioOptions'];
	
	if(isset($_POST['category']) && $_POST['category']!='all'){
		$options['cat'] = $_POST['category'];
	}
	if(isset($_POST['portfolioPage'])){
		$options['paged'] = intval($_POST['portfolioPage']);
	}

	if(isset($options['current'])){
		unset($options['current']);
	}
	if ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) {
		echo apply_filters('the_content',theme_generator('portfolio_list',$options));
	}
	exit();
}
add_action('wp_loaded', 'theme_portfolio_ajax_init');


function theme_responsive_image_init(){
	if ( 'POST' != $_SERVER['REQUEST_METHOD'] || !isset( $_POST['imageAjax'] ) ){
		return;
	}
	if($_POST['imageAjax'] != 'true'){
		return;
	}
	if(!isset($_POST['thumbnail_id'])){
		return;
	}
	if(!isset($_POST['width'])){
		return;
	}
	
	$thumbnail_id = $_POST['thumbnail_id'];
	$width = intval($_POST['width']);
	$height = '';
	if(isset($_POST['height'])){
		$height = intval($_POST['height']);
	}
	
	if ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) {
		@header( 'Content-Type: application/html; charset=' . get_option( 'blog_charset' ) );
		$image_source = array('type'=>'attachment_id','value'=>$thumbnail_id);
		$size = array($width, $height);
		$image_src = theme_get_image_src($image_source, $size);
		echo $image_src;
	}
	exit();
}
add_action('wp_loaded', 'theme_responsive_image_init');

function theme_parse_query($query){
	if($query->is_home && 'posts' == get_option('show_on_front')){
		$query->is_paged = false;
	}
}
add_action('parse_query', 'theme_parse_query');

function theme_kenburn_video(){
	if(!isset($_GET['html5iframe']) || $_GET['html5iframe'] != 'true'){
		return;
	}
	if(!isset($_GET['sliderid'])){
		return;
	}

	include(get_template_directory().'/includes/html5video.php');
	
	exit();
}
add_action('init', 'theme_kenburn_video');

function theme_slide_preview(){
	if(!isset($_GET['layerpreview']) || $_GET['layerpreview'] != 'true'){
		return;
	}
	if(!isset($_GET['sliderid'])){
		return;
	}	
	include(get_template_directory().'/includes/sliderpreview.php');
	
	exit();
}

add_action('wp_loaded', 'theme_slide_preview');


function theme_maybe_process_contact_form(){
	$submit_contact_form = isset($_POST["theme_contact_form_submit"]) ? $_POST["theme_contact_form_submit"] : 0;
	if($submit_contact_form){
		require_once(THEME_FUNCTIONS.'/email.php');
		exit;
	}
}
add_action('wp', 'theme_maybe_process_contact_form', 9);

function theme_exclude_from_search(){
	global $wp_post_types;
	$post_types = theme_get_option('advanced','exclude_from_search');
	if(!empty($post_types)){
		foreach($post_types as $post_type){
			$wp_post_types[$post_type]->exclude_from_search = true;
		}
	}
}
add_action('wp_loaded', 'theme_exclude_from_search');

add_filter( 'wp_setup_nav_menu_item', 'theme_setup_nav_menu_itemu' );
function theme_setup_nav_menu_itemu($menu_item){
	$menu_item->icon = get_post_meta( $menu_item->ID, 'menu-item-icon' , true ) ? get_post_meta( $menu_item->ID, 'menu-item-icon', true ) : '';
	$menu_item->icon_color = get_post_meta( $menu_item->ID, 'menu-item-icon-color' , true ) ? get_post_meta( $menu_item->ID, 'menu-item-icon-color', true ) : '';

	return $menu_item;
}
class Theme_Walker_Nav_Menu extends Walker_Nav_Menu {
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		}
		if(theme_get_option('general','enable_nav_subtitle')){
			$args[0]->link_after ='';
			if (!empty($element->description )&& ($element->post_type='nav_menu_item')&& ($element->menu_item_parent==0)){
				$description = '&nbsp;<span class="menu-subtitle">'.$element->description.'</span>';
				$args[0]->link_after = $description;
			}
		}
		$args[0]->link_before = '';
		if(isset($element->icon) && !empty($element->icon)){
			if(isset($element->icon_color) && !empty($element->icon_color)){
				$icon_color_style = ' style="color:'.$element->icon_color.'"';
			} else {
				$icon_color_style = '';
			}
			$args[0]->link_before = '<i class="icon-'.trim($element->icon).'"'.$icon_color_style.'></i>';
		}
		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}
class Theme_Walker_Nav_Menu_Footer extends Walker_Nav_Menu {
 	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
		}
		$args[0]->link_before = '';
		if(isset($element->icon) && !empty($element->icon)){
			if(isset($element->icon_color) && !empty($element->icon_color)){
				$icon_color_style = ' style="color:'.$element->icon_color.'"';
			} else {
				$icon_color_style = '';
			}
			$args[0]->link_before = '<i class="menu-icon-footer icon-'.trim($element->icon).'"'.$icon_color_style.'></i>';
		}
		return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}
class Theme_The_Excerpt_Length_Constructor {
	var $length;
	function __construct($length) {
		$this->length = $length;
	}
	function get_length(){
		return $this->length;
	}
	function trim($text){
		$excerpt_length = apply_filters('excerpt_length', 55);
		
		$excerpt_more = apply_filters('excerpt_more', ' ' . '...');
		$text = theme_strcut( $text, $excerpt_length, $excerpt_more );
		return $text;
	}
}


function theme_add_script_to_head(){
	if(theme_get_option('font','cufon_enabled')){
		theme_add_cufon_code();
	}
?>
<script type="text/javascript">
var image_url='<?php echo THEME_IMAGES;?>';
var theme_url='<?php echo THEME_URI;?>';
<?php
	$fancybox_skin = theme_get_option('advanced','fancybox_skin');
	$fancybox_title_type = theme_get_option('advanced','fancybox_title_type');
	$fancybox_width = theme_get_option('advanced','fancybox_width');
	$fancybox_height = theme_get_option('advanced','fancybox_height');
	$fancybox_autoSize = theme_get_option('advanced','fancybox_autoSize')?'true':'false';
	$fancybox_autoWidth = theme_get_option('advanced','fancybox_autoWidth')?'true':'false';
	$fancybox_autoHeight = theme_get_option('advanced','fancybox_autoHeight')?'true':'false';
	$fancybox_fitToView = theme_get_option('advanced','fancybox_fitToView')?'true':'false';
	//$fancybox_fitToView_mode = theme_get_option('advanced','fancybox_fitToView_mode')?'true':'false';
	$fancybox_aspectRatio = theme_get_option('advanced','fancybox_aspectRatio')?'true':'false';
	$fancybox_arrows = theme_get_option('advanced','fancybox_arrows')?'true':'false';
	$fancybox_closeBtn = theme_get_option('advanced','fancybox_closeBtn')?'true':'false';
	$fancybox_closeClick = theme_get_option('advanced','fancybox_closeClick')?'true':'false';
	$fancybox_nextClick = theme_get_option('advanced','fancybox_nextClick')?'true':'false';
	$fancybox_autoPlay = theme_get_option('advanced','fancybox_autoPlay')?'true':'false';
	$fancybox_playSpeed = theme_get_option('advanced','fancybox_playSpeed');
	$fancybox_preload = theme_get_option('advanced','fancybox_preload');
	$fancybox_loop = theme_get_option('advanced','fancybox_loop')?'true':'false';
	$fancybox_thumbnail = theme_get_option('advanced','fancybox_thumbnail')?'true':'false';
	$fancybox_thumbnail_width = theme_get_option('advanced','fancybox_thumbnail_width');
	$fancybox_thumbnail_height = theme_get_option('advanced','fancybox_thumbnail_height');
	$fancybox_thumbnail_position = theme_get_option('advanced','fancybox_thumbnail_position');

		echo <<<JS
var fancybox_options = {
	skin : '{$fancybox_skin}',
	title_type : '{$fancybox_title_type}',
	width : {$fancybox_width},
	height : {$fancybox_height},
	autoSize: {$fancybox_autoSize},
	autoWidth: {$fancybox_autoWidth},
	autoHeight: {$fancybox_autoHeight},
	fitToView : {$fancybox_fitToView},
	aspectRatio: {$fancybox_aspectRatio},
	arrows: {$fancybox_arrows},
	closeBtn: {$fancybox_closeBtn},
	closeClick: {$fancybox_closeClick},
	nextClick: {$fancybox_nextClick},
	autoPlay: {$fancybox_autoPlay},
	playSpeed: {$fancybox_playSpeed},
	preload: {$fancybox_preload},
	loop: {$fancybox_loop},
	thumbnail : {$fancybox_thumbnail},
	thumbnail_width : {$fancybox_thumbnail_width},
	thumbnail_height : {$fancybox_thumbnail_height},
	thumbnail_position: '{$fancybox_thumbnail_position}'
};

JS;
	$pie_progress_bar_color = theme_get_option('color', 'pie_progress_bar_color');
	if(!$pie_progress_bar_color){
		$pie_progress_bar_color = theme_get_option('color', 'primary');
	}
	$pie_progress_track_color = theme_get_option('color', 'pie_progress_track_color');

	echo <<<JS
var pie_progress_bar_color = "{$pie_progress_bar_color}",
	pie_progress_track_color = "{$pie_progress_track_color}";

JS;

	$nav2select_indentString = theme_get_option('advanced','nav2select_indentString');
	$nav2select_defaultText = theme_get_option('advanced','nav2select_defaultText');
	echo "var nav2select_indentString = \"".esc_attr($nav2select_indentString)."\";\n";
	echo "var nav2select_defaultText = \"".esc_attr($nav2select_defaultText)."\";\n";

	if(theme_get_option('general','sticky_header')){
		echo "var sticky_header_target = \"".theme_get_option('advanced','sticky_header_target')."\";\n";
	}
	if((is_front_page() && theme_get_option('footer','sticky_footer')) || (theme_get_inherit_option(get_queried_object_id(), '_sticky_footer', 'footer','sticky_footer'))) {
		echo "var sticky_footer_target = \"".theme_get_option('advanced','sticky_footer_target')."\";\n";
	}
?>
</script>
<?php
	if(theme_get_option('general','analytics') && theme_get_option('general','analytics_position')=='header'){
		echo stripslashes(theme_get_option('general','analytics'));
	}

	$post_id = get_queried_object_id();
	if($post_id){
		$css = '';
		$page_css = '';
		$page_image = get_post_meta($post_id, '_page_background_image', true);
		if(!empty($page_image)){
			$page_image = theme_get_image_src($page_image);
			$page_repeat = get_post_meta($post_id, '_page_background_repeat', true);
			$page_position_x = get_post_meta($post_id, '_page_background_position_x', true);
			$page_position_y = get_post_meta($post_id, '_page_background_position_y', true);
			$page_attachment = get_post_meta($post_id, '_page_background_attachment', true);
			$page_size = get_post_meta($post_id, '_page_background_size', true);

			$page_css .= <<<CSS
	background-image: url('{$page_image}');
	background-repeat: {$page_repeat};
	background-position: {$page_position_x} {$page_position_y};
	background-attachment: {$page_attachment};
	-webkit-background-size: {$page_size};
	-moz-background-size: {$page_size};
	-o-background-size: {$page_size};
	background-size: {$page_size};
CSS;
		}
		$page_color = get_post_meta($post_id, '_page_background_color', true);
		if(!empty($page_color) && $page_color != "transparent"){
			$page_css .= theme_color_fallback('background-color',$page_color);
		}
		if(!empty($page_css)) {
			$css .= <<<CSS
#page {
{$page_css}
}

CSS;
		}
		$page_inner_color = get_post_meta($post_id, '_page_inner_background_color', true);
		if(!empty($page_inner_color) && $page_inner_color != "transparent"){
			$css .= <<<CSS
#page .inner {
CSS;
			$css .= theme_color_fallback('background-color',$page_inner_color);
			$css .= <<<CSS
}

CSS;
		}
		$feature_title_color = get_post_meta($post_id, '_feature_title_color', true);
		if(!empty($feature_title_color) && $feature_title_color != "transparent"){
			$css .= <<<CSS
#feature h1 {
CSS;
			$css .= theme_color_fallback('color',$feature_title_color);
			$css .= <<<CSS
}

CSS;
		}

		$feature_introduce_color = get_post_meta($post_id, '_feature_introduce_color', true);
		if(!empty($feature_introduce_color) && $feature_introduce_color != "transparent"){
			$css .= <<<CSS
#introduce, #introduce a {
CSS;
			$css .= theme_color_fallback('color',$feature_introduce_color);
			$css .= <<<CSS
}

CSS;
		}
		$page_color = get_post_meta($post_id, '_page_color', true);
		if(!empty($page_color) && $page_color != "transparent"){
			$css .= <<<CSS
#page {
CSS;
			$css .= theme_color_fallback('color',$page_color);
			$css .= <<<CSS
}

CSS;
		}

		$footer_color = get_post_meta($post_id, '_footer_color', true);
		if(!empty($footer_color) && $footer_color != "transparent"){
			$css .= <<<CSS
#footer {
CSS;
			$css .= theme_color_fallback('color',$footer_color);
			$css .= <<<CSS
}

CSS;
		}

		$footer_title_color = get_post_meta($post_id, '_footer_title_color', true);
		if(!empty($footer_title_color) && $footer_title_color != "transparent"){
			$css .= <<<CSS
#footer h3.widgettitle {
CSS;
			$css .= theme_color_fallback('color',$footer_title_color);
			$css .= <<<CSS
}

CSS;
		}

		$custom_css = get_post_meta($post_id, '_custom_css', true);
		if(!empty($custom_css)){
			$css .= <<<CSS
{$custom_css}

CSS;
		}

		if(!empty($css)){
			echo  <<<CSS
<style type="text/css">
{$css}
</style>

CSS;
		}

		$custom_js = get_post_meta($post_id, '_custom_js', true);
		if(!empty($custom_js)){
			echo stripslashes($custom_js);
		}
	}
}
add_action( 'wp_head', 'theme_add_script_to_head');

if('wp-signup.php' == basename($_SERVER['PHP_SELF'])){
	add_action( 'wp_head', 'theme_wpmu_signup_stylesheet',1 );
	function theme_wpmu_signup_stylesheet() {
		remove_action( 'wp_head', 'wpmu_signup_stylesheet');
		?>
		<style type="text/css">
			.mu_register { margin:0 auto; }
			.mu_register form { margin-top: 2em; }
			.mu_register .error,.mu_register .mu_alert { 
				-webkit-border-radius: 1px;
				-moz-border-radius: 1px;
				border-radius: 1px;
				border: 1px solid #bbb;
				padding:10px;
				margin-bottom: 20px;
			}
			.mu_register .error {
				background: #FDE9EA;
				color: #A14A40;
				border-color: #FDCED0;
			}
			.mu_register input[type="submit"],
				.mu_register #blog_title,
				.mu_register #user_email,
				.mu_register #blogname,
				.mu_register #user_name { width:100%; font-size: 24px; margin:5px 0; }
			.mu_register .prefix_address,
				.mu_register .suffix_address {font-size: 18px;display:inline; }
			.mu_register label { font-weight:700; font-size:15px; display:block; margin:10px 0; }
			.mu_register label.checkbox { display:inline; }
			.mu_register .mu_alert { 
				background: #FFF9CC;
				color: #736B4C;
				border-color: #FFDB4F;
			}
		</style>
		<?php
	}


	// before wp-signup.php and before get_header()
	add_action('before_signup_form', 'theme_before_signup_form');
	function theme_before_signup_form () {

		$output = '<div id="feature">';
		$output .= '<div class="top_shadow"></div>';
		$output .= '<div class="inner">';
		$output .= '<h1>'.__('Sign Up Now','theme_front').'</h1>';
		$output .= '</div>';
		$output .= '<div class="bottom_shadow"></div>';
		$output .= '</div>';
		
		$output .= '<div id="page">';
		$output .= '<div class="inner">';
		echo $output;
	}

	// after wp-signup.php and before get_footer()
	add_action('after_signup_form', 'theme_after_signup_form');
	function theme_after_signup_form () {
		echo '</div>';
		echo '</div>';
	}
}

function theme_strcut($str, $length, $extra = ''){
	if ( function_exists('mb_strlen') ) {
		if ( mb_strlen($str) > $length ) {
			return mb_substr($str, 0, $length).$extra;
		}
	} else {
		if ( strlen($str) > $length ) {
			return substr($str, 0, $length).$extra;
		}
	}
	return $str;
}
