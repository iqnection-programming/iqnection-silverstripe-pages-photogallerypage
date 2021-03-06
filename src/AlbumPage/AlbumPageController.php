<?php

namespace IQnection\AlbumPage;

class AlbumPageController extends \PageController
{
	private static $allowed_actions = array(
		"photo"			
	);
	
	public function LayoutType()
	{
		$LayoutType = $this->LayoutType;
		if ( (!$this->OverrideLayout) && ($this->Parent()->Exists()) && ($this->Parent() instanceof \IQnection\GalleryPage\GalleryPage) )
		{
			$LayoutType = $this->Parent()->LayoutType;
		}
		return $LayoutType;
	}
	
	public function PageCSS()
	{
		return array_merge(
			array(
				"/fancybox3/jquery.fancybox.css"
			),
			parent::PageCSS()
		);
	}
	
	public function PageJS()
	{
		return array_merge([
				"/javascript/pages/AlbumPage_".strtolower($this->LayoutType()).".js",
				"/fancybox3/jquery.fancybox.js",
			],
			parent::PageJS()
		);
	}
	
	public function getAlbumImagesJsData()
	{
		$imagesArray = array();
		foreach($this->AlbumPageImages() as $image)
		{
			if ( ($image->Image()->Exists()) && ($image->Image()->isPublished()) )
			{
				$imagesArray[] = [
					'id' => $image->ID,
					'large_image' => [
						'url' => $image->LargeImage()->getURL(),
						'width' => $image->LargeImage()->getWidth(),
						'height' => $image->LargeImage()->getHeight()
					],
					'fullsize_image' => [
						'url' => $image->Image()->getURL(),
						'width' => $image->Image()->getWidth(),
						'height' => $image->Image()->getHeight()
					],
					'title' => $image->Title,
					'description' => $image->Description,
					'full_description' => $image->FullDescription()->forTemplate(),
					'image_alt' => $image->Alt
				];
			}
		}
		$this->extend('updateAlbumImagesJsData', $imagesArray);
		return $imagesArray;
	}
	
	public function CustomJS()
	{
		$js = parent::CustomJS();
		
		$imagesArray = $this->getAlbumImagesJsData();
		$js .= "var images = ".json_encode($imagesArray).";";
		return $js;
	}
	
	public function index()
	{
		$templates = [];
		$templates[] = 'IQnection\AlbumPage\AlbumPage_layout_'.strtolower($this->LayoutType());
		if (class_exists(\IQnection\Minisite\PageExtension::class) && $this->MinisiteParent())
		{
			$templates[] = 'MinisitePage';
		}
		$templates[] = 'Page';
		$this->extend('updateTemplates', $templates);
		return $this->renderWith($templates);
	}

	public function photo()
	{
		if ( ($photoID = $this->request->param('ID')) && ($photo = $this->AlbumPageImages()->byID($photoID)) )
		{
			$prevPhoto = $this->AlbumPageImages()->sort('SortOrder','DESC')->Filter('SortOrder:LessThan',$photo->SortOrder)->First();
			$nextPhoto = $this->AlbumPageImages()->sort('SortOrder','ASC')->Filter('SortOrder:GreaterThan',$photo->SortOrder)->First();
			$data = array(
				'Photo' => $photo,
				'PrevPhoto' => $prevPhoto,
				'NextPhoto' => $nextPhoto,
				'Number' => $this->AlbumPageImages()->sort('SortOrder','DESC')->Filter('SortOrder:LessThan',$photo->SortOrder)->Count() + 1,
				'Count' => $this->AlbumPageImages()->Count()
			);
						
			//You need the updated way to display MetaData.  Check root Page.ss in the base if this isn't working.
			$data['MetaTitle'] = $photo->MetaTitle;
			$data['MetaKeywords'] = $photo->MetaKeywords;	
			$data['MetaDescription'] = $photo->MetaDescription;
			return $this->Customise($data)->renderWith(array("IQnection/AlbumPage/AlbumPage_photo","Page"));
		}
		//404 without 404-ing
		return $this->redirect($this->Link());
	}
	
}  



