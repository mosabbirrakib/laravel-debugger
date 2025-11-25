<template>
    <div class="debugger-container">
        <!-- Toggle Button - Modern & Compact -->
        <button
            @click="toggleDebugger"
            class="debugger-toggle-modern"
            :class="{ 'debugger-toggle-open': isOpen }"
        >
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span class="text-sm font-semibold">Laravel Debugger</span>
            </div>
            <div class="flex items-center gap-2">
                <span v-if="debugData.queries" class="px-2 py-0.5 text-xs font-medium bg-blue-500/20 text-blue-300 rounded">
                    {{ debugData.queries.total_queries || 0 }} queries
                </span>
                <span v-if="debugData.performance" class="px-2 py-0.5 text-xs font-medium bg-purple-500/20 text-purple-300 rounded">
                    {{ debugData.performance.execution_time }}ms
                </span>
                <svg 
                    class="w-4 h-4 transition-transform duration-300" 
                    :class="{ 'rotate-180': isOpen }"
                    fill="none" 
                    stroke="currentColor" 
                    viewBox="0 0 24 24"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </button>

        <!-- Debug Panel - Modern Design -->
        <transition name="slide-up">
            <div v-if="isOpen" class="debugger-panel-modern">
                <!-- Tabs - Horizontal Compact -->
                <div class="debugger-tabs-modern">
                    <button
                        v-for="tab in tabs"
                        :key="tab.id"
                        @click="activeTab = tab.id"
                        class="debugger-tab-modern"
                        :class="{ 'debugger-tab-active': activeTab === tab.id }"
                    >
                        <component :is="tab.icon" class="w-4 h-4" />
                        <span class="text-xs font-medium">{{ tab.name }}</span>
                        <span v-if="tab.badge" class="ml-1 px-1.5 py-0.5 text-xs font-semibold bg-blue-500/30 text-blue-200 rounded">
                            {{ tab.badge }}
                        </span>
                    </button>
                </div>

                <!-- Content Area -->
                <div class="debugger-content-modern">
                    <PerformancePanel v-if="activeTab === 'performance'" :data="debugData.performance" />
                    <QueryPanel v-if="activeTab === 'queries'" :data="debugData.queries" />
                    <ViewPanel v-if="activeTab === 'views'" :data="debugData.views" />
                    <LogPanel v-if="activeTab === 'logs'" :data="debugData.logs" />
                    <RequestPanel v-if="activeTab === 'request'" :data="debugData.request" />
                    <RoutePanel v-if="activeTab === 'route'" :data="debugData.route" />
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import PerformancePanel from './PerformancePanel.vue';
import QueryPanel from './QueryPanel.vue';
import ViewPanel from './ViewPanel.vue';
import LogPanel from './LogPanel.vue';
import RequestPanel from './RequestPanel.vue';
import RoutePanel from './RoutePanel.vue';

const isOpen = ref(false);
const activeTab = ref('performance');

const debugData = window.laravelDebuggerData || {};

const toggleDebugger = () => {
    isOpen.value = !isOpen.value;
};

const tabs = computed(() => [
    { 
        id: 'performance', 
        name: 'Performance', 
        icon: PerformanceIcon,
        badge: null
    },
    { 
        id: 'queries', 
        name: 'Queries', 
        icon: QueryIcon,
        badge: debugData.queries?.total_queries || 0
    },
    { 
        id: 'views', 
        name: 'Views', 
        icon: ViewIcon,
        badge: debugData.views?.total_views || 0
    },
    { 
        id: 'logs', 
        name: 'Logs', 
        icon: LogIcon,
        badge: debugData.logs?.total_logs || 0
    },
    { 
        id: 'request', 
        name: 'Request', 
        icon: RequestIcon,
        badge: null
    },
    { 
        id: 'route', 
        name: 'Route', 
        icon: RouteIcon,
        badge: null
    }
]);

// Compact Icon Components
const PerformanceIcon = {
    template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>`
};

const QueryIcon = {
    template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/></svg>`
};

const ViewIcon = {
    template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`
};

const LogIcon = {
    template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>`
};

const RequestIcon = {
    template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>`
};

const RouteIcon = {
    template: `<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>`
};
</script>
