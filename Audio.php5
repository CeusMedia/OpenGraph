<?php
class CMM_OGP_Audio extends CMM_OGP_Abstract{

	protected $width;
	protected $height;
	protected $url;
	protected $urlSecure;
	protected $type;
	public $indent	= "\t\t";

	public function __construct( $url, $mimeType = NULL ){
		$this->setUrl( $url );
		if( $mimeType !== NULL )
			$this->setType( $mimeType );
	}

	public function render( $format = TRUE ){
		$tags	= array();
		$tags[]	= self::renderMetaTag( 'audio', $this->url );
		if( $this->urlSecure )
			$tags[]	= self::renderMetaTag( 'audio:secure_url', $this->urlSecure );
		if( $this->type )
			$tags[]	= self::renderMetaTag( 'audio:type', $this->type );
		if( $format )
			return $this->indent.join( "\n".$this->indent, $tags )."\n";
		return join( "\n", $tags );
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
}
?>