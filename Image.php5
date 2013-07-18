<?php
class CMM_OGP_Image extends CMM_OGP_Abstract{

	protected $width;
	protected $height;
	protected $url;
	protected $urlSecure;
	protected $type;
	public $indent	= "\t\t";

	public function __construct( $url, $width = NULL, $height = NULL, $mimeType = NULL ){
		$this->setUrl( $url );
		if( $width !== NULL )
			$this->setWidth( $width );
		if( $height !== NULL )
			$this->setHeight( $height );
		if( $mimeType !== NULL )
			$this->setType( $mimeType );
	}
	
	public function render( $format = TRUE ){
		$tags	= array();
		$tags[]	= self::renderMetaTag( 'image', $this->url );
		if( $this->urlSecure )
			$tags[]	= self::renderMetaTag( 'image:secure_url', $this->urlSecure );
		if( $this->type )
			$tags[]	= self::renderMetaTag( 'image:type', $this->type );
		if( $this->width )
			$tags[]	= self::renderMetaTag( 'image:width', $this->width );
		if( $this->height )
			$tags[]	= self::renderMetaTag( 'image:height', $this->height );
		if( $format )
			return $this->indent.join( "\n".$this->indent, $tags )."\n";
		return join( "\n", $tags );
	}
	
	public function getHeight(){
		return $this->height;
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

	public function getWidth(){
		return $this->width;
	}

	public function setHeight( $height ){
		$this->height	= $height;
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

	public function setWidth( $width ){
		$this->width	= $width;
	}
}
?>