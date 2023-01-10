<?php

namespace paterni\Structural\Adapter\RealExample;

/**
 * The Adapter is some useful class, incompatible with the Target interface. You
 * can't just go in and change the code of the class to follow the Target
 * interface, since the code might be provided by a 3rd-party library.
 */
class SlackApi
{
    /**
     * @var string
     */
    private $login;
    /**
     * @var string
     */
    private $apiKey;

    /**
     * SlackApi constructor.
     *
     * @param string $login
     * @param string $apiKey
     */
    public function __construct(string $login, string $apiKey)
    {
        $this->login = $login;
        $this->apiKey = $apiKey;
    }

    /**
     * @return void
     */
    public function logIn(): void
    {
        // Send authentication request to Slack web service.
        echo "Logged in to a slack account '{$this->login}'.\n";
    }

    /**
     * @param string $chatId
     * @param string $message
     *
     * @return void
     */
    public function sendMessage(string $chatId, string $message): void
    {
        // Send message post request to Slack web service.
        echo "Posted following message into the '$chatId' chat: '$message'.\n";
    }
}
