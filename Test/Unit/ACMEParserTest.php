<?php
declare(strict_types=1);

namespace App\Test\Unit;

use App\Services\Parser\SiteParser;
use PHPUnit\Framework\TestCase;
use App\Services\Parser\ACMEParser;

class ACMEParserTest extends TestCase
{
    /**
     * @var ACMEParser
     */
    private ACMEParser $parser;
    /**
     * @var string
     */
    private string $url;

    /**
     * @return void
     */
    protected function setUp(): void {
        $this->url = 'https://wltest.dns-systems.net';
        $this->parser = new ACMEParser($this->url);
        SiteParser::$delay = 0; // disable timeout for testing
    }

    /**
     * test parsing product list method
     * @return void
     */
    public function testGetProductList() {
        $products = $this->parser->getProductList();
        $this->assertNotEmpty($products, 'Product list is empty');

        // test with invalid url
        $this->parser->setUrl('https://wltest.dns-systems1.net');
        $this->assertEquals(
            $this->url,
            $this->parser->getUrl(),
            'URL is not equal'
        );
        //second test case to check if the url wasn't ben updated with invalid one
        $products = $this->parser->getProductList();
        $this->assertNotEmpty($products,'Product is empty');

    }

    /**
     *
     * @return void
     */
    public function testOderByPrice() {
        $products = $this->parser->getProductList();
        $ordered = $this->parser->oderByPrice($products);
        $this->assertTrue($ordered[0]['price'] > $ordered[1]['price'], 'price is not ordered correctly');
    }

    /**
     * test save file method
     * @return void
     */
    public function testSaveFile() {
        $this->assertFileExists('products.json');
    }
}