<?php
    # Get statuses (called 'toots' on Mastodon)
    $toots = isset($id) ? [$page->toot($id)] : $page->toots($account ?? '');

    foreach ($toots as $toot) :
?>
    <time datetime="<?= date('Y-m-d', strtotime($toot['created_at'])) ?>">
        <?= date('Y-m-d, h:i A', strtotime($toot['created_at'])) ?>
    </time>
    <p><?= $toot['content'] ?></p>

    <?php if (isset($media) && $media === true) : ?>
    <?php foreach ($toot['media_attachments'] as $media) : ?>
    <figure>
        <?php if ($media['type'] == 'image') : ?>
        <?php if ($image = $page->image(basename($media['url']))) : ?>
        <?= $image->thumb(['width' => 460, 'height' => 320, 'quality' => 85]) ?>
        <?php else : ?>
        <?= Html::img($media['url'], ['width' => 460, 'height' => 320]) ?>
        <?php endif ?>
        <?php if ($image->description()->isNotEmpty()) : ?>
        <figcaption><?= $image->description() ?></figcaption>
        <?php endif ?>
        <?php endif ?>
    </figure>
    <?php endforeach ?>
    <?php endif ?>
<?php endforeach ?>
