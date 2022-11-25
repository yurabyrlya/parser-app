<?php
declare(strict_types=1);

namespace App\Services\Parser;

use DiDom\Document;

/**
 * Abstract SiteParser class for Parser services
 */
abstract class SiteParser implements ParserInterface
{

    /**
     * @var Document
     */
    private Document $document;

    /**
     * @var string
     */
    private string $url;

    /**
     * add delay in sec between requests to remote server
     * @var int
     */
    public static int $delay = 1;


    /**
     * initialize parser with site location
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->url = $url;
        $this->document = new Document($url, true);

    }

    /**
     * @return Document
     */
    public function getDocument(): Document
    {
        return $this->document;
    }


    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * add url to document parser
     * @param string $url
     * @return SiteParser
     */
    public function setUrl(string $url): self
    {
        try {
            $this->document->loadHtmlFile($url);
            $this->url = $url;
        } catch (\Exception $e){
            echo $e->getMessage() .PHP_EOL;
        }
        return $this;
    }


    /**
     * Abstract method to parse array to json string value
     * it return null when method was failed to encode data
     * and valid string json when success
     * @see https://www.php.net/manual/en/function.json-encode.php
     * @inheritDoc
     */
    public function toJson(array $data): ?string
    {
        try {
            $json = json_encode($data);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return null;
        }
        return $json;
    }

    /**
     * This method helps us to prevent the client from being blocked by a remote server
     * like DDOS attack or too many requests in a short amount of period which
     * might case that remote server goes down
     * @param string $sectionIndex
     * @return void
     */
    protected function delay(string $sectionIndex): void {
        echo "Parsing product section: $sectionIndex" . PHP_EOL;
        if (self::$delay){
            sleep(self::$delay);
        }
    }
}