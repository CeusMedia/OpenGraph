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
 *	@package		CeusMedia_OpenGraph
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013-2022 {@link https://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/OpenGraph
 */
namespace CeusMedia\OpenGraph;
/**
 *	Generator for OpenGraph markup.
 *	@category		Library
 *	@package		CeusMedia_OpenGraph
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013-2022 {@link https://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/OpenGraph
 */
class Node{

	protected $audios	= array();
	protected $images	= array();
	protected $videos	= array();
	protected $url		= array();
	protected $profile;
	protected $article;
	protected $book;
	protected $properties	= array();

	protected $title;
	protected $type;
	protected $description;
	protected $determiner;
	protected $siteName;
	protected $locale;
	protected $localeAlternates	= array();

	protected $prefixes	= array(
		'og'	=> "http://ogp.me/ns#"
	);

	protected $types	= array(
		'music.song',
		'music.album',
		'music.playlist',
		'music.radio_station',
		'video.movie',
		'video.episode',
		'video.tv_show',
		'video.other',
		'article',
		'book',
		'profile',
		'website'
	);

	public function __construct( string $url, ?string $title = NULL, ?string $type = NULL )
	{
		$this->setUrl( $url );
		if( $title !== NULL )
			$this->setTitle( $title );
		if( $type !== NULL )
			$this->setType( $type );
	}

	public function addStructure( $structure ): self
	{
		$class	= get_class( $structure );
		switch( $class ){
			case '\CeusMedia\OpenGraph\Structure\Audio':
				$this->addAudio( $structure );
				break;
			case '\CeusMedia\OpenGraph\Structure\Image':
				$this->addImage( $structure );
				break;
			case '\CeusMedia\OpenGraph\Structure\Video':
				$this->addVideo( $structure );
				break;
			default:
				throw new \InvalidArgumentException( 'Unsupported structure "'.$class.'"' );
		}
		return $this;
	}

	public function addAudio( Structure\Audio $audio ): self
	{
		$this->audios[]	= $audio;
		return $this;
	}

	public function addImage( Structure\Image $image ): self
	{
		$this->images[]	= $image;
		return $this;
	}

	public function addVideo( Structure\Video $video ): self
	{
		$this->videos[]	= $video;
		return $this;
	}

	public function getAudios()
	{
		return $this->audios;
	}

	public function getArticle()
	{
		return $this->article;
	}

	public function getBook(){
		return $this->book;
	}

	public function getCustomProperties(){
		return $this->properties;
	}

	public function getDescription(){
		return $this->description;
	}

	public function getImages(){
		return $this->images;
	}

	public function getPrefixes(){
		return $this->prefixes;
	}

	public function getProfile(){
		return $this->profile;
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

	public function addCustomProperty( $property, $value ){
		if( !isset( $this->properties[$property] ) )
			$this->properties[$property]	= array();
		$this->properties[$property][]	= $value;
	}

	public function setArticle( Type\Article $article ): self
	{
		$this->article	= $article;
		$this->prefixes['article']	= "http://ogp.me/ns/article#";
	}

	public function setBook( Type\Book $book ){
		$this->book	= $book;
		$this->prefixes['book']	= "http://ogp.me/ns/book#";
	}

	public function setProfile( Type\Profile $profile ){
		$this->profile	= $profile;
		$this->prefixes['profile']	= "http://ogp.me/ns/profile#";
	}

	public function setDescription( $description ){
		$this->description	= htmlentities( $description, ENT_COMPAT, 'UTF-8' );
	}

	public function setTitle( $title ){
		$this->title	= htmlentities( $title, ENT_COMPAT, 'UTF-8' );
	}

	public function setType( $type ){
		if( !in_array( $type, $this->types ) )
			throw new \OutOfRangeException( 'Type no supported' );
		$this->type		= $type;
	}

	public function setUrl( $url ){
		$this->url	= addslashes( $url );
	}
}
?>
