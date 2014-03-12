<?php
class Theme_Metabox_Portfolio extends Theme_Metabox_With_Tabs {
	public $slug = 'portfolio';
	public function config(){
		return array(
			'title' => sprintf(__('%s Portfolio Single Options','striking_admin'),THEME_NAME),
			'post_types' => array('portfolio'),
			'callback' => '',
			'context' => 'normal',
			'priority' => 'high',
		);
	}
	public function __construct(){
		parent::__construct();
		foreach($this->config['post_types'] as $post_type){
			if (theme_is_post_type($post_type)){
				add_action('admin_init', array(&$this, '_enqueue_assets'));
			}
		}

		/* gallery start */
		//gallery insert image ajax action callback
		add_action('wp_ajax_theme-gallery-get-image', array(&$this,'_gallery_get_image_callback'));
	
		//gallery hook
		if (isset($_GET['gallery_image_upload']) || isset($_POST['gallery_image_upload'])) {
			include_once (THEME_ADMIN_FUNCTIONS . '/gallery-media-upload.php');
		}
		if (isset($_GET['gallery_edit_image'])) {
			wp_enqueue_script('theme-gallery-edit-image', THEME_ADMIN_ASSETS_URI . '/js/gallery-edit-image.js');
			
			wp_enqueue_style('theme-gallery-edit-image', THEME_ADMIN_ASSETS_URI . '/css/gallery-edit-image.css');
		}
		/* gallery end */
	}

	public function _enqueue_assets(){
		wp_enqueue_script('theme-metabox-portfolio', THEME_ADMIN_ASSETS_URI . '/js/metabox_portfolio.js', array('jquery'));
	
		/* gallery start */
		wp_deregister_script('autosave');
		wp_enqueue_script('theme-metabox-portfolio-gallery', THEME_ADMIN_ASSETS_URI . '/js/gallery.js', array('jquery-ui-sortable'));
		wp_enqueue_style('theme-metabox-portfolio-gallery', THEME_ADMIN_ASSETS_URI . '/css/gallery.css');
		
		add_thickbox();
		/* gallery end */
	}

	
	public function _gallery_get_image_callback() {
		$html = $this->_gallery_create_image_item($_POST['id']);
		if (! empty($html)) {
			echo $html;
		} else {
			die(0);
		}
		die();
	}

	// gallery metaboax function
	public function _gallery_create_image_item($attachment_id) {
		$image = & get_post($attachment_id);
		if ($image) {
			$meta = wp_get_attachment_metadata($attachment_id);
			$date = mysql2date(get_option('date_format'), $image->post_date);
			$size = $meta['width'] . ' x ' . $meta['height'] . 'pixel';
			
			include (THEME_ADMIN_AJAX . '/gallery-image-item.php');
		}
	}

	function _option_portfolio_type_gallery_function($value, $default) {
		global $post;
?>
	<li class="meta-box-item">
		<div id="gallery_actions">
			<a title="Add Media" class="thickbox" id="add_media" href="media-upload.php?post_id=<?php echo $post->ID; ?>&gallery_image_upload=1&type=image&TB_iframe=1&width=640&height=644" style="border:none;text-decoration:none;">
				<input type="button" class="button-primary" value="Add Image" id="add-image" name="add">
			</a>
		</div>

		<div id="gallery_table_wrapper">
			<table class="widefat gallery_table" cellspacing="0">
				<thead>
					<tr>
						<th width="10" scope="row">&nbsp;</th>
						<th width="70" scope="row">Thumbnail</th>
						<th width="150" scope="row">Title</th>
						<th scope="row">Description</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="4">
							<div>
								<ul id="images_sortable">
		<?php 
			$image_ids_str = get_post_meta($post->ID, '_image_ids', true);
			if(!empty($image_ids_str)){
				$image_ids = explode(',',str_replace('image-','',$image_ids_str));
				foreach($image_ids as $image_id){
					$this->_gallery_create_image_item($image_id);
				}
			}
		?>
								</ul>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<input type="hidden" id="gallery_image_ids" name="_image_ids" value="<?php echo get_post_meta($post->ID, '_image_ids', true);?>">
		</div>
	</li>
<?php
	}

	public function tabs(){
		return array(
			array(
				"name" => __("Portfolio General Setup",'striking_admin'),
				"options" => array(
					array(
						"name" => __("Portfolio Type",'striking_admin'),
						"desc" => sprintf(__("%s supports image and video for demonstrating the portfolio in the Lightbox. If the type is document, the thumbnail image is link to page of portfolio",'striking_admin'),THEME_NAME),
						"id" => "_type",
						"default" => 'image',
						"options" => array(
							"image" => __('Image','striking_admin'),
							"gallery" => __('Gallery','striking_admin'),
							"video" => __('Video','striking_admin'),
							"doc" => __('Document','striking_admin'),
							"link" => __('Link','striking_admin'),
							"lightbox" => __('Lightbox','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Breadcrumbs Parent Page",'striking_admin'),
						"desc" => __("If set will enable portfolio items breadcrumbs. The page you choose here will be the parent page of portfolio items on the breadcrumbs.",'striking_admin'),
						"id" => "_breadcrumbs_page",
						"page" => 0,
						"default" => 0,
						"chosen" => "true", 
						"prompt" => __("Default",'striking_admin'),
						"type" => "select",
					),
					array(
						"name" => __("Thumbnail Icon",'striking_admin'),
						"desc" => __("It will override portfolio type's defualt icon setting.",'striking_admin'),
						"id" => "_icon",
						"default" => 'default',
						"options" => array(
							"default" => __('Default','striking_admin'),
							"zoom" => __('Image','striking_admin'),
							"play" => __('Video','striking_admin'),
							"doc" => __('Document','striking_admin'),
							"link" => __('Link','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Enable Read More",'striking_admin'),
						"desc" => __("if this is on, the read more button will show.",'striking_admin'),
						"id" => "_more",
						"default" => "",
						"type" => "tritoggle"
					),
					array(
						"name" => __("Link for Read More",'striking_admin'),
						"id" => "_more_link",
						"default" => "",
						"shows" => array('page','cat','post','manually'),
						"type" => "superlink"
					),
					array(
						"name" => __("Link Target for Read More",'striking_admin'),
						"id" => "_more_link_target",
						"default" => '_self',
						"options" => array(
							"_blank" => __('Load in a new window','striking_admin'),
							"_self" => __('Load in the same frame as it was clicked','striking_admin'),
							"_parent" => __('Load in the parent frameset','striking_admin'),
							"_top" => __('Load in the full body of the window','striking_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Restrict image Lightbox Dimension",'striking_admin'),
						"desc" => __("If you enable this option, the lightbox dimension will be restricted to fit the browse screen size.",'striking_admin'),
						"id" => "_image_lightbox_fittoview",
						"default" => "",
						"type" => "tritoggle"
					),
				),
			),
			array(
				"name" => __("Portfolio Type: Image",'striking_admin'),
				'id' => 'portfolio_type_image',
				"options" => array(
					array(
						"name" => __("Substitute Image for Lightbox (optional)",'striking_admin'),
						"desc" => __("The substitute images you would like to use for the portfolio lightbox pop-up demonstrate.If not assigned, it will use featured image instead.",'striking_admin'),
						"id" => "_image",
						"button" => "Insert Image",
						"default" => '',
						"type" => "upload",
					),
				),
			),
			array(
				"name" => __("Portfolio Type: Video",'striking_admin'),
				'id' => 'portfolio_type_video',
				"options" => array(
					array(
						"name" => __("Video Link for Lightbox",'striking_admin'),
						"desc" => __("Paste the full url of the Flash(YouTube or Vimeo etc).Only necessary when the lightbox type is video.",'striking_admin'),
						"size" => 30,
						"id" => "_video",
						"default" => '',
						"class" => 'full',
						"type" => "text",
					),
					array(
						"name" => __("Video Width",'striking_admin'),
						"desc" => __("If you specify a number below, this will override the global configuration.",'striking_admin'),
						"id" => "_video_width",
						"default" => "",
						"min" => 0,
						"max" => 960,
						"step" => "1",
						"units" => array('px','%'),
						'default_unit' => 'px',
						"type" => "measurement",
					),
					array(
						"name" => __("Video Height",'striking_admin'),
						"desc" => __("If you specify a number below, this will override the global configuration.",'striking_admin'),
						"id" => "_video_height",
						"default" => "",
						"min" => 0,
						"max" => 960,
						"step" => "1",
						"units" => array('px','%'),
						'default_unit' => 'px',
						"type" => "measurement",
					),
				),
			),
			array(
				"name" => __("Portfolio Type: Lightbox",'striking_admin'),
				'id' => 'portfolio_type_lightbox',
				"options" => array(
					array(
						"name" => __("Lightbox iframe href",'striking_admin'),
						"desc" => __("If you specify the full url of the website link below, when you click on the item, it will show the website on the lightbox.",'striking_admin'),
						"id" => '_lightbox_href',
						"size" => 30,
						"default" => '',
						"class" => 'full',
						"type" => "text",
					),
					array(
						"name" => __("Lightbox Content",'striking_admin'),
						"desc" => __("The content that display on the lightbox when the portfolio item type is lightbox. You can use shortcode here.",'striking_admin'),
						"id" => "_lightbox_content",
						"default" => '',
						"type" => "textarea",
					),
					array(
						"name" => __("Lightbox Width",'striking_admin'),
						"desc" => __("If you specify a number below, this will override the global configuration.",'striking_admin'),
						"id" => "_lightbox_width",
						"default" => "",
						"min" => 0,
						"max" => 960,
						"step" => "1",
						"units" => array('px','%'),
						'default_unit' => 'px',
						"type" => "measurement",
					),
					array(
						"name" => __("Lightbox Height",'striking_admin'),
						"desc" => __("If you specify a number below, this will override the global configuration.",'striking_admin'),
						"id" => "_lightbox_height",
						"default" => "",
						"min" => 0,
						"max" => 960,
						"step" => "1",
						"units" => array('px','%'),
						'default_unit' => 'px',
						"type" => "measurement",
					),
				),
			),
			array(
				"name" => __("Portfolio Type: Link",'striking_admin'),
				'id' => 'portfolio_type_link',
				"options" => array(
					array(
						"name" => __("Link for Portfolio item",'striking_admin'),
						"desc" => __("The url that the portfolio item linked to. It only available if Portfolio type set to Link.",'striking_admin'),
						"id" => "_link",
						"default" => "",
						"shows" => array('page','cat','post','manually'),
						"type" => "superlink"	
					),
					array(
						"name" => __("Link Target",'striking_admin'),
						"id" => "_link_target",
						"default" => '_self',
						"options" => array(
							"_blank" => __('Load in a new window','striking_admin'),
							"_self" => __('Load in the same frame as it was clicked','striking_admin'),
							"_parent" => __('Load in the parent frameset','striking_admin'),
							"_top" => __('Load in the full body of the window','striking_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"name" => __("Portfolio Type: Gallery",'striking_admin'),
				'id' => 'portfolio_type_gallery',
				"options" => array(
					array(
						"id" => "_image_ids",
						"layout" => false,
						"default" => '',
						"function" => "_option_portfolio_type_gallery_function",
						"type" => "custom",
					),
				),
			),	
		);
	}
}
