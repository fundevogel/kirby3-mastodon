<?php

@include_once __DIR__ . '/vendor/autoload.php';


/**
 * Extracts & downloads images
 *
 * @param array $data One or many toot(s)
 * @return array
 */
function bigBite(\Kirby\Cms\Page $page, \Fundevogel\Mastodon\Entities\Status $toot): array
{
    # Skip if media downloads are disabled
    if (option('fundevogel.mastodon.download_media', true) === false) {
        return $toot->data;
    }

    # Download images
    foreach ($toot->downloadMedia($page->root()) as $index => $file) {
        # Build path
        $name = basename($file);
        $path = $page->root() . '/' . $name;

        # Attempt file object creation (as almighty)
        try {
            $description = $toot->data['media_attachments'][$index]['description'];

            $file = kirby()->impersonate('kirby', function () use ($page, $path, $description) {
                $file = new File([
                    'parent' => $page,
                    'filename' => basename($path),
                ]);

                return $file->update([
                    'description' => $description,
                    'template'    => option('fundevogel.mastodon.template', 'mastodon.image'),
                ]);
            });

        } catch (\Exception $e) {}
    }

    return $toot->data;
}


Kirby::plugin('fundevogel/mastodon', [
    /**
     * Plugin options
     */
    'options' => [
        'cache' => true
    ],


    /**
     * Snippets
     *
     * @see https://getkirby.com/docs/reference/plugins/extensions/snippets
     */
    'snippets' => [
        'mastodon' => __DIR__ . '/snippets/mastodon.php',
    ],


    /**
     * Site methods
     *
     * @see https://getkirby.com/docs/reference/plugins/extensions/site-methods
     */
    'siteMethods' => [
        /**
         * Initialize API
         *
         * @param string $instance Mastodon instance
         * @return \Fundevogel\Mastodon\Api
         */
        'mastodon' => function(string $instance = 'mastodon.social'): \Fundevogel\Mastodon\Api
        {
            # Initialize API
            $api = new Fundevogel\Mastodon\Api(option('fundevogel.mastodon.instance', $instance));
            $api->clientKey = option('fundevogel.mastodon.client_key', '');
            $api->clientSecret = option('fundevogel.mastodon.client_secret', '');
            $api->accessToken = option('fundevogel.mastodon.access_token', '');
            $api->appName = option('fundevogel.mastodon.app_name', 'Test App');
            $api->appURL = option('fundevogel.mastodon.app_url', '');

            # Log in
            $api->logIn();

            return $api;
        },
    ],


    /**
     * Page methods
     *
     * @see https://getkirby.com/docs/reference/plugins/extensions/page-methods
     */
    'pageMethods' => [
        /**
         * Get toots for given account ID
         *
         * @param $id Account ID
         * @return array Toots
         */
        'toots' => function(string $id = ''): array
        {
            # Initialize cache
            $cache = kirby()->cache('fundevogel.mastodon');

            # Determine cache key
            $key = empty($id) ? $id : 'statuses';

            # Grab cache by cache key
            $toots = $cache->get($key);

            # If there's nothing in the cache ..
            if (empty($toots)) {
                # .. fetch it!
                $toots = site()->mastodon()->accounts()->statuses($id);

                # Cache results
                # (1) Each status individually
                foreach ($toots as $toot) {
                    $cache->set($toot->data['id'], bigBite($this, $toot), option('fundevogel.mastodon.cache_duration', 60));
                }

                # (2) All statuses at once
                $toots = array_map(function ($toot) {
                    return $toot->data;
                }, $toots);

                $cache->set($id, $toots, option('fundevogel.mastodon.cache_duration', 60));
            }

            return $toots;
        },


        /**
         * Get toot for given status ID
         *
         * @param $id Toot ID
         * @return array Toot
         */
        'toot' => function(string $id): array
        {
            # Initialize cache
            $cache = kirby()->cache('fundevogel.mastodon');

            # Grab cache by toot ID
            $toot = $cache->get($id);

            # If there's nothing in the cache ..
            if (empty($toot)) {
                # .. fetch it!
                $toot = site()->mastodon()->statuses()->get($id);

                # Cache results
                $cache->set($id, bigBite($this, $toot), option('fundevogel.mastodon.cache_duration', 60));
            }

            return $toot;
        },
    ],
]);
