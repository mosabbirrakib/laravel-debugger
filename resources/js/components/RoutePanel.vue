<template>
  <div class="space-y-4 animate-fade-in">
    <div class="debugger-panel">
      <h3 class="text-lg font-semibold text-debugger-text mb-4">Route Information</h3>
      
      <div class="space-y-4">
        <!-- Route Name & URI -->
        <div>
          <label class="text-xs text-debugger-muted">Route Name</label>
          <div class="debugger-code mt-1">{{ data?.name || 'Unnamed Route' }}</div>
        </div>

        <div>
          <label class="text-xs text-debugger-muted">Route URI</label>
          <div class="debugger-code mt-1">{{ data?.uri || 'N/A' }}</div>
        </div>

        <!-- Methods -->
        <div>
          <label class="text-xs text-debugger-muted">HTTP Methods</label>
          <div class="mt-1 flex gap-2 flex-wrap">
            <span 
              v-for="method in data?.methods" 
              :key="method"
              :class="[
                'debugger-badge',
                method === 'GET' ? 'debugger-badge-success' :
                method === 'POST' ? 'debugger-badge-primary' :
                method === 'DELETE' ? 'debugger-badge-error' :
                'debugger-badge-warning'
              ]"
            >
              {{ method }}
            </span>
          </div>
        </div>

        <!-- Controller -->
        <div v-if="data?.controller">
          <label class="text-xs text-debugger-muted">Controller</label>
          <div class="debugger-code mt-1 break-all">{{ data.controller }}</div>
        </div>

        <!-- Action -->
        <div>
          <label class="text-xs text-debugger-muted">Action</label>
          <div class="debugger-code mt-1 break-all">{{ data?.action || 'N/A' }}</div>
        </div>

        <!-- Middleware -->
        <div v-if="data?.middleware?.length">
          <label class="text-xs text-debugger-muted">Middleware</label>
          <div class="mt-2 space-y-1">
            <div 
              v-for="(middleware, index) in data.middleware" 
              :key="index"
              class="debugger-badge debugger-badge-info mr-2 mb-2 inline-block"
            >
              {{ middleware }}
            </div>
          </div>
        </div>

        <!-- Parameters -->
        <div v-if="Object.keys(data?.parameters || {}).length">
          <label class="text-xs text-debugger-muted">Route Parameters</label>
          <div class="mt-2 space-y-2">
            <div 
              v-for="(value, key) in data.parameters" 
              :key="key"
              class="flex gap-2 text-sm"
            >
              <span class="text-debugger-accent font-medium">{{ key }}:</span>
              <span class="debugger-code">{{ value }}</span>
            </div>
          </div>
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
</script>
