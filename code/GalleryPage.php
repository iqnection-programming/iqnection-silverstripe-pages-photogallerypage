<?
	class GalleryPage extends Page
	{
		private static $db = array(
			"Type" => "Varchar(255)"
		);
		
		private static $allowed_children = array(
			"GalleryPage",
			"AlbumPage"
		);
		
		public function getCMSFields()
		{
			$fields = parent::getCMSFields();
			$fields->addFieldToTab("Root.Content.Layout", new LiteralField("Desc1", "<p>The layout chosen below will affect all galleries under this page.  You may override this layout choice on individual gallery pages if you wish.</p><br />"));
			$fields->addFieldToTab("Root.Content.Layout", new OptionsetField("Type", "Choose your layout:", array("All-In-One" => "All-In-One", "Large Thumbnails" => "Large Thumbnails")));
			$fields->addFieldToTab("Root.Content.Layout", new LiteralField("Picture1", "<br /><div style='float:left;'><h2>All-In-One</h2><img src='/iq-photogallerypage/css/images/photo_gallery_layout_1.gif' /></div>"));
			$fields->addFieldToTab("Root.Content.Layout", new LiteralField("Picture2", "<div style='float:left; margin-left:10px;'><h2>Large Thumbnails</h2><img src='/iq-photogallerypage/css/images/photo_gallery_layout_2.gif' /></div>"));
			
			return $fields;
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
				parent::PageCSS(),
				array(
					"iq-photogallerypage/css/pages/GalleryPage.css"
				)
			);
		}
	}  
?>