<template>
  <div class="space-y-4 animate-fade-in">
    <!-- Summary with Level Badges -->
    <div class="debugger-panel">
      <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
          <h3 class="text-lg font-semibold text-debugger-text">Application Logs</h3>
          <p class="text-sm text-debugger-muted">{{ data?.total_logs || 0 }} log entries</p>
        </div>
        <div v-if="data?.by_level" class="flex gap-2 flex-wrap">
          <span 
            v-for="(count, level) in data.by_level" 
            :key="level"
            :class="['debugger-badge', getLevelBadgeClass(level)]"
          >
            {{ level }}: {{ count }}
          </span>
        </div>
      </div>
    </div>

    <!-- Log Entries -->
    <div v-if="data?.logs?.length" class="space-y-2">
      <div 
        v-for="(log, index) in data.logs" 
        :key="index"
        class="debugger-panel hover:border-debugger-accent/50 transition-colors duration-200"
      >
        <div class="flex items-start gap-3">
          <!-- Level Badge -->
          <span :class="['debugger-badge', getLevelBadgeClass(log.level), 'flex-shrink-0']">
            {{ log.level.toUpperCase() }}
          </span>
          
          <div class="flex-1 min-w-0">
            <!-- Message -->
            <div class="text-sm text-debugger-text break-words">{{ log.message }}</div>
            
            <!-- Timestamp -->
            <div class="text-xs text-debugger-muted mt-1">{{ log.timestamp }}</div>

            <!-- Context -->
            <div v-if="log.context && Object.keys(log.context).length" class="mt-2">
              <button 
                @click="toggleContext(index)"
                class="text-xs text-debugger-accent hover:text-debugger-accent/80 transition-colors"
              >
                {{ showContext[index] ? 'Hide' : 'Show' }} context
              </button>
              <div v-if="showContext[index]" class="mt-2 bg-debugger-bg/50 rounded p-2">
                <pre class="text-xs text-debugger-text overflow-x-auto debugger-scrollbar">{{ JSON.stringify(log.context, null, 2) }}</pre>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- No Logs -->
    <div v-else class="debugger-panel text-center py-8">
      <svg class="w-16 h-16 text-debugger-muted mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <p class="text-debugger-muted">No logs recorded</p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});

const showContext = ref({});

const toggleContext = (index) => {
  showContext.value[index] = !showContext.value[index];
};

const getLevelBadgeClass = (level) => {
  const levelMap = {
    emergency: 'debugger-badge-error',
    alert: 'debugger-badge-error',
    critical: 'debugger-badge-error',
    error: 'debugger-badge-error',
    warning: 'debugger-badge-warning',
    notice: 'debugger-badge-info',
    info: 'debugger-badge-info',
    debug: 'debugger-badge-primary',
  };
  return levelMap[level?.toLowerCase()] || 'debugger-badge-primary';
};
</script>
