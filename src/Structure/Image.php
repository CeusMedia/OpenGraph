<?php
declare(strict_types=1);

/**
 *	Generator for OpenGraph markup.
 *
 *	Copyright (c) 2013-2022 Christian Würker / {@link https://ceusmedia.de/ Ceus Media}
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *	@category		Library
 *	@package		CeusMedia_OpenGraph_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013-2022 {@link https://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/OpenGraph
 */
namespace CeusMedia\OpenGraph\Structure;

use ADT_List_Dictionary as Dictionary;
use InvalidArgumentException;

/**
 *	Generator for OpenGraph markup.
 *	@category		Library
 *	@package		CeusMedia_OpenGraph_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013-2022 {@link https://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/OpenGraph
 */
class Image
{
	protected $width;
	protected $height;
	protected $url;
	protected $urlSecure;
	protected $type;

	public function __construct( string $url, ?int $width = NULL, ?int $height = NULL, ?string $mimeType = NULL )
	{
		$this->setUrl( $url );
		if( $width !== NULL )
			$this->setWidth( $width );
		if( $height !== NULL )
			$this->setHeight( $height );
		if( $mimeType !== NULL )
			$this->setType( $mimeType );
	}

	public function getHeight(): ?int
	{
		return $this->height;
	}

	public function getSecureUrl(): string
	{
		if( strlen( trim( $this->urlSecure ) ) === 0 )
			throw new InvalidArgumentException( 'Missing secure image URL' );
		return $this->urlSecure;
	}

	public function getType(): ?string
	{
		return $this->type;
	}

	public function getUrl(): string
	{
		return $this->url;
	}

	public function getWidth(): ?int
	{
		return $this->width;
	}

	public function setHeight( int $height ): self
	{
		if( $height <= 0 )
			throw new InvalidArgumentException( 'Image height must be greater than 0' );
		$this->height	= $height;
		return $this;
	}

	public function setSecureUrl( string $url ): self
	{
		$this->urlSecure	= $url;
		return $this;
	}

	public function setType( string $mimeType ): self
	{
		$this->type	= $mimeType;
		return $this;
	}

	public function setUrl( string $url ): self
	{
		if( strlen( trim( $url ) ) === 0 )
			throw new InvalidArgumentException( 'Missing image URL' );
		$this->url	= $url;
		return $this;
	}

	public function setWidth( int $width ): self
	{
		if( $width <= 0 )
			throw new InvalidArgumentException( 'Image width must be greater than 0' );
		$this->width	= $width;
		return $this;
	}

	public function toArray(): array
	{
		$prefix	= 'og:image';
		$map	= new Dictionary( array( $prefix => $this->url ) );
		if( $this->urlSecure )
			$map->set( $prefix.':secure_url', $this->urlSecure );
		if( $this->type )
			$map->set( $prefix.':type', $this->type );
		if( $this->width )
			$map->set( $prefix.':width', $this->width );
		if( $this->height )
			$map->set( $prefix.':height', $this->height );
		return $map->getAll();
	}
}
