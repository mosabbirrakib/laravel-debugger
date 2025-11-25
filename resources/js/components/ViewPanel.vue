<template>
  <div class="space-y-4 animate-fade-in">
    <!-- Summary -->
    <div class="debugger-panel">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-lg font-semibold text-debugger-text">Rendered Views</h3>
          <p class="text-sm text-debugger-muted">{{ data?.total_views || 0 }} views rendered</p>
        </div>
      </div>
    </div>

    <!-- View List -->
    <div v-if="data?.views?.length" class="space-y-3">
      <div 
        v-for="(view, index) in data.views" 
        :key="index"
        class="debugger-panel hover:border-debugger-accent/50 transition-colors duration-200"
      >
        <div class="flex items-start justify-between mb-2">
          <span class="debugger-badge debugger-badge-primary">View #{{ index + 1 }}</span>
        </div>

        <div class="space-y-2">
          <div>
            <label class="text-xs text-debugger-muted">Name</label>
            <div class="debugger-code mt-1">{{ view.name }}</div>
          </div>

          <div>
            <label class="text-xs text-debugger-muted">Path</label>
            <div class="debugger-code mt-1 text-xs break-all">{{ view.path }}</div>
          </div>

          <!-- View Data -->
          <div v-if="Object.keys(view.data || {}).length">
            <button 
              @click="toggleData(index)"
              class="text-xs text-debugger-accent hover:text-debugger-accent/80 transition-colors flex items-center gap-1"
            >
              <svg 
                :class="['w-4 h-4 transition-transform', showData[index] && 'rotate-90']"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
              View Data ({{ Object.keys(view.data).length }} variables)
            </button>
            <div v-if="showData[index]" class="mt-2 space-y-1">
              <div 
                v-for="(value, key) in view.data" 
                :key="key"
                class="text-xs flex gap-2"
              >
                <span class="text-debugger-accent">{{ key }}:</span>
                <span class="text-debugger-text">{{ formatValue(value) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- No Views -->
    <div v-else class="debugger-panel text-center py-8">
      <svg class="w-16 h-16 text-debugger-muted mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
      </svg>
      <p class="text-debugger-muted">No views rendered</p>
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

const showData = ref({});

const toggleData = (index) => {
  showData.value[index] = !showData.value[index];
};

const formatValue = (value) => {
  if (typeof value === 'string') {
    return value.length > 100 ? value.substring(0, 100) + '...' : value;
  }
  return String(value);
};
</script>
