<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	{foreach from=$sitemap_items key=link item=time}
		<url>
			<loc>{$link}</loc>
			<lastmod>{$time}</lastmod>
		</url>
	{/foreach}
</urlset>