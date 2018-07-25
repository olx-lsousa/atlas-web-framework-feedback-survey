<?php
namespace naspersclassifieds\shared\feedback\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class AnswerHttp
{
    const VERSION = 'v1.0';
    const API_VERSION_V1 = 'feedback';
    const API_URI_SUFFIX = 'api';


    /**
     * @var HttpClient
     */
    private $httpClient;
    /**
     * @var string $protocol
     */
    private $protocol;
    /**
     * @var string $host
     */
    private $host;
    /**
     * @var int $port
     */
    private $port;
    /**
     * @var float $timeout
     */
    private $timeout;

    /**
     * @var LoggerInterface $logger
     */
    private $logger;

    /**
     * AlertClient constructor.
     * @param HttpClient $httpClient
     * @param $protocol
     * @param $host
     * @param $port
     * @param $timeout
     */
    public function __construct(HttpClient $httpClient, $protocol, $host, $port, $timeout)
    {
        $this->logger = new NullLogger();
        $this->httpClient = $httpClient;
        $this->protocol = $protocol;
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return Survey
     */
    public function setLogger(LoggerInterface $logger): Survey
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @return string
     */
    private function buildBaseUri() {
        return sprintf(
            "%s://%s:%s/%s/%s",
            $this->protocol,
            $this->host,
            $this->port,
            self::API_URI_SUFFIX,
            self::API_VERSION_V1
        );
    }
    /**
     * @return array
     */
    private function getDefaultRequestHeaders()
    {
        return [
            'User-Agent' => sprintf('FeedbackClientPHP/%s %s', self::VERSION, $this->getGuzzleUserAgent()),
        ];
    }
    /**
     * @return string
     */
    private function getGuzzleUserAgent()
    {
        return \GuzzleHttp\default_user_agent();
    }

    public function StoreAnswer($answer) {
        $uri = sprintf(
            "%s/reply/",
            $this->buildBaseUri());
        try {
            $this->getLogger()->debug(sprintf("Request POST %s", $uri));
            $response = $this->httpClient->post($uri, [
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::HEADERS => $this->getDefaultRequestHeaders(),
                RequestOptions::BODY => json_encode($answer),
                RequestOptions::TIMEOUT => $this->timeout
            ]);
            return new Response($response->getStatusCode(), $response->getBody());
        } catch (RequestException $e) {
            $this->getLogger()->error(sprintf("Fail POST %s with: %s", $uri, $e->getCode()));
            $this->getLogger()->info($e->getTraceAsString());
            if (null !== $e->getResponse()) {
                return new Response($e->getResponse()->getStatusCode(), $e->getResponse()->getBody());
            }
            throw $e;
        }
    }

}