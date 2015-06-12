<?php
(@include '../vendor/autoload.php') or die('Please use composer to install required packages.');

try{
	$node	= new \CeusMedia\OpenGraph\Node("http://example.com/");
	$node->setType("profile");

	$image	= new \CeusMedia\OpenGraph\Structure\Image("http://example.com/image.png", 1920, 1080);
	$node->addImage($image);

	$image	= new \CeusMedia\OpenGraph\Structure\Video("http://example.com/video.webm", 1920, 1080);
	$node->addVideo($image);

	$profile	= new \CeusMedia\OpenGraph\Type\Profile();
	$profile->setUsername("tester");
	$profile->setFirstName("Firstname");
	$profile->setLastName("Lastname");
	$profile->setGender("male");
	$node->setProfile($profile);

	$book	= new \CeusMedia\OpenGraph\Type\Book();
	$book->setIsbn("987-654-321");
	$book->setAuthor("http://example.com/author1");
	$book->setTag("tag1");
	$node->setBook($book);

	$article	= new \CeusMedia\OpenGraph\Type\Article();
	$article->setPublishedTime(date( 'r', time()));
	$article->setModifiedTime(date( 'r', time()));
	$article->setExpirationTime(date( 'r', time()));
	$article->setAuthor("http://example.com/author1");
	$article->setSection("Examples");
	$article->setTag("tag1");
	$node->setArticle($article);

	$node->addCustomProperty("customProperty", "customValue-1");
	$node->addCustomProperty("customProperty", "customValue-2");

	$html	= \CeusMedia\OpenGraph\Renderer::render($node);
}
catch(Exception $e){
	UI_HTML_Exception_Page::display($e);
	exit;
}

$page	= new UI_HTML_PageFrame();
$page->addHead("\n".$html);
$html	= $page->build( array(), array(
	'prefix' => \CeusMedia\OpenGraph\Renderer::renderPrefixes($node)
));

$body = '
<div class="container">
	<h1 class="muted">CeusMedia Component Demo</h1>
	<h2>OpenGraph</h2>
	<h3>Generating</h3>
	<xmp>'.$html.'</xmp>
</div>';

$page	= new UI_HTML_PageFrame();
$page->addStylesheet("http://cdn.int1a.net/css/bootstrap.min.css");
$page->addBody($body);
print $page->build();
