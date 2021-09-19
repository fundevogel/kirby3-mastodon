<?php

namespace Fundevogel\Mastodon\Traits\Methods;


trait Notifications
{
    /**
     * @return \Fundevogel\Mastodon\Methods\Notifications\Notifications;
     */
    public function notifications(): \Fundevogel\Mastodon\Methods\Notifications\Notifications
    {
        return new \Fundevogel\Mastodon\Methods\Notifications\Notifications($this);
    }
}
