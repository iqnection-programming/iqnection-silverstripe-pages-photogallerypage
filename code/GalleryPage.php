<?
	class GalleryPage extends Page
	{
		private static $icon = "iq-photogallerypage/images/icon-gallerypage";
		
		private static $db = array(
			"Type" => "Varchar(255)",
			'ThumbnailWidth' => 'Int',
			'ThumbnailHeight' => 'Int',
		);
		
		private static $allowed_children = array(
			"GalleryPage",
			"AlbumPage"
		);
		
		private static $defaults = array(
			'ThumbnailWidth' => '340',
			'ThumbnailHeight' => '340',
		);
		
		public function getCMSFields()
		{
			$fields = parent::getCMSFields();
			$fields->addFieldToTab("Root.Developer", new LiteralField("Desc1", "<p>The layout chosen below will affect all galleries under this page.  You may override this layout choice on individual gallery pages if you wish.</p><br />"));
			$fields->addFieldToTab("Root.Developer", new OptionsetField("Type", "Choose your layout:", array(
				"All-In-One" => "<span>All-In-One<br /><img src='/iq-photogallerypage/css/images/photo_gallery_layout_1.gif' /></span>", 
				"Large Thumbnails" => "<span>Large Thumbnails<br /><img src='/iq-photogallerypage/css/images/photo_gallery_layout_2.gif' /></span>"
			)));

			$fields->addFieldToTab('Root.Developer', new HeaderField('head1','Layout 2 Setup') );
			$fields->addFieldToTab('Root.Developer', new NumericField('ThumbnailWidth','Thumbnail Width (default: 340)') );
			$fields->addFieldToTab('Root.Developer', new NumericField('ThumbnailHeight','Thumbnail Height (default: 340)') );

			
			return $fields;
		}
		
		function GalleryThumbnailURL()
		{
			return $this->Children()->First()->GalleryThumbnailURL();
		}
		
		function GalleryThumbnailAlt()
		{
			return $this->Children()->First()->GalleryThumbnailAlt();
		}
	}
	  
	class GalleryPage_Controller extends Page_Controller
	{ 
		public function init()
		{
			parent::init();
		}	
		
		function PageCSS()
		{
			return array_merge(
				array(
					"iq-photogallerypage/css/pages/GalleryPage.css"
				),
				parent::PageCSS()
			);
		}
	}  
?>