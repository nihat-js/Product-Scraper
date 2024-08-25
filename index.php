<?php

$command = 'node scrape.js';

$output = shell_exec($command);

if ($output === null) {
  die("Error executing Puppeteer script.");
}

$products = json_decode($output, true);

if (json_last_error() !== JSON_ERROR_NONE) {
  die("JSON decoding error: " . json_last_error_msg());
}

foreach ($products as $product) {
  echo "Title: " . htmlspecialchars($product['title']) . "<br>";
  echo "Price: " . htmlspecialchars($product['price']) . "<br>";
  echo "Link: <a href='https://www.trendyol.com" . htmlspecialchars($product['link']) . "'>Product Link</a><br>";
  echo "Image: <img src='" . htmlspecialchars($product['image']) . "' alt='Product Image'><br><br>";
}
