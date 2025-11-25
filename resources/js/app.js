import { createApp } from 'vue';
import '../css/app.css';
import DebugBar from './components/DebugBar.vue';

// Wait for DOM to be ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDebugger);
} else {
    initDebugger();
}

function initDebugger() {
    const debugContainer = document.getElementById('laravel-debugger-root');

    if (!debugContainer) {
        console.warn('Laravel Debugger: Container not found');
        return;
    }

    const debugData = window.laravelDebuggerData || {};
    const config = window.laravelDebuggerConfig || {};

    const app = createApp(DebugBar, {
        debugData,
        position: config.position || 'bottom',
    });

    app.mount(debugContainer);
}
