<?php

namespace Fundevogel\Mastodon\Traits\Methods;


trait Announcements
{
    /**
     * @return \Fundevogel\Mastodon\Methods\Announcements\Announcements;
     */
    public function announcements(): \Fundevogel\Mastodon\Methods\Announcements\Announcements
    {
        return new \Fundevogel\Mastodon\Methods\Announcements\Announcements($this);
    }
}
