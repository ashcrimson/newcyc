<?php

namespace Laracasts\Flash;


class FlashNotifier
{




    public $messages;


    function __construct()
    {
        $this->messages = array();
    }

    /**
     * Flash an information message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function info($message = null)
    {
        return $this->message($message, 'info');
    }

    /**
     * Flash a success message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function success($message = null)
    {
        return $this->message($message, 'success');
    }

    /**
     * Flash an error message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function error($message = null)
    {
        return $this->message($message, 'danger');
    }

    /**
     * Flash a warning message.
     *
     * @param  string|null $message
     * @return $this
     */
    public function warning($message = null)
    {
        return $this->message($message, 'warning');
    }

    /**
     * Flash a general message.
     *
     * @param  string|null $message
     * @param  string|null $level
     * @return $this
     */
    public function message($message = null, $level = null)
    {
        // If no message was provided, we should update
        // the most recently added message.
        if (! $message) {
            return $this->updateLastMessage(compact('level'));
        }

        if (! $message instanceof Message) {
            $message = new Message(compact('message', 'level'));
        }

        $this->messages[] = $message;

        return $this->flash();
    }


    /**
     * Modify the most recently added message.
     *
     * @param  array $overrides
     * @return $this
     */
    protected function updateLastMessage($overrides = [])
    {
        end($this->messages)->update($overrides);

        return $this;
    }

    /**
     * Add an "important" flash to the session.
     *
     * @return $this
     */
    public function important()
    {
        return $this->updateLastMessage(['important' => true]);
    }



    /**
     * Flash all messages to the session.
     */
    protected function flash()
    {

        session_start();
        $_SESSION['flash_notification'] = $this->messages;

        return $this;
    }
}

