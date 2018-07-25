<?php
namespace naspersclassifieds\shared\feedback\Client;

use Exception;


class Survey
{
    const NO_HTTP_SUPPORT_ERROR = "no support for http protocol";

    /**
     * @var SurveyHttp $httpClient
     */
    private $httpClient;


    public function __construct($httpClient)
    {
        $this->httpClient = $httpClient;
    }


    public function getAllSurveys($realm)
    {
        if (is_null($this->httpClient)) {
            throw new Exception(self::NO_HTTP_SUPPORT_ERROR);
        }

        if (empty($realm)) {
            throw new Exception("Required fields missing");
        }

        return $this->httpClient->GetSurveyByRealm($realm);
    }

    public function getSurveyById($realm, $id)
    {
        if (is_null($this->httpClient)) {
            throw new Exception(self::NO_HTTP_SUPPORT_ERROR);
        }

        if (empty($realm) || empty($id)) {
            throw new Exception("Required fields missing");
        }

        return $this->httpClient->GetSurveyById($realm, $id);
    }


    
}