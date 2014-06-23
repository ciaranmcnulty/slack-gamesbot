<?php

use Behat\Behat\Context\Context;

class FeatureContext implements Context
{
    private $response;

    /**
     * @When I type the text :text in the :channel channel
     */
    public function iTypeTheTextInTheChannel($text, $channel)
    {
        $query = http_build_query(['text'=>$text]);
        $command = 'curl -s -X POST -d '.escapeshellarg($query).' http://localhost:8000/game-search';

        $this->response = json_decode(shell_exec($command));
    }

    /**
     * @Then The username :username should reply
     */
    public function theUsernameShouldReply($username)
    {
       if( $this->response->username != $username) {
           throw new Exception('Username does not match expected value ' . $username);
       }
    }

    /**
     * @Then The message should be :message
     */
    public function theMessageShouldBe($message)
    {
        if( $this->response->text != $message) {
            throw new Exception('Username does not match expected value ' . $username);
        }
    }
}
