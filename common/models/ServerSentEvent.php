<?php

namespace common\models;

/**
 * @link https://github.com/hhxsv5/php-sse/blob/2d808a249b59f912b6bd74efe6216783aa5fcd28/src/Event.php#
 */
class ServerSentEvent
{
    /** @var int|string|null  */
    protected $id;
    /** @var string|null */
    protected $type;
    /** @var string|int|float */
    protected $data;
    /** @var int|null  */
    protected $retry;
    /** @var string|null  */
    protected $comment;

    /**
     * Event constructor.
     * @param array $event [id=>id,type=>type,data=>data,retry=>retry,comment=>comment]
     */
    public function __construct(array $event)
    {
        $this->id = $event['id'] ?? null;
        $this->type = $event['type'] ?? null;
        $this->data = $event['data'] ?? null;
        $this->retry = $event['retry'] ?? null;
        $this->comment = $event['comment'] ?? null;
    }

    public function __toString()
    {
        $event = [];
        $this->comment != '' && $event[] = sprintf(': %s', $this->comment);//:comments
        $this->id != '' && $event[] = sprintf('id: %s', $this->id);
        $this->retry != '' && $event[] = sprintf('retry: %s', $this->retry);//millisecond
        $this->type != '' && $event[] = sprintf('event: %s', $this->type);
        $this->data != '' && $event[] = sprintf('data: %s', $this->data);
        return implode("\n", $event) . "\n\n";
    }
}
