<?php
class CMM_OGP_Abstract{
	protected static function renderMetaTag( $property, $content ){
		$attributes	= array( 'property' => "og:".$property, 'content' => $content );
		return UI_HTML_Tag::create( 'meta', NULL, $attributes );
	} 
}
?>