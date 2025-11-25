<!-- Laravel Debugger -->
<div id="laravel-debugger-root"></div>

<script>
    window.laravelDebuggerData = @json($data);
    window.laravelDebuggerConfig = @json(config('debugger.ui', []));
</script>

<link rel="stylesheet" href="{{ asset('debugger.css') }}">
<script src="{{ asset('debugger.js') }}" defer></script>
