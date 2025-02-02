<?php
declare(strict_types=1);

namespace CeusMedia\OpenGraph\Type;

use CeusMedia\Common\ADT\Collection\Dictionary;
use InvalidArgumentException;

class Book
{
	protected ?string $author	= NULL;
	protected ?string $isbn		= NULL;
	protected ?int $releaseDate	= NULL;
	protected ?string $tag		= NULL;

	public function getAuthor(): ?string
	{
		return $this->author;
	}

	public function getIsbn(): ?string
	{
		return $this->isbn;
	}

	public function getReleaseDate(): ?string
	{
		if( NULL === $this->releaseDate )
			return NULL;
		return date( 'r', $this->releaseDate );
	}

	public function getTag(): ?string
	{
		return $this->tag;
	}

	/**
	 *	Set URL to author resource.
	 */
	public function setAuthor( string $author ): static
	{
		$this->author	= $author;
		return $this;
	}

	public function setIsbn( string $isbn ): static
	{
		$this->isbn		= $isbn;
		return $this;
	}

	public function setReleaseDate( string $releaseDate ): static
	{
		if( FALSE === strtotime( $releaseDate ) )
			throw new InvalidArgumentException( 'Invalid release date' );
		$this->releaseDate	= strtotime( $releaseDate );
		return $this;
	}

	public function setTag( string $tag ): static
	{
		$this->tag	= $tag;
		return $this;
	}

	public function toArray(): array
	{
		$prefix	= 'book';
		$map	= new Dictionary();
		if( NULL !== $this->author )
			$map->set( $prefix.':author', $this->author );
		if( NULL !== $this->isbn )
			$map->set( $prefix.':isbn', $this->isbn );
		if( NULL !== $this->releaseDate )
			$map->set( $prefix.':release_date', $this->getReleaseDate() );
		if( NULL !== $this->tag )
			$map->set( $prefix.':tag', $this->tag );
		return $map->getAll();
	}
}
