<?
	class AlbumPage_Image extends DataObject
	{
		private static $db = array(
			"SortOrder" => "Int",
			"Title" => "HTMLVarchar(255)",
			"Description" => "HTMLText",
			"Alt" => "Varchar(255)",
			"MetaTitle" => "Varchar(255)",
			"MetaKeywords" => "Text",
			"MetaDescription" => "Text"
		);
		
		private static $default_sort = "SortOrder";
		
		private static $has_one = array(
			"AlbumPage" => "AlbumPage",
			"FullsizeImage" => "Image",
		);
		
		private static $summary_fields = array(
			"ImageNice" => "CustomImage",
			"Title" => "Title"
		);
		
		private static $casting = array(
			"ImageNice" => "HTMLText"
		);
		
		public function getImageNice() {
			return $this->FullsizeImage()->CMSThumbnail();
		}
		
		public function getCMSFields()
		{
			$fields = new FieldList();
			$imageTab = new Tab('Image'); 
			$seoTab = new Tab('Metadata'); 
			$tabset = new TabSet("Root", 
				$imageTab,
				$seoTab
			); 
			$fields->push( $tabset );
			
			$image_field = new UploadField("FullsizeImage", "Image");
			$image_field->setAllowedFileCategories('image');
			$imageTab->push($image_field);
			$imageTab->push(new TextField("Alt","Image Alt Tag"));
			$imageTab->push(new TextField("Title"));
			$imageTab->push(new HTMLEditorField("Description"));
			
			$seoTab->push(new TextField("MetaTitle","Meta Title"));
			$seoTab->push(new TextField("MetaKeywords","Meta Keywords"));
			$seoTab->push(new TextAreaField("MetaDescription","Meta Description"));
			
			return $fields;
		}
		
		public function canCreate($member = null) { return true; }
		public function canDelete($member = null) { return true; }
		public function canEdit($member = null) { return true; }
		public function canView($member = null) { return true; }
				
		public function GetAlbumThumbURL()
		{
			if ( ($this->FullsizeImageID) && ($img = $this->FullsizeImage()) )
			{
				$Width = ($this->AlbumPage()->ThumbnailWidth) ? $this->AlbumPage()->ThumbnailWidth : 340;
				$Height = ($this->AlbumPage()->ThumbnailHeight) ? $this->AlbumPage()->ThumbnailHeight : 340;
				if ($cropped = $img->CroppedImage($Width,$Height))
				{
					return $cropped->getURL();
				}
			}
			return "";
		}
		
		public function GetGalleryThumbURL()
		{
			if ( ($this->FullsizeImageID) && ($img = $this->FullsizeImage()) )
			{
				$Width = ($this->AlbumPage()->Parent()->ThumbnailWidth) ? $this->AlbumPage()->Parent()->ThumbnailWidth : 340;
				$Height = ($this->AlbumPage()->Parent()->ThumbnailHeight) ? $this->AlbumPage()->Parent()->ThumbnailHeight : 340;
				if ($cropped = $img->CroppedImage($Width,$Height))
				{
					return $cropped->getURL();
				}
			}
			return "";
		}
				
		public function GetBigImage()
		{
			if( $this->FullsizeImageID ) 
			{
				if( $img = $this->FullsizeImage() ) 
				{
					$Width = ($Width=$this->AlbumPage()->FullSizeWidth) ? $Width : 1000;
					$Height = ($Height=$this->AlbumPage()->FullSizeHeight) ? $Height : 800;
					if( $img->getWidth() > $Width && $img->getHeight() > $Height )
					{
						return $img->CroppedImage($Width,$Height);
					}
					elseif( $img->getWidth() > $Width )
					{
						return $img->setWidth($Width);
					} 
					elseif ( $img->getHeight() > $Height )
					{
						return $img->setHeight($Height);
					}
					return $img;
				}
			}
			return "";
		}
		
		public function GetBigURL()
		{
			return ($Image = $this->GetBigImage()) ? $Image->getURL() : null;
		}
		
		public function GetDivWidth()
		{
			if ($Image = $this->GetBigImage())
			{
				return ($this->NeedsContent()) ? $Image->getWidth() / 0.55 : $Image->getWidth();
			}
		}
				
		public function ImagePageLink()
		{
			return $this->AlbumPage()->AbsoluteLink()."photo/".$this->ID;
		}
		
		public function NeedsContent()
		{
			return $this->Title || $this->Description;	
		}
	}

	class AlbumPage extends Page
	{
		private static $icon = "iq-photogallerypage/images/icon-albumpage";
		
		private static $db = array(
			'ThumbnailWidth' => 'Int',
			'ThumbnailHeight' => 'Int',
			'FullSizeWidth' => 'Int',
			'FullSizeHeight' => 'Int'
		);
		
		private static $has_many = array(
			"AlbumPage_Images" => "AlbumPage_Image"
		);
		
		private static $defaults = array(
			'ThumbnailWidth' => '340',
			'ThumbnailHeight' => '340',
			'FullSizeWidth' => '1000',
			'FullSizeHeight' => '800'
		);
		
		private static $allowed_children = array();
		
		public function getCMSFields()
		{
			
			$fields = parent::getCMSFields();
			
			if (Permission::check('ADMIN'))
			{
				$fields->addFieldToTab('Root.AlbumSetup', new HeaderField('head1','Layout 2 Setup') );
				$fields->addFieldToTab('Root.AlbumSetup', new NumericField('ThumbnailWidth','Thumbnail Width (default: 340)') );
				$fields->addFieldToTab('Root.AlbumSetup', new NumericField('ThumbnailHeight','Thumbnail Height (default: 340)') );
				$fields->addFieldToTab('Root.AlbumSetup', new NumericField('FullSizeWidth','Full Size Width (default: 1000)') );
				$fields->addFieldToTab('Root.AlbumSetup', new NumericField('FullSizeHeight','Full Size Height (default: 800)') );
			}
			$gallery_config = GridFieldConfig::create()->addComponents(				
				new GridFieldSortableRows('SortOrder'),
				new GridFieldToolbarHeader(),
				new GridFieldAddNewButton('toolbar-header-right'),
				new GridFieldSortableHeader(),
				new GridFieldDataColumns(),
				new GridFieldPaginator(10),
				new GridFieldEditButton(),
				new GridFieldDeleteAction(),
				new GridFieldDetailForm()				
			);
			$fields->addFieldToTab('Root.Images', new GridField('AlbumPage_Images','Album Images',$this->AlbumPage_Images(),$gallery_config));
						
			return $fields;
		}
		
		function GalleryThumbnailURL()
		{
			return $this->AlbumPage_Images()->First()->GetGalleryThumbURL();
		}	
		
		function GalleryThumbnailAlt()
		{
			return $this->AlbumPage_Images()->First()->Alt;
		}		
	}
	  
	class AlbumPage_Controller extends Page_Controller
	{
		private static $allowed_actions = array(
			"photo"			
		);
		
		public function init()
		{
			parent::init();
		}
		
		function PageCSS()
		{
			return array_merge(
				array(
					"iq-photogallerypage/css/pages/AlbumPage.css",
					"iq-photogallerypage/fancybox/jquery.fancybox.css"
				),
				parent::PageCSS()
			);
		}
		
		function PageJS()
		{
			return array_merge(
				array(
					"iq-photogallerypage/javascript/pages/".$this->getLayoutType().".js",
					"iq-photogallerypage/fancybox/jquery.fancybox.pack.js",
					"iq-photogallerypage/javascript/jquery.touchSwipe.min.js",
					"iq-photogallerypage/javascript/pages/AlbumPage_swipe.js"
				),
				parent::PageJS()
			);
		}
		
		function CustomJS()
		{
			$js = parent::CustomJS();
			if($all_images = DataObject::get('AlbumPage_Image', 'AlbumPageID='.$this->ID))
			{
				$first_id = false;
				$js .= "var images = [";
				$i = 0;
				$total = count($all_images);
				foreach($all_images as $image)
				{	
					if($i == 0 )$first_id = $image->ID;
					$js .= "'".$image->GetBigURL()."'";
					if($i+1 < $total) $js .= ", ";
					$i++;
				}
				$js .= "];";
				$js .= "var first_id = ".$first_id.";";
				$js .= "var page_link = '".$this->Link()."';";
			}
			return $js;
		}
		
		public function index()
		{
			$type = $this->getLayoutType();
						
			$params = $this->getURLParams();
			return $this->renderWith(array($type,"Page"));	
		}
		
		public function getLayoutType()
		{
			$type = $this->Parent()->Type;
			
			switch ($type) {
				case "All-In-One":
					$renderWith = "AlbumPage1";
					break;
				case "Large Thumbnails":
					$renderWith = "AlbumPage2";
					break;
			}
			if(!$type || !$renderWith)$renderWith="AlbumPage2";
			
			return $renderWith;
		}
		
		public function photo()
		{
			if( $photo = $this->getCurrentPhoto() )
			{
				$all_images = DataObject::get('AlbumPage_Image', 'AlbumPageID='.$this->ID);
				$image_array = $all_images;
				$prev_photo_id = "";
				$next_photo_id = "";
				$id = is_numeric($this->request->param('ID')) ? $this->request->param('ID') : $this->request->param('OtherID');
				foreach($image_array as $key => $image){
					if($id==$image->ID){
						$number = $key+1;
						$count = count($image_array);
						$prev_photo_id = $key-1 >= 0 ? $image_array[$key-1]->ID : $image_array[count($image_array)-1]->ID;	
						$next_photo_id = $key+1 <= count($image_array)-1 ? $image_array[$key+1]->ID : $image_array[0]->ID;
					}
				}
				$data = array(
					'Photo' => $photo,
					'Prev' => $prev_photo_id,
					'Next' => $next_photo_id,
					'Number' => $number,
					'Count' => $count
				);
				
				$type = $this->getLayoutType();
				
				if(Director::is_ajax()){
					switch ($this->request->param('ID')) {
						case "ajax_text":
							return $this->Customise($data)->renderWith($type."_ajax_text");
							break;
						case "ajax_image":
							$output = "";
							foreach($image_array as $image){
								$same = $image == $photo;
								$style = !$same ? 'display:none;' : '';
								$output	.= '<a href="'.$image->FullsizeImage()->URL.'" rel="photo_gallery_group" title="'.$image->Title.'" style="'.$style.'" id="fancy_image'.$image->ID.'">';
								if($same)$output .= '<img id="photo" src="'.$image->GetBigURL().'" alt="'.$image->Alt.'" />';
								$output .= '</a>';
							}
							$data['Content'] = $output;
							return $this->Customise($data)->renderWith($type."_ajax_image");
							break;
						default:
							return $this->Customise($data)->renderWith("AlbumPagePopup_ajax");
							break;
					}
				}
				//You need the updated way to display MetaData.  Check root Page.ss in the base if this isn't working.
				$data['MetaTitle'] = $photo->MetaTitle;
				$data['MetaKeywords'] = $photo->MetaKeywords;	
				$data['MetaDescription'] = $photo->MetaDescription;
				return $this->Customise($data)->renderWith(array("AlbumPage_photo","Page"));
			}
			else
			{
				//404 without 404-ing
				return $this->redirectBack();
			}
		}
		
		public function getCurrentPhoto()
		{
			$id = is_numeric($this->request->param('ID')) ? $this->request->param('ID') : $this->request->param('OtherID');
			if( $id && $photo = DataObject::get_by_id('AlbumPage_Image', $id) )
				return $photo;
		}
	}  
?>