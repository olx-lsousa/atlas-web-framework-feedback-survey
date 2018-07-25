<?php
namespace Tests\Client;

use \naspersclassifieds\shared\feedback\Helper\AnswerHelper;
use \naspersclassifieds\shared\feedback\Client\AnswerHttp;
use \naspersclassifieds\shared\feedback\Client\Answer;
use \PHPUnit\Framework\TestCase;

class AnswerHelperTest extends TestCase
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

        $target = new AnswerHelper();
        $reply = $target->PrepareAnswer("1", "2", "pergunta 1", "resposta 2");
        $this->assertEquals($expected, $reply);
    }

    public function testGetAllSurveysErrorWithoutHttpClient()
    {
        $this->expectException(\Exception::class);
        $target = new AnswerHelper();
        var_dump($target->PrepareAnswer(null, "2", "pergunta 1", "resposta 2"));exit;
    }

}