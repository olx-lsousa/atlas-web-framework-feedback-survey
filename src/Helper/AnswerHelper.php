<?php
namespace naspersclassifieds\shared\feedback\Helper;

class AnswerHelper
{

    public function PrepareAnswer($user_id, $survey_id, $question, $answer)
    {
        if(empty($user_id)||empty($survey_id)||empty($question)||empty($answer)){
            throw new \Exception("Missing required values");
        }

        return [
        "user_id"=> $user_id,
            "survey_id"=> $survey_id,
            "replies"=> [
                [
                    "question"=> $question,
                    "answer"=> $answer
                ]
            ]
        ];
    }
}