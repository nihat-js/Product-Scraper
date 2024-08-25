<?php

use PHPUnit\Framework\TestCase;

class ScrapeTest extends TestCase
{
  private $command = 'node scrape.js';

  public function testScriptExecution()
  {
    $output = shell_exec($this->command);
    $this->assertNotNull($output, "Puppeteer script did not execute or produced no output.");
  }

  public function testJsonParsing()
  {
    $output = shell_exec($this->command);

    $this->assertJson($output, "Output is not valid JSON.");

    $products = json_decode($output, true);
    $this->assertIsArray($products, "Decoded JSON is not an array.");

    if (!empty($products)) {
      $this->assertArrayHasKey('title', $products[0], "Product item does not have 'title' key.");
      $this->assertArrayHasKey('price', $products[0], "Product item does not have 'price' key.");
      $this->assertArrayHasKey('link', $products[0], "Product item does not have 'link' key.");
      $this->assertArrayHasKey('image', $products[0], "Product item does not have 'image' key.");
    }
  }

  public function testHtmlOutput()
  {
    $output = shell_exec($this->command);
    $products = json_decode($output, true);

    $html = '';
    foreach ($products as $product) {
      $html .= "Title: " . htmlspecialchars($product['title']) . "<br>";
      $html .= "Price: " . htmlspecialchars($product['price']) . "<br>";
      $html .= "Link: <a href='https://www.trendyol.com" . htmlspecialchars($product['link']) . "'>Product Link</a><br>";
      $html .= "Image: <img src='" . htmlspecialchars($product['image']) . "' alt='Product Image'><br><br>";
    }

    $this->assertStringContainsString('<br>', $html, "HTML output does not contain expected line breaks.");
    $this->assertStringContainsString('<a href=', $html, "HTML output does not contain product links.");
    $this->assertStringContainsString('<img src=', $html, "HTML output does not contain product images.");
  }
}
