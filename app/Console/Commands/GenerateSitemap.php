<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use samdark\sitemap\Sitemap;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle()
    {
        $sitemapPath = public_path('sitemap.xml');
        $sitemap = new Sitemap($sitemapPath);

        // Add URLs to the sitemap
        foreach(config('constants.SITEMAP_PAGES') as $route=>$page){
            $sitemap->addItem(route($route), time());
        }
        // $sitemap->addItem(route('home'), time());
        // $sitemap->addItem(route('about'), time());
        // $sitemap->addItem(route('products'), time());
        // $sitemap->addItem(route('blogs'), time());
        // $sitemap->addItem(route('faqs'), time());
        // $sitemap->addItem(route('contact'), time());
        // $sitemap->addItem(route('shipping.policy'), time());
        // $sitemap->addItem(route('terms'), time());
        // $sitemap->addItem(route('privacy'), time());
        // $sitemap->addItem(route('cookie.policy'), time());
        // $sitemap->addItem(route('refund.policy'), time());
        // $sitemap->addItem(route('disclaimer'), time());
        // $sitemap->addItem(route('cart'), time());
        // $sitemap->addItem(route('checkout'), time());
        // $sitemap->addItem(route('wishlist'), time());
        // $sitemap->addItem(route('register'), time());
        // $sitemap->addItem(route('login'), time());

 
        $products = \App\Models\Product::where('status',1)->get();
        foreach ($products as $product) {
            $sitemap->addItem(route('product', $product->slug), $product->updated_at->timestamp, Sitemap::WEEKLY, 0.9);
        }

        $blogs = \App\Models\Blog::where('status',1)->get();
        foreach ($blogs as $blog) {
            $sitemap->addItem(route('blog', $blog->slug), $blog->updated_at->timestamp, Sitemap::WEEKLY, 0.9);
        }
 
        $pages = \App\Models\Page::where('status',1)->get();
        foreach ($pages as $page) {
            $sitemap->addItem(route('page', $page->slug), $page->updated_at->timestamp, Sitemap::WEEKLY, 0.9);
        }
 
        $categories = \App\Models\Category::where('status', 1)->get();
        foreach ($categories as $category) {
            $sitemap->addItem(route('category', $category->slug), time());
        }

        // Write the sitemap file
        $sitemap->write();

        $this->info('Sitemap generated successfully at ' . $sitemapPath);
        return 0;
    }
}
