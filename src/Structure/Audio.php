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
/**
 *	Generator for OpenGraph markup.
 *	@category		Library
 *	@package		CeusMedia_OpenGraph_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013-2022 {@link https://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/OpenGraph
 */
class Audio{

	protected $url;
	protected $urlSecure;
	protected $type;

	public function __construct( $url, ?string $mimeType = NULL )
	{
		$this->setUrl( $url );
		if( $mimeType !== NULL )
			$this->setType( $mimeType );
	}

	public function getSecureUrl(): ?string
	{
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

	public function setSecureUrl( string $url ): self
	{
		$this->urlSecure	= $url;
		return $this;
	}

	public function setType( $mimeType ): self
	{
		$this->type	= $mimeType;
		return $this;
	}

	public function setUrl( $url ): self
	{
		$this->url	= $url;
		return $this;
	}

	public function toArray(): array
	{
		$prefix	= 'og:audio';
		$map	= new \ADT_List_Dictionary( array( $prefix => $this->url ) );
		if( $this->urlSecure )
			$map->set( $prefix.':secure_url', $this->urlSecure );
		if( $this->type )
			$map->set( $prefix.':type', $this->type );
		return $map->getAll();
	}
}
?>
