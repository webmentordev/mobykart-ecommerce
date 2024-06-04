<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>2024-06-03T13:48:00+05:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.00</priority>
    </url>
    <url>
        <loc>{{ url('/') }}/products</loc>
        <lastmod>2024-06-03T13:48:00+05:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1.00</priority>
    </url>

    <url>
        <loc>{{ url('/') }}/cart</loc>
        <lastmod>2024-06-03T13:48:00+05:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.90</priority>
    </url>

    <url>
        <loc>{{ url('/') }}/contact</loc>
        <lastmod>2024-06-03T13:48:00+05:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.90</priority>
    </url>

    <url>
        <loc>{{ url('/') }}/terms-of-service</loc>
        <lastmod>2024-06-03T13:48:00+05:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.90</priority>
    </url>

    <url>
        <loc>{{ url('/') }}/privacy-policy</loc>
        <lastmod>2024-06-03T13:48:00+05:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.90</priority>
    </url>

    <url>
        <loc>{{ url('/') }}/return-policy</loc>
        <lastmod>2024-06-03T13:48:00+05:00</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.90</priority>
    </url>

    <url>
        <loc>{{ url('/') }}/track-order</loc>
        <lastmod>2024-06-03T13:48:00+05:00</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.90</priority>
    </url>
    @foreach ($products as $product)
        <url>
            <loc>{{ url('/') }}/product/{{ $product->slug }}</loc>
            <lastmod>{{ $product->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.90</priority>
        </url>
    @endforeach
</urlset>