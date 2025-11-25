<template>
  <div class="space-y-4 animate-fade-in">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="debugger-panel">
        <div class="flex items-center gap-3">
          <div class="p-3 bg-debugger-accent/20 rounded-lg">
            <svg class="w-6 h-6 text-debugger-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <div class="text-debugger-muted text-xs">Execution Time</div>
            <div class="text-2xl font-bold text-debugger-text">{{ data?.execution_time || 0 }} <span class="text-sm text-debugger-muted">ms</span></div>
          </div>
        </div>
      </div>

      <div class="debugger-panel">
        <div class="flex items-center gap-3">
          <div class="p-3 bg-debugger-success/20 rounded-lg">
            <svg class="w-6 h-6 text-debugger-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
            </svg>
          </div>
          <div>
            <div class="text-debugger-muted text-xs">Peak Memory</div>
            <div class="text-2xl font-bold text-debugger-text">{{ data?.memory_peak || 'N/A' }}</div>
          </div>
        </div>
      </div>

      <div class="debugger-panel">
        <div class="flex items-center gap-3">
          <div class="p-3 bg-debugger-info/20 rounded-lg">
            <svg class="w-6 h-6 text-debugger-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <div>
            <div class="text-debugger-muted text-xs">Included Files</div>
            <div class="text-2xl font-bold text-debugger-text">{{ data?.included_files || 0 }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Memory Details -->
    <div class="debugger-panel">
      <h3 class="text-lg font-semibold text-debugger-text mb-4">Memory Usage</h3>
      <div class="space-y-3">
        <div>
          <div class="flex justify-between text-sm mb-1">
            <span class="text-debugger-muted">Current Memory</span>
            <span class="text-debugger-text font-medium">{{ data?.memory_current || 'N/A' }}</span>
          </div>
          <div class="w-full bg-debugger-bg rounded-full h-2">
            <div 
              class="bg-gradient-to-r from-debugger-accent to-debugger-info h-2 rounded-full transition-all duration-500"
              :style="{ width: getMemoryPercentage(data?.memory_current_bytes, data?.memory_peak_bytes) + '%' }"
            ></div>
          </div>
        </div>

        <div>
          <div class="flex justify-between text-sm mb-1">
            <span class="text-debugger-muted">Memory Used</span>
            <span class="text-debugger-text font-medium">{{ data?.memory_used || 'N/A' }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Server Load -->
    <div v-if="data?.server_load" class="debugger-panel">
      <h3 class="text-lg font-semibold text-debugger-text mb-4">Server Load</h3>
      <div class="grid grid-cols-3 gap-4">
        <div class="text-center">
          <div class="text-debugger-muted text-xs mb-1">1 min</div>
          <div class="text-xl font-bold text-debugger-text">{{ data.server_load['1min'] }}</div>
        </div>
        <div class="text-center">
          <div class="text-debugger-muted text-xs mb-1">5 min</div>
          <div class="text-xl font-bold text-debugger-text">{{ data.server_load['5min'] }}</div>
        </div>
        <div class="text-center">
          <div class="text-debugger-muted text-xs mb-1">15 min</div>
          <div class="text-xl font-bold text-debugger-text">{{ data.server_load['15min'] }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});

const getMemoryPercentage = (current, peak) => {
  if (!current || !peak) return 0;
  return Math.min((current / peak) * 100, 100);
};
</script>
