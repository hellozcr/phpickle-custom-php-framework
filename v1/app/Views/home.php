<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($appName) ?> - Home</title>
    <?php \Core\AssetManager::renderCss(); ?>
    <style>
        body {
            background: #f8fafc;
            color: #222;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
        }

        .container {
            max-width: 540px;
            margin: 5vh auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 16px #0001;
            padding: 2.5rem 2rem;
        }

        h1 {
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .srd {
            font-size: 1.1rem;
            color: #888;
            margin-bottom: 1.5rem;
        }

        .guide {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 2rem;
            font-size: 1rem;
        }

        .guide code {
            background: #e2e8f0;
            border-radius: 4px;
            padding: 2px 6px;
        }

        .footer {
            margin-top: 2.5rem;
            color: #aaa;
            font-size: 0.95rem;
            text-align: center;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to <?= htmlspecialchars($appName) ?></h1>
        <div class="srd">Framework by <strong>(SRD)</strong> 🚀</div>
        <div class="guide">
            <strong>Get Started:</strong>
            <ul style="margin: 0 0 0 1.2em;">
                <li>Edit <code>config/config.php</code> for app and DB settings</li>
                <li>Define routes in <code>config/routes.php</code></li>
                <li>Set up your DB schema in <code>migrations/schema.php</code></li>
                <li>Run <code>php migrations/migrate.php sync</code> to create tables</li>
                <li>Point your web server to the <code>public/</code> directory ::(Default Build with .htaccess)</li>
            </ul>
            <div style="margin-top: 1em;">
                <a href="#">Boom You Are on a Go- &rarr;</a>
            </div>
        </div>
        <div class="footer">
            <span><?= $appName ?> &copy; <?= date('Y') ?> &mdash; Crafted by SRD</span>
        </div>
    </div>
    <?php \Core\AssetManager::renderJs(); ?>
</body>

</html>