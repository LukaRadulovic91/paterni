<?php

namespace paterni\Structural\Adapter\RealExample;


/**
 * The Adapter is a class that links the Target interface and the Adaptee class.
 * In this case, it allows the application to send notifications using Slack
 * API.
 */
class SlackNotification implements Notification
{
    /**
     * @var SlackApi
     */
    private $slack;
    /**
     * @var string
     */
    private $chatId;

    /**
     * SlackNotification constructor.
     *
     * @param SlackApi $slack
     * @param string $chatId
     */
    public function __construct(SlackApi $slack, string $chatId)
    {
        $this->slack = $slack;
        $this->chatId = $chatId;
    }

    /**
     * An Adapter is not only capable of adapting interfaces, but it can also
     * convert incoming data to the format required by the Adaptee.
     *
     * @param string $title
     * @param string $message
     *
     * @return void
     */
    public function send(string $title, string $message): void
    {
        $slackMessage = "#" . $title . "# " . strip_tags($message);
        $this->slack->logIn();
        $this->slack->sendMessage($this->chatId, $slackMessage);
    }
}
