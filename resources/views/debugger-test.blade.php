<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
            padding-bottom: 200px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 2.5rem;
        }
        .subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
        .card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .card h2 {
            color: #667eea;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        li {
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        li:last-child {
            border-bottom: none;
        }
        li:before {
            content: "✓";
            color: #667eea;
            font-weight: bold;
            margin-right: 10px;
        }
        .badge {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-top: 20px;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .info-box p {
            color: #333;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $title }}</h1>
        <p class="subtitle">{{ $message }}</p>

        <div class="card">
            <h2>Package Features</h2>
            <ul>
                @foreach($features as $feature)
                    <li>{{ $feature }}</li>
                @endforeach
            </ul>
        </div>

        <div class="card">
            <h2>What to Check</h2>
            <ul>
                <li>Open the Laravel Debugger at the bottom of the page</li>
                <li>Check the Performance panel for execution time and memory</li>
                <li>View the Queries panel to see database queries</li>
                <li>Inspect the Logs panel for application logs</li>
                <li>Examine the Request panel for HTTP request details</li>
                <li>Look at the Route panel for routing information</li>
                <li>Explore the Views panel to see rendered templates</li>
            </ul>
        </div>

        <div class="info-box">
            <p><strong>💡 Tip:</strong> Click the blue toggle button at the bottom of the page to show/hide the debugger. Use the tabs to navigate between different debugging panels.</p>
        </div>

        <span class="badge">Vue 3 + TailwindCSS</span>
        <span class="badge">Modern UI/UX</span>
    </div>
</body>
</html>
