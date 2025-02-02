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

use CeusMedia\OpenGraph\Structure\Audio as AudioStructure;
use CeusMedia\OpenGraph\Structure\Image as ImageStructure;
use CeusMedia\OpenGraph\Structure\Video as VideoStructure;
use CeusMedia\OpenGraph\Type\Article as ArticleType;
use CeusMedia\OpenGraph\Type\Book as BookType;
use CeusMedia\OpenGraph\Type\Profile as ProfileType;
use InvalidArgumentException;
use OutOfRangeException;

/**
 *	Generator for OpenGraph markup.
 *	@category		Library
 *	@package		CeusMedia_OpenGraph
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013-2022 {@link https://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/OpenGraph
 */
class Node
{
	protected array $audios			= [];
	protected array $images			= [];
	protected array $videos			= [];
	protected string $url;
	protected ?ProfileType $profile	= NULL;
	protected ?ArticleType $article	= NULL;
	protected ?BookType $book		= NULL;
	protected array $properties		= [];

	protected ?string $title		= NULL;
	protected ?string $type			= NULL;
	protected ?string $description	= NULL;
	protected ?string $determiner	= NULL;
	protected ?string $siteName		= NULL;
	protected ?string $locale		= NULL;
	protected array $localeAlternates	= [];

	protected array $prefixes	= [
		'og'	=> 'https://ogp.me/ns#'
	];

	protected array $types	= [
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
	];

	public function __construct( string $url, ?string $title = NULL, ?string $type = NULL )
	{
		$this->setUrl( $url );
		if( NULL !== $title )
			$this->setTitle( $title );
		if( NULL !== $type )
			$this->setType( $type );
	}

	public function addStructure( AudioStructure|ImageStructure|VideoStructure $structure ): static
	{
		$class	= get_class( $structure );
		switch( $class ){
			case AudioStructure::class:
				/** @var AudioStructure $structure */
				$this->addAudio( $structure );
				break;
			case ImageStructure::class:
				/** @var ImageStructure $structure */
				$this->addImage( $structure );
				break;
			case VideoStructure::class:
				/** @var VideoStructure $structure */
				$this->addVideo( $structure );
				break;
			default:
				throw new InvalidArgumentException( 'Unsupported structure "'.$class.'"' );
		}
		return $this;
	}

	public function addAudio( AudioStructure $audio ): static
	{
		$this->audios[]	= $audio;
		return $this;
	}

	public function addImage( ImageStructure $image ): static
	{
		$this->images[]	= $image;
		return $this;
	}

	public function addVideo( VideoStructure $video ): static
	{
		$this->videos[]	= $video;
		return $this;
	}

	public function getAudios(): array
	{
		return $this->audios;
	}

	public function getArticle(): ?ArticleType
	{
		return $this->article;
	}

	public function getBook(): ?BookType
	{
		return $this->book;
	}

	public function getCustomProperties(): array
	{
		return $this->properties;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function getImages(): array
	{
		return $this->images;
	}

	public function getPrefixes(): array
	{
		return $this->prefixes;
	}

	public function getProfile(): ?ProfileType
	{
		return $this->profile;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function getType(): ?string
	{
		return $this->type;
	}

	public function getVideos(): array
	{
		return $this->videos;
	}

	public function getUrl(): string
	{
		return $this->url;
	}

	public function addCustomProperty( string $property, string|int|float $value ): static
	{
		if( !isset( $this->properties[$property] ) )
			$this->properties[$property]	= [];
		$this->properties[$property][]	= $value;
		return $this;
	}

	public function setArticle( ArticleType $article ): static
	{
		$this->article	= $article;
		$this->prefixes['article']	= 'https://ogp.me/ns/article#';
		return $this;
	}

	public function setBook( BookType $book ): static
	{
		$this->book	= $book;
		$this->prefixes['book']	= 'https://ogp.me/ns/book#';
		return $this;
	}

	public function setProfile( ProfileType $profile ): static
	{		$this->profile	= $profile;
		$this->prefixes['profile']	= 'https://ogp.me/ns/profile#';
		return $this;
	}

	public function setDescription( string $description ): static
	{
		$this->description	= htmlentities( $description, ENT_COMPAT, 'UTF-8' );
		return $this;
	}

	public function setTitle( string $title ): static
	{
		$this->title	= htmlentities( $title, ENT_COMPAT, 'UTF-8' );
		return $this;
	}

	public function setType( string $type ): static
	{
		if( !in_array( $type, $this->types, TRUE ) )
			throw new OutOfRangeException( 'Type no supported' );
		$this->type		= $type;
		return $this;
	}

	public function setUrl( string $url ): static
	{
		$this->url	= addslashes( $url );
		return $this;
	}
}
