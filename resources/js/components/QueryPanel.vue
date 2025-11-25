<template>
  <div class="space-y-4 animate-fade-in">
    <!-- Summary -->
    <div class="debugger-panel">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-lg font-semibold text-debugger-text">Database Queries</h3>
          <p class="text-sm text-debugger-muted">{{ data?.total_queries || 0 }} queries executed</p>
        </div>
        <div class="text-right">
          <div class="text-2xl font-bold text-debugger-accent">{{ data?.total_time || 0 }} <span class="text-sm text-debugger-muted">ms</span></div>
          <div class="text-xs text-debugger-muted">Total time</div>
        </div>
      </div>
    </div>

    <!-- Query List -->
    <div v-if="data?.queries?.length" class="space-y-3">
      <div 
        v-for="(query, index) in data.queries" 
        :key="index"
        class="debugger-panel hover:border-debugger-accent/50 transition-colors duration-200"
      >
        <div class="flex items-start justify-between mb-2">
          <span class="debugger-badge debugger-badge-primary">Query #{{ index + 1 }}</span>
          <div class="flex items-center gap-2">
            <span :class="[
              'debugger-badge',
              query.time < 10 ? 'debugger-badge-success' :
              query.time < 50 ? 'debugger-badge-warning' :
              'debugger-badge-error'
            ]">
              {{ query.time }} ms
            </span>
            <span class="debugger-badge debugger-badge-info">{{ query.connection }}</span>
          </div>
        </div>

        <div class="bg-debugger-bg/50 rounded p-3 mt-2 font-mono text-xs overflow-x-auto debugger-scrollbar">
          <code class="text-debugger-text whitespace-pre">{{ query.query }}</code>
        </div>

        <div v-if="query.bindings?.length" class="mt-2">
          <button 
            @click="toggleBindings(index)"
            class="text-xs text-debugger-accent hover:text-debugger-accent/80 transition-colors"
          >
            {{ showBindings[index] ? 'Hide' : 'Show' }} bindings ({{ query.bindings.length }})
          </button>
          <div v-if="showBindings[index]" class="mt-2 space-y-1">
            <div 
              v-for="(binding, bIndex) in query.bindings" 
              :key="bIndex"
              class="text-xs text-debugger-muted flex gap-2"
            >
              <span class="text-debugger-accent">{{ bIndex }}:</span>
              <span class="debugger-code">{{ formatBinding(binding) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- No Queries -->
    <div v-else class="debugger-panel text-center py-8">
      <svg class="w-16 h-16 text-debugger-muted mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
      </svg>
      <p class="text-debugger-muted">No database queries executed</p>
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

const showBindings = ref({});

const toggleBindings = (index) => {
  showBindings.value[index] = !showBindings.value[index];
};

const formatBinding = (binding) => {
  if (binding === null) return 'NULL';
  if (typeof binding === 'boolean') return binding ? 'TRUE' : 'FALSE';
  if (typeof binding === 'string') return `"${binding}"`;
  return String(binding);
};
</script>
