<!DOCTYPE html>
<html lang="en">
<?= view('partials/head.php'); ?>

<body class="dark:bg-neutral-800 bg-neutral-100 dark:text-white">

    <?= view('partials/sidebar.php'); ?>

    <main class="dashboard-main">
        <?= view('partials/navbar.php'); ?>

        <div class="dashboard-main-body">

            <?= view('partials/breadcrumb.php', ['title' => $title ?? '', 'subTitle' => $subTitle ?? '']); ?>

            <input type="hidden" id="base_url" value="<?= base_url() ?>">
