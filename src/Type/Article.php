<?php
declare(strict_types=1);

namespace CeusMedia\OpenGraph\Type;
class Article{

	protected $publishedTime;
	protected $modifiedTime;
	protected $expirationTime;
	protected $author;
	protected $section;
	protected $tag;

	public function getPublishedTime(){
		return date( 'r', $this->publishedTime );
	}

	public function getModifiedTime(){
		return date( 'r', $this->modifiedTime );
	}

	public function getExpirationTime(){
		return date( 'r', $this->expirationTime );
	}

	public function getAuthor(){
		return $this->author;
	}

	public function getSection(){
		return $this->section;
	}

	public function getTag(){
		return $this->tag;
	}

	public function setPublishedTime( $publishedTime ){
		if( !strtotime( $publishedTime ) )
			throw new \InvalidArgumentException( 'Invalid published time' );
		$this->publishedTime	= strtotime( $publishedTime );
	}

	public function setModifiedTime( $modifiedTime ){
		if( !strtotime( $modifiedTime ) )
			throw new \InvalidArgumentException( 'Invalid modified time' );
		$this->modifiedTime	= strtotime( $modifiedTime );
	}

	public function setExpirationTime( $expirationTime ){
		if( !strtotime( $expirationTime ) )
			throw new \InvalidArgumentException( 'Invalid expiration time' );
		$this->expirationTime	= strtotime( $expirationTime );
	}

	public function setAuthor( $author ){
		$this->author	= $author;
	}

	public function setSection( $section ){
		$this->section	= $section;
	}

	public function setTag( $tag ){
		$this->tag	= $tag;
	}

	public function toArray(){
		$prefix	= 'article';
		$map	= new \ADT_List_Dictionary();
		if( $this->publishedTime )
			$map->set( $prefix.':published_time', $this->getPublishedTime() );
		if( $this->modifiedTime )
			$map->set( $prefix.':modified_time', $this->getModifiedTime() );
		if( $this->expirationTime )
			$map->set( $prefix.':expiration_time', $this->getExpirationTime() );
		if( $this->author )
			$map->set( $prefix.':author', $this->author );
		if( $this->section )
			$map->set( $prefix.':section', $this->section );
		if( $this->tag )
			$map->set( $prefix.':tag', $this->tag );
		return $map;
	}
}
