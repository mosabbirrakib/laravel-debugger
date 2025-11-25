/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.{vue,js,blade.php}",
    ],
    theme: {
        extend: {
            colors: {
                debugger: {
                    bg: '#0f172a',
                    panel: '#1e293b',
                    border: '#334155',
                    accent: '#3b82f6',
                    text: '#e2e8f0',
                    muted: '#94a3b8',
                    success: '#10b981',
                    warning: '#f59e0b',
                    error: '#ef4444',
                    info: '#06b6d4',
                },
            },
            backdropBlur: {
                xs: '2px',
            },
            animation: {
                'slide-up': 'slideUp 0.3s ease-out',
                'slide-down': 'slideDown 0.3s ease-out',
                'fade-in': 'fadeIn 0.2s ease-out',
                'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
            },
            keyframes: {
                slideUp: {
                    '0%': { transform: 'translateY(100%)' },
                    '100%': { transform: 'translateY(0)' },
                },
                slideDown: {
                    '0%': { transform: 'translateY(0)' },
                    '100%': { transform: 'translateY(100%)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                pulseSoft: {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.7' },
                },
            },
        },
    },
    plugins: [],
}
