<?php

namespace App\Http\Controllers;

use App\Services\SitemapUrls;
use App\Support\Seo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    private const URLS_PER_SITEMAP = 1000;

    public function robots(Request $request, Seo $seo): Response
    {
        $rules = $seo->indexingEnabled($request)
            ? "User-agent: *\nDisallow:\n\nSitemap: ".$seo->url('/sitemap.xml')."\n"
            : "User-agent: *\nDisallow: /\n";

        return response($rules, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function index(Request $request, Seo $seo, SitemapUrls $sitemap): Response
    {
        abort_unless($seo->indexingEnabled($request), 404);
        $pages = (int) ceil(count($sitemap->all()) / self::URLS_PER_SITEMAP);
        $urls = [];
        for ($page = 1; $page <= $pages; $page++) {
            $urls[] = $seo->url(route('seo.sitemap.page', ['page' => $page], false));
        }

        return response()->view('seo.sitemap', ['urls' => $urls, 'index' => true], 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function page(Request $request, int $page, Seo $seo, SitemapUrls $sitemap): Response
    {
        abort_unless($seo->indexingEnabled($request) && $page > 0, 404);
        $urls = array_slice($sitemap->all(), ($page - 1) * self::URLS_PER_SITEMAP, self::URLS_PER_SITEMAP);
        abort_if($urls === [], 404);

        return response()->view('seo.sitemap', ['urls' => $urls, 'index' => false], 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
