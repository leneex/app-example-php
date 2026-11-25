<?php

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

// Return 404 for any path other than / and /index.php
if ($path !== '/' && $path !== '/index.php') {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Not Found';
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// Only GET and HEAD methods are supported
if ($method !== 'GET' && $method !== 'HEAD') {
    http_response_code(405);
    header('Allow: GET, HEAD');
    header('Content-Type: text/plain; charset=utf-8');
    echo 'Method Not Allowed';
    exit;
}

// Exit early for HEAD requests
if ($method === 'HEAD') {
    header('Content-Type: text/html; charset=utf-8');
    exit;
}

// Sanitize and truncate the name parameter (at most 50 UTF-8 characters)
$name = '';
if (isset($_GET['name']) && is_string($_GET['name'])) {
    $trimmed = trim($_GET['name']);
    if ($trimmed !== '' && preg_match('/^.{1,50}/us', $trimmed, $matches)) {
        $name = $matches[0];
    }
}

$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP</title>
    <style>
        :root {
            color-scheme: light dark;
        }
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 2rem 1rem;
            display: flex;
            justify-content: center;
        }
        .container {
            max-width: 600px;
            width: 100%;
        }
        h1 {
            margin-top: 0;
            font-size: 2rem;
        }
        .info {
            margin: 1.5rem 0;
        }
        .info p {
            margin: 0.25rem 0;
        }
        form {
            margin: 1.5rem 0;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        label {
            font-weight: 500;
        }
        input[type="text"] {
            font: inherit;
            padding: 0.5rem 0.75rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: rgba(127, 127, 127, 0.05);
        }
        button {
            font: inherit;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            background: #0969da;
            color: #fff;
            cursor: pointer;
            align-self: flex-start;
        }
        button:hover {
            background: #0858b9;
        }
        .greeting {
            margin-top: 1rem;
            font-size: 1.1rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hello world</h1>
        <div class="info">
            <p>PHP: <?= htmlspecialchars(PHP_VERSION, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
            <p>Server: <?= htmlspecialchars($serverSoftware, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
        </div>
        <form method="GET" action="/">
            <label for="name">Your name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
            <button type="submit">Say hello</button>
        </form>
        <?php if ($name !== ''): ?>
            <p class="greeting">Hello, <?= htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>!</p>
        <?php endif; ?>
    </div>
</body>
</html>
