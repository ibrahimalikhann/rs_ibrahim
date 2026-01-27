<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { 
    Target, 
    TrendingUp, 
    PieChart, 
    Package, 
    RotateCcw, 
    School, 
    CheckCircle2,
    Users,
    ArrowUpRight,
    ArrowDownRight,
    Wallet,
    Calendar,
    Briefcase,
    Lightbulb,
    AlertTriangle,
    Clock,
    Zap,
    MapPin,
    Phone,
    FileCheck,
    ClipboardList,
    ChevronRight,
    MoreHorizontal,
    AlertCircle,
    BarChart3,
    ArrowRight,
    Percent,
    Activity,
    X
} from 'lucide-vue-next';

// State for View Selection
const viewMode = ref('self'); // 'self' or 'team'

const toggleView = (mode) => {
    viewMode.value = mode;
};

// Formatting helpers
const formatCurrency = (val) => new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumSignificantDigits: 3 }).format(val);

// Dummy Data
const selfData = {
    target: 1500000,
    achieved: 845000,
    balance: 655000,
    quantity: 12500,
    returns: 45000,
    assignedSchools: 120,
    activeSchools: 85,
    achievedPct: 56.3
};

const teamData = {
    target: 25000000,
    achieved: 11200000,
    balance: 13800000,
    quantity: 185000,
    returns: 210000,
    assignedSchools: 1500,
    activeSchools: 980,
    achievedPct: 44.8
};

const currentData = computed(() => viewMode.value === 'self' ? selfData : teamData);

// Computed gradients
const activeGradient = computed(() => {
    return viewMode.value === 'self' 
        ? 'from-orange-600 to-orange-700 shadow-orange-900/5' 
        : 'from-blue-700 to-blue-800 shadow-blue-900/5'; // Distinct blue for team view
});

// Self View Insights
const currentInsights = [
    { type: 'warning', text: 'You need to reach 39 more schools to hit this month’s target.', icon: AlertTriangle },
    { type: 'alert', text: 'Pending approvals are delaying ₹1.2L in revenue.', icon: Clock },
    { type: 'info', text: 'Survey activity is low — 12 schools untouched.', icon: Lightbulb },
];

const todaysFocus = [
    { id: 1, title: 'Visit St. Xavier’s High School', sub: 'Demo scheduled at 11:00 AM', type: 'visit', complete: false, icon: MapPin },
    { id: 2, title: 'Call Principal Sharma', sub: 'DPS Mathura Road - Follow up on proposal', type: 'call', complete: false, icon: Phone },
    { id: 3, title: 'Approve Pending Orders', sub: '3 orders waiting for approval (₹45k)', type: 'admin', complete: false, icon: FileCheck },
    { id: 4, title: 'Complete School Surveys', sub: '2 schools in Sector 14 pending', type: 'survey', complete: false, icon: ClipboardList },
];

const pipelineStages = [
    { name: 'Assigned', count: 120, color: 'bg-gray-100 text-gray-600', width: '100%' },
    { name: 'Surveyed', count: 85, color: 'bg-blue-50 text-blue-600', width: '70%', highlight: false },
    { name: 'Proposal', count: 45, color: 'bg-orange-50 text-orange-600', width: '37%', highlight: true }, // Bottleneck
    { name: 'Order Rec.', count: 12, color: 'bg-purple-50 text-purple-600', width: '10%', highlight: false },
    { name: 'Approved', count: 10, color: 'bg-green-50 text-green-600', width: '8%', highlight: false },
];

// TEAM VIEW SPECIFIC DATA
const teamInsights = [
    { type: 'alert', text: '2 executives (Amit, Sanya) are below 40% target achievement.', icon: AlertTriangle },
    { type: 'warning', text: '18 schools pending survey across team in Sector 4.', icon: MapPin },
    { type: 'info', text: '₹4.6L revenue stuck in approvals awaiting your review.', icon: FileCheck },
];

const selectedMetric = ref(null);

const selectMetric = (metric) => {
    selectedMetric.value = selectedMetric.value === metric ? null : metric;
};

// Dummy Drill Down Chart Options (Reactive based on selection)
const metricChartOptions = computed(() => ({
    chart: { type: 'area', fontFamily: 'Poppins, sans-serif', toolbar: { show: false } }, // Ensure font matches
    stroke: { curve: 'smooth', width: 2 },
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
    colors: [selectedMetric.value === 'revenue' ? '#A855F7' : (selectedMetric.value === 'schools' ? '#10B981' : '#3B82F6')],
    dataLabels: { enabled: false },
    grid: { show: true, borderColor: '#f1f5f9' },
    xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] }
}));

const metricChartSeries = computed(() => {
    // Generate dummy data based on metric
    if (selectedMetric.value === 'revenue') return [{ name: 'Revenue', data: [30, 40, 35, 50, 49, 60, 70, 91, 125, 100, 140, 150] }];
    if (selectedMetric.value === 'returns') return [{ name: 'Returns', data: [10, 5, 8, 12, 15, 8, 10, 5, 4, 3, 2, 8] }];
    if (selectedMetric.value === 'schools') return [{ name: 'Active Schools', data: [80, 82, 85, 85, 90, 95, 100, 110, 115, 118, 120, 120] }];
    return [{ name: 'Target Quantity', data: [28, 32, 33, 35, 40, 45, 50, 55, 60, 65, 78, 85] }];
});

const teamExecutives = [
    { name: 'Rahul Verma', target: 500000, achieved: 460000, schools_assign: 45, schools_active: 40, orders: 12, pending: 3, status: 'Good' },
    { name: 'Priya Singh', target: 500000, achieved: 440000, schools_assign: 42, schools_active: 35, orders: 10, pending: 1, status: 'Good' },
    { name: 'Amit Kumar', target: 500000, achieved: 210000, schools_assign: 40, schools_active: 12, orders: 4, pending: 8, status: 'Risk' },
    { name: 'Sanya Gupta', target: 500000, achieved: 380000, schools_assign: 38, schools_active: 28, orders: 9, pending: 2, status: 'Watch' },
    { name: 'Vikram Raj', target: 500000, achieved: 490000, schools_assign: 44, schools_active: 42, orders: 15, pending: 0, status: 'Good' },
];

// Legacy KPI Data
const legacyData = {
    targetQty: 12500,
    targetVal: 2500000,
    achievedQty: 8500,
    achievedVal: 1800000,
    orders: 450,
    schools: 120,
    visitsSenior: 15,
    visitsGeneral: 45,
    samplesCY: 320,
    samplesLY: 280,
    returnsLYQty: 1200,
    returnsLYVal: 150000,
    discountCY: 18.5,
    discountLY: 20.1
};

// Sparkline Chart Config (Self)
const chartOptions = {
    chart: { type: 'area', height: 100, sparkline: { enabled: true } },
    stroke: { curve: 'smooth', width: 2 },
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] } },
    colors: ['#ea580c'], // Brand Orange
    tooltip: { fixed: { enabled: false }, x: { show: false }, marker: { show: false } }
};
const chartSeries = [{ name: 'Revenue', data: [30, 40, 35, 50, 49, 60, 70, 91, 125, 100, 140] }];

// Team Chart Config (Vertical Bar)
const teamChartOptions = {
    chart: { type: 'bar', height: 280, toolbar: { show: false } },
    plotOptions: { bar: { borderRadius: 4, horizontal: false, columnWidth: '55%' } },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 2, colors: ['transparent'] },
    xaxis: { categories: ['Rahul', 'Priya', 'Amit', 'Sanya', 'Vikram'], axisBorder: { show: false }, axisTicks: { show: false } },
    yaxis: { show: false },
    fill: { opacity: 1 },
    colors: ['#cbd5e1', '#1d4ed8'], // Target (Grey), Achieved (Blue)
    legend: { show: true, position: 'top', horizontalAlign: 'right' },
    grid: { show: false }
};

const teamChartSeries = [
    { name: 'Target', data: [50, 50, 50, 50, 50] }, // Scaled down for visual simplicity
    { name: 'Achieved', data: [46, 44, 21, 38, 49] }
];

const teamPerformance = [
    { name: 'Rahul Verma', target: 500000, achieved: 460000, pct: 92, status: 'good' },
    { name: 'Priya Singh', target: 500000, achieved: 440000, pct: 88, status: 'good' },
    { name: 'Amit Kumar', target: 500000, achieved: 225000, pct: 45, status: 'attention' },
];

</script>

<template>
    <Head title="Overview" />

    <AuthenticatedLayout>
        
        <!-- Dashboard Header / Toolbar - Enterprise -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white font-sans tracking-tight">
                    {{ viewMode === 'self' ? 'My Overview' : 'Team Management' }}
                </h1>
                <p class="text-sm text-slate-500 font-semibold mt-1 flex items-center gap-1">
                    <Zap class="w-4 h-4 text-brand-600 fill-brand-100" />
                    System Status: <span class="text-green-600">Online & Updated</span>
                </p>
            </div>
            
            <!-- View Switcher - High Contrast pill -->
            <div class="bg-white dark:bg-slate-800 p-1 rounded-lg flex gap-1 border border-slate-300 dark:border-slate-600 shadow-sm">
                <button 
                    @click="toggleView('self')"
                    :class="[
                        'px-4 py-2 rounded-md text-sm font-bold transition-all duration-200 flex items-center gap-2',
                        viewMode === 'self' 
                            ? 'bg-slate-900 text-white shadow-md' 
                            : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                    ]"
                >
                    <Users class="w-4 h-4" />
                    My View
                </button>
                <div class="w-px bg-slate-200 my-1 mx-1"></div>
                <button 
                    @click="toggleView('team')"
                    :class="[
                        'px-4 py-2 rounded-md text-sm font-bold transition-all duration-200 flex items-center gap-2',
                        viewMode === 'team' 
                            ? 'bg-blue-700 text-white shadow-md' 
                            : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100'
                    ]"
                >
                    <Briefcase class="w-4 h-4" />
                    Team View
                </button>
            </div>
        </div>

        <!-- Upper Section: Hero + Insights -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
            
            <!-- Hero Stats Block -->
            <div class="lg:col-span-8 relative overflow-hidden rounded-xl bg-gradient-to-r text-white shadow-md border border-slate-900/10" :class="activeGradient">
                <div class="relative z-10 p-6 flex flex-col justify-between h-full min-h-[180px]">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 sm:gap-0">
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded text-xs font-bold uppercase tracking-wider bg-white/20 text-white border border-white/20 mb-3 shadow-sm">
                                {{ viewMode === 'self' ? 'FY 2024-25 Target' : 'Team Annual Target' }}
                            </span>
                            <div class="flex items-baseline gap-3">
                                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white drop-shadow-sm">
                                    {{ formatCurrency(currentData.target) }}
                                </h2>
                                <span class="text-white/80 text-sm sm:text-base font-semibold">Goal</span>
                            </div>
                        </div>
                         <div class="flex gap-6 items-center">
                             <div class="text-left sm:text-right">
                                <p class="text-white/70 text-xs font-bold uppercase tracking-wider mb-1">Balance</p>
                                <p class="text-xl font-bold">{{ formatCurrency(currentData.balance) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="flex items-end justify-between mb-2">
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-bold tracking-tight">{{ currentData.achievedPct }}%</span>
                                <span class="text-white/80 text-sm font-semibold">completed</span>
                            </div>
                            <span class="text-white text-sm font-bold bg-black/20 px-2 py-1 rounded">
                                {{ formatCurrency(currentData.achieved) }} achieved
                            </span>
                        </div>
                        <div class="w-full bg-black/20 rounded-sm h-2 backdrop-blur-sm">
                            <div class="bg-white h-full rounded-sm shadow-sm relative" :style="{ width: currentData.achievedPct + '%' }"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Automated Insights (Dynamic based on View) -->
            <div class="lg:col-span-4 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col">
                <div class="bg-slate-50 dark:bg-slate-800 px-5 py-3 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center rounded-t-xl">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 uppercase tracking-tight flex items-center gap-2">
                         <Lightbulb class="w-4 h-4 text-slate-500" />
                        {{ viewMode === 'self' ? 'My Insights' : 'Team Alerts' }}
                    </h3>
                </div>
                
                <div class="flex-1 p-0 overflow-y-auto">
                    <div v-for="(insight, idx) in (viewMode === 'self' ? currentInsights : teamInsights)" :key="idx" 
                        class="p-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors flex gap-4 items-start group cursor-pointer">
                        <div :class="[
                            'p-2 rounded-md shrink-0 mt-0.5 shadow-sm',
                            insight.type === 'warning' ? 'bg-amber-100 text-amber-700 border border-amber-200' : 
                            insight.type === 'alert' ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-blue-100 text-blue-700 border border-blue-200'
                        ]">
                            <component :is="insight.icon" class="w-4 h-4" />
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 leading-snug">
                                {{ insight.text }}
                            </p>
                            <div v-if="insight.type === 'warning'" class="mt-2 text-xs text-brand-700 font-bold flex items-center gap-1 hover:underline">
                                Take Action <ChevronRight class="w-3 h-3" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metrics Grid -->
        <h3 class="text-base font-bold text-slate-900 mt-8 mb-4 flex items-center gap-3">
             {{ viewMode === 'self' ? 'Operational KPIs' : 'Team Performance Metrics' }}
            <div class="h-px bg-slate-300 flex-1 ml-2"></div>
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            <!-- KPICard Component Style -->
            <div class="bg-white dark:bg-slate-800 rounded-lg p-5 shadow-sm border border-slate-200 border-l-4 border-l-emerald-500 hover:shadow-md transition-all cursor-pointer group hover:-translate-y-0.5">
                 <div class="flex justify-between items-start mb-2">
                     <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Active Schools</span>
                     <div class="p-1.5 bg-emerald-50 rounded text-emerald-600">
                        <School class="w-4 h-4" />
                     </div>
                 </div>
                 <div class="flex items-end gap-2 mt-1">
                     <h4 class="text-2xl font-extrabold text-slate-900">{{ currentData.activeSchools }}</h4>
                     <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded mb-1.5">+12%</span>
                 </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-lg p-5 shadow-sm border border-slate-200 border-l-4 border-l-purple-500 hover:shadow-md transition-all cursor-pointer group hover:-translate-y-0.5">
                 <div class="flex justify-between items-start mb-2">
                     <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">This Month</span>
                     <div class="p-1.5 bg-purple-50 rounded text-purple-600">
                        <Calendar class="w-4 h-4" />
                     </div>
                 </div>
                 <div class="flex items-end gap-2 mt-1">
                     <h4 class="text-2xl font-extrabold text-slate-900">₹ 2.5L</h4>
                     <span class="text-xs font-bold text-slate-500 mb-1.5">Target: ₹5.2L</span>
                 </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-lg p-5 shadow-sm border border-slate-200 border-l-4 border-l-orange-500 hover:shadow-md transition-all cursor-pointer group hover:-translate-y-0.5">
                <div class="flex justify-between items-start mb-2">
                     <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Books Sold</span>
                     <div class="p-1.5 bg-orange-50 rounded text-orange-600">
                        <Package class="w-4 h-4" />
                     </div>
                 </div>
                 <div class="flex items-end gap-2 mt-1">
                     <h4 class="text-2xl font-extrabold text-slate-900">{{ (currentData.quantity / 1000).toFixed(1) }}k</h4>
                     <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded mb-1.5">+8.2%</span>
                 </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-lg p-5 shadow-sm border border-slate-200 border-l-4 border-l-red-500 hover:shadow-md transition-all cursor-pointer group hover:-translate-y-0.5">
                  <div class="flex justify-between items-start mb-2">
                     <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Returns</span>
                     <div class="p-1.5 bg-red-50 rounded text-red-600">
                        <RotateCcw class="w-4 h-4" />
                     </div>
                 </div>
                 <div class="flex items-end gap-2 mt-1">
                     <h4 class="text-2xl font-extrabold text-slate-900">₹{{ (currentData.returns / 1000).toFixed(1) }}k</h4>
                     <span class="text-xs font-bold text-red-700 bg-red-50 px-2 py-0.5 rounded mb-1.5">High</span>
                 </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-lg p-5 shadow-sm border border-slate-200 border-l-4 border-l-blue-500 hover:shadow-md transition-all cursor-pointer group hover:-translate-y-0.5">
                 <div class="flex justify-between items-start mb-2">
                     <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">Conversion</span>
                     <div class="p-1.5 bg-blue-50 rounded text-blue-600">
                        <CheckCircle2 class="w-4 h-4" />
                     </div>
                 </div>
                 <div class="flex items-end gap-2 mt-1">
                     <h4 class="text-2xl font-extrabold text-slate-900">68.5%</h4>
                     <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded mb-1.5">+5.0%</span>
                 </div>
            </div>
        </div>

        <!-- LEGACY KPIS SECTION / OPERATIONAL BREAKDOWN -->
        <template v-if="viewMode === 'self'">
            <h3 class="text-base font-bold text-slate-900 mt-8 mb-4 flex items-center gap-3">
                Operational Breakdown
                <div class="h-px bg-slate-300 flex-1 ml-2"></div>
            </h3>

            <!-- NEW PREMIUM OPERATIONAL BREAKDOWN -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6 group-scope">
                
                <!-- 1. TARGET: QUANTITY -->
                <div @click="selectMetric('quantity')" :class="{'ring-2 ring-blue-500 ring-offset-2 ring-offset-slate-50 dark:ring-offset-slate-900': selectedMetric === 'quantity'}" class="relative bg-slate-900 rounded-xl p-5 shadow-lg border border-slate-800 overflow-hidden group hover:shadow-2xl transition-all duration-300 cursor-pointer h-full flex flex-col justify-between hover:scale-[1.01]">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-full blur-2xl -mr-6 -mt-6 pointer-events-none"></div>
                    
                    <div class="relative z-10 w-full flex-1 flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="p-1.5 bg-blue-500/20 rounded text-blue-400">
                                        <Package class="w-4 h-4" />
                                    </div>
                                    <span class="text-xs font-bold text-blue-200 uppercase tracking-wider">Qty Target</span>
                                </div>
                                <div class="flex items-baseline gap-1.5 mt-1">
                                    <span class="text-3xl font-extrabold text-white tracking-tight">{{ (legacyData.achievedQty / 1000).toFixed(1) }}k</span>
                                    <span class="text-slate-500 text-xs font-semibold">/ {{ (legacyData.targetQty / 1000).toFixed(1) }}k</span>
                                </div>
                            </div>
                            <div class="h-10 w-10 relative flex items-center justify-center">
                                <svg class="transform -rotate-90 w-10 h-10">
                                    <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-800" />
                                    <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="3" fill="transparent" :stroke-dasharray="100" :stroke-dashoffset="100 - (legacyData.achievedQty / legacyData.targetQty * 100)" class="text-blue-500" />
                                </svg>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="flex justify-between text-xs font-bold text-slate-400 mb-1.5 uppercase tracking-wide">
                                <span>Completion</span>
                                <span class="text-blue-400">{{ Math.round((legacyData.achievedQty / legacyData.targetQty) * 100) }}%</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden border border-white/5">
                                <div class="bg-blue-500 h-full rounded-full shadow-[0_0_8px_rgba(59,130,246,0.6)]" :style="{ width: (legacyData.achievedQty / legacyData.targetQty * 100) + '%' }"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. TARGET: RECEIVABLE -->
                <div @click="selectMetric('revenue')" :class="{'ring-2 ring-purple-500 ring-offset-2 ring-offset-slate-50 dark:ring-offset-slate-900': selectedMetric === 'revenue'}" class="relative bg-slate-900 rounded-xl p-5 shadow-lg border border-slate-800 overflow-hidden group hover:shadow-2xl transition-all duration-300 cursor-pointer h-full flex flex-col justify-between hover:scale-[1.01]">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl -mr-6 -mt-6 pointer-events-none"></div>
                    
                    <div class="relative z-10 w-full flex-1 flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="p-1.5 bg-purple-500/20 rounded text-purple-400">
                                        <Wallet class="w-4 h-4" />
                                    </div>
                                    <span class="text-xs font-bold text-purple-200 uppercase tracking-wider">Revenue</span>
                                </div>
                                <div class="flex items-baseline gap-1.5 mt-1">
                                    <span class="text-3xl font-extrabold text-white tracking-tight">₹{{ (legacyData.achievedVal / 100000).toFixed(1) }}L</span>
                                    <span class="text-slate-500 text-xs font-semibold">/ {{ (legacyData.targetVal / 100000).toFixed(1) }}L</span>
                                </div>
                            </div>
                            <div class="h-10 w-10 relative flex items-center justify-center">
                                <svg class="transform -rotate-90 w-10 h-10">
                                    <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="3" fill="transparent" class="text-slate-800" />
                                    <circle cx="20" cy="20" r="16" stroke="currentColor" stroke-width="3" fill="transparent" :stroke-dasharray="100" :stroke-dashoffset="100 - (legacyData.achievedVal / legacyData.targetVal * 100)" class="text-purple-500" />
                                </svg>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="flex justify-between text-xs font-bold text-slate-400 mb-1.5 uppercase tracking-wide">
                                <span>Collected</span>
                                <span class="text-purple-400">{{ Math.round((legacyData.achievedVal / legacyData.targetVal) * 100) }}%</span>
                            </div>
                            <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden border border-white/5">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-full rounded-full shadow-[0_0_8px_rgba(168,85,247,0.6)]" :style="{ width: (legacyData.achievedVal / legacyData.targetVal * 100) + '%' }"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. SCHOOLS COVERAGE -->
                <div @click="selectMetric('schools')" :class="{'ring-2 ring-emerald-500 ring-offset-2 ring-offset-slate-50 dark:ring-offset-slate-900': selectedMetric === 'schools'}" class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-all group relative overflow-hidden cursor-pointer h-full flex flex-col justify-between hover:scale-[1.01]">
                    <div class="absolute top-0 inset-x-0 h-1 bg-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="w-full flex-1 flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">School Base</span>
                                <div class="text-lg font-bold text-slate-800 dark:text-white mt-1">Coverage Status</div>
                            </div>
                             <div class="p-2 bg-emerald-50 rounded text-emerald-600">
                                <School class="w-5 h-5" />
                            </div>
                        </div>

                        <div class="space-y-4 mt-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">85</div>
                                    <div>
                                        <div class="text-sm font-bold text-slate-800 dark:text-white leading-tight">Active</div>
                                        <div class="text-xs text-slate-500 leading-tight">Order Received</div>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">71%</span>
                            </div>
                            
                            <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full" style="width: 71%"></div>
                            </div>

                             <div class="flex items-center justify-between pt-3 border-t border-slate-50 mt-1">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-xs ring-1 ring-slate-200">35</div>
                                    <div>
                                        <div class="text-xs font-semibold text-slate-600">Pending</div>
                                    </div>
                                </div>
                                <span class="text-xs bg-slate-100 text-slate-500 px-2 py-1 rounded font-bold">Needs Action</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. VISITS BREAKDOWN -->
                <div @click="selectMetric('visits')" :class="{'ring-2 ring-blue-500 ring-offset-2 ring-offset-slate-50 dark:ring-offset-slate-900': selectedMetric === 'visits'}" class="bg-white dark:bg-slate-800 rounded-xl p-6 shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-all group relative overflow-hidden cursor-pointer h-full flex flex-col justify-between hover:scale-[1.01]">
                    <div class="absolute top-0 inset-x-0 h-1 bg-blue-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="w-full flex-1 flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Field Activity</span>
                                <div class="text-lg font-bold text-slate-800 dark:text-white mt-1">Visit Analysis</div>
                            </div>
                             <div class="p-2 bg-blue-50 rounded text-blue-600">
                                <MapPin class="w-5 h-5" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div class="bg-blue-50/50 rounded-xl p-3 border border-blue-100 flex flex-col justify-center items-center text-center">
                                <div class="text-3xl font-extrabold text-blue-700 leading-none">{{ legacyData.visitsSenior }}</div>
                                <div class="text-xs font-bold text-blue-600 uppercase mt-1">Senior Visits</div>
                            </div>
                            <div class="bg-indigo-50/50 rounded-xl p-3 border border-indigo-100 flex flex-col justify-center items-center text-center">
                                <div class="text-3xl font-extrabold text-indigo-700 leading-none">{{ legacyData.visitsGeneral }}</div>
                                <div class="text-xs font-bold text-indigo-600 uppercase mt-1">General Visits</div>
                            </div>
                        </div>
                         <div class="mt-3 text-center">
                            <span class="text-xs text-slate-500 font-medium">Total 60 Visits this month</span>
                         </div>
                    </div>
                </div>

                <!-- 5. SAMPLES -->
                <div @click="selectMetric('samples')" :class="{'ring-2 ring-violet-500 ring-offset-2 ring-offset-slate-50 dark:ring-offset-slate-900': selectedMetric === 'samples'}" class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-all group relative overflow-hidden cursor-pointer h-full flex flex-col justify-between hover:scale-[1.01]">
                    <div class="absolute left-0 inset-y-0 w-1 bg-violet-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-full flex-1 flex flex-col justify-between">
                         <div class="flex justify-between items-center mb-2">
                             <div class="flex items-center gap-2">
                                  <div class="p-1.5 bg-violet-100 text-violet-600 rounded">
                                     <Package class="w-4 h-4" />
                                 </div>
                                 <span class="text-xs font-bold text-slate-700 uppercase">Samples</span>
                             </div>
                             <span class="text-xs font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">+14% YoY</span>
                         </div>
                         
                         <div class="flex items-center gap-2 my-auto">
                             <div class="text-4xl font-extrabold text-slate-900 leading-none">{{ legacyData.samplesCY }}</div>
                             <div class="text-xs font-bold text-slate-400 mt-2">Given</div>
                         </div>

                        <div class="text-xs text-slate-500 flex items-center justify-between border-t border-slate-100 pt-3 mt-3 w-full">
                             <span>Last Year</span>
                             <span class="font-bold text-slate-800 text-sm">{{ legacyData.samplesLY }}</span>
                        </div>
                    </div>
                </div>

                <!-- 6. DISCOUNT -->
                <div @click="selectMetric('discount')" :class="{'ring-2 ring-orange-500 ring-offset-2 ring-offset-slate-50 dark:ring-offset-slate-900': selectedMetric === 'discount'}" class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-all group relative overflow-hidden cursor-pointer h-full flex flex-col justify-between hover:scale-[1.01]">
                    <div class="absolute left-0 inset-y-0 w-1 bg-orange-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-full flex-1 flex flex-col justify-between">
                         <div class="flex justify-between items-center mb-2">
                             <div class="flex items-center gap-2">
                                  <div class="p-1.5 bg-orange-100 text-orange-600 rounded">
                                     <Percent class="w-4 h-4" />
                                 </div>
                                 <span class="text-xs font-bold text-slate-700 uppercase">Discount</span>
                             </div>
                             <span class="text-xs font-bold bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full">Avg</span>
                         </div>
                         
                         <div class="flex items-center gap-2 my-auto">
                             <div class="text-4xl font-extrabold text-slate-900 leading-none">{{ legacyData.discountCY }}%</div>
                         </div>
                    
                         <div class="text-xs text-slate-500 flex items-center justify-between border-t border-slate-100 pt-3 mt-3 w-full">
                             <span>Last Year</span>
                            <span class="font-bold text-emerald-600 text-sm">{{ legacyData.discountLY }}% (Imp)</span>
                        </div>
                    </div>
                </div>

                <!-- 7. RETURNS -->
                <div @click="selectMetric('returns')" :class="{'ring-2 ring-red-500 ring-offset-2 ring-offset-slate-50 dark:ring-offset-slate-900': selectedMetric === 'returns'}" class="md:col-span-2 bg-white dark:bg-slate-800 rounded-xl p-5 shadow-sm border border-slate-200 dark:border-slate-700 hover:shadow-md transition-all group relative overflow-hidden cursor-pointer h-full flex flex-col justify-between hover:scale-[1.01]">
                     <div class="absolute left-0 inset-y-0 w-1 bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="flex justify-between items-center w-full h-full">
                        <div class="flex flex-col justify-center h-full max-w-[50%]">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="p-2 bg-red-50 text-red-600 rounded-lg">
                                    <RotateCcw class="w-5 h-5" />
                                </div>
                                <span class="text-sm font-bold text-slate-800 uppercase tracking-wide">Sales Returns <span class="text-slate-400 font-normal normal-case">(LY)</span></span>
                           </div>
                           <p class="text-xs text-slate-500 leading-relaxed pr-6">
                               Total processed returns from last fiscal timeline.
                               <span class="text-red-600 font-bold block mt-1 hover:underline text-sm">View Breakdown &rarr;</span>
                           </p>
                        </div>

                         <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 flex gap-6 px-6 items-center h-fit my-auto">
                            <div class="text-center border-r border-slate-200 pr-6">
                                <div class="text-xs font-bold text-slate-400 uppercase mb-1">Volume</div>
                                <div class="text-2xl font-extrabold text-slate-900">{{ (legacyData.returnsLYQty / 1000).toFixed(1) }}k</div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs font-bold text-slate-400 uppercase mb-1">Value</div>
                                <div class="text-2xl font-extrabold text-red-600">₹{{ (legacyData.returnsLYVal / 100000).toFixed(1) }}L</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

             <!-- DETAILED METRIC ANALYSIS PANEL (Expandable) -->
            <transition name="fade">
                <div v-if="selectedMetric" class="mb-12 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden animate-in slide-in-from-top-4 duration-500">
                    <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-brand-100 text-brand-600 rounded-lg">
                                <Activity class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-white capitalize">{{ selectedMetric }} Performance Analysis</h3>
                                <p class="text-xs text-slate-500">Historical trend and detailed breakdown report.</p>
                            </div>
                        </div>
                        <button @click="selectedMetric = null" class="p-2 hover:bg-slate-200 rounded-full text-slate-500 transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>
                    
                    <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Chart Area -->
                        <div class="lg:col-span-2">
                             <div class="mb-4 flex items-center justify-between">
                                 <h4 class="text-sm font-bold text-slate-700">12-Month Trend</h4>
                                 <select class="text-xs border-slate-300 rounded-lg shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                     <option>Last 12 Months</option>
                                     <option>Fiscal Year</option>
                                 </select>
                             </div>
                             <!-- Placeholder Chart -->
                             <div class="h-64 w-full bg-slate-50 rounded-xl border border-dashed border-slate-300 flex items-center justify-center p-2 relative overflow-hidden">
                                 <apexchart width="100%" height="100%" type="area" :options="metricChartOptions" :series="metricChartSeries"></apexchart>
                             </div>
                        </div>

                        <!-- Quick Report / Stats -->
                        <div class="lg:col-span-1 space-y-4">
                             <h4 class="text-sm font-bold text-slate-700">Key Insights</h4>
                             <div class="space-y-3">
                                 <div class="p-3 bg-green-50 rounded-xl border border-green-100">
                                     <div class="flex items-start gap-3">
                                         <div class="mt-0.5"><div class="w-2 h-2 bg-green-500 rounded-full"></div></div>
                                         <div>
                                             <p class="text-xs font-bold text-green-800">Growth Orbit</p>
                                             <p class="text-xs text-green-700 mt-1">Consistency observed in last 3 months. Maintain current pace to exceed Q4 targets.</p>
                                         </div>
                                     </div>
                                 </div>
                                  <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                                     <div class="flex justify-between items-center mb-1">
                                         <span class="text-xs font-semibold text-slate-500">Month Avg</span>
                                         <span class="text-sm font-bold text-slate-800">12%</span>
                                     </div>
                                      <div class="flex justify-between items-center">
                                         <span class="text-xs font-semibold text-slate-500">Best Month</span>
                                         <span class="text-sm font-bold text-slate-800">August (18%)</span>
                                     </div>
                                 </div>
                                 
                                 <button class="w-full py-2.5 rounded-xl bg-brand-600 text-white font-semibold text-sm hover:bg-brand-700 transition shadow-lg shadow-brand-200">
                                     Download Full Report
                                 </button>
                             </div>
                        </div>
                    </div>
                </div>
            </transition>
        </template>

        <!-- NEW SECTIONS: Productive Console Area -->
        <h3 class="text-base font-bold text-slate-900 mt-8 mb-4 flex items-center gap-3">
            {{ viewMode === 'self' ? 'Action Console' : 'Management Console' }}
            <div class="h-px bg-slate-300 flex-1 ml-2"></div>
        </h3>

        <!-- SELF VIEW CONTENT -->
        <template v-if="viewMode === 'self'">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Left: Today's Focus -->
                <div class="lg:col-span-1 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
                    <div class="p-4 border-b border-slate-200 bg-slate-50 flex justify-between items-center rounded-t-xl">
                        <h4 class="font-extrabold text-slate-800 text-sm flex items-center gap-2">
                            <Calendar class="w-4 h-4 text-brand-600" />
                            Today's Focus
                        </h4>
                        <span class="bg-slate-800 text-white text-[10px] font-bold px-2 py-0.5 rounded">4 Pending</span>
                    </div>
                    
                    <div class="p-1 space-y-0 flex-1">
                        <div v-for="task in todaysFocus.slice(0, 4)" :key="task.id" class="flex items-start gap-3 p-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition-colors cursor-pointer group">
                            <div class="mt-0.5">
                                <component :is="task.icon" class="w-4 h-4 text-slate-400 group-hover:text-brand-600" />
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-slate-800 line-clamp-1 group-hover:text-brand-700">{{ task.title }}</p>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">{{ task.sub }}</p>
                            </div>
                            <div class="h-4 w-4 rounded border-2 border-slate-300 group-hover:border-brand-500 transition-colors"></div>
                        </div>
                    </div>
                    
                    <div class="p-3 border-t border-slate-200 text-center mt-auto bg-slate-50 rounded-b-xl">
                        <button class="text-xs font-bold text-slate-600 hover:text-slate-900 uppercase tracking-wide inline-flex items-center gap-1">
                            View All Tasks <ChevronRight class="w-3 h-3" />
                        </button>
                    </div>
                </div>

                <!-- Right: Pipeline & Trends/Team -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- 1. Pipeline Overview -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="font-extrabold text-slate-900 text-sm">Pipeline Health</h4>
                            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded">Real-time</span>
                        </div>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                            <div v-for="stage in pipelineStages" :key="stage.name" 
                                class="relative flex flex-col items-center text-center p-3 rounded-lg border border-transparent transition-all"
                                :class="stage.highlight ? 'bg-orange-50 border-orange-100' : 'bg-slate-50 border-slate-100'"
                            >
                                <span class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-2">{{ stage.name }}</span>
                                <span class="text-2xl font-extrabold text-slate-900 mb-2">{{ stage.count }}</span>
                                <!-- Tiny Bar -->
                                <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden mt-1">
                                    <div class="h-full rounded-full" :class="stage.color.split(' ')[0]" :style="{ width: '100%' }"></div>
                                </div>
                                <!-- Bottleneck Indicator -->
                                <div v-if="stage.highlight" class="absolute -top-1 -right-1">
                                    <span class="flex h-2.5 w-2.5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-orange-600 border border-white"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Dual Block: Trend & Team -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Trend Chart - Fixed Height No Scroll -->
                        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 p-0 relative overflow-hidden flex flex-col h-[14rem]">
                             <div class="p-5 flex justify-between items-start z-10 border-b border-slate-100 bg-slate-50/50">
                                <div>
                                    <h4 class="font-extrabold text-slate-900 text-sm">Revenue Momentum</h4>
                                </div>
                                <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-1 rounded inline-flex items-center">
                                    <TrendingUp class="w-3 h-3 mr-1" /> Trending Up
                                </span>
                            </div>
                            <div class="flex-1 w-full relative pt-4">
                                 <apexchart type="area" height="100%" width="100%" :options="chartOptions" :series="chartSeries"></apexchart>
                            </div>
                        </div>

                        <!-- Team Snapshot - No Scroll, Fixed List -->
                        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 flex flex-col h-[14rem]">
                            <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center rounded-t-xl">
                                <h4 class="font-extrabold text-slate-900 text-sm">Top Performers</h4>
                                <div class="p-1 px-2 bg-slate-200 rounded text-[10px] font-bold text-slate-600 uppercase">Live</div>
                            </div>
                            <div class="p-4 space-y-4 flex-1">
                                <div v-for="member in teamPerformance.slice(0, 3)" :key="member.name">
                                    <div class="flex justify-between text-xs mb-1.5">
                                        <span class="font-bold text-slate-700">{{ member.name }}</span>
                                        <span :class="member.status === 'attention' ? 'text-red-700 font-extrabold' : 'text-slate-600 font-bold'">{{ member.pct }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden shadow-inner">
                                        <div class="h-full rounded-full" 
                                            :class="member.status === 'attention' ? 'bg-red-500' : 'bg-emerald-500'" 
                                            :style="{ width: member.pct + '%' }">
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="p-2 border-t border-slate-100 text-center bg-slate-50 rounded-b-xl">
                                <button class="text-[10px] font-bold text-slate-500 hover:text-brand-600 transition-colors uppercase tracking-widest">
                                    Full Roster
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- TEAM VIEW CONTENT -->
        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left: Executive List (Detailed) -->
            <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col">
                <div class="p-5 border-b border-slate-200 bg-slate-50 flex justify-between items-center rounded-t-xl">
                    <h4 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                        <Users class="w-4 h-4 text-brand-600" />
                        Executive Performance
                    </h4>
                    <button class="text-xs font-bold text-brand-700 bg-brand-50 border border-brand-100 px-3 py-1.5 rounded hover:bg-brand-100 transition-colors">
                        Download Report
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Executive</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Revenue</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Schools</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Orders</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            <tr v-for="exec in teamExecutives" :key="exec.name" class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600 border border-slate-200">
                                            {{ exec.name.charAt(0) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-bold text-slate-900">{{ exec.name }}</div>
                                            <div class="text-xs text-slate-500">{{ exec.pending }} pending tasks</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-900">{{ formatCurrency(exec.achieved) }}</div>
                                    <div class="text-xs text-slate-500">Target: {{ formatCurrency(exec.target) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900"><span class="font-bold">{{ exec.schools_active }}</span> / {{ exec.schools_assign }}</div>
                                    <div class="w-24 h-1.5 bg-slate-100 rounded-full mt-1">
                                        <div class="h-full rounded-full bg-blue-500" :style="{ width: (exec.schools_active / exec.schools_assign * 100) + '%' }"></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 font-medium">
                                    {{ exec.orders }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span v-if="exec.status === 'Good'" class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                        On Track
                                    </span>
                                    <span v-else-if="exec.status === 'Watch'" class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                        Watch
                                    </span>
                                    <span v-else class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                        At Risk
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right: Chart -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 p-0 overflow-hidden flex flex-col h-full">
                    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                        <h4 class="font-extrabold text-slate-900 text-sm">Target vs Achieved</h4>
                        <p class="text-xs text-slate-500 mt-1">Executive-wise comparison</p>
                    </div>
                    <div class="flex-1 p-4 flex items-center justify-center">
                         <apexchart type="bar" height="300" width="100%" :options="teamChartOptions" :series="teamChartSeries"></apexchart>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
