<?php

use SilverStripe\Forms;
use SilverStripe\AssetAdmin\Forms\UploadField;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class AlbumPage extends Page
{
	private static $icon = "iq-photogallerypage/images/icons/icon-albumpage-file.gif";
	
	private static $db = [
		'ThumbnailWidth' => 'Int',
		'ThumbnailHeight' => 'Int',
		'FullSizeWidth' => 'Int',
		'FullSizeHeight' => 'Int'
	];
	
	private static $has_many = [
		"AlbumPageImages" => AlbumPageImage::class
	];
	
	private static $has_one = [
		'OverrideGalleryImage' => \SilverStripe\Assets\Image::class
	];
	
	private static $owns = [
		"OverrideGalleryImage"
	];
	
	private static $defaults = [
		'ThumbnailWidth' => '400',
		'ThumbnailHeight' => '400',
		'FullSizeWidth' => '1200',
		'FullSizeHeight' => '1000'
	];
	
	private static $allowed_children = [];
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', UploadField::create('OverrideGalleryImage','Override Parent Gallery Thumbnail')
			->setAllowedFileCategories('image/supported') );
		
		$fields->addFieldToTab('Root.Developer.AlbumSettings', Forms\HeaderField::create('head1','Layout 2 Setup') );
		$fields->addFieldToTab('Root.Developer.AlbumSettings', Forms\NumericField::create('ThumbnailWidth','Thumbnail Width (default: 340)') );
		$fields->addFieldToTab('Root.Developer.AlbumSettings', Forms\NumericField::create('ThumbnailHeight','Thumbnail Height (default: 340)') );
		$fields->addFieldToTab('Root.Developer.AlbumSettings', Forms\NumericField::create('FullSizeWidth','Full Size Width (default: 1000)') );
		$fields->addFieldToTab('Root.Developer.AlbumSettings', Forms\NumericField::create('FullSizeHeight','Full Size Height (default: 800)') );

		$fields->addFieldToTab('Root.Images', Forms\GridField\GridField::create(
			'AlbumPageImages',
			'Album Images',
			$this->AlbumPageImages(),
			Forms\GridField\GridFieldConfig_RecordEditor::create(99)->addComponent(
				new GridFieldSortableRows('SortOrder')
			)
		));
		
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
		elseif ($this->AlbumPageImages()->Count())
		{
			$image = $this->AlbumPageImages()->First()->Image();
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
  
