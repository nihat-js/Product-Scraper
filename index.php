<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.trendyol.com/erkek-t-shirt-x-g2-c73");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

$html = curl_exec($ch);

if ($html == false) {
  echo 'cURL error' . curl_error($ch);
}


$dom = new DOMDocument();
@$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
libxml_use_internal_errors(true); // Suppress warnings for invalid HTML
$xpath = new DOMXPath($dom);
libxml_clear_errors();


// echo $html;

$productXPath = '//div[contains(@class, "p-card-wrppr")]'; // Adjust XPath based on actual HTML
$imageXPath = './/img[@class="p-card-img"]/@src'; // Adjust based on actual HTML
$titleXPath = './/h2[@class="product-title"]'; // Adjust based on actual HTML
$ratingXPath = './/span[@class="product-rating"]'; // Adjust based on actual HTML
$ratingCountXPath = './/span[@class="rating-count"]'; // Adjust based on actual HTML
$priceXPath = './/span[@class="prc-box-dscntd"]'; // Adjust based on actual HTML

// Extract products
$products = [];
$productNodes = $xpath->query($productXPath);

foreach ($productNodes as $productNode) {
  $image = $xpath->query($imageXPath, $productNode)->item(0)->nodeValue ?? 'No image';
  $title = $xpath->query($titleXPath, $productNode)->item(0)->nodeValue ?? 'No title';
  $rating = $xpath->query($ratingXPath, $productNode)->item(0)->nodeValue ?? 'No rating';
  $ratingCount = $xpath->query($ratingCountXPath, $productNode)->item(0)->nodeValue ?? 'No rating count';
  $price = $xpath->query($priceXPath, $productNode)->item(0)->nodeValue ?? 'No price';

  $products[] = [
    'image' => $image,
    'title' => $title,
    'rating' => $rating,
    'rating_count' => $ratingCount,
    'price' => $price,
  ];
}


// Output the extracted products
echo "<pre>";
print_r($products);
echo "</pre>";



// var_dump($response);