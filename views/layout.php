<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Supermarché 2.0' ?></title>
    <link rel="stylesheet" href="css/style.css">
    <?php if(isset($styles)): echo $styles; endif; ?>
</head>
<body>

    <?php if(isset($no_container) && $no_container): ?>
        <?= $content ?>
    <?php else: ?>
        <div class="container" <?= isset($container_style) ? 'style="'.$container_style.'"' : '' ?>>
            <?= $content ?>
        </div>
    <?php endif; ?>

    <?php if(isset($scripts)): echo $scripts; endif; ?>

</body>
</html>
