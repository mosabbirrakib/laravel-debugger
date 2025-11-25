# Laravel Debugger

A modern, sleek debugging toolbar for Laravel with a fresh UI/UX design built with Vue 3 and TailwindCSS.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/almosabbirrakib/laravel-debugger.svg?style=flat-square)](https://packagist.org/packages/almosabbirrakib/laravel-debugger)
[![Total Downloads](https://img.shields.io/packagist/dt/almosabbirrakib/laravel-debugger.svg?style=flat-square)](https://packagist.org/packages/almosabbirrakib/laravel-debugger)
[![Laravel](https://img.shields.io/badge/Laravel-10%2B%20%7C%2011%2B-orange?style=flat-square)](https://laravel.com)
[![License](https://img.shields.io/github/license/almosabbirrakib/laravel-debugger?style=flat-square)](https://github.com/almosabbirrakib/laravel-debugger/blob/main/LICENSE)
[![Vue 3](https://img.shields.io/badge/Vue-3.x-green?style=flat-square)](https://vuejs.org)

## ✨ Features

- 🎨 **Modern UI/UX**: Beautiful dark mode interface with glassmorphic design
- ⚡ **Performance Metrics**: Execution time, memory usage, and server load tracking
- 🗄️ **Database Queries**: View all SQL queries with bindings, timing, and syntax highlighting
- 🛣️ **Route Information**: Route name, controller, action, middleware, and parameters
- 👁️ **View Debugging**: Track rendered views and their data
- 📝 **Application Logs**: Color-coded log entries with context
- 💾 **Request Data**: Complete request information including headers, parameters, and session
- 📱 **Responsive Design**: Works on desktop and mobile devices
- 🎯 **Collapsible Interface**: Clean, non-intrusive toolbar that slides in/out smoothly
- 🔒 **Environment Aware**: Only loads in development/local environments

## 📦 Installation

Install the package via Composer:

```bash
composer require almosabbirrakib/laravel-debugger --dev
```

The package will automatically register its service provider using Laravel's package discovery.

## 🚀 Setup

### 1. Publish Configuration (Optional)

```bash
php artisan vendor:publish --tag=debugger-config
```

This will create a `config/debugger.php` file where you can customize the debugger behavior.

### 2. Publish Assets

```bash
php artisan vendor:publish --tag=debugger-assets
```

This will publish the compiled CSS and JavaScript files to `public/vendor/debugger`.

### 3. Enable the Debugger

Add to your `.env` file:

```env
DEBUGGER_ENABLED=true
```

Or keep it enabled only when `APP_DEBUG` is true (default behavior).

## ⚙️ Configuration

The configuration file allows you to customize various aspects of the debugger:

```php
return [
    // Enable/disable the debugger
    'enabled' => env('DEBUGGER_ENABLED', env('APP_DEBUG', false)),

    // Allowed environments
    'allowed_environments' => ['local', 'development', 'dev', 'testing'],

    // Toggle individual collectors
    'collectors' => [
        'request' => true,
        'route' => true,
        'queries' => true,
        'views' => true,
        'logs' => true,
        'performance' => true,
    ],

    // Query settings
    'queries' => [
        'max_queries' => 100,
    ],

    // Log settings
    'logs' => [
        'max_logs' => 50,
    ],

    // UI customization
    'ui' => [
        'position' => 'bottom', // bottom or top
        'theme' => 'dark',
    ],

    // Exclude routes
    'except' => [
        'debugger/*',
        '_debugbar/*',
    ],
];
```

## 📋 Usage

Once installed and configured, the debugger will automatically appear at the bottom of your pages when accessing your Laravel application in a local or development environment.

### Toggle the Debugger

Click the blue toggle button to show/hide the debug bar.

### Navigate Panels

Use the tab navigation to switch between different debugging panels:

- **Performance**: View execution time, memory usage, and server load
- **Queries**: Inspect all database queries with timing and bindings
- **Request**: Examine request data, headers, and session
- **Route**: View route information and middleware
- **Views**: See rendered views and their data
- **Logs**: Review application log entries

## 🎨 UI Preview

The debugger features a modern dark theme with:

- Glassmorphic backdrop blur effects
- Smooth slide animations
- Color-coded badges for quick information scanning
- Syntax-highlighted SQL queries
- Responsive tabbed interface
- Custom scrollbars

## 🔧 Advanced Usage

### Excluding Routes

To exclude specific routes from debugging, add them to the `except` array in the config:

```php
'except' => [
    'api/*',
    'webhooks/*',
    '_debugbar/*',
],
```

### Customizing Data Limits

Adjust the maximum number of queries and logs captured:

```php
'queries' => [
    'max_queries' => 200, // Default: 100
],

'logs' => [
    'max_logs' => 100, // Default: 50
],
```

## 🏗️ Package Structure

```
laravel-debugger/
├── config/
│   └── debugger.php          # Configuration file
├── src/
│   ├── DataCollectors/       # Data collection classes
│   ├── Middleware/           # Debug middleware
│   └── LaravelDebuggerServiceProvider.php
├── resources/
│   ├── js/                   # Vue 3 components
│   ├── css/                  # TailwindCSS styles
│   └── views/                # Blade templates
├── public/                   # Compiled assets
├── package.json              # NPM dependencies
├── vite.config.js            # Vite configuration
└── tailwind.config.js        # TailwindCSS configuration
```

## 🛠️ Development

To work on the package:

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Build assets:
   ```bash
   npm run build
   ```
4. For development with hot reload:
   ```bash
   npm run dev
   ```

## 📝 Requirements

- PHP 8.1 or higher
- Laravel 10.x or 11.x
- Node.js 18+ (for building assets)

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## 🙏 Acknowledgments

Inspired by [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) but built from scratch with a modern UI/UX approach.

## 💡 Support

If you encounter any issues or have questions, please [open an issue](https://github.com/almosabbirrakib/laravel-debugger/issues) on GitHub.

---

Made with ❤️ by Almosabbir Rakib
