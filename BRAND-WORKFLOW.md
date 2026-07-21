# ProductPro Brand Workflow

## How to add a new brand (or update an existing one)

### Step 1: Add logo image
Place the logo file in `assets/img/` named exactly **`{brandname}.png`** (or `.webp`).

Examples:
- `assets/img/LELO.png`
- `assets/img/We-Vibe.png`
- `assets/img/Sportsheets.png`

**Naming convention:** Match the brand name as it appears in the directory. Spaces and capitalization are fine — the system handles slug conversion automatically.

### Step 2: Add product/hero image (optional but recommended)
Place ONE product/lifestyle image in `assets/img/` named **`{brandname}_wholesale_dropship.png`**

This image shows on the brand page as "Image 1" (hero area). Ideal sources:
- Brand's Instagram (real lifestyle product photo)
- AI-generated product image
- Supplier's product catalog photo

Examples:
- `assets/img/LELO_wholesale_dropship.png`
- `assets/img/We-Vibe_wholesale_dropship.png`

### Step 3: Register in the brand directory
Add the brand to `inc/brand-directory.php` in the `sdn_brand_directory()` array:
```php
array( 'name' => 'Brand Name', 'slug' => 'brand-name', 'initials' => 'BN', 'value' => 7 ),
```

If updating an existing brand (adding a logo), no directory change needed — just add the image file.

### Step 4: Register the logo + product image in the theme
Add entries to the `$logos` array in `sdn_theme_brand_logo()` (inc/helpers.php):
```php
'brand-name' => 'Brand Name.png',           // logo
```

And add to `sdn_theme_brand_image()` (inc/helpers.php) for product images:
```php
'brand-name' => 'Brand Name_wholesale_dropship.png',
```

### Step 5: Write the brand description
Brand descriptions are auto-generated from `sdn_brand_description()` in `inc/brand-content.php`. For real, brand-specific descriptions:
- Create a WordPress brand CPT post at `/wp-admin/post-new.php?post_type=brand`
- Set the title to the brand name
- Paste the real description in the content editor (with headings, bullet points)
- The brand page will use this instead of the auto-generated text

### Step 6: Commit and deploy
```bash
cd C:\Users\kevin\ZCodeProject\productpro-theme
git add -A
git commit -m "Add brand: {Brand Name} logo + product image"
git push origin main
```
The auto-deploy pushes it live in ~60 seconds.

---

## Quick reference: File naming

| File | Purpose | Example |
|------|---------|---------|
| `{BrandName}.png` | Brand logo (shows in directory, mega menu, brand page) | `LELO.png` |
| `{BrandName}.webp` | Same as above (alternative format) | `Blush.webp` |
| `{BrandName}_wholesale_dropship.png` | Product/lifestyle photo (shows as Image 1 on brand page) | `LELO_wholesale_dropship.png` |

## Where each image shows up

| Location | Logo | Product image |
|----------|------|---------------|
| `/brands/` directory grid | ✅ | ❌ |
| Homepage logo carousel | ✅ | ❌ |
| Header mega menu | ❌ (text links) | ❌ |
| `/brand/{slug}/` page (logo spot) | ✅ | ❌ |
| `/brand/{slug}/` page (Image 1 hero) | ❌ | ✅ |
| Footer brand links | ❌ (text links) | ❌ |

## Bulk adding brands

To add many brands at once:
1. Drop all logo files into `assets/img/`
2. Drop all product images into `assets/img/`
3. Run the scan script: `php scan-brand-images.php` (generates the PHP arrays for you)
4. Paste the output into `sdn_theme_brand_logo()` and `sdn_theme_brand_image()`
5. Commit + push
