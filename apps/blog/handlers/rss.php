<?php

/**
 * Renders the RSS feed for the blog.
 */

$res = $cache->get ('blog_rss');
if (! $res) {
	$p = new blog\Post;
	$page->posts = $p->latest (10, 0);
	$page->title = $appconf['Blog']['title'];
	$page->date = gmdate ('Y-m-d\TH:i:s');
	foreach ($page->posts as $k => $post) {
		$page->posts[$k]->url = '/blog/post/' . $post->id . '/' . URLify::filter ($post->title);
		$page->posts[$k]->body = $tpl->run_includes ($page->posts[$k]->body);
	}

	$res = $tpl->render ('blog/rss', $page);
	$cache->set ('blog_rss', $res, 1800); // half an hour
}
$page->layout = FALSE;
header ('Content-Type: text/xml');
echo $res;

?>