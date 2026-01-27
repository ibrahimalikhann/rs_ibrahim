<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import StatCard from '@/Components/StatCard.vue';
import { Target, TrendingUp, Award, Layers } from 'lucide-vue-next';

const stats = [
    { title: 'Portfolio Value', value: '$12.5M', change: '+22%', trend: 'up', icon: Layers },
    { title: 'Strategic Goals', value: '8/10', change: '80%', trend: 'up', icon: Target },
    { title: 'Growth Rate', value: '15.4%', change: '+2.1%', trend: 'up', icon: TrendingUp },
    { title: 'Top Performers', value: '12', change: '+4', trend: 'up', icon: Award },
];
</script>

<template>
    <Head title="VP Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Strategic Strategic Dashboard
            </h2>
        </template>

        <div class="space-y-6">
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Vice President Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">Strategic oversight and portfolio management.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <StatCard v-for="(stat, index) in stats" :key="index" v-bind="stat" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl p-6 text-white shadow-lg">
                    <h3 class="text-xl font-bold mb-2">Q4 Strategic Vision</h3>
                    <p class="opacity-90 mb-4">Focus on expanding market share in the APAC region while optimizing operational costs by 15%.</p>
                    <button class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-4 py-2 rounded-lg transition-colors text-sm font-medium">View Detailed Plan</button>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-4">Department Resource Allocation</h3>
                    <div class="space-y-4">
                         <div v-for="dept in ['Engineering', 'Marketing', 'Sales', 'HR']" :key="dept">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-700 dark:text-gray-300">{{ dept }}</span>
                                <span class="text-gray-900 dark:text-gray-100 font-medium">{{ Math.floor(Math.random() * 40 + 20) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-indigo-500 h-2 rounded-full" :style="{ width: Math.random() * 60 + 20 + '%' }"></div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
