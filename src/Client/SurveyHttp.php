<?php
namespace naspersclassifieds\shared\feedback\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class SurveyHttp
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
     * @param $token
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
    public function getGuzzleUserAgent()
    {
        return \GuzzleHttp\default_user_agent();
    }

    public function GetSurveyById($realm, $identifier) {
        $uri = sprintf(
            "%s/survey/%s/%s",
            $this->buildBaseUri(),
            $realm,
            $identifier);
        try {
            $this->getLogger()->debug(sprintf("Request GET %s", $uri));
            $response = $this->httpClient->get($uri, [
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::HEADERS => $this->getDefaultRequestHeaders(),
                RequestOptions::TIMEOUT => $this->timeout,
            ]);
            return new Response($response->getStatusCode(), $response->getBody());
        } catch (RequestException $e) {
            $this->getLogger()->error(sprintf("Fail GET %s with: %s", $uri, $e->getCode()));
            $this->getLogger()->info($e->getTraceAsString());
            if (!is_null($e->getResponse())) {
                return new Response($e->getResponse()->getStatusCode(), $e->getResponse()->getBody());
            }
            throw $e;
        }
    }

    public function GetSurveyByRealm($realm) {
        $uri = sprintf(
            "%s/survey/%s",
            $this->buildBaseUri(),
            $realm
        );
        try {
            $this->getLogger()->debug(sprintf("Request GET %s", $uri));
            $response = $this->httpClient->get($uri, [
                RequestOptions::HTTP_ERRORS => false,
                RequestOptions::HEADERS => $this->getDefaultRequestHeaders(),
                RequestOptions::TIMEOUT => $this->timeout,
            ]);
            return new Response($response->getStatusCode(), $response->getBody());
        } catch (RequestException $e) {
            $this->getLogger()->error(sprintf("Fail GET %s with: %s", $uri, $e->getCode()));
            $this->getLogger()->info($e->getTraceAsString());
            if (!is_null($e->getResponse())) {
                return new Response($e->getResponse()->getStatusCode(), $e->getResponse()->getBody());
            }
            throw $e;
        }
    }

}