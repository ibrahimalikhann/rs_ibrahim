<script setup>
import { computed } from 'vue';
import { ArrowUp, ArrowDown, Activity } from 'lucide-vue-next';

const props = defineProps({
    title: String,
    value: String,
    change: String,
    trend: {
        type: String,
        default: 'neutral', // 'up', 'down', 'neutral'
    },
    icon: {
        type: Object,
        default: Activity
    }
});

const trendColor = computed(() => {
    switch (props.trend) {
        case 'up': return 'text-green-600 dark:text-green-400';
        case 'down': return 'text-red-600 dark:text-red-400';
        default: return 'text-gray-500 dark:text-gray-400';
    }
});

const trendIcon = computed(() => {
    switch (props.trend) {
        case 'up': return ArrowUp;
        case 'down': return ArrowDown;
        default: return null;
    }
});
</script>

<template>
    <div class="overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-md">
        <div class="flex items-center">
            <div class="p-3 rounded-lg bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400">
                <component :is="icon" class="h-6 w-6" />
            </div>
            <div class="ml-4 flex-1">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ title }}</p>
                <div class="flex items-baseline mt-1">
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ value }}</p>
                    <p v-if="change" :class="[trendColor, 'ml-2 flex items-baseline text-sm font-semibold']">
                        <component v-if="trendIcon" :is="trendIcon" class="h-4 w-4 self-center shrink-0" aria-hidden="true" />
                        {{ change }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
