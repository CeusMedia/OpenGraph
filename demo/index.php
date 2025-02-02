<?php

use CeusMedia\Common\UI\HTML\Exception\Page;
use CeusMedia\Common\UI\HTML\PageFrame;
use CeusMedia\OpenGraph\Node;
use CeusMedia\OpenGraph\Renderer;
use CeusMedia\OpenGraph\Structure\Image as ImageStructure;
use CeusMedia\OpenGraph\Structure\Video as VideoStructure;
use CeusMedia\OpenGraph\Type\Article as ArticleType;
use CeusMedia\OpenGraph\Type\Book as BookType;
use CeusMedia\OpenGraph\Type\Profile as ProfileType;

(@include '../vendor/autoload.php') or die('Please use composer to install required packages.');
ini_set('display_errors', 1);

try{
	$node	= new Node("https://example.com/");
	$node->setType("profile");

	$image	= new ImageStructure("https://example.com/image.png", 1920, 1080);
	$node->addImage($image);

	$video	= new VideoStructure("https://example.com/video.webm", 1920, 1080);
	$node->addVideo($video);

	$profile	= new ProfileType();
	$profile->setUsername("tester");
	$profile->setFirstName("Firstname");
	$profile->setLastName("Lastname");
	$profile->setGender("male");
	$node->setProfile($profile);

	$book	= new BookType();
	$book->setIsbn("987-654-321");
	$book->setAuthor("https://example.com/author1");
	$book->setTag("tag1");
	$node->setBook($book);

	$article	= new ArticleType();
	$article->setPublishedTime(date( 'r', time()));
	$article->setModifiedTime(date( 'r', time()));
	$article->setExpirationTime(date( 'r', time()));
	$article->setAuthor("https://example.com/author1");
	$article->setSection("Examples");
	$article->setTag("tag1");
	$node->setArticle($article);

	$node->addCustomProperty("customProperty", "customValue-1");
	$node->addCustomProperty("customProperty", "customValue-2");

	$html	= Renderer::render($node);
}
catch(Exception $e){
	Page::display($e);
	exit;
}

$page	= new PageFrame();
$page->addHead("\n".$html);
$html	= $page->build( [], array(
	'prefix' => Renderer::renderPrefixes($node)
));

$body = '
<div class="container">
	<h1 class="muted">CeusMedia Component Demo</h1>
	<h2>OpenGraph</h2>
	<h3>Generating</h3>
	<xmp>'.$html.'</xmp>
</div>';

$page	= new PageFrame();
$page->addStylesheet("https://cdn.ceusmedia.de/css/bootstrap.min.css");
$page->addBody($body);
print $page->build();
