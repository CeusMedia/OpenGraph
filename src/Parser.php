<?php
/**
 *	Parser for OpenGraph markup.
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
 *	Parser for OpenGraph markup.
 *	@category		cmModules
 *	@package		OGP
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2013 {@link http://ceusmedia.de/ Ceus Media}
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			http://code.google.com/p/cmmodules/
 *	@since			0.3.0
 *	@version		$Id$
 */
class CMM_OGP_Parser{

	public static function toNode( $html ){
		$html	= preg_replace( "/^.*<head>/is", "", $html );
		$html	= preg_replace( "/<\/head>.*$/is", "", $html );
		$xml	= new XML_Element( '<metas>'.$html.'</metas>' );
		$node	= NULL;
		$audios	= array();
		$images	= array();
		$videos	= array();
		foreach( $xml->meta as $metaTag ){
			if( $metaTag->hasAttribute( 'property' ) && $metaTag->hasAttribute( 'content' ) ){
				$property	= $metaTag->getAttribute( 'property' );
				$content	= $metaTag->getAttribute( 'content' );
				if( substr( $property, 0, 3 ) == "og:" ){
					if( !$node && $property == "og:url" )
						$node	= new CMM_OGP_Node( $content );
					else{
						switch( $property ){
							case 'og:type';
								$node->setType( $content );
								break;
							case 'og:title';
								$node->setTitle( $content );
								break;
							case 'og:description';
								$node->setDescription( $content );
								break;
							case 'og:audio';
								$audios[]	= new CMM_OGP_Image( $content );
								break;
							case 'og:audio:type';
								$audio	= array_pop( $audios );
								$audio->setType( $content );
								array_push( $audios, $audio );
								break;
							case 'og:audio:secure_url';
								$audio	= array_pop( $audios );
								$audio->setSecureUrl( $content );
								array_push( $audios, $audio );
								break;
							case 'og:image';
								$images[]	= new CMM_OGP_Image( $content );
								break;
							case 'og:image:width';
								$image	= array_pop( $images );
								$image->setWidth( $content );
								array_push( $images, $image );
								break;
							case 'og:image:height';
								$image	= array_pop( $images );
								$image->setHeight( $content );
								array_push( $images, $image );
								break;
							case 'og:image:type';
								$image	= array_pop( $images );
								$image->setType( $content );
								array_push( $images, $image );
								break;
							case 'og:image:secure_url';
								$image	= array_pop( $images );
								$image->setSecureUrl( $content );
								array_push( $images, $image );
								break;
							case 'og:video';
								$videos[]	= new CMM_OGP_Video( $content );
								break;
							case 'og:video:width';
								$video	= array_pop( $videos );
								$video->setWidth( $content );
								array_push( $videos, $video );
								break;
							case 'og:video:height';
								$video	= array_pop( $videos );
								$video->setHeight( $content );
								array_push( $videos, $video );
								break;
							case 'og:video:type';
								$video	= array_pop( $videos );
								$video->setType( $content );
								array_push( $videos, $video );
								break;
							case 'og:video:secure_url';
								$videos	= array_pop( $videos );
								$video->setSecureUrl( $content );
								array_push( $videos, $video );
								break;
						}
					}
				}
			}
		}
		if( $node ){
			foreach( $audios as $audio )
				$node->add( $audio );
			foreach( $images as $image )
				$node->add( $image );
			foreach( $videos as $video )
				$node->add( $video );
		}
		return $node;
	}
	
}
?>