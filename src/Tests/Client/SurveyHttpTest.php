<?php
namespace Tests\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use naspersclassifieds\shared\feedback\Client\SurveyHttp;
use \PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;

class SurveyHttpTest extends TestCase
{


    public function testGetSurveyByRealm()
    {
        $httpClient = \Mockery::mock(HttpClient::class);
        $mockResponse = \Mockery::mock(Response::class);
        $mockResponse->shouldReceive('getStatusCode')->andReturn("200");
        $mockResponse->shouldReceive('getBody')->andReturn([]);

        $httpClient->shouldReceive('get')->andReturn($mockResponse);

        $target = new SurveyHttp($httpClient, "https","127.0.0.1", "80", "1");
        $teste = $target->GetSurveyByRealm("imovirtualpt");
        $this->assertEquals(200, $teste->getStatusCode());

    }

    public function testGetSurveyByRealmError()
    {
        $httpClient = \Mockery::mock(HttpClient::class);
        $mockResponse = \Mockery::mock(RequestException::class);
        $this->expectException(RequestException::class);
        $mockResponse->shouldReceive('getResponse')->andReturn(null);

        $httpClient->shouldReceive('get')->andThrow($mockResponse);

        $target = new SurveyHttp($httpClient, "https","127.0.0.1", "80", null);
        $target->GetSurveyByRealm(null);

    }

    public function testGetSurveyById()
    {
        $httpClient = \Mockery::mock(HttpClient::class);
        $mockResponse = \Mockery::mock(Response::class);
        $mockResponse->shouldReceive('getStatusCode')->andReturn("200");
        $mockResponse->shouldReceive('getBody')->andReturn([]);

        $httpClient->shouldReceive('get')->andReturn($mockResponse);

        $target = new SurveyHttp($httpClient, "https","127.0.0.1", "80", "1");
        $teste = $target->GetSurveyById("imovirtualpt",1);
        $this->assertEquals(200, $teste->getStatusCode());

    }

    public function testGetSurveyByIdError()
    {
        $httpClient = \Mockery::mock(HttpClient::class);
        $mockResponse = \Mockery::mock(RequestException::class);
        $this->expectException(RequestException::class);
        $mockResponse->shouldReceive('getResponse')->andReturn(null);

        $httpClient->shouldReceive('get')->andThrow($mockResponse);

        $target = new SurveyHttp($httpClient, "https","127.0.0.1", "80", null);
        $target->GetSurveyById("imovirtualpt",1);

    }

}