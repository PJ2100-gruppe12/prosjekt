<?php
class Theme_Metabox_Portfolio extends Theme_Metabox_With_Tabs {
	public $slug = 'portfolio';
	public function config(){
		return array(
			'title' => sprintf(__('%s Portfolio Single Options','theme_admin'),THEME_NAME),
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
<?php
		global $wp_version;
		if(version_compare($wp_version, "3.5", '<')){
			echo '<a title="Add Media" class="thickbox" id="add_media" href="media-upload.php?post_id='.$post->ID.'&gallery_image_upload=1&type=image&TB_iframe=1&width=640&height=644" style="border:none;text-decoration:none;">
				<input type="button" class="button-primary" value="Add Image" id="add-image" name="add">
			</a>';
		} else {
			echo '<a href="#" class="button theme-add-gallery-button" data-uploader_title="Add Images to gallery" data-uploader_button_text="Add Images" title="Add Image">Add Images</a>';
		}
?>	
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
				"name" => __("Portfolio General Setup",'theme_admin'),
				"options" => array(
					array(
						"name" => __("Featured Image",'theme_admin'),
						"desc" => __("Whether to dispaly Featured Image in this page. This will override the global configuration",'theme_admin'),
						"id" => "_featured_image",
						"default" => '',
						"type" => "tritoggle",
					),
					array(
						"name" => __("Portfolio Type",'theme_admin'),
						"desc" => sprintf(__("%s supports image and video for demonstrating the portfolio in the Lightbox. If the type is document, the thumbnail image is link to page of portfolio",'theme_admin'),THEME_NAME),
						"id" => "_type",
						"default" => 'image',
						"options" => array(
							"image" => __('Image','theme_admin'),
							"gallery" => __('Gallery','theme_admin'),
							"video" => __('Video','theme_admin'),
							"doc" => __('Document','theme_admin'),
							"link" => __('Link','theme_admin'),
							"lightbox" => __('Lightbox','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Breadcrumbs Parent Page",'theme_admin'),
						"desc" => __("If set will enable portfolio items breadcrumbs. The page you choose here will be the parent page of portfolio items on the breadcrumbs.",'theme_admin'),
						"id" => "_breadcrumbs_page",
						"page" => 0,
						"default" => 0,
						"chosen" => "true", 
						"prompt" => __("Default",'theme_admin'),
						"type" => "select",
					),
					array(
						"name" => __("Thumbnail Icon",'theme_admin'),
						"desc" => __("It will override portfolio type's defualt icon setting.",'theme_admin'),
						"id" => "_icon",
						"default" => 'default',
						"options" => array(
							"default" => __('Default','theme_admin'),
							"zoom" => __('Image','theme_admin'),
							"play" => __('Video','theme_admin'),
							"doc" => __('Document','theme_admin'),
							"link" => __('Link','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Enable Read More",'theme_admin'),
						"desc" => __("if this is on, the read more button will show.",'theme_admin'),
						"id" => "_more",
						"default" => "",
						"type" => "tritoggle"
					),
					array(
						"name" => __("Link for Read More",'theme_admin'),
						"id" => "_more_link",
						"default" => "",
						"shows" => array('page','cat','post','manually'),
						"type" => "superlink"
					),
					array(
						"name" => __("Link Target for Read More",'theme_admin'),
						"id" => "_more_link_target",
						"default" => '_self',
						"options" => array(
							"_blank" => __('Load in a new window','theme_admin'),
							"_self" => __('Load in the same frame as it was clicked','theme_admin'),
							"_parent" => __('Load in the parent frameset','theme_admin'),
							"_top" => __('Load in the full body of the window','theme_admin'),
						),
						"type" => "select",
					),
					array(
						"name" => __("Restrict image Lightbox Dimension",'theme_admin'),
						"desc" => __("If you enable this option, the lightbox dimension will be restricted to fit the browse screen size.",'theme_admin'),
						"id" => "_image_lightbox_fittoview",
						"default" => "",
						"type" => "tritoggle"
					),
				),
			),
			array(
				"name" => __("Portfolio Type: Image",'theme_admin'),
				'id' => 'portfolio_type_image',
				"options" => array(
					array(
						"name" => __("Substitute Image for Lightbox (optional)",'theme_admin'),
						"desc" => __("The substitute images you would like to use for the portfolio lightbox pop-up demonstrate.If not assigned, it will use featured image instead.",'theme_admin'),
						"id" => "_image",
						"button" => "Insert Image",
						"default" => '',
						"type" => "upload",
					),
				),
			),
			array(
				"name" => __("Portfolio Type: Video",'theme_admin'),
				'id' => 'portfolio_type_video',
				"options" => array(
					array(
						"name" => __("Video Link for Lightbox",'theme_admin'),
						"desc" => __("Paste the full url of the Flash(YouTube or Vimeo etc).Only necessary when the lightbox type is video.",'theme_admin'),
						"size" => 30,
						"id" => "_video",
						"default" => '',
						"class" => 'full',
						"type" => "text",
					),
					array(
						"name" => __("Video Width",'theme_admin'),
						"desc" => __("If you specify a number below, this will override the global configuration.",'theme_admin'),
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
						"name" => __("Video Height",'theme_admin'),
						"desc" => __("If you specify a number below, this will override the global configuration.",'theme_admin'),
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
				"name" => __("Portfolio Type: Lightbox",'theme_admin'),
				'id' => 'portfolio_type_lightbox',
				"options" => array(
					array(
						"name" => __("Lightbox iframe href",'theme_admin'),
						"desc" => __("If you specify the full url of the website link below, when you click on the item, it will show the website on the lightbox.",'theme_admin'),
						"id" => '_lightbox_href',
						"size" => 30,
						"default" => '',
						"class" => 'full',
						"type" => "text",
					),
					array(
						"name" => __("Lightbox Content",'theme_admin'),
						"desc" => __("The content that display on the lightbox when the portfolio item type is lightbox. You can use shortcode here.",'theme_admin'),
						"id" => "_lightbox_content",
						"default" => '',
						"type" => "textarea",
					),
					array(
						"name" => __("Lightbox Width",'theme_admin'),
						"desc" => __("If you specify a number below, this will override the global configuration.",'theme_admin'),
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
						"name" => __("Lightbox Height",'theme_admin'),
						"desc" => __("If you specify a number below, this will override the global configuration.",'theme_admin'),
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
				"name" => __("Portfolio Type: Link",'theme_admin'),
				'id' => 'portfolio_type_link',
				"options" => array(
					array(
						"name" => __("Link for Portfolio item",'theme_admin'),
						"desc" => __("<p>Select whether you wish to link to a page, post, category, or link manually -> where one manually designates the url to be linked.  &nbsp;Upon making a selection another field will appear allowing one to choose the specific page, post or category in a dropdown list.  &nbsp;If manually is selected, a field will appear in which to enter the full url (including http://) for linking.</p>",'theme_admin'),
						"id" => "_link",
						"default" => "",
						"shows" => array('page','post','cat','manually'),
						"type" => "superlink"	
					),
					array(
						"name" => __("Link Target",'theme_admin'),
						"id" => "_link_target",
						"default" => '_self',
						"options" => array(
							"_blank" => __('Load in a new window','theme_admin'),
							"_self" => __('Load in the same frame as it was clicked','theme_admin'),
							"_parent" => __('Load in the parent frameset','theme_admin'),
							"_top" => __('Load in the full body of the window','theme_admin'),
						),
						"type" => "select",
					),
				),
			),
			array(
				"name" => __("Portfolio Type: Gallery",'theme_admin'),
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
