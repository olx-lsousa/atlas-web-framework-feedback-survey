<?php
namespace Tests\Client;

use \naspersclassifieds\shared\feedback\Helper\AnswerHelper;
use \naspersclassifieds\shared\feedback\Client\AnswerHttp;
use \naspersclassifieds\shared\feedback\Client\Answer;
use \PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{

    public function testPostAnswer()
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

        $answerHelper = \Mockery::mock(AnswerHelper::class);
        $answerHttp = \Mockery::mock(AnswerHttp::class);
        $answerHelper->shouldReceive('PrepareAnswer')->with(
            "1",
            "2",
            "pergunta 1",
            "resposta 2"
        )->andReturn($expected);

        $answerHttp->shouldReceive('StoreAnswer')->andReturn(json_encode($expected));

        $target = new Answer($answerHttp, $answerHelper);
        $reply = $target->StoreAnswer("1", "2", "pergunta 1", "resposta 2");
        $this->assertEquals(json_encode($expected), $reply);
    }

    public function testGetAllSurveysErrorWithoutHttpClient()
    {
        $this->expectException(\Exception::class);
        $answerHttp = \Mockery::mock(AnswerHttp::class);
        $target = new Answer(null, $answerHttp);
        var_dump($target->StoreAnswer("1", "2", "pergunta 1", "resposta 2"));exit;
    }


}