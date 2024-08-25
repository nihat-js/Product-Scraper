const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.goto('https://www.trendyol.com/erkek-t-shirt-x-g2-c73', { waitUntil: 'networkidle2' });

  // Wait for the products to load
  await page.waitForSelector('.p-card-chldrn-cntnr');

  // Extract product details
  const products = await page.evaluate(() => {
    const items = Array.from(document.querySelectorAll('.p-card-chldrn-cntnr'));
    return items.map(item => {
      const link = item.querySelector('a').getAttribute('href');
      const image = item.querySelector('img.p-card-img').getAttribute('src');
      const title = item.querySelector('.prdct-desc-cntnr-ttl').textContent.trim();
      const price = item.querySelector('.prc-box-dscntd') ? item.querySelector('.prc-box-dscntd').textContent.trim() : 'N/A';
      return {
        link,
        image,
        title,
        price
      };
    });
  });

  // Output results as JSON
  console.log(JSON.stringify(products));

  await browser.close();
})();
