<?php
namespace Tests\Client;

use naspersclassifieds\shared\feedback\Client\Survey;
use naspersclassifieds\shared\feedback\Client\SurveyHttp;
use \PHPUnit\Framework\TestCase;

class SurveyTest extends TestCase
{

    public function testGetAllAnswers()
    {
        $expected = [
            [
      "identifier"=> "1",
    "title"=> "PT Sample",
    "realm"=> "imovirtual",
    "language"=> "pt",
    "questions"=> [
          "question"=> "Did you like it?",
        "answers"=> [
          "Yes",
          "No!"
      ]
    ]
  ],
[
      "identifier"=> "2",
    "title"=> "PT Sample",
    "realm"=> "imovirtual",
    "language"=> "pt",
    "questions"=> [
          "question"=> "Did you like it?",
        "answers"=> [
          "Yes",
          "No!"
      ]

    ]
]
];

        $surveyHttp = \Mockery::mock(SurveyHttp::class);
        $surveyHttp->shouldReceive('GetSurveyByRealm')->with("imovirtualpt")->andReturn(json_encode($expected));

        $target = new Survey($surveyHttp);
        $reply = $target->getAllSurveys("imovirtualpt");
        $this->assertEquals(json_encode($expected), $reply);
    }

    public function testGetAllSurveysErrorWithoutRealm()
    {
        $this->expectException(\Exception::class);
        $surveyHttp = \Mockery::mock(SurveyHttp::class);

        $target = new Survey($surveyHttp);
        var_dump($target->getAllSurveys(null));exit;
    }

    public function testGetAllSurveysErrorWithoutHttpClient()
    {
        $this->expectException(\Exception::class);

        $target = new Survey(null);
        var_dump($target->getAllSurveys(null));exit;
    }

    public function testAnswerByid()
    {
        $expected = [
            "identifier"=> "1",
            "title"=> "PT Sample",
            "realm"=> "imovirtual",
            "language"=> "pt",
            "questions"=> [
                [
                    "question"=> "Did you like it?",
                    "answers"=> [
                        "Yes",
                        "No!"
                    ]
                ]
            ]
        ];

        $surveyHttp = \Mockery::mock(SurveyHttp::class);
        $surveyHttp->shouldReceive('GetSurveyById')->with("imovirtualpt","1")->andReturn(json_encode($expected));

        $target = new Survey($surveyHttp);
        $reply = $target->getSurveyById("imovirtualpt","1");
        $this->assertEquals(json_encode($expected), $reply);
    }

    public function testGetSurveyByIdErrorWithoutRealm()
    {
        $this->expectException(\Exception::class);
        $surveyHttp = \Mockery::mock(SurveyHttp::class);

        $target = new Survey($surveyHttp);
        var_dump($target->getSurveyById(null,1));exit;
    }

    public function testGetSurveyByIdErrorWithoutHttpClient()
    {
        $this->expectException(\Exception::class);

        $target = new Survey(null);
        var_dump($target->getSurveyById(null,1));exit;
    }

}