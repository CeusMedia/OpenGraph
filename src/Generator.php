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
class CMM_OGP_Generator{

	public static function renderMetaTag( $property, $content ){
		$attributes	= array( 'property' => $property, 'content' => $content );
		return UI_HTML_Tag::create( 'meta', NULL, $attributes );
	} 

	public static function toArray( $node ){
		$map	= new ADT_List_Dictionary();
		$map->set( 'og:url', $node->getUrl() );
		if( $node->getTitle() )
			$map->set( 'og:title', $node->getTitle() );
		if( $node->getDescription() )
			$map->set( 'og:description', $node->getDescription() );
		if( $node->getType() )
			$map->set( 'og:type', $node->getType() );
		foreach( $node->getAudios() as $audio )
			foreach( $audio->toArray() as $property => $content )
				$map->set( $property, $content );
		foreach( $node->getImages() as $image )
			foreach( $image->toArray() as $property => $content )
				$map->set( $property, $content );
		foreach( $node->getVideos() as $video )
			foreach( $video->toArray() as $property => $content )
				$map->set( $property, $content );
		return $map;
	}

	public static function toString( $node, $linePrefix	= "\t\t", $lineSuffix = "\n" ){
		foreach( self::toArray( $node ) as $property => $content )
			$tags[]	= CMM_OGP_Generator::renderMetaTag( $property, $content );
		return $linePrefix.join( $lineSuffix.$linePrefix, $tags ).$lineSuffix;
	}
}
?>