<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import StatCard from '@/Components/StatCard.vue';
import { Map, MapPin, Globe, Activity } from 'lucide-vue-next';

const stats = [
    { title: 'Regional Revenue', value: '$850k', change: '+8%', trend: 'up', icon: Globe },
    { title: 'Active Zones', value: '12', change: '0', trend: 'neutral', icon: Map },
    { title: 'Top Region', value: 'North-East', change: '+15%', trend: 'up', icon: MapPin },
    { title: 'Field Activity', value: 'High', change: '', trend: 'neutral', icon: Activity },
];
</script>

<template>
    <Head title="Geo Head Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Regional Overview
            </h2>
        </template>

        <div class="space-y-6">
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Geo Head Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Monitor regional performance and field operations.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <StatCard v-for="(stat, index) in stats" :key="index" v-bind="stat" />
            </div>

            <!-- Map Placeholder -->
            <div class="h-96 w-full rounded-xl bg-gray-100 dark:bg-gray-800 overflow-hidden relative shadow-inner">
                <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                    <div class="text-center">
                        <Map class="h-16 w-16 mx-auto mb-2 opacity-50" />
                        <p>Interactive Map Component Placeholder</p>
                    </div>
                </div>
            </div>

             <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div v-for="i in 3" :key="i" class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                     <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Zone {{ i }} Performance</h4>
                     <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5 mb-4">
                        <div class="bg-blue-600 h-2.5 rounded-full" :style="{ width: (Math.random() * 50 + 40) + '%' }"></div>
                     </div>
                     <p class="text-sm text-gray-500 dark:text-gray-400">Target: $50k / Month</p>
                </div>
             </div>
        </div>
    </AuthenticatedLayout>
</template>
