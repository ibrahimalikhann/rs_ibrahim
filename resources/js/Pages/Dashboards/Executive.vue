<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import StatCard from '@/Components/StatCard.vue';
import { DollarSign, Briefcase, TrendingUp, Users } from 'lucide-vue-next';

// Static Data for Executive View
const stats = [
    { title: 'Total Revenue', value: '$2.4M', change: '+12%', trend: 'up', icon: DollarSign },
    { title: 'Active Projects', value: '45', change: '+3', trend: 'up', icon: Briefcase },
    { title: 'Market Share', value: '18%', change: '+1.2%', trend: 'up', icon: TrendingUp },
    { title: 'Total Headcount', value: '124', change: '-2', trend: 'down', icon: Users },
];
</script>

<template>
    <Head title="Executive Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Executive Overview
            </h2>
        </template>

        <div class="space-y-6">
             <!-- Welcome Section -->
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Executive Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">High-level insights and company performance metrics.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <StatCard 
                    v-for="(stat, index) in stats" 
                    :key="index"
                    v-bind="stat"
                />
            </div>

            <!-- Placeholder for detailed reports -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="h-96 rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="font-semibold text-lg mb-4 text-gray-900 dark:text-gray-100">Revenue Breakdown</h3>
                    <div class="h-full flex items-center justify-center bg-gray-50 dark:bg-gray-700/50 rounded-lg text-gray-400">
                        Chart Placeholder
                    </div>
                </div>
                <div class="h-96 rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="font-semibold text-lg mb-4 text-gray-900 dark:text-gray-100">Quarterly Goals</h3>
                    <div class="h-full flex items-center justify-center bg-gray-50 dark:bg-gray-700/50 rounded-lg text-gray-400">
                        Chart Placeholder
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
