<?php
/**
 *	Generator for OpenGraph markup.
 *
 *	Copyright (c) 2013 Christian Würker / {@link http://ceusmedia.de/ Ceus Media}
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
 *	@category		cmModules
 *	@package		OGP
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013 {@link http://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			http://code.google.com/p/cmmodules/
 *	@since			0.3.0
 *	@version		$Id$
 */
/**
 *	Generator for OpenGraph markup.
 *	@category		cmModules
 *	@package		OGP
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013 {@link http://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			http://code.google.com/p/cmmodules/
 *	@since			0.3.0
 *	@version		$Id$
 */
class CMM_OGP_Node{

	protected $audios	= array();
	protected $images	= array();
	protected $videos	= array();
	protected $url		= array();

	protected $title;
	protected $type;
	protected $description;
	protected $determiner;
	protected $siteName;
	protected $locale;
	protected $localeAlternates	= array();
	
	public function __construct( $url, $title = NULL, $type = NULL ){
		$this->setUrl( $url );
		if( $title !== NULL )
			$this->setTitle( $title );
		if( $type !== NULL )
			$this->setType( $type );
	}

	public function add( CMM_OGP_Abstract $structure ){
		$class	= get_class( $structure );
		switch( $class ){
			case 'CMM_OGP_Audio':
				$this->addAudio( $structure );
				break;
			case 'CMM_OGP_Image':
				$this->addImage( $structure );
				break;
			case 'CMM_OGP_Video':
				$this->addVideo( $structure );
				break;
			default:
				throw new InvalidArgumentException( 'Unsupported structure "'.$class.'"' );
		}
	}

	
	public function addAudio(CMM_OGP_Audio $audio ){
		$this->audios[]	= $audio;
	}
	
	public function addImage( CMM_OGP_Image $image ){
		$this->images[]	= $image;
	}

	public function addVideo( CMM_OGP_Video $video ){
		$this->videos[]	= $video;
	}

	public function getAudios(){
		return $this->audios;
	}

	public function getDescription(){
		return $this->description;
	}

	public function getImages(){
		return $this->images;
	}

	public function getTitle(){
		return $this->title;
	}

	public function getType(){
		return $this->type;
	}

	public function getVideos(){
		return $this->videos;
	}

	public function getUrl(){
		return $this->url;
	}

	public function setDescription( $description ){
		$this->description	= htmlentities( $description, ENT_COMPAT, 'UTF-8' );
	}

	public function setTitle( $title ){
		$this->title	= htmlentities( $title, ENT_COMPAT, 'UTF-8' );
	}

	public function setType( $type ){
		$this->type		= $type;
	}

	public function setUrl( $url ){
		$this->url	= addslashes( $url );
	}
}
?>
