<?php

namespace App\Core;

use RuntimeException;

class Flash
{
    protected $storageKey = 'flash';
    protected $fromPrevious = [];
    protected $storage;

    public function __construct(string $storageKey = null)
    {
        if (is_string($storageKey) && $storageKey) {
            $this->storageKey = $storageKey;
        }

        if (!isset($_SESSION)) {
            throw new RuntimeException('Flash messages middleware failed. Session not found.');
        } 
        $this->storage = &$_SESSION;

        if (isset($this->storage[$this->storageKey]) && is_array($this->storage[$this->storageKey])) {
            $this->fromPrevious = $this->storage[$this->storageKey];
        }
        $this->storage[$this->storageKey] = [];
    }

    public function addMessage($key, $message)
    {
        $this->storage[$this->storageKey][$key][] = $message;
    }

    public function getMessages()
    {
        return $this->fromPrevious;
    }

    public function getMessage($key)
    {
        $messages = $this->getMessages();

        // If the key exists then return all messages or null
        return (isset($messages[$key])) ? $messages[$key] : null;
    }
}
