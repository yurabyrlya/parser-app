<?php
declare(strict_types=1);

namespace App\Services\Parser;

/**
 * Simple ACME demo site parser to extract
 * all the product options on the page.
 */
class ACMEParser extends SiteParser
{
    /**
     * Parse product list from site
     * @return array
     */
    public function getProductList(): array {
        $products = [];

        try {
            echo '++++++++++++ Parsing successfully started +++++++++++++'.PHP_EOL;
            $subscriptions = $this->getDocument()->find('.row-subscriptions');
            if (!count($subscriptions)) {
                echo 'Failed to find subscriptions section';
                return [];
            }
            $product = [];
            foreach ($subscriptions as $i => $subscribeSection) {
                $i++; // because of 0 index
                $this->delay((string) $i);

                $productsDocument = $subscribeSection->find('.col-xs-4, .col-cs-4 ');
                if (!count($productsDocument)) {
                    echo 'Failed to find product options section';
                }
                foreach ($productsDocument as $k => $productEl) {
                    $k++;
                    $this->delay($i.'.'.$k);

                    $titleEl = $productEl->first('.header h3');
                    $descriptionEl = $productEl->first('.package-name');
                    $priceEl = $productEl->first('.package-price span.price-big');
                    $discountEl = $productEl->first('.package-price p');


                    $product['option_title'] = $titleEl ? $titleEl->text(): '';
                    $product['description'] = $descriptionEl ? $descriptionEl->text(): '';
                    $product['price'] = $priceEl ? explode('£', $priceEl->text())[1] : 0;;
                    $product['discount'] = $discountEl ? $discountEl->text() : '';;

                    $products[] = $product;
                }

            }

            $products = $this->oderByPrice($products);
            echo '++++++++++++ Parsing successfully finished +++++++++++++'.PHP_EOL;

        } catch (\Exception $e) {
            echo 'failed to parse with message: '. $e->getMessage();
        }

        return $products;
    }

    /**
     * @param array $products
     * @return array
     */
    public function oderByPrice(array $products): array {
        usort($products, function ($product, $nextProduct) {
            return ((double) $product['price'] > (double)$nextProduct['price']) ? -1 : 1;
        });
        return $products;
    }

    /**
     * @param string $content
     * @param string $fileName
     * @return void
     */
    public function saveToFile(string $content, string $fileName = 'products.json'): void{
        $file = fopen($fileName, "w") or die("Unable to open file!");
        fwrite($file, $content);
        fclose($file);
        echo "product list stored to: $fileName file";
    }
}