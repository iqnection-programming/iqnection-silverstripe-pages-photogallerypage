<?php

use SilverStripe\ORM;
use SilverStripe\Forms;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Control\Director;
use SilverStripe\Assets\Image;

class AlbumPageImage extends ORM\DataObject
{
	private static $singular_name = 'Album Image';
	private static $plural_name = 'Album Images';
	
	private static $db = [
		"SortOrder" => "Int",
		"Title" => "HTMLVarchar(255)",
		"Description" => "HTMLText",
		"Alt" => "Varchar(255)",
		"MetaTitle" => "Varchar(255)",
		"MetaKeywords" => "Text",
		"MetaDescription" => "Text"
	];
	
	private static $default_sort = "SortOrder";
	
	private static $has_one = [
		"AlbumPage" => AlbumPage::class,
		"Image" => Image::class,
	];
	
	private static $owns = [
		"Image"
	];
	
	private static $summary_fields = [
		"CMSThumbnail" => "Thumbnail",
		"Title" => "Title"
	];
	
	private static $casting = [
		"CMSThumbnail" => "HTMLText"
	];
	
	public function CMSThumbnail() 
	{
		return $this->Image()->CMSThumbnail();
	}
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->push( Forms\HiddenField::create('SortOrder',null,$fields->dataFieldByName('SortOrder')->Value()) );
		
		$fields->addFieldToTab('Root.Main', UploadField::create("Image", "Image")->setAllowedFileCategories('image/supported') );
		
		$fields->addFieldToTab('Root.Main', Forms\TextField::create("Alt","Image Alt Tag"));
		$fields->addFieldToTab('Root.Main', Forms\TextField::create("Title"));
		$fields->addFieldToTab('Root.Main', Forms\HTMLEditor\HTMLEditorField::create("Description"));
		
		$fields->addFieldToTab('Root.Metadata', Forms\TextField::create("MetaTitle","Meta Title"));
		$fields->addFieldToTab('Root.Metadata', Forms\TextField::create("MetaKeywords","Meta Keywords"));
		$fields->addFieldToTab('Root.Metadata', Forms\TextAreaField::create("MetaDescription","Meta Description"));
		
		$this->extend('updateCMSFields',$fields);
		
		return $fields;
	}
	
	public function canCreate($member = null, $context = array()) { return true; }
	public function canDelete($member = null, $context = array()) { return true; }
	public function canEdit($member = null, $context = array()) { return true; }
	public function canView($member = null, $context = array()) { return true; }
	
	public function onAfterWrite()
	{
		parent::onAfterWrite();
		if ( ($this->Image()->Exists()) && (!$this->Image()->isPublished()) )
		{
			$this->Image()->publishSingle();
		}
	}
	
	public function Thumbnail()
	{
		$cropped = false;
		if ($this->Image()->Exists())
		{
			$Width = ($this->AlbumPage()->ThumbnailWidth) ? $this->AlbumPage()->ThumbnailWidth : 400;
			$Height = ($this->AlbumPage()->ThumbnailHeight) ? $this->AlbumPage()->ThumbnailHeight : 400;
			$cropped = $this->Image()->Fill($Width,$Height);			
		}
		$this->extend('updateThumbnail',$cropped);
		return $cropped;
	}
				
	public function LargeImage()
	{
		$sizedImage = false;
		if ($this->Image()->Exists())
		{
			$Width = ($Width = $this->AlbumPage()->FullSizeWidth) ? $Width : 1000;
			$Height = ($Height = $this->AlbumPage()->FullSizeHeight) ? $Height : 800;
			$sizedImage = $this->Image()->FitMax($Width,$Height);
		}
		$this->extend('updateLargeImage',$sizedImage);
		return $sizedImage;
	}
			
	public function Link()
	{
		return $this->AlbumPage()->AbsoluteLink()."photo/".$this->ID;
	}
	
	public function AbsoluteLink()
	{
		return Director::absoluteURL($this->Link());
	}
	
}


