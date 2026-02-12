<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';

// Get user name from page props
const page = usePage();
const userName = computed(() => page.props.auth.user.name);
import { 
    TrendingUp, 
    TrendingDown,
    Target,
    Users,
    School,
    ShoppingCart,
    AlertCircle,
    ArrowRight,
    Download,
    Search,
    ChevronDown,
    ChevronUp,
    Briefcase,
    DollarSign,
    Percent,
    Activity,
    CheckCircle2,
    Building2,
    Calendar,
    Filter,
    Map,
    BarChart3,
    PieChart,
    Layers,
    ShieldAlert,
    FileText,
    MoreHorizontal,
    Flag,
    X,
    Maximize2
} from 'lucide-vue-next';

// ECharts Imports
import VChart from 'vue-echarts';
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { BarChart, LineChart, PieChart as EPieChart, MapChart, ScatterChart } from 'echarts/charts';
import { GridComponent, TooltipComponent, LegendComponent, VisualMapComponent, GeoComponent, DataZoomComponent } from 'echarts/components';

use([CanvasRenderer, BarChart, LineChart, EPieChart, MapChart, ScatterChart, GridComponent, TooltipComponent, LegendComponent, VisualMapComponent, GeoComponent, DataZoomComponent]);

// Helper function to wrap rupee symbols with CSS class for font styling
const formatRupee = (text) => {
    if (!text) return text;
    return String(text).replace(/₹/g, '<span class="rupee-symbol">₹</span>');
};

// ----------------------------------------------------------------------
// DATA & STATE
// ----------------------------------------------------------------------

const isLoaded = ref(false);
const selectedTimeRange = ref('Yearly');
const selectedView = ref('National');
const expandedRoles = ref({});
const drawerOpen = ref(false);
const selectedKpiForAnalysis = ref(null);

onMounted(() => {
    setTimeout(() => {
        isLoaded.value = true;
    }, 100);
});

// 1. NATIONAL HEADER DATA
const corporateData = {
    revenue: '₹ 145.2 Cr',
    target: '₹ 220.0 Cr',
    achievedRaw: 145.2,
    targetRaw: 220.0,
    pct: 66,
    growth: '+14.2%',
    riskStatus: 'Amber', // Green, Amber, Red
    lastSync: 'Today, 09:30 AM'
};

// 2. STRATEGIC KPI CARDS
const kpis = [
    { id: 'revenue', label: 'Total Revenue', value: '₹ 145.2 Cr', change: '+14%', sub: 'vs last year', trend: 'up', icon: DollarSign, color: 'border-[#015276]', bg: 'bg-[#FFEEDE]', text: 'text-[rgb(143,5,7)]' },
    { id: 'orders', label: 'Total Orders', value: '12,450', change: '+8%', sub: 'vs last year', trend: 'up', icon: ShoppingCart, color: 'border-[#F37B15]', bg: 'bg-[#FFEEDE]', text: 'text-[rgb(143,5,7)]' },
    { id: 'schools', label: 'Active Schools', value: '2,800', change: '+3%', sub: 'growing base', trend: 'up', icon: School, color: 'border-[#015276]', bg: 'bg-[#FFEEDE]', text: 'text-[rgb(143,5,7)]' },
    { id: 'conversion', label: 'Conversion', value: '64%', change: '-1.2%', sub: 'slight dip', trend: 'down', icon: Percent, color: 'border-[#F37B15]', bg: 'bg-[#FFEEDE]', text: 'text-[rgb(143,5,7)]' },
    { id: 'returns', label: 'Returns Value', value: '₹ 5.8 Cr', change: '4.0%', sub: 'of revenue', trend: 'up', isBad: true, icon: AlertCircle, color: 'border-[rgb(143,5,7)]', bg: 'bg-[#FFEEDE]', text: 'text-[rgb(143,5,7)]' },
    { id: 'receivables', label: 'Receivables', value: '₹ 12.5 Cr', change: '-2%', sub: 'outstanding', trend: 'down', isGood: true, icon: Activity, color: 'border-[#015276]', bg: 'bg-[#FFEEDE]', text: 'text-[rgb(143,5,7)]' },
];

// 4. PERFORMANCE HIERARCHY DATA
const hierarchyData = [
    {
        id: 'geo1', role: 'Head GEO', name: 'North Region (Vikram Singh)', revenue: '₹ 45.2 Cr', target: '₹ 65 Cr', pct: 69, risk: 'Low',
        children: [
            { id: 'tl1', role: 'Team Leader', name: 'Suresh Kumar (North-A)', revenue: '₹ 12.5 Cr', target: '₹ 18 Cr', pct: 69, risk: 'Low' },
            { id: 'tl2', role: 'Team Leader', name: 'Amit Verma (North-B)', revenue: '₹ 10.2 Cr', target: '₹ 15 Cr', pct: 68, risk: 'Medium' },
        ]
    },
    {
        id: 'geo2', role: 'Head GEO', name: 'West Region (Rajesh Gupta)', revenue: '₹ 38.5 Cr', target: '₹ 60 Cr', pct: 64, risk: 'Medium',
        children: [
            { id: 'tl3', role: 'Team Leader', name: 'Priya Sharma (West-A)', revenue: '₹ 15.0 Cr', target: '₹ 22 Cr', pct: 68, risk: 'Low' },
            { id: 'tl4', role: 'Team Leader', name: 'Rahul Mehta (West-B)', revenue: '₹ 11.0 Cr', target: '₹ 20 Cr', pct: 55, risk: 'High' }, // Low performance
        ]
    },
    {
        id: 'geo3', role: 'Head GEO', name: 'South Region (Anitha Reddy)', revenue: '₹ 32.0 Cr', target: '₹ 50 Cr', pct: 64, risk: 'Low',
        children: []
    },
    {
        id: 'geo4', role: 'Head GEO', name: 'East Region (Subhash Bose)', revenue: '₹ 29.5 Cr', target: '₹ 45 Cr', pct: 65, risk: 'High',
        children: []
    }
];

// 5. REGIONAL INTELLIGENCE (CHARTS)
const revenueTrendOption = {
    tooltip: { trigger: 'axis' },
    legend: { bottom: 0 },
    grid: { top: 20, left: '3%', right: '4%', bottom: 30, containLabel: true },
    xAxis: { type: 'category', data: ['Q1', 'Q2', 'Q3', 'Q4 (Proj)'], boundaryGap: false },
    yAxis: { type: 'value' },
    series: [
        { name: 'Revenue', type: 'line', smooth: true, data: [32, 45, 68, 75], itemStyle: { color: '#ea580c' }, areaStyle: { opacity: 0.1 }, lineStyle: { width: 3 } },
        { name: 'Target', type: 'line', smooth: true, command: 'dashed', data: [40, 55, 75, 80], itemStyle: { color: '#94a3b8' }, lineStyle: { type: 'dashed', width: 2 } }
    ]
};

const zoneHeatmapOption = {
    tooltip: { trigger: 'item', formatter: '{b}: ₹{c} Cr' },
    series: [{
        type: 'treemap',
        data: [
            { name: 'North-A', value: 12.5, itemStyle: { color: '#16a34a' } }, // Green
            { name: 'North-B', value: 10.2, itemStyle: { color: '#facc15' } }, // Yellow
            { name: 'West-A', value: 15.0, itemStyle: { color: '#16a34a' } },
            { name: 'West-B', value: 11.0, itemStyle: { color: '#dc2626' } }, // Red
            { name: 'South-A', value: 18.0, itemStyle: { color: '#16a34a' } },
            { name: 'East-A', value: 9.5, itemStyle: { color: '#facc15' } },
        ],
        label: { show: true, formatter: '{b}\n₹ {c} Cr', fontSize: 11 },
        breadcrumb: { show: false },
        itemStyle: { borderColor: '#fff' }
    }]
};

// 6. STRATEGIC INSIGHTS
const insights = [
    { title: 'Growth Driver', text: 'North Region driving 41% of national growth, led by North-A zone.', type: 'positive' },
    { title: 'Risk Alert', text: 'Returns trending up in West Zone for 3 consecutive months.', type: 'negative' },
    { title: 'Operational Lag', text: '2 Head GEOs underperforming for 2 consecutive quarters.', type: 'warning' }
];

// 7. FINANCIAL RISK
const financialRisks = [
    { label: 'Pending Approvals', value: '₹ 8.5 Cr', status: 'High', barIdx: 80, desc: 'Highest in East Region' },
    { label: 'Outstanding (>90 Days)', value: '₹ 12.5 Cr', status: 'Medium', barIdx: 45, desc: 'Improving trend (-2%)' },
    { label: 'Returns Trend', value: '4.0%', status: 'Medium', barIdx: 40, desc: 'Slight uptake in Q3' },
];

const toggleRole = (id) => {
    expandedRoles.value[id] = !expandedRoles.value[id];
};

const getRiskColor = (risk) => {
    if (risk === 'High') return 'text-red-600 bg-red-50 border-red-200';
    if (risk === 'Medium') return 'text-amber-600 bg-amber-50 border-amber-200';
    return 'text-emerald-600 bg-emerald-50 border-emerald-200';
};

const getStatusColor = (risk) => {
    if (risk === 'High') return 'bg-red-500';
    if (risk === 'Medium') return 'bg-amber-500';
    return 'bg-emerald-500';
};

// Drawer Logic
const openAnalysisDrawer = (kpi) => {
    selectedKpiForAnalysis.value = kpi;
    drawerOpen.value = true;
};
const closeAnalysisDrawer = () => {
    drawerOpen.value = false;
    setTimeout(() => { selectedKpiForAnalysis.value = null; }, 300);
};

// 8. PIPELINE & OUTLOOK
const pipelineStages = [
    { label: 'Assigned', value: '3,200', drop: null, color: 'bg-slate-100', text: 'text-slate-600' },
    { label: 'Surveyed', value: '2,800', drop: '-12%', color: 'bg-blue-50', text: 'text-blue-700' },
    { label: 'Proposal', value: '1,500', drop: '-46%', color: 'bg-indigo-50', text: 'text-indigo-700', alert: true },
    { label: 'Order Recv', value: '1,100', drop: '-26%', color: 'bg-orange-50', text: 'text-orange-700' },
    { label: 'Approved', value: '980', drop: '-10%', color: 'bg-emerald-50', text: 'text-emerald-700' },
];

// Deep Dive Chart Data (Simulated)
const deepDiveTrendOption = computed(() => ({
    title: { text: (selectedKpiForAnalysis.value?.label || 'KPI') + ' - 12 Month Trend', left: 'center', textStyle: { fontSize: 14 } },
    tooltip: { trigger: 'axis' },
    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
    xAxis: { type: 'category', data: ['J','F','M','A','M','J','J','A','S','O','N','D'], boundaryGap: false },
    yAxis: { type: 'value' },
    series: [{ 
        data: [120, 132, 101, 134, 90, 230, 210, 200, 220, 250, 260, 280], 
        type: 'line', 
        smooth: true, 
        areaStyle: { opacity: 0.1, color: '#ea580c' },
        lineStyle: { width: 3, color: '#ea580c' },
        symbolSize: 8
    }]
}));

</script>

<template>
    <Head title="VP Console" />

    <AuthenticatedLayout>
        <div class="space-y-8 pb-12 font-sans text-slate-800 relative">
            
            <!-- Greeting Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Hi, {{ userName }}!</h1>
                </div>
            </div>
            
            <!-- 1) VP STRATEGIC COMMAND BAR -->
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
                <!-- Decorative Glow -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
                
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <!-- Title & Context -->
                    <div class="lg:col-span-3">
                        <div class="flex items-center gap-2 text-orange-400 font-bold uppercase tracking-widest text-[10px] mb-1">
                            <Building2 class="w-3 h-3" /> Corporate Command
                        </div>
                        <h1 class="text-3xl font-bold font-display tracking-tight leading-none">National Overview</h1>
                        <p class="text-slate-400 text-xs mt-1 font-medium tracking-wide">FY 2025-26 â€¢ Synced: {{ corporateData.lastSync }}</p>
                    </div>

                    <!-- Main Metrics -->
                    <div class="lg:col-span-6 flex flex-col md:flex-row items-center justify-around gap-8 border-l border-r border-white/10 px-8">
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Revenue</p>
                            <p class="text-4xl font-bold text-white tracking-tight">{{ corporateData.revenue }}</p>
                            <p class="text-xs font-bold text-emerald-400 mt-1 flex items-center justify-center gap-1 bg-emerald-400/10 rounded-full px-2 py-0.5 w-fit mx-auto">
                                <TrendingUp class="w-3 h-3" /> {{ corporateData.growth }} YoY
                            </p>
                        </div>
                        <div class="text-center w-full max-w-xs">
                             <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 flex justify-between">
                                <span>Achievement</span>
                                <span>{{ corporateData.pct }}%</span>
                            </p>
                            <div class="h-3 bg-slate-700/50 rounded-full overflow-hidden backdrop-blur-sm relative shadow-inner">
                                <div class="absolute inset-0 bg-white/5 animate-pulse"></div>
                                <div class="h-full bg-gradient-to-r from-orange-500 to-orange-400 rounded-full shadow-[0_0_15px_rgba(249,115,22,0.6)] transition-all duration-1000 ease-out" 
                                     :style="{ width: isLoaded ? corporateData.pct + '%' : '0%' }"></div>
                            </div>
                            <p class="text-[10px] text-slate-500 mt-2 text-right font-mono">Target: {{ corporateData.target }}</p>
                        </div>
                    </div>

                    <!-- Risk Status -->
                    <div class="lg:col-span-3 flex flex-col items-end justify-center h-full">
                        <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 flex items-center gap-4 backdrop-blur-sm">
                            <div class="p-2 bg-amber-500/20 rounded-full animate-pulse">
                                <ShieldAlert class="w-6 h-6 text-amber-500" />
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Net Risk Index</p>
                                <p class="text-lg font-bold text-amber-400 leading-none mt-1">Moderate Risk</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3) MULTI-DIMENSIONAL CONTROL FILTER -->
            <div class="sticky top-20 z-30 bg-white/80 backdrop-blur-xl border border-slate-200 shadow-lg rounded-xl p-2 flex items-center justify-between gap-4 transition-all hover:bg-white">
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-lg">
                    <button v-for="view in ['Organization', 'Region', 'Head GEO', 'Team Leader']" :key="view"
                            @click="selectedView = view"
                            :class="['px-4 py-2 rounded-md text-xs font-bold transition-all', selectedView === view ? 'bg-white text-slate-900 shadow-sm ring-1 ring-black/5' : 'text-slate-500 hover:text-slate-700']">
                        {{ view }}
                    </button>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-lg border border-slate-200">
                        <Filter class="w-3.5 h-3.5 text-slate-400" />
                        <span class="text-xs font-bold text-slate-600">Focus: Revenue</span>
                    </div>
                    <div class="h-6 w-px bg-slate-300"></div>
                    <div class="flex items-center gap-2">
                        <Calendar class="w-4 h-4 text-slate-400" />
                        <select v-model="selectedTimeRange" class="text-sm font-bold text-slate-700 bg-transparent border-none focus:ring-0 cursor-pointer py-0 pl-0 pr-8">
                            <option>Monthly</option>
                            <option>Quarterly</option>
                            <option>Yearly</option>
                            <option>5 Years</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 2) ENTERPRISE KPI MATRIX -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                 <button v-for="(kpi, idx) in kpis" :key="idx" 
                     @click="openAnalysisDrawer(kpi)"
                     class="group bg-[#FFFAF7] rounded-xl p-5 border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 cursor-pointer relative overflow-hidden text-left focus:outline-none focus:ring-2 focus:ring-[#015276] focus:ring-offset-2">
                    <div :class="['absolute top-0 left-0 w-1 h-full transition-colors', kpi.color.replace('border-', 'bg-')]"></div>
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ kpi.label }}</p>
                        <div :class="['p-1.5 rounded-lg', kpi.bg]">
                            <component :is="kpi.icon" :class="['w-4 h-4 group-hover:scale-110 transition-transform', kpi.text]" />
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-[#015276] tracking-tight" v-html="formatRupee(kpi.value)"></p>
                    <div class="flex items-center gap-1 mt-2 text-[11px] font-bold">
                        <span :class="[(kpi.trend === 'up' && !kpi.isBad) || (kpi.trend === 'down' && kpi.isGood) ? 'text-emerald-600' : 'text-red-600']">{{ kpi.change }}</span>
                        <component :is="kpi.trend === 'up' ? TrendingUp : TrendingDown" :class="['w-3 h-3', (kpi.trend === 'up' && !kpi.isBad) ? 'text-emerald-600' : 'text-red-600']" />
                    </div>
                    <!-- Hover hint -->
                    <div class="absolute inset-0 bg-slate-50 opacity-0 group-hover:opacity-10 transition-opacity pointer-events-none"></div>
                 </button>
            </div>

            <!-- MAIN CONTENT GRID -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                
                <!-- LEFT COL (2/3) -->
                <div class="xl:col-span-2 space-y-8">
                    
                    <!-- 4) PERFORMANCE HIERARCHY VIEW -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2 text-sm uppercase tracking-wide">
                                <Layers class="w-4 h-4 text-brand-600" /> Organizational Hierarchy
                            </h3>
                            <div class="flex gap-2">
                                <button class="p-1.5 hover:bg-slate-200 rounded text-slate-500"><Search class="w-4 h-4" /></button>
                                <button class="p-1.5 hover:bg-slate-200 rounded text-slate-500"><Maximize2 class="w-4 h-4" /></button>
                            </div>
                        </div>
                        
                        <div class="divide-y divide-slate-100 overflow-x-auto">
                             <!-- Header Row -->
                            <div class="flex items-center px-6 py-2 bg-slate-50/50 text-[10px] font-bold uppercase text-slate-400 tracking-wider">
                                <div class="w-1/3">Region / Role</div>
                                <div class="w-1/3 px-4">Performance vs Target</div>
                                <div class="w-1/4 text-right">Revenue & Risk</div>
                            </div>

                            <div v-for="geo in hierarchyData" :key="geo.id" class="group">
                                <!-- Parent Row -->
                                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors cursor-pointer relative" @click="toggleRole(geo.id)">
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-brand-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    <div class="flex items-center gap-3 w-1/3">
                                        <button class="p-1 rounded-md hover:bg-slate-200 text-slate-400 transition-colors">
                                            <component :is="expandedRoles[geo.id] ? ChevronUp : ChevronDown" class="w-4 h-4" />
                                        </button>
                                        <div>
                                            <p class="font-bold text-slate-800 text-sm">{{ geo.name }}</p>
                                            <div class="flex items-center gap-1 text-[10px] text-slate-500 font-bold uppercase tracking-wider mt-0.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> {{ geo.role }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Progress -->
                                    <div class="w-1/3 px-4">
                                        <div class="flex justify-between text-xs font-bold mb-1.5">
                                            <span>{{ geo.pct }}%</span>
                                            <span class="text-slate-400 font-medium font-mono text-[10px]">Tgt: {{ geo.target }}</span>
                                        </div>
                                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                            <div :class="['h-full rounded-full transition-all duration-500', getStatusColor(geo.risk)]" :style="{ width: geo.pct + '%' }"></div>
                                        </div>
                                    </div>

                                    <!-- Revenue & Risk -->
                                    <div class="w-1/4 text-right">
                                        <p class="font-bold text-slate-800 text-sm tracking-tight">{{ geo.revenue }}</p>
                                        <span :class="['text-[10px] font-bold uppercase px-2 py-0.5 rounded-full inline-block mt-1', getRiskColor(geo.risk)]">{{ geo.risk }} Risk</span>
                                    </div>
                                </div>

                                <!-- Child Rows -->
                                <transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0">
                                    <div v-if="expandedRoles[geo.id]" class="bg-slate-50/50 border-t border-slate-100 divide-y divide-slate-100/50">
                                        <div v-for="tl in geo.children" :key="tl.id" class="px-6 py-3 pl-16 flex items-center justify-between hover:bg-slate-100/80 transition-colors">
                                             <div class="w-1/3 flex items-center gap-2">
                                                <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div>
                                                <div>
                                                    <p class="font-semibold text-slate-700 text-xs">{{ tl.name }}</p>
                                                    <p class="text-[10px] text-slate-400">{{ tl.role }}</p>
                                                </div>
                                            </div>
                                            <div class="w-1/3 px-4">
                                                <div class="h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                                    <div :class="['h-full rounded-full', getStatusColor(tl.risk)]" :style="{ width: tl.pct + '%' }"></div>
                                                </div>
                                            </div>
                                            <div class="w-1/4 text-right">
                                                <span class="text-xs font-bold text-slate-600">{{ tl.revenue }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </transition>
                            </div>
                        </div>
                    </div>

                    <!-- 5) INTELLIGENCE CHARTS & 8) PIPELINE -->
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Revenue Trend -->
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h4 class="font-bold text-slate-800 text-xs uppercase tracking-widest flex items-center gap-2">
                                    <BarChart3 class="w-4 h-4 text-slate-400" /> Revenue Forecast
                                </h4>
                                <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-[10px] font-bold">Next 2 Qtrs</span>
                            </div>
                            <div class="h-60 w-full">
                                <v-chart class="h-full w-full" :option="revenueTrendOption" autoresize />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COL (1/3) -->
                <div class="xl:col-span-1 space-y-8">
                    
                    <!-- 6) STRATEGIC PIPELINE -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col">
                         <h4 class="font-bold text-slate-800 text-xs uppercase tracking-widest flex items-center gap-2 mb-6">
                            <Briefcase class="w-4 h-4 text-brand-600" /> Strategic Pipeline
                        </h4>
                        <div class="flex-1 flex flex-col justify-center space-y-3">
                            <div v-for="(stage, i) in pipelineStages" :key="i" class="relative group">
                                <div :class="['flex items-center justify-between px-4 py-2.5 rounded-lg border border-transparent transition-all', stage.color, stage.alert ? 'ring-2 ring-red-200' : '']">
                                    <span class="text-xs font-bold uppercase tracking-wide w-24">{{ stage.label }}</span>
                                    <span :class="['font-bold text-sm', stage.text]">{{ stage.value }}</span>
                                    <span v-if="stage.drop" class="text-[10px] font-bold text-slate-400">{{ stage.drop }}</span>
                                </div>
                                <div v-if="i < pipelineStages.length-1" class="h-2 w-0.5 bg-slate-300 mx-auto"></div>
                                <!-- Tooltip for dropoff -->
                                <div v-if="stage.alert" class="absolute -right-2 top-0 translate-x-full bg-red-600 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity w-24 text-center z-10">
                                    High Drop-off! Needs Review.
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-slate-100 flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-500">Forecasted Revenue</span>
                            <span class="text-sm font-bold text-slate-800">₹ 42.5 Cr</span>
                        </div>
                    </div>

                    <!-- 7) STRATEGIC INSIGHTS -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-5 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                             <h3 class="font-bold text-slate-800 flex items-center gap-2 text-xs uppercase tracking-widest">
                                <Activity class="w-4 h-4 text-brand-600" /> AI Strategic Signals
                            </h3>
                        </div>
                        <div class="divide-y divide-slate-100">
                            <div v-for="(insight, idx) in insights" :key="idx" class="p-5 hover:bg-slate-50 transition-colors">
                                <div class="flex items-center gap-2 mb-2">
                                    <component 
                                        :is="insight.type === 'positive' ? TrendingUp : insight.type === 'negative' ? AlertCircle : Activity" 
                                        :class="['w-4 h-4', insight.type === 'positive' ? 'text-emerald-500' : insight.type === 'negative' ? 'text-red-500' : 'text-amber-500']"
                                    />
                                    <span :class="['text-[10px] font-bold uppercase tracking-wide', insight.type === 'positive' ? 'text-emerald-700' : insight.type === 'negative' ? 'text-red-700' : 'text-amber-700']">{{ insight.title }}</span>
                                </div>
                                <p class="text-sm font-semibold text-slate-700 leading-snug">{{ insight.text }}</p>
                                <button class="mt-3 text-xs font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1 group">
                                    View Details <ArrowRight class="w-3 h-3 group-hover:translate-x-1 transition-transform" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 8) FINANCIAL RISK -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                        <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2 text-xs uppercase tracking-widest">
                            <ShieldAlert class="w-4 h-4 text-slate-400" /> Governance & Risk
                        </h3>
                        <div class="space-y-6">
                            <div v-for="(risk, idx) in financialRisks" :key="idx">
                                <div class="flex justify-between items-end mb-2">
                                    <span class="text-xs font-bold text-slate-500">{{ risk.label }}</span>
                                    <span :class="['text-sm font-bold', risk.status === 'High' ? 'text-red-600' : 'text-amber-600']">{{ risk.value }}</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                     <div :class="['h-full rounded-full', risk.status === 'High' ? 'bg-red-500' : 'bg-amber-500']" :style="{ width: risk.barIdx + '%' }"></div>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1 italic">{{ risk.desc }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- 9) EXECUTIVE ACTION CENTER -->
                    <div class="bg-slate-900 rounded-xl p-6 text-white shadow-xl">
                        <h3 class="font-bold text-white mb-4 text-xs uppercase tracking-widest flex items-center gap-2 opacity-80">
                            <Flag class="w-4 h-4" /> Executive Actions
                        </h3>
                        <div class="space-y-3">
                            <button class="w-full bg-white/10 hover:bg-white/20 border border-white/10 text-white p-4 rounded-lg font-bold flex items-center justify-between group transition-all">
                                <span class="flex items-center gap-3 text-sm"><FileText class="w-4 h-4 text-slate-300" /> Board Summary</span>
                                <Download class="w-4 h-4 opacity-50 group-hover:opacity-100 transition-opacity" />
                            </button>
                            <button class="w-full bg-brand-600 hover:bg-brand-700 border border-transparent text-white p-4 rounded-lg font-bold flex items-center justify-between group transition-all shadow-lg shadow-brand-900/50">
                                <span class="flex items-center gap-3 text-sm"><Flag class="w-4 h-4" /> Flag Critical Issue</span>
                                <ArrowRight class="w-4 h-4" />
                            </button>
                            <button class="w-full bg-white/10 hover:bg-white/20 border border-white/10 text-white p-4 rounded-lg font-bold flex items-center justify-between group transition-all">
                                <span class="flex items-center gap-3 text-sm"><Calendar class="w-4 h-4 text-slate-300" /> Leadership Review</span>
                                <ChevronRight class="w-4 h-4 opacity-50 group-hover:opacity-100 transition-opacity" />
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ------------------------------ -->
        <!-- KPI ANALYSIS DRAWER (SLIDE IN) -->
        <!-- ------------------------------ -->
        <transition 
            enter-active-class="transform transition ease-in-out duration-300" 
            enter-from-class="translate-x-full" 
            enter-to-class="translate-x-0"
            leave-active-class="transform transition ease-in-out duration-300" 
            leave-from-class="translate-x-0" 
            leave-to-class="translate-x-full"
        >
            <div v-if="drawerOpen" class="fixed inset-y-0 right-0 w-full md:w-[600px] bg-white shadow-2xl z-50 overflow-y-auto border-l border-slate-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Deep &nbsp; Dive &nbsp; Analytics</p>
                            <h2 class="text-2xl font-bold text-slate-800 mt-1">{{ selectedKpiForAnalysis?.label }}</h2>
                        </div>
                        <button @click="closeAnalysisDrawer" class="p-2 bg-slate-100 hover:bg-slate-200 rounded-full transition-colors">
                            <X class="w-6 h-6 text-slate-500" />
                        </button>
                    </div>

                    <div class="space-y-8">
                        <!-- Chart -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 h-80">
                            <v-chart class="h-full w-full" :option="deepDiveTrendOption" autoresize />
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-lg border border-slate-200">
                                <p class="text-xs font-bold text-slate-400 uppercase mb-1">Yearly High</p>
                                <p class="text-xl font-bold text-slate-800">₹ 280 Cr</p>
                                <p class="text-[10px] text-slate-500">December 2024</p>
                            </div>
                            <div class="p-4 rounded-lg border border-slate-200">
                                <p class="text-xs font-bold text-slate-400 uppercase mb-1">Yearly Low</p>
                                <p class="text-xl font-bold text-slate-800">₹ 90 Cr</p>
                                <p class="text-[10px] text-slate-500">May 2024</p>
                            </div>
                        </div>

                        <!-- Regional Split -->
                        <div>
                            <h4 class="font-bold text-slate-800 mb-4 text-sm uppercase tracking-wide">Regional Contribution</h4>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-bold text-slate-600">North Region</span>
                                    <span class="font-bold text-slate-800">42%</span>
                                </div>
                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-brand-500 w-[42%]"></div>
                                </div>

                                <div class="flex items-center justify-between text-sm pt-2">
                                    <span class="font-bold text-slate-600">West Region</span>
                                    <span class="font-bold text-slate-800">28%</span>
                                </div>
                                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-500 w-[28%]"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <!-- Overlay backdrop for drawer -->
        <div v-if="drawerOpen" @click="closeAnalysisDrawer" class="fixed inset-0 bg-slate-900/20 backdrop-blur-sm z-40 transition-opacity"></div>

    </AuthenticatedLayout>
</template>
