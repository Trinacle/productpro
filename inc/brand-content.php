<?php
/**
 * Brand content generator.
 *
 * Generates unique, brand-specific descriptive text and category detection
 * for each brand page, since the production brand pages are empty Astra
 * shells with no real content. Also resolves the brand's product images.
 *
 * @package ProductPro
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ---------- Detect a brand's primary category/niche from its name ---------- */
function sdn_brand_niche( $brand_name ) {
    $name = strtolower( $brand_name );
    $niches = array(
        'vibrators & toys'     => array( 'lelo', 'we-vibe', 'we vibe', 'satisfyer', 'womanizer', 'lovense', 'blush', 'dame', 'hot octopuss', 'happy rabbit', 'tenga', 'pipedream', 'cal exotics', 'calexotics', 'screaming o', 'lovehoney', 'adam & eve', 'adameve', 'wish', 'arcwave', 'satisfyer', 'romp', 'mysteryvibe', 'Fun Factory', 'fun factory', 'key', 'jopen', 'lush', 'hush', 'nova', 'osé' ),
        'lingerie & apparel'   => array( 'dreamgirl', 'leg avenue', 'coquette', 'magic silk', 'rene rofe', 'male power', 'malebasics', 'kixies', 'liberator', 'shirley of hollywood', 'elegantly_scandalous', 'intimate ammo', 'oh la la cheri', ' ella mccguire', 'secrets in lace', 'coquette', 'honey dollz', 'mapale', 'dancing' ),
        'lubricants & wellness'=> array( 'sliquid', 'pjur', 'astroglide', 'system jo', 'jo', 'intimate earth', 'coconu', 'good clean love', 'screaming o', 'wicked', 'wicked sensual', 'wet', 'id glide', 'id', 'swiss navy', 'k-y', 'ky', 'uberlube', 'uber', 'maintain', 'promescent', 'replens', 'lubricant', 'moist' ),
        'men\'s toys'          => array( 'fleshlight', 'tenga', 'pipedream', 'autoblow', 'njoy', 'doxy', 'arcwave', 'bathmate', 'pump', 'edge', 'mangasm', 'roxoff', 'lovehoney', 'satisfyer', 'manstroke', 'toys for men' ),
        'bondage & kink'       => array( 'stockroom', 'sportsheets', 'b-vibe', 'prowler', 'oxballs', 'spartacus', 'noir handmade', 'bdsm', 'kink', 'restraint', 'cuff', 'fetish', 'bondage', 'leather', 'dominix', 'master series', 'zeus', 'electro', 'satisfyer' ),
        'novelty & gifts'      => array( 'kheper games', 'what do you meme', 'knock knock', 'kushkards', 'pieBox', 'game', 'party', 'novelty', 'bachelorette', 'bachelor', 'gag', 'gift', 'kosmic', 'kheper' ),
    );

    foreach ( $niches as $niche => $keywords ) {
        foreach ( $keywords as $kw ) {
            if ( strpos( $name, strtolower( $kw ) ) !== false ) {
                return $niche;
            }
        }
    }
    // Default: derive from initials for variety
    return 'adult store';
}

/* ---------- Generate unique descriptive copy for a brand ---------- */
function sdn_brand_description( $brand_name ) {
    $niche   = sdn_brand_niche( $brand_name );
    $first   = strtok( $brand_name, ' ' );

    // Niche-specific intro sentences (varied so each brand reads uniquely)
    $intros = array(
        'vibrators & toys'     => array(
            "$brand_name is a standout in the vibrator and pleasure-toy category, known for body-safe engineering and a reputation that pulls shoppers into stores.",
            "As one of the most-requested intimacy brands on the ProductPro marketplace, $brand_name pairs premium build quality with the kind of category recognition that drives repeat sales.",
            "Retailers carrying $brand_name benefit from a brand that buyers actively search for — a proven performer across external, internal, and couples toys.",
        ),
        'lingerie & apparel'   => array(
            "$brand_name is a sought-after lingerie and intimate apparel brand carried by ProductPro, offering pieces that turn first-time browsers into loyal repeat customers.",
            "As an apparel specialist on the ProductPro marketplace, $brand_name delivers the statement pieces that anchor a boutique's display and drive impulse add-ons.",
            "$brand_name's designs are built to be photographed and shared, giving retailers products that market themselves on social and in-store.",
        ),
        'lubricants & wellness'=> array(
            "$brand_name is a premium lubricant and intimate wellness brand carried by ProductPro, offering body-safe formulas that move fast in today's market.",
            "With wellness products from $brand_name, retailers tap into one of the fastest-growing verticals — body-safe, thoughtfully formulated, and dropship-ready.",
            "$brand_name brings a thoughtfully formulated lubricant and wellness lineup to the marketplace, engineered for the customers already asking for it by name.",
        ),
        'men\'s toys'          => array(
            "$brand_name is a staple in the men's pleasure category — the high-velocity, high-margin products that every adult store restocks weekly.",
            "Carrying $brand_name means stocking the strokers, sleeves, and pumps your customers already reach for, with wholesale pricing that protects your margin.",
            "$brand_name brings decades of category heritage to the marketplace, with the consistency and brand recognition that keeps shelves turning.",
        ),
        'bondage & kink'       => array(
            "$brand_name makes the bondage and kink accessories that complete every purchase — restraints, impact toys, and cuffs that round out a basket.",
            "As a ProductPro kink partner, $brand_name delivers the high-turn essentials that lift average order value without eating shelf space.",
            "$brand_name's accessories solve the everyday desires shoppers have, which is exactly why they sell through again and again.",
        ),
        'novelty & gifts'      => array(
            "$brand_name is a go-to for adult novelty and gifts — the high-velocity, high-margin items that every adult store restocks for every party season.",
            "Carrying $brand_name means stocking the games, cards, and gag gifts your customers already reach for, with wholesale pricing that protects your margin.",
            "$brand_name brings years of novelty-category heritage to the marketplace, with the consistency and brand recognition that keeps shelves turning.",
        ),
        'adult store'          => array(
            "$brand_name is part of the ProductPro marketplace — a curated, dropship-ready catalog of the brands intimacy product shoppers already ask for.",
            "Retailers dropshipping $brand_name get instant access to a vetted supplier with automatic inventory sync and blind shipping under their own brand.",
            "$brand_name rounds out the ProductPro catalog with products built for the modern adult, intimacy, and wellness retailer.",
        ),
    );

    // Deterministic pick based on the brand name so each brand is stable + unique
    $pool     = $intros[ $niche ];
    $pick     = abs( crc32( $brand_name ) ) % count( $pool );
    $intro    = $pool[ $pick ];

    $middle = " Dropship $brand_name products with zero inventory — every order routes to the right supplier and ships blind under your brand, with real-time stock and price sync across your Shopify, WooCommerce, or BigCommerce store. Or buy at wholesale pricing with no minimum order and stock your shelves directly.";

    $close = " $brand_name is ranked among the top brands on the ProductPro network, available to retailers and wholesalers with no transaction fees and no commissions.";

    return $intro . $middle . $close;
}

/* ---------- Get up to N product image URLs for a brand ----------
 * Matches products whose title contains the brand name, then pulls their
 * featured + gallery image IDs in ONE query (no per-product wc_get_product
 * calls). Result is cached 24h via a transient so repeat visits are instant.
 * Falls back to a curated set if the brand has no products yet.
 */
function sdn_brand_gallery_images( $brand_name, $limit = 3 ) {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return sdn_brand_gallery_fallback( $limit );
    }

    $cache_key = 'sdn_brand_gallery_' . md5( $brand_name . '_' . $limit );
    $cached    = get_transient( $cache_key );
    if ( is_array( $cached ) && ! empty( $cached ) ) {
        return $cached;
    }

    global $wpdb;
    $like = '%' . $wpdb->esc_like( $brand_name ) . '%';
    // Fetch product IDs + their _thumbnail_id and _product_image_gallery meta
    // in a single joined query (avoids N+1 wc_get_product() calls).
    $rows = $wpdb->get_results( $wpdb->prepare(
        "SELECT p.ID, pm.meta_value AS thumb, pmg.meta_value AS gallery
         FROM {$wpdb->posts} p
         LEFT JOIN {$wpdb->postmeta} pm  ON pm.post_id = p.ID  AND pm.meta_key = '_thumbnail_id'
         LEFT JOIN {$wpdb->postmeta} pmg ON pmg.post_id = p.ID AND pmg.meta_key = '_product_image_gallery'
         WHERE p.post_type = 'product' AND p.post_status = 'publish'
           AND p.post_title LIKE %s
         ORDER BY p.post_date DESC
         LIMIT 12",
        $like
    ) );

    $image_ids = array();
    foreach ( $rows as $r ) {
        if ( ! empty( $r->thumb ) ) {
            $image_ids[] = (int) $r->thumb;
        }
        if ( ! empty( $r->gallery ) ) {
            foreach ( explode( ',', $r->gallery ) as $gid ) {
                $gid = (int) trim( $gid );
                if ( $gid ) $image_ids[] = $gid;
            }
        }
        $image_ids = array_values( array_unique( $image_ids ) );
        if ( count( $image_ids ) >= $limit ) break;
    }

    $images = array();
    foreach ( array_slice( $image_ids, 0, $limit ) as $aid ) {
        $url = wp_get_attachment_image_url( $aid, 'large' );
        if ( $url ) $images[] = $url;
    }

    if ( count( $images ) < $limit ) {
        $images = array_merge( $images, sdn_brand_gallery_fallback( $limit - count( $images ) ) );
    }
    $images = array_slice( array_unique( $images ), 0, $limit );

    set_transient( $cache_key, $images, DAY_IN_SECONDS );
    return $images;
}

/* ---------- Fallback product images when a brand has no Woo products ---------- */
function sdn_brand_gallery_fallback( $limit = 3 ) {
    $placeholder = function_exists( 'sdn_product_placeholder_url' ) ? sdn_product_placeholder_url() : '';
    $fallbacks = $placeholder ? array_fill( 0, $limit, $placeholder ) : array();
    return array_slice( $fallbacks, 0, $limit );
}
