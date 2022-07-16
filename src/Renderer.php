<?php
declare(strict_types=1);

/**
 *	Renderer for OpenGraph markup.
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
 *	Renderer for OpenGraph markup.
 *	@category		Library
 *	@package		CeusMedia_OpenGraph
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013-2022 {@link https://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/OpenGraph
 */
class Renderer
{
	public static $linePrefix	= "    ";
	public static $lineSuffix	= "\n";

	public static function render( Node $node, bool $withComments = TRUE ): string
	{
		$list	= [];
		if( $withComments )
			$list[]	= "<!-- OpenGraph Start -->";
		self::enlist( $list, 'og:url', $node->getUrl() );
		self::enlist( $list, 'og:title', $node->getTitle() );
		self::enlist( $list, 'og:description', $node->getDescription() );
		self::enlist( $list, 'og:type', $node->getType() );
		foreach( $node->getAudios() as $audio )
			foreach( $audio->toArray() as $property => $content )
				self::enlist( $list, $property, $content );
		foreach( $node->getImages() as $image )
			foreach( $image->toArray() as $property => $content )
				self::enlist( $list, $property, $content );
		foreach( $node->getVideos() as $video )
			foreach( $video->toArray() as $property => $content )
				self::enlist( $list, $property, $content );
		if( $node->getProfile() )
			foreach( $node->getProfile()->toArray() as $property => $content )
				self::enlist( $list, $property, $content );
		if( $node->getArticle() )
			foreach( $node->getArticle()->toArray() as $property => $content )
				self::enlist( $list, $property, $content );
		if( $node->getBook() )
			foreach( $node->getBook()->toArray() as $property => $content )
				self::enlist( $list, $property, $content );
		if( $node->getCustomProperties() )
			foreach( $node->getCustomProperties() as $property => $contents )
				foreach( $contents as $content )
					self::enlist( $list, $property, $content );
		if( $withComments )
			$list[]	= '<!-- OpenGraph End -->';
		$list	= join( self::$lineSuffix . self::$linePrefix, $list );
		return self::$linePrefix . $list . self::$lineSuffix;
	}

	public static function renderPrefixes( Node $node ): string
	{
		$list	= [];
		foreach( $node->getPrefixes() as $ns => $url )
			$list[]	= $ns.': '.$url;
		return join( ' ', $list );
	}

	protected static function enlist( &$list, string $property, string $content ): void
	{
		if( strlen( trim( $content ) ) === 0 )
			return;
		$list[]	= \UI_HTML_Tag::create( 'meta', NULL, array(
			'property'	=> $property,
			'content'	=> addslashes( $content )
		) );
	}
}
