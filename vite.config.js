import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
    plugins: [vue()],
    build: {
        outDir: 'public',
        emptyOutDir: true,
        rollupOptions: {
            input: resolve(__dirname, 'resources/js/app.js'),
            output: {
                entryFileNames: 'debugger.js',
                assetFileNames: (assetInfo) => {
                    if (assetInfo.name.endsWith('.css')) {
                        return 'debugger.css';
                    }
                    return assetInfo.name;
                },
            },
        },
    },
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
        },
    },
});
