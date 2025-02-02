<?php
declare(strict_types=1);

/**
 *	Parser for OpenGraph markup.
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

use CeusMedia\Common\XML\Element as XmlElement;
use CeusMedia\OpenGraph\Structure\Audio as AudioStructure;
use CeusMedia\OpenGraph\Structure\Image as ImageStructure;
use CeusMedia\OpenGraph\Structure\Video as VideoStructure;

/**
 *	Parser for OpenGraph markup.
 *	@category		Library
 *	@package		CeusMedia_OpenGraph
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013-2022 {@link https://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/OpenGraph
 */
class Parser
{
	public static function toNode( string $html ): Node
	{
		$html	= preg_replace( "/^.*<head>/is", "", $html );
		$html	= preg_replace( "/<\/head>.*$/is", "", $html );
		$xml	= new XmlElement( '<metas>'.$html.'</metas>' );
		$node	= NULL;
		$audios	= [];
		$images	= [];
		$videos	= [];
		foreach( $xml->meta as $metaTag ){
			if( $metaTag->hasAttribute( 'property' ) && $metaTag->hasAttribute( 'content' ) ){
				$property	= $metaTag->getAttribute( 'property' );
				$content	= $metaTag->getAttribute( 'content' );
				if( str_starts_with( $property, 'og:' ) ){
					if( is_null( $node ) && 'og:url' === $property )
						$node	= new Node( $content );
					else{
						switch( $property ){
							case 'og:type':
								$node->setType( $content );
								break;
							case 'og:title':
								$node->setTitle( $content );
								break;
							case 'og:description':
								$node->setDescription( $content );
								break;
							case 'og:audio':
								$audios[]	= new AudioStructure( $content );
								break;
							case 'og:audio:type':
								$audio	= array_pop( $audios );
								$audio->setType( $content );
								$audios[] = $audio;
								break;
							case 'og:audio:secure_url':
								$audio	= array_pop( $audios );
								$audio->setSecureUrl( $content );
								$audios[] = $audio;
								break;
							case 'og:image':
								$images[]	= new ImageStructure( $content );
								break;
							case 'og:image:width':
								$image	= array_pop( $images );
								$image->setWidth( (int) $content );
								$images[] = $image;
								break;
							case 'og:image:height':
								$image	= array_pop( $images );
								$image->setHeight( (int) $content );
								$images[] = $image;
								break;
							case 'og:image:type':
								$image	= array_pop( $images );
								$image->setType( $content );
								$images[] = $image;
								break;
							case 'og:image:secure_url':
								$image	= array_pop( $images );
								$image->setSecureUrl( $content );
								$images[] = $image;
								break;
							case 'og:video':
								$videos[]	= new VideoStructure( $content );
								break;
							case 'og:video:width':
								$video	= array_pop( $videos );
								$video->setWidth( (int) $content );
								$videos[] = $video;
								break;
							case 'og:video:height':
								$video	= array_pop( $videos );
								$video->setHeight( (int) $content );
								$videos[] = $video;
								break;
							case 'og:video:type':
								$video	= array_pop( $videos );
								$video->setType( $content );
								$videos[] = $video;
								break;
							case 'og:video:secure_url':
								$video	= array_pop( $videos );
								$video->setSecureUrl( $content );
								$videos[] = $video;
								break;
						}
					}
				}
			}
		}
		if( !is_null( $node ) ){
			foreach( $audios as $audio )
				$node->addAudio( $audio );
			foreach( $images as $image )
				$node->addImage( $image );
			foreach( $videos as $video )
				$node->addVideo( $video );
		}
		return $node;
	}
}
