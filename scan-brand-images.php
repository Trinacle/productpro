<?php
/**
 * Scans assets/img/ for brand logo and product image files, and generates
 * the PHP array entries for sdn_theme_brand_logo() and sdn_theme_brand_image().
 *
 * Usage: php scan-brand-images.php
 * Then paste the output into inc/helpers.php
 *
 * File naming convention:
 *   Logo:    {BrandName}.png  or  {BrandName}.webp
 *   Product: {BrandName}_wholesale_dropship.png
 */

$dir = __DIR__ . '/assets/img';
$files = scandir( $dir );

$logos = array();
$products = array();

foreach ( $files as $f ) {
    if ( $f === '.' || $f === '..' || $f === 'no-product.svg' ) continue;
    if ( strpos( $f, '_wholesale_dropship' ) !== false ) {
        // Product image
        $brand = str_replace( '_wholesale_dropship', '', $f );
        // Remove extension
        $brand = preg_replace( '/\.(png|jpg|jpeg|webp)$/i', '', $brand );
        $slug = strtolower( preg_replace( '/[^a-z0-9]+/i', '-', $brand ) );
        $slug = trim( $slug, '-' );
        $products[ $slug ] = $f;
    } else {
        // Logo
        $brand = preg_replace( '/\.(png|jpg|jpeg|webp)$/i', '', $f );
        $slug = strtolower( preg_replace( '/[^a-z0-9]+/i', '-', $brand ) );
        $slug = trim( $slug, '-' );
        // Skip platform logos
        if ( strpos( $f, 'shopify-logo' ) !== false || strpos( $f, 'woocommerce-logo' ) !== false || strpos( $f, 'bigcommerce-logo' ) !== false ) continue;
        $logos[ $slug ] = $f;
    }
}

echo "=== PASTE THIS into sdn_theme_brand_logo() ===\n\n";
ksort( $logos );
foreach ( $logos as $slug => $file ) {
    echo "        '$slug' => '$file',\n";
}

echo "\n=== PASTE THIS into sdn_theme_brand_image() ===\n\n";
ksort( $products );
foreach ( $products as $slug => $file ) {
    echo "        '$slug' => '$file',\n";
}

echo "\n=== Summary ===\n";
echo count( $logos ) . " logos, " . count( $products ) . " product images\n";
