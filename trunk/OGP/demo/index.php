<?php
require_once 'cmClasses/trunk/autoload.php5';
require_once 'cmModules/trunk/autoload.php5';

$page	= new UI_HTML_PageFrame();
$page->indent	= "  ";
$page->addPrefix( 'og', 'http://ogp.me/ns#' );

$ogNode	= new CMM_OGP_Node( "http://localhost/test#", "Test Page", "website" );
$ogNode->add( new CMM_OGP_Image( "test.png", 200, 100, "image/png" ) );
$ogNode->add( new CMM_OGP_Video( "test.swf", 300, 150, "video/flash" ) );
$ogNode->setDescription( "This is a test site." );

$map	= CMM_OGP_Generator::toArray( $ogNode );


xmp( CMM_OGP_Generator::toString( CMM_OGP_Parser::toNode( CMM_OGP_Generator::toString( $ogNode ) ) ) );
print_m( $ogNode == CMM_OGP_Parser::toNode( CMM_OGP_Generator::toString( $ogNode ) ) );
die;

foreach( $map as $property => $content )
	$page->addMetaTag( 'property', $property, $content );

$body	= '<h1 class="muted">cmModules Demos</h1>
	<h2>OGP - OpenGraph Processor</h2>
	<h3>Data</h3>
	<h4>Classes</h4>
	<p>
	Central class to hold all OpenGraph data is <code>CMM_OGP_Node</code>.<br/>
	This class has these attributes: URL, title, description, type. More are about to come.<br/>
	Instances of stucture classes can be added: <code>CMM_OGP_Audio</code>, <code>CMM_OGP_Image</code>, <code>CMM_OGP_Video</code>.
	</p>
	<h4>Example</h4>
	<xmp class="php">$ogNode	= new CMM_OGP_Node( "http://localhost/test#", "Test Page", "website" );
$ogNode->add( new CMM_OGP_Image( "test.png", 200, 100, "image/png" ) );
$ogNode->add( new CMM_OGP_Video( "test.swf", 300, 150, "video/flash" ) );
$ogNode->setDescription( "This is a test site." );</xmp>
	<h3>Rendering</h3>
    <h4>Generate HTML string</h4>
    <p>Running <small class="muted">CMM_OGP_Generator::</small>toString() on node <small class="muted">(CMM_OGP_Node)</small> instance, like this:</p>
    <xmp class="php">print( CMM_OGP_Generator::toString( $ogNode ) );</xmp>
    <p>will print the following HTML code:</p>
    <xmp class="html">'.CMM_OGP_Generator::toString( $ogNode, "" ).'</xmp>
    <br/>
    <h4>Generate array </h4>
    <p>Run <small class="muted">CMM_OGP_Generator::</small>toArray() on node <small class="muted">(CMM_OGP_Node)</small> instance, like this:</p>
    <xmp class="php">CMM_OGP_Generator::toArray( $ogNode );</xmp>
    <p>will deliver a map <small class=muted">(ADT_List_Dictionary)</small> like this:</p>
    '.print_m( $map->getAll(), NULL, NULL, TRUE ).'
    <br/>
    <h3>Apply to UI_HTML_PageFrame</h3>
    <h4>PHP code</h4>
    <xmp class="php">$page	= new UI_HTML_PageFrame();
$page->addPrefix( "og", "http://ogp.me/ns#" );
foreach( CMM_OGP_Generator::toArray( $ogNode ) as $property => $content )
    $page->addMetaTag( "property", $property, $content );
print( $page->build() );</xmp>
    <h4>HTML result</h4>
    <xmp class="html">'.$page->build().'</xmp>
';
$page->addBody( $body );

$page->addStylesheet( "http://cdn.int1a.net/css/bootstrap.min.css" );
$page->addStylesheet( "http://cdn.int1a.net/css/xmp.formats.css" );
print( $page->build( array( 'style' => 'margin: 1em 2em' ) ) );
?>
