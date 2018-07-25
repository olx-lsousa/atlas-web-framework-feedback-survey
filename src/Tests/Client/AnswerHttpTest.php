<?php
namespace Tests\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use \naspersclassifieds\shared\feedback\Client\AnswerHttp;
use \PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class AnswerHttpTest extends TestCase
{
    public function testGetSurveyByRealm()
    {
        $expected = [
            "user_id"=> "1",
            "survey_id"=> "2",
            "replies"=> [
                [
                    "question"=> "pergunta 1",
                    "answer"=> "resposta 2"
                ]
            ]
        ];
        $httpClient = \Mockery::mock(HttpClient::class);
        $mockResponse = \Mockery::mock(Response::class);
        $mockResponse->shouldReceive('getStatusCode')->andReturn("201");
        $mockResponse->shouldReceive('getBody')->andReturn([]);

        $httpClient->shouldReceive('post')->andReturn($mockResponse);

        $target = new AnswerHttp($httpClient, "https","127.0.0.1", "80", "1");
        $teste = $target->StoreAnswer(json_encode($expected));
        $this->assertEquals(201, $teste->getStatusCode());

    }

    public function testGetSurveyByIdError()
    {
        $expected = [
            "user_id"=> "1",
            "survey_id"=> "2",
            "replies"=> [
                [
                    "question"=> "pergunta 1",
                    "answer"=> "resposta 2"
                ]
            ]
        ];
        $httpClient = \Mockery::mock(HttpClient::class);
        $mockResponse = \Mockery::mock(RequestException::class);
        $this->expectException(RequestException::class);
        $mockResponse->shouldReceive('getResponse')->andReturn(null);

        $httpClient->shouldReceive('post')->andThrow($mockResponse);

        $target = new AnswerHttp($httpClient, "https","127.0.0.1", "80", null);
        $target->StoreAnswer(json_encode($expected));

    }

}