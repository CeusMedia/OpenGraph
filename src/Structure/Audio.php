<?php
/**
 *	Generator for OpenGraph markup.
 *
 *	Copyright (c) 2013-2015 Christian Würker / {@link http://ceusmedia.de/ Ceus Media}
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
 *	@copyright		2013-2015 {@link http://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/OpenGraph
 */
namespace CeusMedia\OpenGraph\Structure;
/**
 *	Generator for OpenGraph markup.
 *	@category		Library
 *	@package		CeusMedia_OpenGraph_Structure
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013-2015 {@link http://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/OpenGraph
 */
class Audio{

	protected $url;
	protected $urlSecure;
	protected $type;

	public function __construct( $url, $mimeType = NULL ){
		$this->setUrl( $url );
		if( $mimeType !== NULL )
			$this->setType( $mimeType );
	}

	public function getSecureUrl(){
		return $this->urlSecure;
	}

	public function getType(){
		return $this->type;
	}

	public function getUrl(){
		return $this->url;
	}

	public function setSecureUrl( $url ){
		$this->urlSecure	= $url;
	}

	public function setType( $mimeType ){
		$this->type	= $mimeType;
	}

	public function setUrl( $url ){
		$this->url	= $url;
	}

	public function toArray(){
		$prefix	= 'og:audio';
		$map	= new \ADT_List_Dictionary( array( $prefix => $this->url ) );
		if( $this->urlSecure )
			$map->set( $prefix.':secure_url', $this->urlSecure );
		if( $this->type )
			$map->set( $prefix.':type', $this->type );
		return $map;
	}
}
?>
