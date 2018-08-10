<?php

namespace IQnection\GalleryPage;

use SilverStripe\Forms;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;

class GalleryPage extends \Page
{
	private static $table_name = 'GalleryPage';
	
	private static $icon = "resources/iqnection-pages/photogallerypage/images/icons/icon-gallerypage-file.gif";
	
	private static $db = [
		"LayoutType" => "Enum('Individual,Split','Individual')",
		'ThumbnailWidth' => 'Int',
		'ThumbnailHeight' => 'Int',
	];
	
	private static $has_one = [
		'OverrideGalleryImage' => \SilverStripe\Assets\Image::class
	];
	
	private static $owns = [
		"OverrideGalleryImage"
	];
	
	private static $allowed_children = [
		"GalleryPage",
		"AlbumPage"
	];
	
	private static $defaults = [
		'LayoutType' => 'Individual',
		'ThumbnailWidth' => '400',
		'ThumbnailHeight' => '400',
	];
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		if ($this->Parent()->ClassName == \IQnection\PhotoGalleryPage\GalleryPage::class)
		{
			$fields->addFieldToTab('Root.Main', UploadField::create('OverrideGalleryImage','Override Parent Gallery Thumbnail')
				->setAllowedFileCategories('image/supported') );
		}
		$fields->findOrMakeTab('Root.Developer.GallerySettings');
		$fields->addFieldToTab("Root.Developer.GallerySettings", Forms\LiteralField::create("Desc1", "<p>The layout chosen below will affect all galleries under this page.  You may override this layout choice on individual gallery pages if you wish.</p><br />"));
		$fields->addFieldToTab("Root.Developer.GallerySettings", Forms\OptionsetField::create("LayoutType", "Choose your layout:", array(
			"Split" => DBField::create_field('HTMLText',"<span>All-In-One<br /><img src='/iq-photogallerypage/images/photo_gallery_layout_1.gif' /></span>"), 
			"Individual" => DBField::create_field('HTMLText',"<span>Large Thumbnails<br /><img src='/iq-photogallerypage/images/photo_gallery_layout_2.gif' /></span>")
		)));

		$fields->addFieldToTab('Root.Developer.GallerySettings', Forms\HeaderField::create('head1','Layout 2 Setup') );
		$fields->addFieldToTab('Root.Developer.GallerySettings', Forms\NumericField::create('ThumbnailWidth','Thumbnail Width (default: 340)') );
		$fields->addFieldToTab('Root.Developer.GallerySettings', Forms\NumericField::create('ThumbnailHeight','Thumbnail Height (default: 340)') );

		$this->extend('updateCMSFields',$fields);
		
		return $fields;
	}
	
	public function GalleryImage()
	{
		$image = false;
		if ( ($this->OverrideGalleryImage()->Exists()) && ($this->OverrideGalleryImage()->isPublished()) )
		{
			$image = $this->OverrideGalleryImage();
		}
		elseif ($this->Children()->First())
		{
			$image = $this->Children()->First()->GalleryImage();
		}
		$this->extend('updateGalleryImage',$image);
		return $image;
	}
	
	public function GalleryThumbnail()
	{
		$cropped = false;
		if ($image = $this->GalleryImage())
		{
			$Width = ($this->ThumbnailWidth) ? $this->ThumbnailWidth : 400;
			$Height = ($this->ThumbnailHeight) ? $this->ThumbnailHeight : 400;
			$cropped = $image->Fill($Width,$Height);			
		}
		$this->extend('updateGalleryThumbnail',$cropped);
		return $cropped;
	}
}
  
