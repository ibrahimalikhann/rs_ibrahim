<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import VueApexCharts from 'vue3-apexcharts';
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { PieChart } from 'echarts/charts';
import {
  TitleComponent,
  TooltipComponent,
  LegendComponent
} from 'echarts/components';
import VChart from 'vue-echarts';
import { ArrowUp, ArrowDown, DollarSign, Users, ShoppingBag, Activity } from 'lucide-vue-next';

// Register ECharts components
use([
  CanvasRenderer,
  PieChart,
  TitleComponent,
  TooltipComponent,
  LegendComponent
]);

const loading = ref(true);

onMounted(() => {
    // Simulate data loading for skeleton effect
    setTimeout(() => {
        loading.value = false;
    }, 1500);
});

// Stats Data
const stats = [
    { name: 'Total Revenue', value: '$45,231.89', change: '+20.1%', trend: 'up', icon: DollarSign },
    { name: 'Active Users', value: '+2,350', change: '+180.1%', trend: 'up', icon: Users },
    { name: 'Sales', value: '+12,234', change: '-4.5%', trend: 'down', icon: ShoppingBag },
    { name: 'Active Now', value: '+573', change: '+201', trend: 'up', icon: Activity },
];

// ApexChart Options
const areaChartOptions = {
    chart: {
        type: 'area',
        toolbar: { show: false },
        background: 'transparent',
        fontFamily: 'Outfit, sans-serif'
    },
    colors: ['#6366f1'],
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 2 },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
        labels: { style: { colors: '#94a3b8' } },
        axisBorder: { show: false },
        axisTicks: { show: false }
    },
    yaxis: {
        labels: { style: { colors: '#94a3b8' } }
    },
    tooltip: { theme: 'dark' },
    grid: { borderColor: '#334155', strokeDashArray: 4, opacity: 0.3 },
    fill: { gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.05, stops: [0, 90, 100] } },
    theme: { mode: 'dark' }
};

const areaChartSeries = [{ name: 'Revenue', data: [31, 40, 28, 51, 42, 109, 100] }];

// ECharts Options
const pieChartOption = ref({
    tooltip: { trigger: 'item' },
    legend: { top: '5%', left: 'center', textStyle: { color: '#9ca3af' } },
    series: [
        {
            name: 'Access From',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            itemStyle: { borderRadius: 10, borderColor: '#1f2937', borderWidth: 2 },
            label: { show: false, position: 'center' },
            emphasis: { label: { show: true, fontSize: 20, fontWeight: 'bold', color: '#fff' } },
            labelLine: { show: false },
            data: [
                { value: 1048, name: 'Search Engine', itemStyle: { color: '#6366f1' } },
                { value: 735, name: 'Direct', itemStyle: { color: '#8b5cf6' } },
                { value: 580, name: 'Email', itemStyle: { color: '#ec4899' } },
                { value: 484, name: 'Union Ads', itemStyle: { color: '#10b981' } },
                { value: 300, name: 'Video Ads', itemStyle: { color: '#f59e0b' } }
            ]
        }
    ]
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 font-sans tracking-tight">Dashboard Overview</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Welcome back! Here's what's happening today.</p>
        </div>

        <!-- Skeleton Loader -->
        <div v-if="loading" class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-4">
             <div v-for="i in 4" :key="i" class="h-32 rounded-xl bg-gray-200 dark:bg-gray-800 animate-pulse"></div>
        </div>
        <div v-if="loading" class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="h-96 rounded-xl bg-gray-200 dark:bg-gray-800 animate-pulse"></div>
            <div class="h-96 rounded-xl bg-gray-200 dark:bg-gray-800 animate-pulse"></div>
        </div>

        <!-- Real Content -->
        <div v-else class="space-y-6">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div v-for="stat in stats" :key="stat.name" class="overflow-hidden rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm ring-1 ring-gray-900/5 transition-all hover:shadow-lg hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400">
                            <component :is="stat.icon" class="h-6 w-6" />
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ stat.name }}</p>
                            <div class="flex items-baseline">
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ stat.value }}</p>
                                <p :class="[stat.trend === 'up' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400', 'ml-2 flex items-baseline text-sm font-semibold']">
                                    <component :is="stat.trend === 'up' ? ArrowUp : ArrowDown" class="h-4 w-4 self-center shrink-0" aria-hidden="true" />
                                    {{ stat.change }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- ApexChart Area -->
                <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4">Revenue Trends</h3>
                    <div class="h-80 w-full text-gray-900 dark:text-gray-100">
                        <apexchart type="area" height="100%" :options="areaChartOptions" :series="areaChartSeries" />
                    </div>
                </div>

                <!-- ECharts Pie -->
                <div class="rounded-xl bg-white dark:bg-gray-800 p-6 shadow-sm ring-1 ring-gray-900/5">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-gray-100 mb-4">User Demographics</h3>
                    <div class="h-80 w-full">
                        <VChart :option="pieChartOption" class="h-full w-full" :autoresize="true" />
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions / Command Palette Hint -->
             <div class="rounded-xl bg-gradient-to-r from-primary-900 to-secondary-900 p-8 shadow-lg text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold">Power User?</h3>
                    <p class="mt-2 text-primary-100 max-w-xl">
                         Use the global command palette to quickly navigate, search, and perform actions without lifting your hands from the keyboard.
                    </p>
                    <div class="mt-6 flex items-center gap-4">
                        <span class="inline-flex items-center rounded-md bg-white/10 px-3 py-2 text-sm font-medium text-white ring-1 ring-inset ring-white/20">
                            Press <kbd class="mx-1 font-sans font-bold">Ctrl</kbd> + <kbd class="mx-1 font-sans font-bold">K</kbd>
                        </span>
                    </div>
                </div>
                <!-- Decor bg -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 h-[400px] w-[400px] rounded-full bg-white/5 blur-3xl"></div>
             </div>
        </div>
    </AuthenticatedLayout>
</template>
