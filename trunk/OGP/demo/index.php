<?php
require_once 'cmClasses/trunk/autoload.php5';
require_once 'cmModules/trunk/autoload.php5';

class CMM_OGP_Generator{

	protected $tags	= array();
	public function addStructure( $structure ){
		$this->tags[]	= $structure->render( FALSE );
	}
}

$ogg	= new CMM_OGP_Generator();
$ogg->addStructure( new CMM_OGP_Image( "test.png", 200, 100, "image/png" ) );
$ogg->addStructure( new CMM_OGP_Video( "test.swf", 300, 150, "video/flash" ) );

xmp( $ogg->render() );
