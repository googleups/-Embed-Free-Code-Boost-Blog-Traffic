<?php
$rss = simplexml_load_file("https://omnibestseller.com/feed/");
$items = [];

foreach ($rss->channel->item as $item) {
    $content = (string)$item->children("http://purl.org/rss/1.0/modules/content/")->encoded;

    // Get first image
    preg_match('/<img[^>]+src="([^"]+)"/i', $content, $match);
    $image = isset($match[1]) ? $match[1] : '';

    $items[] = [
        'title' => (string)$item->title,
        'link' => (string)$item->link,
        'image' => $image
    ];
}

shuffle($items);
$randomPosts = array_slice($items, 0, 5);
?>

<style>
.omni-container { max-width:1000px; margin:30px auto; padding:20px; background:#f3f3f3; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); font-family:Arial,sans-serif; }
.omni-header { text-align:center; font-size:22px; font-weight:bold; color:#232f3e; margin-bottom:20px; }
.omni-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:20px; }
.omni-card { background:white; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.12); transition:transform 0.2s ease; text-align:center; border:1px solid #ddd; }
.omni-card:hover { transform:translateY(-5px); box-shadow:0 4px 15px rgba(0,0,0,0.2); }
.omni-card img { width:100%; height:180px; object-fit:contain; background:#fff; }
.omni-card a { display:block; padding:10px; font-size:15px; font-weight:bold; color:#007185; text-decoration:none; }
.omni-card a:hover { color:#c45500; }
</style>

<div class="omni-container">
    <div class="omni-header">Amazon Best Seller by OmniBestSeller.com</div>
    <div class="omni-grid">
        <?php foreach ($randomPosts as $p): ?>
            <div class="omni-card">
                <?php if ($p['image']): ?>
                    <a href="<?php echo $p['link']; ?>" target="_blank">
                        <img src="<?php echo $p['image']; ?>" alt="">
                    </a>
                <?php endif; ?>
                <a href="<?php echo $p['link']; ?>" target="_blank"><?php echo $p['title']; ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</div>