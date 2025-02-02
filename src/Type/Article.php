<?php
declare(strict_types=1);

namespace CeusMedia\OpenGraph\Type;

use CeusMedia\Common\ADT\Collection\Dictionary;
use InvalidArgumentException;

class Article
{
	protected ?int $publishedTime	= NULL;
	protected ?int $modifiedTime	= NULL;
	protected ?int $expirationTime	= NULL;
	protected ?string $author		= NULL;
	protected ?string $section		= NULL;
	protected ?string $tag			= NULL;

	public function getPublishedTime(): ?string
	{
		if( NULL === $this->publishedTime )
			return NULL;
		return date( 'r', $this->publishedTime );
	}

	public function getModifiedTime(): ?string
	{
		if( NULL === $this->modifiedTime )
			return NULL;
		return date( 'r', $this->modifiedTime );
	}

	public function getExpirationTime(): ?string
	{
		if( NULL === $this->expirationTime )
			return NULL;
		return date( 'r', $this->expirationTime );
	}

	public function getAuthor(): ?string
	{
		return $this->author;
	}

	public function getSection(): ?string
	{
		return $this->section;
	}

	public function getTag(): ?string
	{
		return $this->tag;
	}

	public function setPublishedTime( string $publishedTime ): static
	{
		if( FALSE === strtotime( $publishedTime ) )
			throw new InvalidArgumentException( 'Invalid published time' );
		$this->publishedTime	= strtotime( $publishedTime );
		return $this;
	}

	public function setModifiedTime( string $modifiedTime ): static
	{
		if( FALSE === strtotime( $modifiedTime ) )
			throw new InvalidArgumentException( 'Invalid modified time' );
		$this->modifiedTime	= strtotime( $modifiedTime );
		return $this;
	}

	public function setExpirationTime( string $expirationTime ): static
	{
		if( FALSE === strtotime( $expirationTime ) )
			throw new InvalidArgumentException( 'Invalid expiration time' );
		$this->expirationTime	= strtotime( $expirationTime );
		return $this;
	}

	public function setAuthor( string $author ): static
	{
		$this->author	= $author;
		return $this;
	}

	public function setSection( string $section ): static
	{
		$this->section	= $section;
		return $this;
	}

	public function setTag( string $tag ): static
	{
		$this->tag	= $tag;
		return $this;
	}

	public function toArray(): array
	{
		$prefix	= 'article';
		$map	= new Dictionary();
		if( NULL !== $this->publishedTime )
			$map->set( $prefix.':published_time', $this->getPublishedTime() );
		if( NULL !== $this->modifiedTime )
			$map->set( $prefix.':modified_time', $this->getModifiedTime() );
		if( NULL !== $this->expirationTime )
			$map->set( $prefix.':expiration_time', $this->getExpirationTime() );
		if( NULL !== $this->author )
			$map->set( $prefix.':author', $this->author );
		if( NULL !== $this->section )
			$map->set( $prefix.':section', $this->section );
		if( NULL !== $this->tag )
			$map->set( $prefix.':tag', $this->tag );
		return $map->getAll();
	}
}
