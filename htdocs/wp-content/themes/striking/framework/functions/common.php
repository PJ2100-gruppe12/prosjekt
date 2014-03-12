<?php
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
		return '<a href="' . get_author_posts_url(get_the_author_meta( 'ID' )) . '" title="' . esc_attr( sprintf(__('Visit %s&#8217;s all posts','striking_front'), get_the_author()) ) . '" rel="author">' . get_the_author() . '</a>';
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
if(!function_exists("wp_basename")){
	function wp_basename( $path, $suffix = '' ) {
		return urldecode( basename( str_replace( '%2F', '/', urlencode( $path ) ), $suffix ) );
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
		if(strpos($src, get_blog_option($blog_id,'upload_path')) !== false){
			return str_replace(get_option('siteurl'), '', $src);
		}
		if(is_subdomain_install()){
			if ( defined( 'DOMAIN_MAPPING' ) ){
				if(function_exists('get_original_url')){ //WordPress MU Domain Mapping
					if(false !== strpos($src, str_replace(get_original_url('siteurl'),get_bloginfo('wpurl'),get_blog_option($blog_id,'fileupload_url')))){
						return get_bloginfo('wpurl').'/'.str_replace(str_replace(get_original_url('siteurl'),get_bloginfo('wpurl'),get_blog_option($blog_id,'fileupload_url')),get_blog_option($blog_id,'upload_path'),$src);
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
						if(false !== strpos($src, str_replace($orig_urls[$blog_id],get_bloginfo('wpurl'),get_blog_option($blog_id,'fileupload_url')))){
							return get_bloginfo('wpurl').'/'.str_replace(str_replace($orig_urls[$blog_id],get_bloginfo('wpurl'),get_blog_option($blog_id,'fileupload_url')),get_blog_option($blog_id,'upload_path'),$src);
						}
					}
				}
			}
			if(false !== strpos($src, get_blog_option($blog_id,'fileupload_url'))){
				return get_bloginfo('wpurl').'/'.str_replace(get_blog_option($blog_id,'fileupload_url'),get_blog_option($blog_id,'upload_path'),$src);
			}
		}else{
			if ( defined( 'DOMAIN_MAPPING' ) ){
				if(function_exists('get_original_url')){ //WordPress MU Domain Mapping
					if(false !== strpos($src, get_blog_option($blog_id,'fileupload_url'))){
						return get_bloginfo('wpurl').'/'.str_replace(str_replace(get_original_url('siteurl'),get_bloginfo('wpurl'),get_blog_option($blog_id,'fileupload_url')),get_blog_option($blog_id,'upload_path'),$src);
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
	
	$timthumb = theme_get_option('advanced', 'timthumb');
	if($timthumb){
		$src = theme_get_image_src($source);
		$width = $size[0];
		$height = $size[1];
		return THEME_INCLUDES.'/timthumb.php?src='.get_image_src($src).((empty($height))?'':'&amp;h='.$height).'&amp;w='. $width .'&amp;zc=1'.($quality?'&q='.$quality:'');
	} else {
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
		if(version_compare($wp_version, "3.5", '<')){
			$image = wp_load_image( $file );
		} else {
			@ini_set( 'memory_limit', apply_filters( 'image_memory_limit', WP_MAX_MEMORY_LIMIT ) );
			$image = imagecreatefromstring( file_get_contents( $file ) );
		}
		
		if ( !is_resource( $image ) )
			return new WP_Error( 'error_loading_image', $image, $file );
		
		$size = @getimagesize( $file );
		if ( !$size )
			return new WP_Error('invalid_image', __('Could not read image size','striking_front'), $file);

		list($orig_w, $orig_h, $orig_type) = $size;

		if($height == ''){
			$height = round($orig_h * $width/$orig_w);
			if ( !$suffix )
			$suffix = "{$width}";
		}
		$dims = $this->resize_dimensions($orig_w, $orig_h, $width, $height);
		if ( !$dims )
			return new WP_Error( 'error_getting_dimensions', __('Could not calculate resized image dimensions','striking_front') );
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
				return new WP_Error('resize_path_invalid', __('Resize path invalid','striking_front'));
		} elseif ( IMAGETYPE_PNG == $orig_type ) {
			if ( !imagepng( $newimage, $destfilename ) )
				return new WP_Error('resize_path_invalid', __('Resize path invalid','striking_front'));
		} else {
			// all other formats are converted to jpg
			$destfilename = "{$dir}/{$name}-{$suffix}.jpg";
			if ( !imagejpeg( $newimage, $destfilename, apply_filters( 'jpeg_quality', $jpeg_quality, 'image_resize' ) ) )
				return new WP_Error('resize_path_invalid', __('Resize path invalid','striking_front'));
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
				return new WP_Error('attachment_is_not_image', __('Attachment is not image','striking_front'));
			}
			$file = get_attached_file($this->attachment_id);
		}
		
		
		$info = @getimagesize($file);
		if ( empty($info) || !in_array($info[2], array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG))) // only gif, jpeg and png images can reliably be displayed
			return new WP_Error('image_type_is_not_correctly', __('Image type is not correctly','striking_front'));
		
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
			return new WP_Error('file_is_not_exists', __('File is not exists','striking_front'));
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
		@header( 'Content-Type: application/html; charset=' . get_option( 'blog_charset' ) );
		echo apply_filters('the_content',theme_generator('portfolio_list',$options));
	}
	exit();
}
add_action('init', 'theme_portfolio_ajax_init');

function theme_maybe_process_contact_form(){
	$submit_contact_form = isset($_POST["theme_contact_form_submit"]) ? $_POST["theme_contact_form_submit"] : 0;
	if($submit_contact_form){
		require_once(THEME_FUNCTIONS.'/email.php');
		exit;
	}
}
add_action('wp', 'theme_maybe_process_contact_form', 9);

add_action('init', 'theme_exclude_from_search');
function theme_exclude_from_search(){
	global $wp_post_types;
	$post_types = theme_get_option('advanced','exclude_from_search');
	if(!empty($post_types)){
		foreach($post_types as $post_type){
			$wp_post_types[$post_type]->exclude_from_search = true;
		}
	}
}

class Theme_Walker_Nav_Menu extends Walker_Nav_Menu {
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		if ( is_object( $args[0] ) ) {
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
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
}

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
		$output .= '<h1>'.__('Sign Up Now','striking_front').'</h1>';
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
