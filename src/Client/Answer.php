<?php
namespace naspersclassifieds\shared\feedback\Client;

use naspersclassifieds\shared\feedback\Helper\AnswerHelper;
use Exception;

class Answer
{
    const NO_HTTP_SUPPORT_ERROR = "no support for http protocol";

    /**
     * @var AnswerHttp $httpClient
     */
    private $httpClient;

    /**
     * @var AnswerHelper $answerHelper
     */
    private $answerHelper;


    public function __construct($httpClient,$answerHelper)
    {
        $this->httpClient = $httpClient;
        $this->answerHelper = $answerHelper;
    }

    public function StoreAnswer($user_id, $survey_id, $question, $answer)
    {
        if (null === $this->httpClient) {
            throw new Exception(self::NO_HTTP_SUPPORT_ERROR);
        }

        $body = $this->answerHelper->PrepareAnswer($user_id, $survey_id, $question, $answer);
        return $this->httpClient->StoreAnswer($body);
    }

}