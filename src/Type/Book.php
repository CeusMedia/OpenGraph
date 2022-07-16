<?php
declare(strict_types=1);

namespace CeusMedia\OpenGraph\Type;
class Book{

	protected $author;
	protected $isbn;
	protected $releaseDate;
	protected $tag;

	public function getAuthor(){
		return $this->author;
	}

	public function getIsbn(){
		return $this->isbn;
	}

	public function getReleaseDate(){
		return date( 'r', $this->releaseDate );
	}

	public function getTag(){
		return $this->tag;
	}

	/**
	 *	Set URL to author resource.
	 */
	public function setAuthor( $author ){
		$this->author	= $author;
	}

	public function setIsbn( $isbn ){
		$this->isbn		= $isbn;
	}

	public function setReleaseDate( $releaseDate ){
		if( !strtotime( $releaseDate ) )
			throw new \InvalidArgumentException( 'Invalid release date' );
		$this->releaseDate	= strtotime( $releaseDate );
	}

	public function setTag( $tag ){
		$this->tag	= $tag;
	}

	public function toArray(){
		$prefix	= 'book';
		$map	= new \ADT_List_Dictionary();
		if( $this->author )
			$map->set( $prefix.':author', $this->author );
		if( $this->isbn )
			$map->set( $prefix.':isbn', $this->isbn );
		if( $this->releaseDate )
			$map->set( $prefix.':release_date', $this->getReleaseDate() );
		if( $this->tag )
			$map->set( $prefix.':tag', $this->tag );
		return $map;
	}
}
