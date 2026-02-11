<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, computed, watch, nextTick } from 'vue';

// Get user name from page props
const page = usePage();
const userName = computed(() => page.props.auth.user.name);
import { 
    AlertTriangle, 
    TrendingUp, 
    TrendingDown,
    Target,
    Users,
    School,
    ShoppingCart,
    AlertCircle,
    ArrowRight,
    Download,
    Flag,
    Search,
    ChevronDown,
    ChevronRight,
    ChevronUp,
    MoreHorizontal,
    Briefcase,
    DollarSign,
    Percent,
    Activity,
    CheckCircle2,
    XCircle,
    Info,
    X,
    Calendar,
    BarChart3,
    PieChart,
    ArrowLeft
} from 'lucide-vue-next';

// Helper function to wrap rupee symbols with CSS class for font styling
const formatRupee = (text) => {
    if (!text) return text;
    return String(text).replace(/₹/g, '<span class="rupee-symbol">₹</span>');
};

// ECharts Imports
import VChart from 'vue-echarts';
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { BarChart, LineChart, PieChart as EPieChart } from 'echarts/charts';
import { GridComponent, TooltipComponent, LegendComponent, DataZoomComponent } from 'echarts/components';

use([CanvasRenderer, BarChart, LineChart, EPieChart, GridComponent, TooltipComponent, LegendComponent, DataZoomComponent]);

// ----------------------------------------------------------------------
// DATA & STATE
// ----------------------------------------------------------------------

const isLoaded = ref(false);
const detailViewOpen = ref(false);
const selectedKpi = ref(null);
const timeRange = ref('12M'); // 12M, 3Y, 5Y, 10Y
const animationStep = ref(0);

onMounted(() => {
    setTimeout(() => {
        isLoaded.value = true;
    }, 100);
});

const regionData = {
    name: 'North India Region',
    fyTarget: '₹ 45.0 Cr',
    achieved: '₹ 28.45 Cr',
    achievedRaw: 28.45,
    targetRaw: 45.0,
    pct: 63.2,
    balance: '₹ 16.55 Cr',
    trend: '+8.4% vs last month'
};

// Sparkline Option (Header)
const sparklineOption = {
    color: ['#fff'],
    tooltip: { trigger: 'axis', formatter: '{c} Cr' },
    grid: { left: 0, right: 0, top: 0, bottom: 0 },
    xAxis: { type: 'category', show: false, data: ['Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'] },
    yAxis: { type: 'value', show: false },
    series: [{ 
        data: [3.2, 3.5, 4.1, 3.8, 4.5, 4.8], 
        type: 'line', 
        smooth: true, 
        symbol: 'none',
        lineStyle: { width: 2, opacity: 0.8 },
        areaStyle: { opacity: 0.1 }
    }]
};

const insights = [
    { id: 1, text: '3 TLs (Suresh, Amit, Rahul) below 70% target achievement.', severity: 'critical', impact: '₹ 1.2 Cr Risk', action: 'Review Performance' },
    { id: 2, text: '₹ 4.2 Cr orders stuck in corporate approvals > 7 days.', severity: 'medium', impact: 'High Delay', action: 'Track Approvals' },
    { id: 3, text: '15% drop in school surveys in South Zone vs last month.', severity: 'medium', impact: 'Pipeline Gap', action: 'Investigate' },
    { id: 4, text: 'Sales returns in West Delhi exceeded safe limit (5%).', severity: 'critical', impact: '- ₹ 45 L', action: 'View Returns' },
];

const kpis = [
    { id: 'revenue', label: 'Total Revenue', value: '₹ 28.45 Cr', change: '+12%', sub: 'vs last year', trend: 'up', icon: DollarSign, color: 'border-[#015276]', shadow: 'shadow-[#FFEEDE]', bg: 'bg-[#FFEEDE]', text: 'text-[#AC0C13]' },
    { id: 'orders', label: 'Total Orders', value: '1,240', change: '+8%', sub: 'vs last month', trend: 'up', icon: ShoppingCart, color: 'border-[#F37B15]', shadow: 'shadow-[#FFEEDE]', bg: 'bg-[#FFEEDE]', text: 'text-[#AC0C13]' },
    { id: 'schools', label: 'Active Schools', value: '450', change: '-2%', sub: 'churn rate', trend: 'down', icon: School, color: 'border-[#015276]', shadow: 'shadow-[#FFEEDE]', bg: 'bg-[#FFEEDE]', text: 'text-[#AC0C13]' },
    { id: 'conversion', label: 'Conversion', value: '68%', change: '+1.5%', sub: 'efficiency', trend: 'up', icon: Percent, color: 'border-[#F37B15]', shadow: 'shadow-[#FFEEDE]', bg: 'bg-[#FFEEDE]', text: 'text-[#AC0C13]' },
    { id: 'returns', label: 'Returns Value', value: '₹ 1.2 Cr', change: '4.2%', sub: 'of revenue', trend: 'up', isBad: true, icon: AlertCircle, color: 'border-[#AC0C13]', shadow: 'shadow-[#FFEEDE]', bg: 'bg-[#FFEEDE]', text: 'text-[#AC0C13]' },
];

// Zone Data
const zonePerformance = ref([
    { 
        id: 1, name: 'North Zone - A', tl: 'Suresh Kumar', target: '5.0', achieved: 62, orders: 120, returns: '1.2%', status: 'On Track', expanded: false,
        teams: [
            { name: 'Arjun (Exec)', achieved: 75 },
            { name: 'Varun (Exec)', achieved: 45 },
            { name: 'Simran (Exec)', achieved: 60 }
        ]
    },
    { 
        id: 2, name: 'North Zone - B', tl: 'Amit Verma', target: '4.5', achieved: 45, orders: 85, returns: '2.4%', status: 'Critical', expanded: false,
        teams: [
            { name: 'Karan (Exec)', achieved: 30 },
            { name: 'Pooja (Exec)', achieved: 55 }
        ]
    },
    { id: 3, name: 'West Zone - A', tl: 'Rahul Sharma', target: '6.0', achieved: 58, orders: 150, returns: '5.1%', status: 'Attention', expanded: false, teams: [] },
    { id: 4, name: 'West Zone - B', tl: 'Priya Singh', target: '5.5', achieved: 72, orders: 180, returns: '0.8%', status: 'On Track', expanded: false, teams: [] },
    { id: 5, name: 'Central Zone', tl: 'Vikram Malhotra', target: '4.0', achieved: 68, orders: 110, returns: '1.5%', status: 'On Track', expanded: false, teams: [] },
]);

// Main Dashboard Charts
const revenueChartOption = {
    tooltip: { trigger: 'axis' },
    legend: { bottom: 0, itemWidth: 10, itemHeight: 10 },
    grid: { top: 20, left: '2%', right: '2%', bottom: 30, containLabel: true },
    xAxis: { type: 'category', data: ['NZ-A', 'NZ-B', 'WZ-A', 'WZ-B', 'CZ'], axisLine: { show: false }, axisTick: { show: false } },
    yAxis: { type: 'value', splitLine: { lineStyle: { type: 'dashed' } } },
    series: [
        { name: 'Achieved', type: 'bar', stack: 'total', data: [3.1, 2.0, 3.5, 3.9, 2.7], itemStyle: { color: '#f97316' }, barWidth: 20 },
        { name: 'Remaining', type: 'bar', stack: 'total', data: [1.9, 2.5, 2.5, 1.6, 1.3], itemStyle: { color: '#e2e8f0' } }
    ]
};

const pipelineConfig = [
    { label: 'Assigned', count: '450', drop: '0%', color: 'bg-slate-100 text-slate-600', border: 'border-slate-200' },
    { label: 'Surveyed', count: '320', drop: '28%', color: 'bg-blue-50 text-blue-700', border: 'border-blue-100' },
    { label: 'Proposal', count: '180', drop: '44%', color: 'bg-indigo-50 text-indigo-700', border: 'border-indigo-100', bottleneck: true },
    { label: 'Order Recv', count: '125', drop: '30%', color: 'bg-orange-50 text-orange-700', border: 'border-orange-100' },
    { label: 'Approved', count: '98', drop: '21%', color: 'bg-emerald-50 text-emerald-700', border: 'border-emerald-100' },
];

const risks = [
    { label: 'Pending Approvals', value: '₹ 4.2 Cr', status: 'High', score: 85, desc: 'Critical delay in orders > 5L' },
    { label: 'LY vs CY Returns', value: '+1.2%', status: 'Medium', score: 45, desc: 'Marginal increase in North Zone' },
    { label: 'Discount Deviation', value: '2.5%', status: 'Low', score: 20, desc: 'Within acceptable range' },
];

const decisions = [
    { text: 'Call North Zone B TL (Amit)', sub: 'Target risk > 50%', type: 'Urgent' },
    { text: 'Review West Zone returns spike', sub: 'Returns > 5%', type: 'Warning' },
    { text: 'Approve pending ₹2.4 Cr orders', sub: 'Aging > 2 days', type: 'Action' },
];

// ----------------------------------------------------------------------
// DEEP DIVE ANALYTICS LOGIC
// ----------------------------------------------------------------------

const openDetailView = (kpi) => {
    selectedKpi.value = kpi;
    detailViewOpen.value = true;
    animationStep.value = 0;
    
    // Staggered animation sequence
    setTimeout(() => { animationStep.value = 1; }, 200); // Overlay
    setTimeout(() => { animationStep.value = 2; }, 500); // Charts
    setTimeout(() => { animationStep.value = 3; }, 900); // Insights
};

const closeDetailView = () => {
    detailViewOpen.value = false;
    setTimeout(() => {
        selectedKpi.value = null;
        animationStep.value = 0;
    }, 300);
};

const getButtonClass = (range) => {
    return timeRange.value === range
        ? 'bg-slate-800 text-white shadow-md'
        : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200';
};

// DUMMY CHART DATA GENERATOR for Deep Dive
const getTrendChartOption = computed(() => {
    const rangeMap = {
        '12M': { x: ['J','F','M','A','M','J','J','A','S','O','N','D'], y: [42,45,60,55,58,62,59,65,70,72,68,75] },
        '3Y': { x: ['2023', '2024', '2025'], y: [450, 520, 610] },
        '5Y': { x: ['2021','2022','2023','2024','2025'], y: [300, 380, 450, 520, 610] },
        '10Y': { x: ['16','17','18','19','20','21','22','23','24','25'], y: [100,120,150,180,210,300,380,450,520,610] },
    };
    
    const data = rangeMap[timeRange.value];
    
    return {
        color: ['#ea580c'],
        tooltip: { trigger: 'axis' },
        grid: { left: '3%', right: '4%', bottom: '3%', padding: 20, containLabel: true },
        xAxis: { type: 'category', boundaryGap: false, data: data.x },
        yAxis: { type: 'value', splitLine: { lineStyle: { type: 'dashed' } } },
        series: [{
            data: data.y,
            type: 'line',
            smooth: true,
            symbolSize: 8,
            areaStyle: {
                opacity: 0.2,
                color: {
                    type: 'linear', x: 0, y: 0, x2: 0, y2: 1,
                    colorStops: [{ offset: 0, color: '#f97316' }, { offset: 1, color: 'rgba(249, 115, 22, 0)' }]
                }
            },
            lineStyle: { width: 4 }
        }]
    };
});

const getCompareChartOption = computed(() => {
    return {
        tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
        grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
        xAxis: { type: 'value', splitLine: { show: false } },
        yAxis: { type: 'category', data: ['North', 'West', 'South', 'East'] },
        series: [{
            name: 'Performance',
            type: 'bar',
            data: [82, 65, 58, 74],
            itemStyle: { borderRadius: [0, 4, 4, 0], color: '#3b82f6' },
            barWidth: 20,
            label: { show: true, position: 'right', formatter: '{c}%' }
        }]
    };
});

const getStatusColor = (status) => {
    if (status === 'Critical') return 'bg-red-50 text-red-700 border-red-200 ring-1 ring-red-100';
    if (status === 'Attention') return 'bg-amber-50 text-amber-700 border-amber-200 ring-1 ring-amber-100';
    return 'bg-emerald-50 text-emerald-700 border-emerald-200 ring-1 ring-emerald-100';
};
const toggleRow = (id) => {
    const zone = zonePerformance.value.find(z => z.id === id);
    if (zone) zone.expanded = !zone.expanded;
};
</script>

<template>
    <Head title="Head GEO Dashboard" />

    <AuthenticatedLayout>
        <!-- MASTER CONTAINER FOR DASHBOARD -->
        <div class="relative transition-all duration-500 ease-in-out pb-10"
             :class="[detailViewOpen ? 'opacity-30 scale-95 blur-sm overflow-hidden h-screen pointer-events-none' : 'opacity-100 scale-100']">
            
            <!-- Greeting Section -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Hi, {{ userName }}!</h1>
                </div>
            </div>
            
            <div class="space-y-8">
                
                <!-- 1) REGIONAL COMMAND HEADER -->
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#ea580c] to-[#c2410c] text-white shadow-xl shadow-orange-900/20 group">
                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10 mix-blend-soft-light"></div>
                    <div class="absolute -right-20 -top-20 h-96 w-96 rounded-full bg-white/10 blur-3xl group-hover:bg-white/15 transition-colors duration-500"></div>
                    
                    <div class="relative z-10 p-6 md:p-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                        <div class="lg:col-span-4 space-y-2">
                            <div class="flex items-center gap-2 text-orange-100/80 uppercase tracking-widest text-[11px] font-bold">
                                <Activity class="w-3.5 h-3.5" /> Regional Command Center
                            </div>
                            <h1 class="text-4xl md:text-5xl font-bold font-display tracking-tight leading-none">
                                {{ regionData.achieved }}
                            </h1>
                            <div class="flex items-center gap-3">
                                <span class="bg-white/20 backdrop-blur-md px-2.5 py-1 rounded text-xs font-bold">{{ regionData.pct }}% Achieved</span>
                                <span class="text-sm font-medium text-orange-100 flex items-center gap-1">
                                    <TrendingUp class="w-4 h-4" /> {{ regionData.trend }}
                                </span>
                            </div>
                        </div>
                        <div class="lg:col-span-4 flex flex-col justify-center h-24 border-l border-white/10 pl-8">
                            <p class="text-xs font-bold text-orange-200 mb-1">6-Month Revenue Trend</p>
                            <div class="h-16 w-full -ml-1">
                                <v-chart class="h-full w-full" :option="sparklineOption" autoresize />
                            </div>
                        </div>
                        <div class="lg:col-span-4 space-y-3 pl-4">
                            <div class="flex justify-between items-end">
                                <div class="text-right w-full">
                                    <p class="text-[10px] uppercase font-bold text-orange-200 mb-1">FY Target: {{ regionData.fyTarget }}</p>
                                    <div class="h-2.5 w-full bg-black/20 rounded-full overflow-hidden backdrop-blur-sm">
                                        <div 
                                            class="h-full bg-white shadow-[0_0_10px_rgba(255,255,255,0.5)] rounded-full transition-all duration-1000 ease-out" 
                                            :style="{ width: isLoaded ? regionData.pct + '%' : '0%' }"
                                        ></div>
                                    </div>
                                    <p class="text-xs font-bold text-orange-100 mt-2 text-right">Balance: {{ regionData.balance }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DASHBOARD CONTENT -->
                <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                    
                    <div class="xl:col-span-3 space-y-8">
                        <!-- 2) INTERACTIVE EXECUTIVE KPI STRIP -->
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            <button 
                                v-for="(kpi, idx) in kpis" :key="idx" 
                                @click="openDetailView(kpi)"
                                :class="['group relative bg-[#FFFAF7] dark:bg-slate-800 rounded-xl p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border-b-4 text-left outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#015276]', kpi.color, 'border border-t-slate-100 border-l-slate-100 border-r-slate-100 dark:border-slate-700']"
                            >
                                <div class="flex items-start justify-between mb-3">
                                    <div :class="['p-2 rounded-lg transition-colors group-hover:scale-110', kpi.bg, kpi.text]">
                                        <component :is="kpi.icon" class="w-5 h-5" />
                                    </div>
                                    <div class="flex items-center gap-0.5 text-xs font-bold">
                                        <span :class="kpi.isBad ? 'text-red-600' : 'text-emerald-600'">{{ kpi.change }}</span>
                                        <component :is="kpi.trend === 'up' ? TrendingUp : TrendingDown" :class="['w-3 h-3', kpi.isBad ? 'text-red-600' : 'text-emerald-600']" />
                                    </div>
                                </div>
                                <p class="text-2xl font-bold text-[#015276] dark:text-white" v-html="formatRupee(kpi.value)"></p>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide mt-1">{{ kpi.label }}</p>
                                <div class="absolute inset-0 rounded-xl ring-2 ring-transparent group-hover:ring-black/5 transition-all"></div>
                            </button>
                        </div>

                         <!-- 4) ZONE & TEAM PERFORMANCE (TABLE) -->
                        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-slate-50/50">
                                <div>
                                    <h3 class="font-bold text-slate-800 dark:text-white text-lg flex items-center gap-2">
                                        <Target class="w-5 h-5 text-brand-600" /> Performance Cockpit
                                    </h3>
                                    <p class="text-xs text-slate-500 mt-1">Real-time zone wise breakdown</p>
                                </div>
                                <div class="flex gap-2">
                                    <button class="p-2 hover:bg-slate-100 rounded-lg text-slate-500 transition-colors"><Search class="w-4 h-4" /></button>
                                    <button class="text-xs font-bold text-brand-600 px-3 py-1.5 bg-brand-50 rounded-lg hover:bg-brand-100 transition-colors">
                                        View Full Report
                                    </button>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead class="bg-slate-50 dark:bg-slate-700/20 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                                        <tr>
                                            <th class="px-6 py-4 w-10"></th> <!-- Expand Icon -->
                                            <th class="px-2 py-4">Zone / TL</th>
                                            <th class="px-4 py-4">Target (Cr)</th>
                                            <th class="px-6 py-4 text-center">Achievement</th>
                                            <th class="px-4 py-4 text-center">Orders</th>
                                            <th class="px-4 py-4 text-center">Returns</th>
                                            <th class="px-6 py-4 text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 text-sm">
                                        <template v-for="zone in zonePerformance" :key="zone.id">
                                            <!-- Main Row -->
                                            <tr class="hover:bg-slate-50/80 transition-colors group cursor-pointer" @click="toggleRow(zone.id)">
                                                <td class="px-6 py-4 text-slate-400">
                                                    <component :is="zone.expanded ? ChevronUp : ChevronDown" class="w-4 h-4" />
                                                </td>
                                                <td class="px-2 py-4">
                                                    <div class="font-bold text-slate-800 dark:text-slate-200">{{ zone.name }}</div>
                                                    <div class="text-xs text-slate-500 flex items-center gap-1 mt-0.5">
                                                        <Briefcase class="w-3 h-3" /> {{ zone.tl }}
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-slate-600 font-medium">₹ {{ zone.target }}</td>
                                                <td class="px-6 py-4">
                                                    <div class="flex flex-col gap-1 w-32 mx-auto">
                                                        <div class="flex justify-between text-xs font-bold">
                                                            <span>{{ zone.achieved }}%</span>
                                                            <span class="text-slate-400">Target</span>
                                                        </div>
                                                        <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                                            <div :class="['h-full rounded-full transition-all duration-700', zone.achieved < 50 ? 'bg-red-500' : zone.achieved < 70 ? 'bg-amber-500' : 'bg-emerald-500']" 
                                                                 :style="{ width: zone.achieved + '%' }"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-center font-bold text-slate-700">{{ zone.orders }}</td>
                                                <td class="px-4 py-4 text-center text-red-600 font-medium bg-red-50/50 rounded lg:mr-4">{{ zone.returns }}</td>
                                                <td class="px-6 py-4 text-right">
                                                    <span :class="['px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border', getStatusColor(zone.status)]">
                                                        {{ zone.status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            
                                            <!-- Expanded Child Row -->
                                            <tr v-if="zone.expanded" class="bg-slate-50/50 animate-in slide-in-from-top-2 duration-200">
                                                <td colspan="7" class="px-6 py-4">
                                                    <div class="ml-8 pl-4 border-l-2 border-slate-200 space-y-2">
                                                        <p class="text-xs font-bold text-slate-400 uppercase mb-2">Team Breakdown</p>
                                                        <div v-if="zone.teams.length > 0" class="grid grid-cols-3 gap-4">
                                                            <div v-for="(team, tIdx) in zone.teams" :key="tIdx" class="bg-white p-3 rounded border border-slate-200 flex justify-between items-center text-xs">
                                                                <span class="font-medium text-slate-700">{{ team.name }}</span>
                                                                <span :class="['font-bold', team.achieved < 50 ? 'text-red-600' : 'text-emerald-600']">{{ team.achieved }}%</span>
                                                            </div>
                                                        </div>
                                                        <div v-else class="text-xs text-slate-400 italic">No direct reports data available.</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                         <!-- 5) VISUAL ANALYTICS (NEW) -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Revenue Mix Chart -->
                            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm p-6">
                                <h4 class="font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2 text-sm uppercase tracking-wider">
                                    <DollarSign class="w-4 h-4 text-slate-400" /> Revenue Mix vs Target
                                </h4>
                                <div class="h-64 w-full">
                                    <v-chart class="h-full w-full" :option="revenueChartOption" autoresize />
                                </div>
                            </div>
                            <!-- 6) PIPELINE HEALTH -->
                            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm p-6 flex flex-col justify-center">
                                <div class="flex justify-between items-center mb-6">
                                    <h4 class="font-bold text-slate-800 dark:text-white flex items-center gap-2 text-sm uppercase tracking-wider">
                                        <Activity class="w-4 h-4 text-slate-400" /> Pipeline Health
                                    </h4>
                                    <div class="flex items-center gap-2 text-[10px] text-slate-400">
                                        <span class="w-2 h-2 rounded-full bg-red-100 border border-red-300"></span> Bottleneck
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div v-for="(stage, i) in pipelineConfig" :key="i" class="relative">
                                        <div :class="['flex items-center justify-between p-3 rounded-lg border relative z-10', stage.color, stage.border, stage.bottleneck ? 'ring-2 ring-red-300 ring-offset-1' : '']">
                                            <div class="flex items-center gap-3">
                                                <span class="text-xs font-bold uppercase tracking-widest min-w-[80px]">{{ stage.label }}</span>
                                                <span class="text-lg font-bold">{{ stage.count }}</span>
                                            </div>
                                            <span class="text-[10px] font-bold opacity-70">Drop: {{ stage.drop }}</span>
                                            <AlertCircle v-if="stage.bottleneck" class="absolute -right-2 -top-2 w-5 h-5 text-red-500 fill-white" />
                                        </div>
                                        <div v-if="i < pipelineConfig.length - 1" class="h-4 w-0.5 bg-slate-300 mx-auto my-[-4px] relative z-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN (Risk & Decision) -->
                    <div class="xl:col-span-1 space-y-6">
                        <!-- 3) OPERATIONS ALERT PANEL (SMARTER) -->
                        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-0 overflow-hidden shadow-sm">
                            <div class="px-5 py-4 bg-red-50 dark:bg-red-900/10 border-b border-red-100 flex justify-between items-center">
                                <h3 class="font-bold text-red-7000 dark:text-red-400 text-sm uppercase tracking-widest flex items-center gap-2">
                                    <AlertTriangle class="w-4 h-4 text-red-600" /> Operations Alerts
                                </h3>
                                <span class="bg-red-200 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded-full animate-pulse">2 Critical</span>
                            </div>
                            <div class="divide-y divide-slate-100">
                                <div v-for="insight in insights" :key="insight.id" class="p-4 hover:bg-slate-50 transition-colors">
                                    <div class="flex justify-between items-start mb-1">
                                        <span :class="['text-[10px] font-bold uppercase px-1.5 py-0.5 rounded', insight.severity === 'critical' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700']">
                                            {{ insight.severity }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-medium">Impact: {{ insight.impact }}</span>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700 leading-snug my-2">{{ insight.text }}</p>
                                    <button class="text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1 group">
                                        {{ insight.action }} <ArrowRight class="w-3 h-3 transition-transform group-hover:translate-x-1" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- 7) FINANCIAL MONITOR -->
                        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-5 shadow-sm">
                            <h3 class="font-bold text-slate-800 dark:text-white mb-5 text-sm uppercase tracking-widest flex items-center gap-2">
                                <CheckCircle2 class="w-4 h-4 text-slate-400" /> Risk Monitor
                            </h3>
                            <div class="space-y-5">
                                <div v-for="(risk, idx) in risks" :key="idx" class="relative">
                                    <div class="flex justify-between items-end mb-1">
                                        <span class="text-xs font-bold text-slate-600">{{ risk.label }}</span>
                                        <span :class="['text-sm font-bold', risk.status === 'High' ? 'text-red-600' : risk.status === 'Medium' ? 'text-amber-600' : 'text-emerald-600']">
                                            {{ risk.value }}
                                        </span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden mb-1">
                                        <div :class="['h-full rounded-full', risk.status === 'High' ? 'bg-red-500' : risk.status === 'Medium' ? 'bg-amber-500' : 'bg-emerald-500']" 
                                             :style="{ width: risk.score + '%' }"></div>
                                    </div>
                                    <p class="text-[10px] text-slate-400 italic leading-tight">{{ risk.desc }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- 8) DECISION CENTER -->
                        <div class="bg-slate-900 rounded-xl p-5 shadow-lg text-white">
                            <h3 class="font-bold text-white mb-4 text-sm uppercase tracking-widest flex items-center gap-2">
                                <Flag class="w-4 h-4 text-orange-500" /> Recommended Actions
                            </h3>
                            <div class="space-y-3">
                                <div v-for="(dec, idx) in decisions" :key="idx" 
                                     class="p-3 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 transition-colors cursor-pointer group">
                                    <div class="flex justify-between items-start mb-1">
                                        <span class="text-[10px] font-bold text-orange-400 uppercase">{{ dec.type }}</span>
                                        <ChevronRight class="w-3 h-3 text-slate-500 group-hover:text-white transition-colors" />
                                    </div>
                                    <p class="text-sm font-medium text-slate-200 group-hover:text-white">{{ dec.text }}</p>
                                    <p class="text-[10px] text-slate-500 mt-1">{{ dec.sub }}</p>
                                </div>
                            </div>
                             
                            <button class="w-full mt-4 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold py-3 rounded-lg transition-colors shadow-lg shadow-orange-900/20">
                                Generate Daily Briefing
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- --------------------------------------- -->
        <!-- DEEP DIVE ANALYTICS OVERLAY (SLIDE UP) -->
        <!-- --------------------------------------- -->
        <transition 
            enter-active-class="transform transition ease-out duration-300" 
            enter-from-class="translate-y-full opacity-0" 
            enter-to-class="translate-y-0 opacity-100"
            leave-active-class="transform transition ease-in duration-200" 
            leave-from-class="translate-y-0 opacity-100" 
            leave-to-class="translate-y-full opacity-0"
        >
            <div v-if="detailViewOpen" class="fixed inset-x-0 bottom-0 top-[10vh] z-50 bg-white dark:bg-slate-900 rounded-t-3xl shadow-[0_-20px_50px_rgba(0,0,0,0.3)] overflow-hidden flex flex-col">
                
                <!-- Header Control Frame -->
                <div v-if="animationStep >= 1" class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 backdrop-blur-md sticky top-0 z-20">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-xl bg-orange-50 dark:bg-slate-800 text-orange-600 ring-4 ring-orange-50/50">
                            <component :is="selectedKpi.icon" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-0.5">Deep Dive Analytics</p>
                            <h2 class="text-2xl font-bold font-display text-slate-800 dark:text-white flex items-center gap-2">
                                {{ selectedKpi.label }} 
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-sm text-slate-600" v-html="formatRupee(selectedKpi.value)"></span>
                            </h2>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="bg-white rounded-lg p-1 border border-slate-200 flex shadow-sm">
                            <button v-for="range in ['12M', '3Y', '5Y', '10Y']" :key="range" 
                                    @click="timeRange = range"
                                    :class="['px-4 py-1.5 rounded-md text-sm font-bold transition-all', getButtonClass(range)]">
                                {{ range }}
                            </button>
                        </div>
                        <button @click="closeDetailView" class="p-2 bg-slate-100 hover:bg-slate-200 rounded-full transition-colors text-slate-500">
                            <X class="w-6 h-6" />
                        </button>
                    </div>
                </div>

                <!-- Main Analytics Body -->
                <div class="flex-1 overflow-y-auto p-8 bg-slate-50/30">
                    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        <!-- Col 1: Trend Chart & Insight -->
                        <div class="lg:col-span-2 space-y-6">
                            
                            <!-- Main Chart -->
                             <transition 
                                enter-active-class="transition ease-out duration-700 delay-100" 
                                enter-from-class="opacity-0 translate-y-8" 
                                enter-to-class="opacity-100 translate-y-0"
                            >
                                <div v-if="animationStep >= 2" class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 h-[400px]">
                                    <div class="flex justify-between items-center mb-6">
                                        <h3 class="font-bold text-slate-700 dark:text-white flex items-center gap-2">
                                            <TrendingUp class="w-5 h-5 text-orange-500" /> Historical Trend Analysis
                                        </h3>
                                        <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                                            <span class="w-3 h-3 rounded bg-orange-500"></span> Actuals
                                        </div>
                                    </div>
                                    <div class="h-[300px] w-full">
                                        <v-chart class="h-full w-full" :option="getTrendChartOption" autoresize />
                                    </div>
                                </div>
                            </transition>
                            
                            <!-- Smart Insight Text -->
                            <transition 
                                enter-active-class="transition ease-out duration-700 delay-300" 
                                enter-from-class="opacity-0 translate-y-4" 
                                enter-to-class="opacity-100 translate-y-0"
                            >
                                <div v-if="animationStep >= 3" class="bg-indigo-50 dark:bg-slate-800 p-5 rounded-xl border border-indigo-100 dark:border-slate-700 flex gap-4">
                                    <div class="p-2 bg-white rounded-lg h-fit shadow-sm text-indigo-600">
                                        <Info class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-indigo-900 border-b border-indigo-200 pb-1 mb-2 inline-block">AI Insight</h4>
                                        <p class="text-sm text-indigo-800 leading-relaxed font-medium">
                                            "Revenue peaked in March due to bulk approvals from North Zone. However, Q2 shows a slight dip (-5%) aligned with the new policy rollout. Recommended to push focused campaigns in West Zone to recover Q3 baseline."
                                        </p>
                                    </div>
                                </div>
                            </transition>
                        </div>

                        <!-- Col 2: Comparative & Actions -->
                        <div class="lg:col-span-1 space-y-6">
                             
                            <!-- Comparative Chart -->
                             <transition 
                                enter-active-class="transition ease-out duration-700 delay-200" 
                                enter-from-class="opacity-0 translate-x-8" 
                                enter-to-class="opacity-100 translate-x-0"
                            >
                                <div v-if="animationStep >= 2" class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700 h-[300px]">
                                    <h3 class="font-bold text-slate-700 dark:text-white mb-4 flex items-center gap-2">
                                        <BarChart3 class="w-5 h-5 text-blue-500" /> Zone Breakdown
                                    </h3>
                                    <div class="h-[220px] w-full">
                                        <v-chart class="h-full w-full" :option="getCompareChartOption" autoresize />
                                    </div>
                                </div>
                            </transition>

                            <!-- Quick Actions -->
                             <transition 
                                enter-active-class="transition ease-out duration-700 delay-400" 
                                enter-from-class="opacity-0 translate-y-4" 
                                enter-to-class="opacity-100 translate-y-0"
                            >
                                <div v-if="animationStep >= 3" class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-lg border border-slate-100 dark:border-slate-700">
                                    <h3 class="font-bold text-slate-700 dark:text-white mb-4">Quick Actions</h3>
                                    <div class="space-y-3">
                                        <button class="w-full flex items-center justify-between p-3 rounded-lg border border-slate-200 hover:border-orange-500 hover:bg-orange-50 transition-all group">
                                            <span class="text-sm font-medium group-hover:text-orange-700 transition-colors">Download Detailed Report</span>
                                            <Download class="w-4 h-4 text-slate-400 group-hover:text-orange-500" />
                                        </button>
                                        <button class="w-full flex items-center justify-between p-3 rounded-lg border border-slate-200 hover:border-orange-500 hover:bg-orange-50 transition-all group">
                                            <span class="text-sm font-medium group-hover:text-orange-700 transition-colors">Compare with Previous Year</span>
                                            <ArrowLeft class="w-4 h-4 text-slate-400 group-hover:text-orange-500 rotate-180" />
                                        </button>
                                    </div>
                                </div>
                            </transition>

                        </div>
                    </div>
                </div>

            </div>
        </transition>

    </AuthenticatedLayout>
</template>
