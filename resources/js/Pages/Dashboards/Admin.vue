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
    Activity, 
    DollarSign, 
    ShoppingCart, 
    School, 
    AlertTriangle, 
    ShieldAlert, 
    FileText, 
    BarChart3, 
    PieChart, 
    ArrowRight, 
    Lock, 
    RefreshCw, 
    CheckCircle2, 
    AlertOctagon, 
    Users, 
    Layers, 
    ChevronDown, 
    ChevronUp,
    Download,
    Eye,
    EyeOff,
    Landmark,
    Search,
    CreditCard,
    Wallet,
    ArrowUpRight,
    ArrowDownRight,
    X,
    Maximize2,
    Flag,
    Send
} from 'lucide-vue-next';

// ECharts Imports
import VChart from 'vue-echarts';
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { LineChart, BarChart, PieChart as EPieChart, TreemapChart, GaugeChart, SankeyChart } from 'echarts/charts';
import { GridComponent, TooltipComponent, LegendComponent, DataZoomComponent, TitleComponent } from 'echarts/components';

use([CanvasRenderer, LineChart, BarChart, EPieChart, TreemapChart, GaugeChart, SankeyChart, GridComponent, TooltipComponent, LegendComponent, DataZoomComponent, TitleComponent]);

// Helper function to wrap rupee symbols with CSS class for font styling
const formatRupee = (text) => {
    if (!text) return text;
    return String(text).replace(/₹/g, '<span class="rupee-symbol">₹</span>');
};

// Computed property to format all KPI values with rupee styling
const formattedKpis = computed(() => {
    return kpis.map(kpi => ({
        ...kpi,
        valueHtml: formatRupee(kpi.value)
    }));
});

// Financial Unlock State
const isFinancialsUnlocked = ref(false);
const showUnlockModal = ref(false);
const otpInput = ref('');
const otpError = ref('');
const correctOTP = '123456'; // Fake OTP

const openUnlockModal = () => {
    showUnlockModal.value = true;
    otpInput.value = '';
    otpError.value = '';
};

const closeUnlockModal = () => {
    showUnlockModal.value = false;
    otpInput.value = '';
    otpError.value = '';
};

const submitOTP = () => {
    if (otpInput.value.trim() === correctOTP) {
        isFinancialsUnlocked.value = true;
        otpError.value = '';
        closeUnlockModal();
    } else {
        otpError.value = 'Invalid OTP. Please try again.';
    }
};

// Helper function to mask financial values with dots
const maskFinancial = (value) => {
    if (isFinancialsUnlocked.value) return value;
    // Return dots matching the length
    const numStr = String(value).replace(/[^0-9]/g, '');
    return '••••••';
};

// Helper function to display masked or real values
const displayFinancial = (value) => {
    if (isFinancialsUnlocked.value) return formatRupee(value);
    return '<span class="tracking-widest font-bold">•••••••</span>';
};

// Critical Issue Reporting State
const showCriticalIssueModal = ref(false);
const issueForm = ref({
    issueTitle: '',
    issueCategory: 'Technical',
    severity: 'High',
    description: '',
    affectedModules: []
});
const isSubmittingIssue = ref(false);
const issueSubmitMessage = ref('');

const openCriticalIssueModal = () => {
    showCriticalIssueModal.value = true;
    issueForm.value = {
        issueTitle: '',
        issueCategory: 'Technical',
        severity: 'High',
        description: '',
        affectedModules: []
    };
    issueSubmitMessage.value = '';
};

const closeCriticalIssueModal = () => {
    showCriticalIssueModal.value = false;
    issueForm.value = {
        issueTitle: '',
        issueCategory: 'Technical',
        severity: 'High',
        description: '',
        affectedModules: []
    };
};

const submitCriticalIssue = async () => {
    if (!issueForm.value.issueTitle.trim() || !issueForm.value.description.trim()) {
        issueSubmitMessage.value = 'Please fill in all required fields.';
        return;
    }

    isSubmittingIssue.value = true;
    
    try {
        const formData = {
            ...issueForm.value,
            timestamp: new Date().toISOString(),
            reportedBy: 'Admin User'
        };
        
        console.log('Critical Issue Reported:', formData);
        await new Promise(resolve => setTimeout(resolve, 1500));
        
        issueSubmitMessage.value = '✓ Issue reported successfully to IT Department!';
        setTimeout(() => {
            closeCriticalIssueModal();
        }, 2000);
    } catch (error) {
        issueSubmitMessage.value = 'Error submitting issue. Please try again.';
        console.error('Issue submission error:', error);
    } finally {
        isSubmittingIssue.value = false;
    }
};

// -----------------------------------------------------------------------------
// DATA & STATE
// ----------------------------------------------------------------------

const isLoaded = ref(false);
const expandedRows = ref({});
const selectedTimeRange = ref('10Y'); // 10Y, 5Y, 1Y
const drawerOpen = ref(false);
const selectedKpi = ref(null);

// Financial Module State
const finView = ref('Yearly');
const showDetailFlow = ref(false); // Controls the expanded, detailed flow view
const sankeyInstance = ref(null);

onMounted(() => {
    setTimeout(() => {
        isLoaded.value = true;
    }, 100);
});

// 1. COMPANY HEADER DATA
const companyData = {
    revenue: '₹ 145.2 Cr',
    target: '₹ 220.0 Cr',
    achieved: 66,
    growth: '+14.2%',
    riskIndex: 'Low',
    lastSync: 'Today, 09:30 AM',
    netProfit: '₹ 24.5 Cr', // Net Profit
};

// 2. ABSOLUTE FILTER KPI SNAPSHOT
const kpis = [
    { id: 'revenue', label: 'Total Revenue', value: '₹ 145.2 Cr', change: '+14%', trend: 'up', icon: DollarSign, color: 'text-blue-700 bg-blue-50 border-blue-200' },
    { id: 'profit', label: 'Net Profit', value: '₹ 24.5 Cr', change: '+11%', trend: 'up', icon: Landmark, color: 'text-emerald-700 bg-emerald-50 border-emerald-200' },
    { id: 'orders', label: 'Total Orders', value: '12,450', change: '+8%', trend: 'up', icon: ShoppingCart, color: 'text-indigo-700 bg-indigo-50 border-indigo-200' },
    { id: 'schools', label: 'Active Schools', value: '2,800', change: '+3%', trend: 'up', icon: School, color: 'text-orange-700 bg-orange-50 border-orange-200' },
    { id: 'returns', label: 'Returns Value', value: '₹ 5.8 Cr', change: '+4%', trend: 'down', icon: AlertTriangle, color: 'text-red-700 bg-red-50 border-red-200', isBad: true },
    { id: 'receivables', label: 'Outstanding', value: '₹ 12.5 Cr', change: '-2%', trend: 'up', icon: Activity, color: 'text-amber-700 bg-amber-50 border-amber-200', isGood: true },
    { id: 'discount', label: 'Discount Dev.', value: '12.4%', change: '+1.5%', trend: 'down', icon: PieChart, color: 'text-pink-700 bg-pink-50 border-pink-200', isBad: true },
];

// 3. ORGANIZATIONAL POWER MAP DATA
const powerMap = [
    {
        id: 'vp', role: 'VP Leadership', name: 'Rajesh Gupta (VP Sales)', target: '₹ 220 Cr', revenue: '₹ 145.2 Cr', pct: 66, risk: 'Low',
        children: [
            { id: 'geo1', role: 'Head GEO', name: 'Vikram Singh (North)', target: '₹ 65 Cr', revenue: '₹ 45.2 Cr', pct: 69, risk: 'Low', children: [
                 { id: 'tl1', role: 'Team Leader', name: 'Suresh Kumar (North-A)', target: '₹ 18 Cr', revenue: '₹ 12.5 Cr', pct: 69, risk: 'Low' }
            ]},
            { id: 'geo2', role: 'Head GEO', name: 'Anitha Reddy (South)', target: '₹ 50 Cr', revenue: '₹ 32.0 Cr', pct: 64, risk: 'Low', children: [] },
            { id: 'geo3', role: 'Head GEO', name: 'Rajesh Gupta (West)', target: '₹ 60 Cr', revenue: '₹ 38.5 Cr', pct: 64, risk: 'Medium', children: [] }, // Medium Risk
            { id: 'geo4', role: 'Head GEO', name: 'Subhash Bose (East)', target: '₹ 45 Cr', revenue: '₹ 29.5 Cr', pct: 65, risk: 'High', children: [] }, // High Risk
        ]
    }
];

// 4. STRATEGIC FINANCIAL CONTROL
const financialControls = [
    { label: 'Pending Approvals', value: '₹ 8.5 Cr', status: 'High', desc: 'Critical bottleneck in East Region' },
    { label: 'Outstanding (>90 Days)', value: '₹ 4.2 Cr', status: 'Medium', desc: 'Improving, but requires monitoring' },
    { label: 'Returns vs LY', value: '+12%', status: 'High', desc: 'Significant spike in Q3 (West Zone)' },
    { label: 'Discount Misuse', value: '3 Flags', status: 'Medium', desc: 'Detected in North-B Zone' },
];

// 5. MULTI-YEAR TREND CHARTS
const multiYearTrendOption = {
    tooltip: { trigger: 'axis' },
    legend: { bottom: 0 },
    grid: { top: 20, left: '2%', right: '2%', bottom: 30, containLabel: true },
    xAxis: { type: 'category', data: ['2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024', '2025'] },
    yAxis: { type: 'value' },
    series: [
        { name: 'Revenue', type: 'line', smooth: true, data: [45, 52, 68, 80, 75, 90, 110, 135, 145, 160], itemStyle: { color: '#ea580c' }, areaStyle: { opacity: 0.1 }, symbolSize: 8 },
        { name: 'Target', type: 'line', smooth: true, data: [50, 60, 75, 85, 85, 100, 120, 150, 170, 200], itemStyle: { color: '#94a3b8' }, lineStyle: { type: 'dashed' }, symbol: 'none' }
    ]
};

// -----------------------------------------------------------
// FINANCIAL FLOW & PROFIT INTELLIGENCE
// -----------------------------------------------------------
const financialSummary = [
    { label: 'Total Revenue', value: '₹ 145.2 Cr', change: '+14% YoY', isPositive: true },
    { label: 'Total Expenses', value: '₹ 120.7 Cr', change: '+12% YoY', isPositive: false }, // Spending increase is generally "bad" for margin unless rev grows faster
    { label: 'Net Profit', value: '₹ 24.5 Cr', change: '+22% YoY', isPositive: true },
    { label: 'Profit Margin', value: '16.8%', change: '+1.5% pts', isPositive: true },
];

// Standard View Option
const sankeyOption = {
    tooltip: { trigger: 'item', formatter: '{b}: ₹ {c} Cr' },
    series: {
        type: 'sankey',
        layout: 'none',
        emphasis: { focus: 'adjacency' },
        data: [
            { name: 'Revenue', itemStyle: { color: '#ea580c' } },
            { name: 'Net Profit', itemStyle: { color: '#16a34a' } }, // Green - Now First
            { name: 'Production', itemStyle: { color: '#64748b' } },
            { name: 'Salaries', itemStyle: { color: '#64748b' } },
            { name: 'Marketing', itemStyle: { color: '#64748b' } },
            { name: 'Discounts', itemStyle: { color: '#64748b' } },
            { name: 'Logistics', itemStyle: { color: '#64748b' } },
            { name: 'Ops/Admin', itemStyle: { color: '#64748b' } },
        ],
        links: [
            { source: 'Revenue', target: 'Net Profit', value: 24.5 },
            { source: 'Revenue', target: 'Production', value: 42.0 },
            { source: 'Revenue', target: 'Salaries', value: 25.0 },
            { source: 'Revenue', target: 'Marketing', value: 18.5 },
            { source: 'Revenue', target: 'Discounts', value: 15.2 },
            { source: 'Revenue', target: 'Logistics', value: 12.0 },
            { source: 'Revenue', target: 'Ops/Admin', value: 8.0 },
        ],
        lineStyle: { color: 'gradient', curveness: 0.5 },
        label: { color: '#334155', fontWeight: 'bold' }
    }
};

const handleSankeyClick = (params) => {
    if (params.data.name === 'Revenue') {
        showDetailFlow.value = true;
    }
};

const expensePieOption = {
    tooltip: { trigger: 'item' },
    legend: { show: false },
    series: [
        {
            name: 'Expenses',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            itemStyle: { borderRadius: 5, borderColor: '#fff', borderWidth: 2 },
            label: { show: false },
            emphasis: { label: { show: true, fontSize: 12, fontWeight: 'bold' } },
            data: [
                { value: 42.0, name: 'Production', itemStyle: { color: '#3B82F6' } },
                { value: 25.0, name: 'Salaries', itemStyle: { color: '#10B981' } },
                { value: 18.5, name: 'Marketing', itemStyle: { color: '#F59E0B' } },
                { value: 15.2, name: 'Discounts', itemStyle: { color: '#EF4444' } },
                { value: 12.0, name: 'Logistics', itemStyle: { color: '#8B5CF6' } },
                { value: 8.0, name: 'Operations', itemStyle: { color: '#EC4899' } }
            ]
        }
    ]
};

const profitFitOption = {
    tooltip: { trigger: 'axis' },
    legend: { bottom: 0 },
    grid: { top: 20, left: '2%', right: '2%', bottom: 30, containLabel: true },
    xAxis: { type: 'category', data: ['2016','2017','2018','2019','2020','2021','2022','2023','2024','2025'] },
    yAxis: { type: 'value' },
    series: [
        { name: 'Revenue', type: 'line', data: [45, 52, 68, 80, 75, 90, 110, 135, 145, 160], smooth: true, itemStyle: { color: '#ea580c' }, lineStyle: { width: 3 } },
        { name: 'Expenses', type: 'line', data: [38, 45, 55, 65, 68, 75, 90, 105, 120, 125], smooth: true, itemStyle: { color: '#94a3b8' }, lineStyle: { type: 'dashed' } },
        { name: 'Net Profit', type: 'line', data: [7, 7, 13, 15, 7, 15, 20, 30, 25, 35], smooth: true, areaStyle: { opacity: 0.2 }, itemStyle: { color: '#16a34a' } }
    ]
};

// 7. LEADERSHIP ACCOUNTABILITY
const leadershipStats = [
    { name: 'Vikram Singh (North)', role: 'Head GEO', score: 92, status: 'Top Performer', trend: 'up' },
    { name: 'Anitha Reddy (South)', role: 'Head GEO', score: 88, status: 'Steady', trend: 'neutral' },
    { name: 'Rajesh Gupta (West)', role: 'Head GEO', score: 74, status: 'Risk Warning', trend: 'down' },
    { name: 'Subhash Bose (East)', role: 'Head GEO', score: 65, status: 'Underperforming', trend: 'down' },
];


const toggleRow = (id) => {
    expandedRows.value[id] = !expandedRows.value[id];
};

const getStatusColor = (risk) => {
    if (risk === 'High') return 'bg-red-500';
    if (risk === 'Medium') return 'bg-amber-500';
    return 'bg-emerald-500';
};
const getRiskBadgeColor = (risk) => {
     if (risk === 'High') return 'bg-red-100 text-red-700 border-red-200';
    if (risk === 'Medium') return 'bg-amber-100 text-amber-700 border-amber-200';
    return 'bg-emerald-100 text-emerald-700 border-emerald-200';
};

// Drawer Logic
const openDrawer = (kpi) => {
    selectedKpi.value = kpi;
    drawerOpen.value = true;
};
const closeDrawer = () => {
    drawerOpen.value = false;
    setTimeout(() => { selectedKpi.value = null; }, 300);
};

</script>

<template>
    <Head title="Owner Console" />

    <AuthenticatedLayout>
        <div class="space-y-8 pb-12 font-sans text-slate-900 bg-slate-50 min-h-screen">
            
            <!-- Greeting Section -->
            <div class="px-6 pt-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">Hi, {{ userName }}!</h1>
                </div>
            </div>

            <!-- 1) COMPANY COMMAND HEADER -->
            <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white p-6 shadow-2xl relative overflow-hidden border-b-4 border-orange-600">
                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-5 mix-blend-soft-light"></div>
                
                <div class="max-w-[1920px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                    <!-- Identity -->
                    <div class="lg:col-span-3 border-r border-white/10 pr-6">
                        <div class="flex items-center gap-3 mb-1">
                             <div class="p-2 bg-orange-600 rounded-lg shadow-lg shadow-orange-900/50">
                                <ShieldAlert class="w-6 h-6 text-white" />
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold font-display tracking-tight leading-none bg-clip-text text-transparent bg-gradient-to-r from-white to-slate-400">Owner Console</h1>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Ratna Sagar P. Ltd.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Core Metrics -->
                    <div class="lg:col-span-6 flex justify-around items-center px-4">
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Revenue</p>
                            <p v-if="isFinancialsUnlocked" class="text-4xl font-bold font-mono tracking-tight" v-html="formatRupee(companyData.revenue)"></p>
                            <p v-else class="text-4xl font-bold font-mono tracking-widest text-white/40">•••••••</p>
                            <span class="text-xs font-bold text-emerald-400 flex items-center justify-center gap-1">{{ companyData.growth }} YoY</span>
                        </div>
                        <div class="h-10 w-px bg-white/10"></div>
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Achievement</p>
                            <p class="text-4xl font-bold font-mono tracking-tight">{{ companyData.achieved }}%</p>
                            <div class="w-24 h-1.5 bg-slate-700 rounded-full mt-1.5 mx-auto overflow-hidden">
                                <div class="h-full bg-orange-500 rounded-full" :style="{ width: companyData.achieved + '%' }"></div>
                            </div>
                        </div>
                        <div class="h-10 w-px bg-white/10"></div>
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Net Risk</p>
                            <div class="flex items-center gap-2 bg-white/5 px-3 py-1.5 rounded border border-white/10">
                                <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_#10b981]"></div>
                                <span class="text-lg font-bold text-white leading-none">Low</span>
                            </div>
                        </div>
                    </div>

                    <!-- Meta -->
                    <div class="lg:col-span-3 flex flex-col items-end border-l border-white/10 pl-6 space-y-2">
                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                                <RefreshCw class="w-3.5 h-3.5 animate-spin-slow" />
                                Synced: {{ companyData.lastSync }}
                            </div>
                            <button 
                                @click="openCriticalIssueModal"
                                class="ml-4 p-2 hover:bg-red-600/30 rounded-lg text-red-400 hover:text-red-300 transition-all hover:scale-110 transform"
                                title="Flag Critical Issue">
                                <Flag class="w-5 h-5" />
                            </button>
                        </div>
                        <button 
                            v-if="!isFinancialsUnlocked"
                            @click="openUnlockModal"
                            class="bg-amber-600 hover:bg-amber-500 text-white text-xs font-bold px-4 py-2 rounded-md shadow-lg transition-all flex items-center gap-2">
                            <Lock class="w-3.5 h-3.5" /> Unlock Revenues & Financials
                        </button>
                        <button v-else class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold px-4 py-2 rounded-md shadow-lg transition-all flex items-center gap-2">
                            <Eye class="w-3.5 h-3.5" /> Financials Unlocked
                        </button>
                        <button class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-4 py-2 rounded-md shadow-lg transition-all flex items-center gap-2">
                            <Lock class="w-3.5 h-3.5" /> Emergency Access
                        </button>
                    </div>
                </div>
            </div>

            <div class="max-w-[1920px] mx-auto px-6 space-y-8">
                
                <!-- 2) ABSOLUTE KPI SNAPSHOT -->
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                    <button v-for="(kpi, idx) in kpis" :key="idx" 
                            @click="openDrawer(kpi)"
                            :class="['group relative bg-[#FFFAF7] p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all text-left overflow-hidden']">
                        <div :class="['absolute top-0 left-0 w-1 h-full', kpi.color.split(' ')[0].replace('text-', 'bg-')]"></div>
                        <div class="flex justify-between items-start mb-2 opacity-80">
                            <component :is="kpi.icon" :class="['w-4 h-4', kpi.color.split(' ')[0]]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">{{ kpi.label }}</p>
                        <p v-if="isFinancialsUnlocked" class="text-xl font-bold text-[#015276] tracking-tight" v-html="formatRupee(kpi.value)"></p>
                        <p v-else class="text-xl font-bold text-slate-400 tracking-widest">•••••••</p>
                        <div class="flex items-center gap-1 mt-1.5 text-[10px] font-bold">
                             <component :is="kpi.trend === 'up' ? TrendingUp : TrendingDown" :class="['w-3 h-3', (kpi.trend === 'up' && !kpi.isBad) || (kpi.trend === 'down' && kpi.isGood) ? 'text-emerald-600' : 'text-red-600']" />
                            <span :class="[(kpi.trend === 'up' && !kpi.isBad) || (kpi.trend === 'down' && kpi.isGood) ? 'text-emerald-600' : 'text-red-600']">{{ kpi.change }}</span>
                        </div>
                    </button>
                </div>

                <!-- NEW MODULE: FINANCIAL FLOW & PROFIT INTELLIGENCE -->
                <div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6 lg:p-8 animate-in slide-in-from-bottom-5 duration-700">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                                <Wallet class="w-6 h-6 text-emerald-600" /> Financial Flow & Profit Intelligence
                            </h2>
                            <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest font-bold">Strategic Cost Analysis & Profit Retention</p>
                        </div>
                        <div class="flex gap-2">
                             <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-lg">
                                <button v-for="t in ['Monthly', 'Quarterly', 'Yearly', '5Y']" :key="t" 
                                        @click="finView = t"
                                        :class="['px-3 py-1.5 rounded-md text-xs font-bold transition-all', finView === t ? 'bg-white shadow text-slate-900' : 'text-slate-500 hover:text-slate-700']">
                                    {{ t }}
                                </button>
                            </div>
                            <button class="bg-indigo-50 text-indigo-700 px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-100 transition-colors flex items-center gap-2">
                                <Download class="w-3.5 h-3.5" /> Report
                            </button>
                        </div>
                    </div>

                    <!-- Row 1: Summary Chips -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div v-for="(item, idx) in financialSummary" :key="idx" class="p-4 rounded-xl border bg-slate-50/50 flex flex-col justify-center">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">{{ item.label }}</p>
                            <p v-if="isFinancialsUnlocked" :class="['text-2xl font-bold tracking-tight', item.label === 'Net Profit' || item.label === 'Profit Margin' ? 'text-emerald-700' : 'text-slate-900']" v-html="formatRupee(item.value)"></p>
                            <p v-else class="text-2xl font-bold tracking-widest text-slate-300">•••••••</p>
                            <div class="flex items-center gap-1 mt-1">
                                <component :is="item.isPositive ? TrendingUp : TrendingDown" :class="['w-3 h-3', item.isPositive ? 'text-emerald-600' : 'text-slate-500']" />
                                <span :class="['text-xs font-bold', item.isPositive ? 'text-emerald-600' : 'text-slate-500']">{{ item.change }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Visuals (Sankey + Insights) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-8">
                        <!-- Sankey Chart -->
                        <div class="lg:col-span-8 bg-slate-50 rounded-xl border border-slate-100 p-4 min-h-[500px] relative overflow-hidden group">
                            <div class="flex justify-between items-center mb-4 pl-2 border-l-4 border-orange-500">
                                <div>
                                    <h3 class="font-bold text-slate-700 text-xs uppercase">Revenue to Profit Flow (Cr)</h3>
                                    <p v-if="isFinancialsUnlocked" class="text-sm font-bold text-emerald-700 mt-1">Net Profit: <span v-html="formatRupee('₹ 24.5 Cr')"></span></p>
                                    <p v-else class="text-sm font-bold text-slate-400 mt-1 tracking-widest">••••••••••••</p>
                                </div>
                                <div class="text-[10px] text-slate-400 italic">Click on 'Revenue' to expand details</div>
                            </div>
                            <!-- Added Click Handler -->
                            <v-chart class="h-full w-full" :option="sankeyOption" @click="handleSankeyClick" autoresize />
                            
                            <!-- Hover Overlay Prompt -->
                            <div class="absolute inset-0 bg-slate-900/0 group-hover:bg-slate-900/5 transition-colors pointer-events-none flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <span class="bg-white px-3 py-1 rounded-full text-[10px] font-bold shadow-sm text-slate-600">Interact to Explore</span>
                            </div>
                        </div>
                        
                        <!-- Expense Breakdown & Insights -->
                        <div class="lg:col-span-4 flex flex-col gap-6">
                            <div class="bg-white border border-slate-200 rounded-xl p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="font-bold text-slate-700 text-xs uppercase">Expense Distribution</h3>
                                    <span class="text-[10px] font-bold text-slate-400">All Categories</span>
                                </div>
                                <div class="h-40 w-full">
                                    <v-chart class="h-full w-full" :option="expensePieOption" autoresize />
                                </div>
                                <div class="space-y-2 mt-3">
                                    <div class="flex justify-between text-xs items-center">
                                        <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-blue-500"></div> <span class="text-slate-600 font-bold">Production</span></div>
                                        <span v-if="isFinancialsUnlocked" class="font-bold">35%</span>
                                        <span v-else class="font-bold text-slate-400 tracking-widest">••••</span>
                                    </div>
                                    <div class="flex justify-between text-xs items-center">
                                        <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-green-500"></div> <span class="text-slate-600 font-bold">Salaries</span></div>
                                        <span v-if="isFinancialsUnlocked" class="font-bold">21%</span>
                                        <span v-else class="font-bold text-slate-400 tracking-widest">••••</span>
                                    </div>
                                    <div class="flex justify-between text-xs items-center">
                                        <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-amber-500"></div> <span class="text-slate-600 font-bold">Marketing</span></div>
                                        <span v-if="isFinancialsUnlocked" class="font-bold">15%</span>
                                        <span v-else class="font-bold text-slate-400 tracking-widest">••••</span>
                                    </div>
                                    <div class="flex justify-between text-xs items-center">
                                        <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-red-500"></div> <span class="text-slate-600 font-bold">Discounts</span></div>
                                        <span v-if="isFinancialsUnlocked" class="font-bold">13%</span>
                                        <span v-else class="font-bold text-slate-400 tracking-widest">••••</span>
                                    </div>
                                    <div class="flex justify-between text-xs items-center">
                                        <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-purple-500"></div> <span class="text-slate-600 font-bold">Logistics</span></div>
                                        <span v-if="isFinancialsUnlocked" class="font-bold">10%</span>
                                        <span v-else class="font-bold text-slate-400 tracking-widest">••••</span>
                                    </div>
                                    <div class="flex justify-between text-xs items-center">
                                        <div class="flex items-center gap-2"><div class="w-2 h-2 rounded-full bg-pink-500"></div> <span class="text-slate-600 font-bold">Operations</span></div>
                                        <span v-if="isFinancialsUnlocked" class="font-bold">6%</span>
                                        <span v-else class="font-bold text-slate-400 tracking-widest">••••</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Profit Evolution -->
                    <div class="bg-white border border-slate-200 rounded-xl p-6">
                        <h3 class="font-bold text-slate-700 text-xs uppercase mb-4 flex items-center gap-2">
                            <TrendingUp class="w-4 h-4 text-emerald-600" /> Profit Evolution & Sustainability (10Y)
                        </h3>
                        <div class="h-60 w-full">
                            <v-chart class="h-full w-full" :option="profitFitOption" autoresize />
                        </div>
                    </div>
                </div>

                <!-- MAIN CONTENT GRID -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
                    
                    <!-- LEFT COL (2/3) -->
                    <div class="xl:col-span-2 space-y-4">
                        
                        <!-- 3) ORGANIZATIONAL POWER MAP -->
                        <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
                                    <Layers class="w-4 h-4 text-slate-500" /> Organizational Performance Map
                                </h3>
                                <div class="flex gap-2">
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-slate-500"><div class="w-2 h-2 rounded-full bg-red-500"></div> High Risk</span>
                                    <span class="flex items-center gap-1 text-[10px] font-bold text-slate-500"><div class="w-2 h-2 rounded-full bg-amber-500"></div> Med Risk</span>
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <div class="min-w-full divide-y divide-slate-100 text-sm">
                                    <!-- Header -->
                                    <div class="bg-slate-50/50 flex px-6 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        <div class="w-5/12">Leadership Node</div>
                                        <div class="w-2/12 text-center">Revenue</div>
                                        <div class="w-3/12 px-4">Achievement</div>
                                        <div class="w-2/12 text-right">Risk Status</div>
                                    </div>

                                    <!-- Tree View -->
                                    <div v-for="node in powerMap" :key="node.id">
                                        <!-- Root (VP) -->
                                        <div class="flex items-center px-6 py-4 hover:bg-slate-50 cursor-pointer border-l-4 border-orange-500 bg-orange-50/10" @click="toggleRow(node.id)">
                                            <div class="w-5/12 flex items-center gap-3">
                                                <button class="p-1 hover:bg-slate-200 rounded text-slate-400">
                                                    <component :is="expandedRows[node.id] ? ChevronUp : ChevronDown" class="w-4 h-4" />
                                                </button>
                                                <div>
                                                    <p class="font-bold text-slate-900 text-base">{{ node.name }}</p>
                                                    <span class="text-[10px] font-bold text-orange-600 bg-orange-100 uppercase px-1.5 py-0.5 rounded">{{ node.role }}</span>
                                                </div>
                                            </div>
                                            <div class="w-2/12 text-center font-bold font-mono text-slate-700">
                                                <span v-if="isFinancialsUnlocked" v-html="formatRupee(node.revenue)"></span>
                                                <span v-else class="tracking-widest text-slate-400">•••••••</span>
                                            </div>
                                            <div class="w-3/12 px-4">
                                                <div class="flex justify-between text-xs font-bold mb-1">
                                                    <span>{{ node.pct }}%</span>
                                                </div>
                                                <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                                                    <div :class="['h-full rounded-full', getStatusColor(node.risk)]" :style="{ width: node.pct + '%' }"></div>
                                                </div>
                                            </div>
                                            <div class="w-2/12 text-right">
                                                <span :class="['text-[10px] font-bold uppercase px-2 py-1 rounded border', getRiskBadgeColor(node.risk)]">{{ node.risk }} Risk</span>
                                            </div>
                                        </div>

                                        <!-- VP Children (Head GEOs) -->
                                        <div v-if="expandedRows[node.id]" class="border-t border-slate-100 bg-slate-50/30">
                                            <div v-for="geo in node.children" :key="geo.id">
                                                <div class="flex items-center px-6 py-3 pl-12 hover:bg-slate-50 cursor-pointer border-l border-slate-100" @click="toggleRow(geo.id)">
                                                     <div class="w-5/12 flex items-center gap-3">
                                                        <button v-if="geo.children.length" class="p-1 hover:bg-slate-200 rounded text-slate-400">
                                                            <component :is="expandedRows[geo.id] ? ChevronUp : ChevronDown" class="w-3 h-3" />
                                                        </button>
                                                        <div v-else class="w-5"></div> <!-- Spacer -->
                                                        <div>
                                                            <p class="font-bold text-slate-800 text-sm">{{ geo.name }}</p>
                                                            <span class="text-[10px] font-bold text-slate-400 uppercase">{{ geo.role }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="w-2/12 text-center font-bold font-mono text-sm text-slate-600">
                                                        <span v-if="isFinancialsUnlocked" v-html="formatRupee(geo.revenue)"></span>
                                                        <span v-else class="tracking-widest text-slate-400">•••••••</span>
                                                    </div>
                                                    <div class="w-3/12 px-4">
                                                        <div class="h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                                            <div :class="['h-full rounded-full', getStatusColor(geo.risk)]" :style="{ width: geo.pct + '%' }"></div>
                                                        </div>
                                                    </div>
                                                    <div class="w-2/12 text-right">
                                                        <span :class="['text-[10px] font-bold uppercase px-1.5 py-0.5 rounded border', getRiskBadgeColor(geo.risk)]">{{ geo.risk }}</span>
                                                    </div>
                                                </div>

                                                <!-- TL Children -->
                                                 <div v-if="expandedRows[geo.id]" class="bg-white border-t border-slate-100">
                                                      <div v-for="tl in geo.children" :key="tl.id" class="flex items-center px-6 py-2 pl-24 hover:bg-slate-50 text-xs">
                                                          <div class="w-5/12 flex items-center gap-2">
                                                              <div class="w-1.5 h-1.5 rounded-full bg-slate-300"></div>
                                                              <span class="font-medium text-slate-600">{{ tl.name }}</span>
                                                          </div>
                                                           <div class="w-2/12 text-center font-mono text-slate-500">
                                                               <span v-if="isFinancialsUnlocked" v-html="formatRupee(tl.revenue)"></span>
                                                               <span v-else class="tracking-widest text-slate-400">•••••••</span>
                                                           </div>
                                                           <div class="w-3/12 px-4">
                                                               <span class="font-bold text-slate-700">{{ tl.pct }}%</span>
                                                           </div>
                                                           <div class="w-2/12 text-right">
                                                               <span class="text-[10px] text-slate-400">{{ tl.risk }}</span>
                                                           </div>
                                                      </div>
                                                 </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 5) MULTI-YEAR TREND VIEW -->
                        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
                                    <BarChart3 class="w-4 h-4 text-slate-500" /> Multi-Year Business Trajectory
                                </h3>
                                <div class="flex gap-2 bg-slate-100 p-1 rounded-lg">
                                    <button v-for="t in ['10Y', '5Y', '3Y']" :key="t" 
                                            @click="selectedTimeRange = t"
                                            :class="['px-3 py-1 rounded text-xs font-bold transition-all', selectedTimeRange === t ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500']">
                                        {{ t }}
                                    </button>
                                </div>
                            </div>
                            <div class="h-80 w-full">
                                <v-chart class="h-full w-full" :option="multiYearTrendOption" autoresize />
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COL (1/3) -->
                    <div class="xl:col-span-1 space-y-4">
                        
                        <!-- 4) STRATEGIC FINANCIAL CONTROL -->
                        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-4 opacity-5">
                                <Landmark class="w-24 h-24" />
                            </div>
                            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-6 flex items-center gap-2">
                                <ShieldAlert class="w-4 h-4 text-slate-500" /> Financial Control
                            </h3>
                            <div class="space-y-6 relative z-10">
                                <div v-for="(item, i) in financialControls" :key="i" class="flex items-start gap-4 p-3 rounded-lg border border-slate-100 bg-slate-50/50 hover:bg-white hover:shadow-md transition-all">
                                    <div :class="['p-2 rounded-full mt-1', item.status === 'High' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600']">
                                        <AlertOctagon v-if="item.status === 'High'" class="w-4 h-4" />
                                        <AlertTriangle v-else class="w-4 h-4" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-xs font-bold text-slate-600 uppercase">{{ item.label }}</span>
                                            <span v-if="isFinancialsUnlocked" class="text-sm font-bold text-slate-900" v-html="formatRupee(item.value)"></span>
                                            <span v-else class="text-sm font-bold text-slate-400 tracking-widest">•••••••</span>
                                        </div>
                                        <p class="text-[11px] font-medium text-slate-500 leading-tight">{{ item.desc }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 6) STRATEGIC INTELLIGENCE -->
                        <div class="bg-slate-900 text-white rounded-xl shadow-lg p-6">
                             <h3 class="font-bold text-white text-sm uppercase tracking-wider mb-6 flex items-center gap-2 opacity-80">
                                <Eye class="w-4 h-4" /> Strategic Intelligence
                            </h3>
                            <div class="space-y-4">
                                <div class="flex gap-3">
                                    <div class="w-1 bg-emerald-500 rounded-full"></div>
                                    <div>
                                        <p class="text-sm font-bold text-white leading-snug">42% of company growth is driven solely by North Region.</p>
                                        <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-wide">High Positive Impact</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="w-1 bg-red-500 rounded-full"></div>
                                    <div>
                                        <p class="text-sm font-bold text-white leading-snug">Returns in West Zone have increased for 3 consecutive quarters.</p>
                                        <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-wide">Critical Attention</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="w-1 bg-amber-500 rounded-full"></div>
                                    <div>
                                        <p class="text-sm font-bold text-white leading-snug">Discount deviation crossed 12% threshold in 2 regions.</p>
                                        <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-wide">Policy Warning</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 7) LEADERSHIP ACCOUNTABILITY -->
                        <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                             <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Leadership Matrix</h3>
                             </div>
                             <div class="divide-y divide-slate-100">
                                 <div v-for="(leader, i) in leadershipStats" :key="i" class="px-6 py-3 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                     <div>
                                         <p class="text-xs font-bold text-slate-700">{{ leader.name }}</p>
                                         <p class="text-[10px] text-slate-400">{{ leader.role }}</p>
                                     </div>
                                     <div class="text-right">
                                         <span :class="['text-[10px] font-bold px-2 py-0.5 rounded-full', leader.status === 'Top Performer' ? 'bg-emerald-100 text-emerald-700' : leader.status === 'Underperforming' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-600']">{{ leader.status }}</span>
                                         <p class="text-xs font-bold text-slate-800 mt-0.5">Score: {{ leader.score }}/100</p>
                                     </div>
                                 </div>
                             </div>
                        </div>

                        <!-- 8) EXECUTIVE ACTION -->
                        <div class="space-y-3">
                            <button class="w-full bg-slate-800 hover:bg-slate-700 text-white p-4 rounded-lg font-bold flex items-center justify-between shadow-lg shadow-slate-300 transform transition-transform hover:-translate-y-0.5">
                                <span class="flex items-center gap-2 text-sm"><FileText class="w-4 h-4 text-slate-400" /> Full Company Audit</span>
                                <Download class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- 9) SYSTEM FOOTER -->
                <div class="border-t border-slate-200 pt-6 mt-12 flex justify-between items-center text-[10px] text-slate-400 font-medium uppercase tracking-widest pb-8">
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1"><CheckCircle2 class="w-3 h-3 text-emerald-500" /> System Healthy</span>
                        <span>ERP Sync: Active</span>
                        <span>Audit Log: Verified</span>
                    </div>
                    <div>
                        Ratna Sagar P. Ltd. • Owner Console v3.1 • Confidential
                    </div>
                </div>

            </div>
        </div>

        <!-- ------------------------------ -->
        <!-- ANALYTICS DRAWER (SLIDE IN) -->
        <!-- ------------------------------ -->
        <transition 
            enter-active-class="transform transition ease-in-out duration-300" 
            enter-from-class="translate-x-full" 
            enter-to-class="translate-x-0"
            leave-active-class="transform transition ease-in-out duration-300" 
            leave-from-class="translate-x-0" 
            leave-to-class="translate-x-full"
        >
             <div v-if="drawerOpen" class="fixed inset-y-0 right-0 w-full md:w-[700px] bg-white shadow-2xl z-50 overflow-y-auto border-l border-slate-200">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
                        <div>
                             <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Deep Dive Analytics</p>
                             <h2 class="text-3xl font-bold text-slate-900">{{ selectedKpi?.label }}</h2>
                        </div>
                        <button @click="closeDrawer" class="p-2 hover:bg-slate-100 rounded-full text-slate-400 hover:text-slate-600"><AlertOctagon class="w-6 h-6 rotate-45" /></button>
                    </div>

                    <div class="space-y-8">
                        <div class="bg-slate-50 p-6 rounded-xl border border-slate-100 h-80">
                            <h4 class="font-bold text-slate-700 text-xs uppercase mb-4">Historical Trend (10 Years)</h4>
                             <v-chart class="h-full w-full" :option="multiYearTrendOption" autoresize />
                        </div>

                         <div class="grid grid-cols-2 gap-6">
                            <div class="p-5 border border-slate-200 rounded-xl">
                                <h4 class="font-bold text-slate-500 text-xs uppercase mb-2">Highest Peak</h4>
                                <p class="text-3xl font-bold text-slate-900" v-html="formatRupee('₹ 210 Cr')"></p>
                                <p class="text-xs text-slate-400 mt-1">FY 2024-25</p>
                            </div>
                            <div class="p-5 border border-slate-200 rounded-xl">
                                <h4 class="font-bold text-slate-500 text-xs uppercase mb-2">Lowest Point</h4>
                                <p class="text-3xl font-bold text-slate-900" v-html="formatRupee('₹ 45 Cr')"></p>
                                <p class="text-xs text-slate-400 mt-1">FY 2016-17</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-bold text-slate-700 text-xs uppercase mb-4">Leadership Contribution</h4>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-slate-600">Vikram Singh (North)</span>
                                    <span class="text-sm font-bold text-slate-900">42%</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden"><div class="h-full bg-slate-800 w-[42%]"></div></div>

                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-slate-600">Rajesh Gupta (West)</span>
                                    <span class="text-sm font-bold text-slate-900">28%</span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden"><div class="h-full bg-slate-800 w-[28%]"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
         <div v-if="drawerOpen" @click="closeDrawer" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 transition-opacity"></div>

        <!-- ------------------------------ -->
        <!-- DETAIL REVENUE FLOW OVERLAY -->
        <!-- ------------------------------ -->
        <transition 
            enter-active-class="transition duration-300 ease-out" 
            enter-from-class="opacity-0 scale-95" 
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-200 ease-in" 
            leave-from-class="opacity-100 scale-100" 
            leave-to-class="opacity-0 scale-95"
        >
            <div v-if="showDetailFlow" class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-10">
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showDetailFlow = false"></div>
                
                <div class="bg-white w-full h-full max-w-6xl max-h-[90vh] rounded-2xl shadow-2xl flex relative overflow-hidden flex-col">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-brand-100 rounded-lg">
                                <Layers class="w-6 h-6 text-brand-600" />
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-slate-900">Revenue Distribution Breakdown</h2>
                                <p class="text-xs text-slate-500 font-medium">Detailed attribution of every rupee earned.</p>
                            </div>
                        </div>
                        <button @click="showDetailFlow = false" class="p-2 hover:bg-slate-200 rounded-full transition-colors">
                            <X class="w-6 h-6 text-slate-500" />
                        </button>
                    </div>

                    <div class="flex-1 overflow-hidden flex">
                        <!-- Main Visual (Left 70%) -->
                        <div class="w-2/3 p-8 border-r border-slate-100 flex flex-col">
                           <v-chart class="h-full w-full" :option="sankeyOption" autoresize />
                           <div class="mt-4 text-center">
                               <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Interactive Data Flow - Hover nodes for values</p>
                           </div>
                        </div>

                        <!-- Sidebar Context (Right 30%) -->
                         <div class="w-1/3 bg-slate-50 overflow-y-auto p-6 space-y-8">
                             
                             <div>
                                 <h4 class="font-bold text-slate-800 mb-4 text-sm flex items-center gap-2">
                                     <ArrowDownRight class="w-4 h-4 text-slate-500" /> Major Cost Drivers
                                 </h4>
                                 <div class="space-y-4">
                                     <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                                         <div class="flex justify-between mb-1">
                                             <span class="text-xs font-bold text-slate-500">Production & Printing</span>
                                             <span class="text-xs font-bold text-slate-900">₹ 42.0 Cr</span>
                                         </div>
                                         <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                             <div class="h-full bg-slate-600 w-[35%]"></div>
                                         </div>
                                         <p class="text-[10px] text-slate-400 mt-2 leading-relaxed">Paper costs rose by 4% in Q3. Bulk purchasing strategy recommended for Q4.</p>
                                     </div>

                                      <div class="p-4 bg-white border border-slate-200 rounded-xl shadow-sm">
                                         <div class="flex justify-between mb-1">
                                             <span class="text-xs font-bold text-slate-500">Salaries & Benefits</span>
                                             <span class="text-xs font-bold text-slate-900">₹ 25.0 Cr</span>
                                         </div>
                                         <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                             <div class="h-full bg-slate-400 w-[21%]"></div>
                                         </div>
                                         <p class="text-[10px] text-slate-400 mt-2 leading-relaxed">Includes annual increments. Sales incentive payout accounts for 12% of this block.</p>
                                     </div>
                                 </div>
                             </div>

                             <div>
                                 <h4 class="font-bold text-slate-800 mb-4 text-sm flex items-center gap-2">
                                     <ArrowUpRight class="w-4 h-4 text-emerald-600" /> Profit Retention
                                 </h4>
                                  <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl">
                                      <p class="text-3xl font-bold text-emerald-700">₹ 24.5 Cr</p>
                                      <h6 class="text-xs font-bold text-emerald-800 uppercase tracking-widest mb-2">Net Realized Profit</h6>
                                      
                                      <p class="text-[11px] font-medium text-emerald-900 leading-snug">
                                          Total profit margin stands at <span class="font-bold">16.8%</span>. This is above the industry average of 14.5%, indicating strong operational efficiency despite rising input costs.
                                      </p>
                                  </div>
                             </div>

                         </div>
                    </div>
                </div>
            </div>
        </transition>

        <!-- OTP UNLOCK MODAL -->
        <transition name="fade">
            <div v-if="showUnlockModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50">
                <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-in slide-in-from-bottom-5">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-amber-100 rounded-full">
                                <Lock class="w-6 h-6 text-amber-600" />
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">Unlock Financials</h3>
                                <p class="text-xs text-slate-500">Enter OTP to view revenues</p>
                            </div>
                        </div>
                        <button @click="closeUnlockModal" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-400 hover:text-slate-600 transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>

                    <!-- OTP Display -->
                    <div class="bg-slate-50 p-4 rounded-lg mb-6 border border-slate-200">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Your OTP</p>
                        <p class="text-2xl font-mono font-bold text-slate-900 select-all">{{ correctOTP }}</p>
                        <p class="text-[10px] text-slate-400 mt-2">OTP displayed for reference (in real scenario, sent via SMS/Email)</p>
                    </div>

                    <!-- OTP Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Enter OTP</label>
                        <input 
                            v-model="otpInput"
                            type="text"
                            placeholder="000000"
                            maxlength="6"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all font-mono text-lg font-bold tracking-widest text-center"
                            @keyup.enter="submitOTP"
                        />
                        <p v-if="otpError" class="text-sm font-bold text-red-600 mt-2">{{ otpError }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button 
                            @click="closeUnlockModal"
                            class="flex-1 px-4 py-2.5 border-2 border-slate-200 text-slate-700 font-bold rounded-lg hover:bg-slate-50 transition-colors">
                            Cancel
                        </button>
                        <button 
                            @click="submitOTP"
                            class="flex-1 px-4 py-2.5 bg-amber-600 hover:bg-amber-500 text-white font-bold rounded-lg shadow-lg transition-all hover:shadow-xl">
                            Proceed
                        </button>
                    </div>

                    <!-- Info -->
                    <p class="text-[11px] text-slate-500 text-center mt-4">
                        This will unlock all financial and revenue data on the dashboard.
                    </p>
                </div>
            </div>
        </transition>

        <!-- Critical Issue Reporting Modal -->
        <transition 
            enter-active-class="transition ease-out duration-300"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95">
            <div v-if="showCriticalIssueModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                <div class="bg-slate-800 rounded-lg shadow-2xl max-w-md w-full border border-red-900/30">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <Flag class="w-5 h-5 text-red-100" />
                            <h2 class="text-lg font-bold text-white">Report Critical Issue</h2>
                        </div>
                        <button 
                            @click="closeCriticalIssueModal"
                            class="text-red-100 hover:text-white transition-colors">
                            ✕
                        </button>
                    </div>

                    <!-- Form -->
                    <div class="p-6 space-y-4">
                        <!-- Issue Title -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-2">Issue Title *</label>
                            <input 
                                v-model="issueForm.issueTitle"
                                type="text"
                                placeholder="e.g., Revenue calculations incorrect"
                                class="w-full bg-slate-700 text-white px-3 py-2 rounded-lg border border-slate-600 focus:border-red-500 focus:outline-none text-sm placeholder-slate-500 transition-colors" />
                        </div>

                        <!-- Category & Severity Row -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-300 mb-2">Category</label>
                                <select 
                                    v-model="issueForm.issueCategory"
                                    class="w-full bg-slate-700 text-white px-3 py-2 rounded-lg border border-slate-600 focus:border-red-500 focus:outline-none text-sm transition-colors">
                                    <option value="Technical">Technical</option>
                                    <option value="Security">Security</option>
                                    <option value="Data">Data</option>
                                    <option value="Performance">Performance</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-300 mb-2">Severity</label>
                                <select 
                                    v-model="issueForm.severity"
                                    class="w-full bg-slate-700 text-white px-3 py-2 rounded-lg border border-slate-600 focus:border-red-500 focus:outline-none text-sm transition-colors">
                                    <option value="Critical">Critical</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-2">Description *</label>
                            <textarea 
                                v-model="issueForm.description"
                                placeholder="Provide detailed information about the issue..."
                                rows="3"
                                class="w-full bg-slate-700 text-white px-3 py-2 rounded-lg border border-slate-600 focus:border-red-500 focus:outline-none text-sm placeholder-slate-500 transition-colors resize-none"></textarea>
                        </div>

                        <!-- Affected Modules -->
                        <div>
                            <label class="block text-xs font-bold text-slate-300 mb-2">Affected Modules</label>
                            <div class="space-y-2">
                                <label v-for="module in ['Revenue', 'Financials', 'Performance', 'Organization', 'Other']" :key="module" class="flex items-center gap-2 cursor-pointer">
                                    <input 
                                        type="checkbox"
                                        :value="module"
                                        v-model="issueForm.affectedModules"
                                        class="w-4 h-4 bg-slate-700 border-slate-600 rounded accent-red-600" />
                                    <span class="text-xs text-slate-300">{{ module }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Status Message -->
                        <div v-if="issueSubmitMessage" class="p-3 bg-emerald-900/40 border border-emerald-600/50 rounded-lg text-xs text-emerald-200">
                            {{ issueSubmitMessage }}
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-slate-700/50 px-6 py-4 flex gap-3 border-t border-slate-700">
                        <button 
                            @click="closeCriticalIssueModal"
                            class="flex-1 px-4 py-2 bg-slate-600 hover:bg-slate-500 text-white font-bold rounded-lg transition-all">
                            Cancel
                        </button>
                        <button 
                            @click="submitCriticalIssue"
                            :disabled="isSubmittingIssue || !issueForm.issueTitle || !issueForm.description"
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-500 disabled:bg-red-600/50 disabled:cursor-not-allowed text-white font-bold rounded-lg shadow-lg transition-all flex items-center justify-center gap-2">
                            <Send class="w-4 h-4" />
                            {{ isSubmittingIssue ? 'Reporting...' : 'Report to IT' }}
                        </button>
                    </div>
                </div>
            </div>
        </transition>

    </AuthenticatedLayout>
</template>
