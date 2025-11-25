<template>
  <div class="space-y-4 animate-fade-in">
    <!-- Request Info -->
    <div class="debugger-panel">
      <h3 class="text-lg font-semibold text-debugger-text mb-4">Request Information</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="text-xs text-debugger-muted">Method</label>
          <div class="debugger-code mt-1">
            <span :class="[
              'font-bold',
              data?.method === 'GET' ? 'text-debugger-success' :
              data?.method === 'POST' ? 'text-debugger-accent' :
              data?.method === 'DELETE' ? 'text-debugger-error' :
              'text-debugger-warning'
            ]">{{ data?.method || 'N/A' }}</span>
          </div>
        </div>
        <div>
          <label class="text-xs text-debugger-muted">IP Address</label>
          <div class="debugger-code mt-1">{{ data?.ip || 'N/A' }}</div>
        </div>
        <div class="md:col-span-2">
          <label class="text-xs text-debugger-muted">URI</label>
          <div class="debugger-code mt-1 break-all">{{ data?.uri || 'N/A' }}</div>
        </div>
        <div>
          <label class="text-xs text-debugger-muted">AJAX Request</label>
          <div class="mt-1">
            <span :class="[
              'debugger-badge',
              data?.ajax ? 'debugger-badge-success' : 'debugger-badge-error'
            ]">
              {{ data?.ajax ? 'Yes' : 'No' }}
            </span>
          </div>
        </div>
        <div>
          <label class="text-xs text-debugger-muted">Secure (HTTPS)</label>
          <div class="mt-1">
            <span :class="[
              'debugger-badge',
              data?.secure ? 'debugger-badge-success' : 'debugger-badge-warning'
            ]">
              {{ data?.secure ? 'Yes' : 'No' }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Headers -->
    <div class="debugger-panel">
      <button 
        @click="showHeaders = !showHeaders"
        class="w-full flex items-center justify-between text-left"
      >
        <h3 class="text-lg font-semibold text-debugger-text">Headers</h3>
        <svg 
          :class="['w-5 h-5 text-debugger-accent transition-transform', showHeaders && 'rotate-180']"
          fill="none" 
          stroke="currentColor" 
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div v-if="showHeaders" class="mt-4 space-y-2">
        <div 
          v-for="(value, key) in data?.headers" 
          :key="key"
          class="flex gap-2 text-sm"
        >
          <span class="text-debugger-accent font-medium">{{ key }}:</span>
          <span class="text-debugger-text break-all">{{ value }}</span>
        </div>
      </div>
    </div>

    <!-- Input Data -->
    <div v-if="hasInputData" class="debugger-panel">
      <h3 class="text-lg font-semibold text-debugger-text mb-4">Input Data</h3>
      <div class="space-y-4">
        <div v-if="Object.keys(data?.input?.get || {}).length">
          <h4 class="text-sm font-medium text-debugger-accent mb-2">GET Parameters</h4>
          <div class="space-y-1">
            <div 
              v-for="(value, key) in data.input.get" 
              :key="key"
              class="text-sm flex gap-2"
            >
              <span class="text-debugger-muted">{{ key }}:</span>
              <span class="debugger-code">{{ value }}</span>
            </div>
          </div>
        </div>

        <div v-if="Object.keys(data?.input?.post || {}).length">
          <h4 class="text-sm font-medium text-debugger-accent mb-2">POST Parameters</h4>
          <div class="space-y-1">
            <div 
              v-for="(value, key) in data.input.post" 
              :key="key"
              class="text-sm flex gap-2"
            >
              <span class="text-debugger-muted">{{ key }}:</span>
              <span class="debugger-code">{{ formatValue(value) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Session -->
    <div v-if="Object.keys(data?.session || {}).length" class="debugger-panel">
      <h3 class="text-lg font-semibold text-debugger-text mb-4">Session Data</h3>
      <div class="space-y-1">
        <div 
          v-for="(value, key) in data.session" 
          :key="key"
          class="text-sm flex gap-2"
        >
          <span class="text-debugger-muted">{{ key }}:</span>
          <span class="debugger-code break-all">{{ formatValue(value) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});

const showHeaders = ref(false);

const hasInputData = computed(() => {
  return Object.keys(props.data?.input?.get || {}).length > 0 ||
         Object.keys(props.data?.input?.post || {}).length > 0;
});

const formatValue = (value) => {
  if (typeof value === 'object') {
    return JSON.stringify(value);
  }
  return String(value);
};
</script>
