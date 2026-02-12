<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { BarChart, LineChart, PieChart, TreemapChart, GaugeChart } from 'echarts/charts';
import { GridComponent, TooltipComponent, LegendComponent, TitleComponent } from 'echarts/components';
import VChart from 'vue-echarts';
import { 
    Users,
    TrendingUp,
    TrendingDown,
    Target,
    Award,
    ChevronDown,
    ChevronUp,
    ChevronRight,
    Building2,
    MapPin,
    UserCheck,
    AlertTriangle,
    Star,
    BarChart3,
    PieChart as PieChartIcon,
    Activity,
    Zap,
    Crown,
    Medal,
    Trophy,
    Filter,
    Download,
    RefreshCw
} from 'lucide-vue-next';

use([CanvasRenderer, BarChart, LineChart, PieChart, TreemapChart, GaugeChart, GridComponent, TooltipComponent, LegendComponent, TitleComponent]);

// ============================================
// STATE
// ============================================

const selectedView = ref('overview');
const selectedVP = ref(null);
const selectedGeo = ref(null);
const selectedTL = ref(null);
const expandedVPs = ref({});
const expandedGeos = ref({});
const expandedTLs = ref({});

// ============================================
// HIERARCHICAL TEAM DATA
// ============================================

const teamHierarchy = ref([
    {
        id: 'vp1',
        name: 'Rajesh Malhotra',
        role: 'Vice President',
        region: 'North & East India',
        avatar: 'RM',
        target: 45.0,
        achieved: 38.5,
        pct: 85.6,
        teamSize: 156,
        status: 'On Track',
        trend: '+12%',
        children: [
            {
                id: 'geo1',
                name: 'Vikram Singh',
                role: 'Head GEO',
                region: 'North Zone',
                avatar: 'VS',
                target: 18.0,
                achieved: 16.8,
                pct: 93.3,
                teamSize: 48,
                status: 'Top Performer',
                trend: '+18%',
                children: [
                    {
                        id: 'tl1',
                        name: 'Suresh Kumar',
                        role: 'Team Leader',
                        region: 'Delhi NCR',
                        avatar: 'SK',
                        target: 6.0,
                        achieved: 5.8,
                        pct: 96.7,
                        teamSize: 12,
                        status: 'Top Performer',
                        trend: '+22%',
                        children: [
                            { id: 'ex1', name: 'Rahul Sharma', role: 'Sales Executive', target: 1.25, achieved: 1.18, pct: 94.4, status: 'On Track', schools: 45 },
                            { id: 'ex2', name: 'Priya Verma', role: 'Sales Executive', target: 1.25, achieved: 1.32, pct: 105.6, status: 'Top Performer', schools: 52 },
                            { id: 'ex3', name: 'Amit Gupta', role: 'Sales Executive', target: 1.25, achieved: 1.15, pct: 92.0, status: 'On Track', schools: 38 },
                            { id: 'ex4', name: 'Neha Singh', role: 'Sales Executive', target: 1.25, achieved: 0.98, pct: 78.4, status: 'At Risk', schools: 41 },
                            { id: 'ex5', name: 'Karan Mehta', role: 'Sales Executive', target: 1.00, achieved: 1.17, pct: 117.0, status: 'Top Performer', schools: 48 },
                        ]
                    },
                    {
                        id: 'tl2',
                        name: 'Meera Joshi',
                        role: 'Team Leader',
                        region: 'Haryana',
                        avatar: 'MJ',
                        target: 5.5,
                        achieved: 5.2,
                        pct: 94.5,
                        teamSize: 10,
                        status: 'On Track',
                        trend: '+15%',
                        children: [
                            { id: 'ex6', name: 'Rohit Kapoor', role: 'Sales Executive', target: 1.10, achieved: 1.08, pct: 98.2, status: 'On Track', schools: 35 },
                            { id: 'ex7', name: 'Anita Rao', role: 'Sales Executive', target: 1.10, achieved: 1.22, pct: 110.9, status: 'Top Performer', schools: 42 },
                            { id: 'ex8', name: 'Deepak Sharma', role: 'Sales Executive', target: 1.10, achieved: 0.95, pct: 86.4, status: 'At Risk', schools: 38 },
                        ]
                    },
                    {
                        id: 'tl3',
                        name: 'Arun Patel',
                        role: 'Team Leader',
                        region: 'Punjab',
                        avatar: 'AP',
                        target: 6.5,
                        achieved: 5.8,
                        pct: 89.2,
                        teamSize: 14,
                        status: 'On Track',
                        trend: '+8%',
                        children: [
                            { id: 'ex9', name: 'Simran Kaur', role: 'Sales Executive', target: 1.30, achieved: 1.25, pct: 96.2, status: 'On Track', schools: 40 },
                            { id: 'ex10', name: 'Harpreet Singh', role: 'Sales Executive', target: 1.30, achieved: 1.15, pct: 88.5, status: 'On Track', schools: 36 },
                        ]
                    }
                ]
            },
            {
                id: 'geo2',
                name: 'Subhash Bose',
                role: 'Head GEO',
                region: 'East Zone',
                avatar: 'SB',
                target: 12.0,
                achieved: 9.2,
                pct: 76.7,
                teamSize: 36,
                status: 'At Risk',
                trend: '-5%',
                children: [
                    {
                        id: 'tl4',
                        name: 'Rajiv Ghosh',
                        role: 'Team Leader',
                        region: 'West Bengal',
                        avatar: 'RG',
                        target: 6.0,
                        achieved: 4.8,
                        pct: 80.0,
                        teamSize: 11,
                        status: 'At Risk',
                        trend: '-8%',
                        children: [
                            { id: 'ex11', name: 'Sourav Das', role: 'Sales Executive', target: 1.20, achieved: 0.95, pct: 79.2, status: 'At Risk', schools: 32 },
                            { id: 'ex12', name: 'Moumita Sen', role: 'Sales Executive', target: 1.20, achieved: 1.05, pct: 87.5, status: 'On Track', schools: 38 },
                        ]
                    },
                    {
                        id: 'tl5',
                        name: 'Pradeep Mishra',
                        role: 'Team Leader',
                        region: 'Bihar',
                        avatar: 'PM',
                        target: 6.0,
                        achieved: 4.4,
                        pct: 73.3,
                        teamSize: 12,
                        status: 'Critical',
                        trend: '-12%',
                        children: [
                            { id: 'ex13', name: 'Ravi Kumar', role: 'Sales Executive', target: 1.00, achieved: 0.72, pct: 72.0, status: 'Critical', schools: 28 },
                            { id: 'ex14', name: 'Anjali Sinha', role: 'Sales Executive', target: 1.00, achieved: 0.88, pct: 88.0, status: 'On Track', schools: 34 },
                        ]
                    }
                ]
            },
            {
                id: 'geo3',
                name: 'Manoj Tiwari',
                role: 'Head GEO',
                region: 'UP & Uttarakhand',
                avatar: 'MT',
                target: 15.0,
                achieved: 12.5,
                pct: 83.3,
                teamSize: 72,
                status: 'On Track',
                trend: '+6%',
                children: [
                    {
                        id: 'tl6',
                        name: 'Vivek Dubey',
                        role: 'Team Leader',
                        region: 'Lucknow',
                        avatar: 'VD',
                        target: 7.5,
                        achieved: 6.8,
                        pct: 90.7,
                        teamSize: 15,
                        status: 'On Track',
                        trend: '+10%',
                        children: [
                            { id: 'ex15', name: 'Aditya Pandey', role: 'Sales Executive', target: 1.50, achieved: 1.42, pct: 94.7, status: 'On Track', schools: 45 },
                            { id: 'ex16', name: 'Shweta Mishra', role: 'Sales Executive', target: 1.50, achieved: 1.38, pct: 92.0, status: 'On Track', schools: 42 },
                        ]
                    }
                ]
            }
        ]
    },
    {
        id: 'vp2',
        name: 'Anitha Reddy',
        role: 'Vice President',
        region: 'South & West India',
        avatar: 'AR',
        target: 42.0,
        achieved: 36.8,
        pct: 87.6,
        teamSize: 142,
        status: 'On Track',
        trend: '+9%',
        children: [
            {
                id: 'geo4',
                name: 'Anitha Reddy',
                role: 'Head GEO',
                region: 'South Zone',
                avatar: 'AR',
                target: 16.0,
                achieved: 15.2,
                pct: 95.0,
                teamSize: 52,
                status: 'Top Performer',
                trend: '+14%',
                children: [
                    {
                        id: 'tl7',
                        name: 'Karthik Iyer',
                        role: 'Team Leader',
                        region: 'Chennai',
                        avatar: 'KI',
                        target: 5.5,
                        achieved: 5.6,
                        pct: 101.8,
                        teamSize: 11,
                        status: 'Top Performer',
                        trend: '+20%',
                        children: [
                            { id: 'ex17', name: 'Lakshmi Narayanan', role: 'Sales Executive', target: 1.10, achieved: 1.18, pct: 107.3, status: 'Top Performer', schools: 48 },
                            { id: 'ex18', name: 'Venkat Krishnan', role: 'Sales Executive', target: 1.10, achieved: 1.12, pct: 101.8, status: 'Top Performer', schools: 44 },
                        ]
                    },
                    {
                        id: 'tl8',
                        name: 'Priya Menon',
                        role: 'Team Leader',
                        region: 'Kerala',
                        avatar: 'PM',
                        target: 5.0,
                        achieved: 4.8,
                        pct: 96.0,
                        teamSize: 10,
                        status: 'On Track',
                        trend: '+11%',
                        children: [
                            { id: 'ex19', name: 'Arjun Nair', role: 'Sales Executive', target: 1.00, achieved: 0.98, pct: 98.0, status: 'On Track', schools: 38 },
                            { id: 'ex20', name: 'Divya Pillai', role: 'Sales Executive', target: 1.00, achieved: 1.05, pct: 105.0, status: 'Top Performer', schools: 42 },
                        ]
                    }
                ]
            },
            {
                id: 'geo5',
                name: 'Rajesh Gupta',
                role: 'Head GEO',
                region: 'West Zone',
                avatar: 'RG',
                target: 14.0,
                achieved: 11.2,
                pct: 80.0,
                teamSize: 44,
                status: 'At Risk',
                trend: '+2%',
                children: [
                    {
                        id: 'tl9',
                        name: 'Amit Deshmukh',
                        role: 'Team Leader',
                        region: 'Mumbai',
                        avatar: 'AD',
                        target: 7.0,
                        achieved: 5.8,
                        pct: 82.9,
                        teamSize: 14,
                        status: 'At Risk',
                        trend: '-3%',
                        children: [
                            { id: 'ex21', name: 'Rohan Patil', role: 'Sales Executive', target: 1.40, achieved: 1.15, pct: 82.1, status: 'At Risk', schools: 35 },
                            { id: 'ex22', name: 'Sneha Joshi', role: 'Sales Executive', target: 1.40, achieved: 1.28, pct: 91.4, status: 'On Track', schools: 40 },
                        ]
                    },
                    {
                        id: 'tl10',
                        name: 'Nilesh Shah',
                        role: 'Team Leader',
                        region: 'Gujarat',
                        avatar: 'NS',
                        target: 7.0,
                        achieved: 5.4,
                        pct: 77.1,
                        teamSize: 13,
                        status: 'At Risk',
                        trend: '-6%',
                        children: [
                            { id: 'ex23', name: 'Dhruv Patel', role: 'Sales Executive', target: 1.40, achieved: 1.08, pct: 77.1, status: 'At Risk', schools: 32 },
                            { id: 'ex24', name: 'Foram Shah', role: 'Sales Executive', target: 1.40, achieved: 1.12, pct: 80.0, status: 'At Risk', schools: 34 },
                        ]
                    }
                ]
            },
            {
                id: 'geo6',
                name: 'Prasad Kumar',
                role: 'Head GEO',
                region: 'Central Zone',
                avatar: 'PK',
                target: 12.0,
                achieved: 10.4,
                pct: 86.7,
                teamSize: 46,
                status: 'On Track',
                trend: '+7%',
                children: [
                    {
                        id: 'tl11',
                        name: 'Rakesh Jain',
                        role: 'Team Leader',
                        region: 'MP',
                        avatar: 'RJ',
                        target: 6.0,
                        achieved: 5.4,
                        pct: 90.0,
                        teamSize: 12,
                        status: 'On Track',
                        trend: '+8%',
                        children: [
                            { id: 'ex25', name: 'Manish Verma', role: 'Sales Executive', target: 1.20, achieved: 1.10, pct: 91.7, status: 'On Track', schools: 38 },
                            { id: 'ex26', name: 'Pooja Sharma', role: 'Sales Executive', target: 1.20, achieved: 1.08, pct: 90.0, status: 'On Track', schools: 36 },
                        ]
                    }
                ]
            }
        ]
    }
]);

// ============================================
// COMPUTED
// ============================================

const overallStats = computed(() => ({
    totalRevenue: 75.3,
    totalTarget: 87.0,
    achievement: 86.6,
    totalTeam: 298,
    topPerformers: 42,
    atRisk: 18,
    critical: 5
}));

// ============================================
// CHART OPTIONS
// ============================================

// VP Performance Comparison
const vpPerformanceOption = computed(() => ({
    tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
    legend: { data: ['Target', 'Achieved'], top: 5 },
    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
    xAxis: { type: 'category', data: teamHierarchy.value.map(vp => vp.name.split(' ')[0]) },
    yAxis: { type: 'value', name: '₹ Cr', axisLabel: { formatter: '{value}' } },
    series: [
        {
            name: 'Target',
            type: 'bar',
            barWidth: '35%',
            itemStyle: { color: '#e2e8f0', borderRadius: [4, 4, 0, 0] },
            data: teamHierarchy.value.map(vp => vp.target)
        },
        {
            name: 'Achieved',
            type: 'bar',
            barWidth: '35%',
            itemStyle: { 
                color: {
                    type: 'linear',
                    x: 0, y: 0, x2: 0, y2: 1,
                    colorStops: [
                        { offset: 0, color: '#F88313' },
                        { offset: 1, color: '#E6611D' }
                    ]
                },
                borderRadius: [4, 4, 0, 0]
            },
            data: teamHierarchy.value.map(vp => vp.achieved)
        }
    ]
}));

// Zone-wise Revenue Distribution
const zoneRevenueOption = computed(() => ({
    tooltip: { trigger: 'item', formatter: '{b}: ₹{c} Cr ({d}%)' },
    legend: { orient: 'vertical', right: 10, top: 'center' },
    series: [{
        type: 'pie',
        radius: ['45%', '70%'],
        center: ['35%', '50%'],
        avoidLabelOverlap: false,
        itemStyle: { borderRadius: 8, borderColor: '#fff', borderWidth: 2 },
        label: { show: false },
        emphasis: { label: { show: true, fontSize: 14, fontWeight: 'bold' } },
        data: [
            { value: 16.8, name: 'North', itemStyle: { color: '#3b82f6' } },
            { value: 9.2, name: 'East', itemStyle: { color: '#ef4444' } },
            { value: 12.5, name: 'UP/UK', itemStyle: { color: '#f59e0b' } },
            { value: 15.2, name: 'South', itemStyle: { color: '#10b981' } },
            { value: 11.2, name: 'West', itemStyle: { color: '#8b5cf6' } },
            { value: 10.4, name: 'Central', itemStyle: { color: '#06b6d4' } }
        ]
    }]
}));

// Monthly Trend
const monthlyTrendOption = computed(() => ({
    tooltip: { trigger: 'axis' },
    legend: { data: ['Revenue', 'Target', 'Last Year'], top: 5 },
    grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
    xAxis: { type: 'category', data: ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'] },
    yAxis: { type: 'value', name: '₹ Cr' },
    series: [
        {
            name: 'Revenue',
            type: 'line',
            smooth: true,
            lineStyle: { width: 3, color: '#F88313' },
            itemStyle: { color: '#F88313' },
            areaStyle: {
                color: {
                    type: 'linear',
                    x: 0, y: 0, x2: 0, y2: 1,
                    colorStops: [
                        { offset: 0, color: 'rgba(248, 131, 19, 0.3)' },
                        { offset: 1, color: 'rgba(248, 131, 19, 0.05)' }
                    ]
                }
            },
            data: [5.2, 6.1, 6.8, 7.2, 7.8, 8.5, 8.2, 8.8, 9.2, 7.5]
        },
        {
            name: 'Target',
            type: 'line',
            smooth: true,
            lineStyle: { width: 2, type: 'dashed', color: '#94a3b8' },
            itemStyle: { color: '#94a3b8' },
            data: [6.0, 6.5, 7.0, 7.5, 8.0, 8.5, 9.0, 9.5, 10.0, 10.0]
        },
        {
            name: 'Last Year',
            type: 'line',
            smooth: true,
            lineStyle: { width: 2, color: '#3b82f6' },
            itemStyle: { color: '#3b82f6' },
            data: [4.5, 5.2, 5.8, 6.2, 6.5, 7.0, 7.2, 7.5, 7.8, 6.2]
        }
    ]
}));

// Achievement Distribution Gauge
const achievementGaugeOption = computed(() => ({
    series: [{
        type: 'gauge',
        startAngle: 200,
        endAngle: -20,
        min: 0,
        max: 100,
        splitNumber: 10,
        itemStyle: {
            color: {
                type: 'linear',
                x: 0, y: 1, x2: 1, y2: 1,
                colorStops: [
                    { offset: 0, color: '#ef4444' },
                    { offset: 0.5, color: '#f59e0b' },
                    { offset: 1, color: '#10b981' }
                ]
            }
        },
        progress: { show: true, width: 20 },
        pointer: { show: false },
        axisLine: { lineStyle: { width: 20, color: [[1, '#e2e8f0']] } },
        axisTick: { show: false },
        splitLine: { show: false },
        axisLabel: { show: false },
        anchor: { show: false },
        title: { show: false },
        detail: {
            valueAnimation: true,
            fontSize: 28,
            fontWeight: 'bold',
            formatter: '{value}%',
            color: '#334155',
            offsetCenter: [0, '0%']
        },
        data: [{ value: 86.6 }]
    }]
}));

// Team Performance Treemap
const teamTreemapOption = computed(() => ({
    tooltip: { formatter: '{b}: ₹{c} Cr' },
    series: [{
        type: 'treemap',
        roam: false,
        nodeClick: false,
        breadcrumb: { show: false },
        label: { show: true, formatter: '{b}\n₹{c} Cr', fontSize: 11, fontWeight: 'bold' },
        itemStyle: { borderColor: '#fff', borderWidth: 2, gapWidth: 2 },
        levels: [{
            itemStyle: { borderColor: '#fff', borderWidth: 3, gapWidth: 3 }
        }],
        data: [
            { name: 'North', value: 16.8, itemStyle: { color: '#3b82f6' } },
            { name: 'South', value: 15.2, itemStyle: { color: '#10b981' } },
            { name: 'UP/UK', value: 12.5, itemStyle: { color: '#f59e0b' } },
            { name: 'West', value: 11.2, itemStyle: { color: '#8b5cf6' } },
            { name: 'Central', value: 10.4, itemStyle: { color: '#06b6d4' } },
            { name: 'East', value: 9.2, itemStyle: { color: '#ef4444' } }
        ]
    }]
}));

// Top Performers Bar Chart
const topPerformersOption = computed(() => ({
    tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
    grid: { left: '3%', right: '10%', bottom: '3%', containLabel: true },
    xAxis: { type: 'value', max: 120, axisLabel: { formatter: '{value}%' } },
    yAxis: { 
        type: 'category', 
        data: ['Karan M.', 'Priya V.', 'Anita R.', 'Lakshmi N.', 'Divya P.'],
        axisLabel: { fontSize: 11 }
    },
    series: [{
        type: 'bar',
        barWidth: '60%',
        label: { show: true, position: 'right', formatter: '{c}%', fontWeight: 'bold' },
        itemStyle: { 
            color: {
                type: 'linear',
                x: 0, y: 0, x2: 1, y2: 0,
                colorStops: [
                    { offset: 0, color: '#10b981' },
                    { offset: 1, color: '#059669' }
                ]
            },
            borderRadius: [0, 4, 4, 0]
        },
        data: [117.0, 105.6, 110.9, 107.3, 105.0]
    }]
}));

// At Risk Executives
const atRiskOption = computed(() => ({
    tooltip: { trigger: 'axis', axisPointer: { type: 'shadow' } },
    grid: { left: '3%', right: '10%', bottom: '3%', containLabel: true },
    xAxis: { type: 'value', max: 100, axisLabel: { formatter: '{value}%' } },
    yAxis: { 
        type: 'category', 
        data: ['Ravi K.', 'Dhruv P.', 'Neha S.', 'Sourav D.', 'Foram S.'],
        axisLabel: { fontSize: 11 }
    },
    series: [{
        type: 'bar',
        barWidth: '60%',
        label: { show: true, position: 'right', formatter: '{c}%', fontWeight: 'bold' },
        itemStyle: { 
            color: {
                type: 'linear',
                x: 0, y: 0, x2: 1, y2: 0,
                colorStops: [
                    { offset: 0, color: '#ef4444' },
                    { offset: 1, color: '#dc2626' }
                ]
            },
            borderRadius: [0, 4, 4, 0]
        },
        data: [72.0, 77.1, 78.4, 79.2, 80.0]
    }]
}));

// ============================================
// FUNCTIONS
// ============================================

const toggleVP = (vpId) => {
    expandedVPs.value[vpId] = !expandedVPs.value[vpId];
};

const toggleGeo = (geoId) => {
    expandedGeos.value[geoId] = !expandedGeos.value[geoId];
};

const toggleTL = (tlId) => {
    expandedTLs.value[tlId] = !expandedTLs.value[tlId];
};

const getStatusColor = (status) => {
    switch(status) {
        case 'Top Performer': return 'bg-emerald-100 text-emerald-700 border-emerald-200';
        case 'On Track': return 'bg-blue-100 text-blue-700 border-blue-200';
        case 'At Risk': return 'bg-amber-100 text-amber-700 border-amber-200';
        case 'Critical': return 'bg-red-100 text-red-700 border-red-200';
        default: return 'bg-slate-100 text-slate-700 border-slate-200';
    }
};

const getProgressColor = (pct) => {
    if (pct >= 95) return 'bg-emerald-500';
    if (pct >= 85) return 'bg-blue-500';
    if (pct >= 75) return 'bg-amber-500';
    return 'bg-red-500';
};

const getTrendColor = (trend) => {
    return trend.startsWith('+') ? 'text-emerald-600' : 'text-red-600';
};

const formatRupee = (val) => {
    return `<span class="rupee-symbol">₹</span> ${val}`;
};

</script>

<template>
    <Head title="Team Overview" />

    <AuthenticatedLayout>
        <div class="max-w-full mx-auto space-y-6">

            <!-- PAGE HEADER -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <Users class="w-8 h-8 text-orange-600" />
                        <h1 class="text-3xl font-bold text-slate-900">Team Overview</h1>
                    </div>
                    <p class="text-slate-600">Comprehensive view of organizational performance hierarchy</p>
                </div>
                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 flex items-center gap-2 shadow-sm">
                        <Filter class="w-4 h-4" /> Filter
                    </button>
                    <button class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 flex items-center gap-2 shadow-sm">
                        <Download class="w-4 h-4" /> Export
                    </button>
                    <button class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg text-sm font-bold text-white hover:from-orange-600 hover:to-orange-700 flex items-center gap-2 shadow-sm">
                        <RefreshCw class="w-4 h-4" /> Refresh
                    </button>
                </div>
            </div>

            <!-- OVERALL STATS -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-4 text-white shadow-lg">
                    <div class="flex items-center gap-2 mb-2 opacity-80">
                        <Target class="w-4 h-4" />
                        <span class="text-xs font-bold uppercase">Total Revenue</span>
                    </div>
                    <p class="text-2xl font-bold">₹ {{ overallStats.totalRevenue }} Cr</p>
                    <p class="text-xs opacity-80 mt-1">of ₹ {{ overallStats.totalTarget }} Cr target</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-2 text-blue-600">
                        <Activity class="w-4 h-4" />
                        <span class="text-xs font-bold uppercase text-slate-500">Achievement</span>
                    </div>
                    <p class="text-2xl font-bold text-slate-800">{{ overallStats.achievement }}%</p>
                    <p class="text-xs text-emerald-600 font-bold mt-1">+8.2% vs LY</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-2 text-slate-600">
                        <Users class="w-4 h-4" />
                        <span class="text-xs font-bold uppercase text-slate-500">Total Team</span>
                    </div>
                    <p class="text-2xl font-bold text-slate-800">{{ overallStats.totalTeam }}</p>
                    <p class="text-xs text-slate-500 mt-1">2 VPs â€¢ 6 GEOs â€¢ 11 TLs</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-2 text-emerald-600">
                        <Trophy class="w-4 h-4" />
                        <span class="text-xs font-bold uppercase text-slate-500">Top Performers</span>
                    </div>
                    <p class="text-2xl font-bold text-emerald-600">{{ overallStats.topPerformers }}</p>
                    <p class="text-xs text-slate-500 mt-1">Above 100% target</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-2 text-blue-600">
                        <Medal class="w-4 h-4" />
                        <span class="text-xs font-bold uppercase text-slate-500">On Track</span>
                    </div>
                    <p class="text-2xl font-bold text-blue-600">186</p>
                    <p class="text-xs text-slate-500 mt-1">85-100% target</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-2 text-amber-600">
                        <AlertTriangle class="w-4 h-4" />
                        <span class="text-xs font-bold uppercase text-slate-500">At Risk</span>
                    </div>
                    <p class="text-2xl font-bold text-amber-600">{{ overallStats.atRisk }}</p>
                    <p class="text-xs text-slate-500 mt-1">75-85% target</p>
                </div>
                <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-2 text-red-600">
                        <Zap class="w-4 h-4" />
                        <span class="text-xs font-bold uppercase text-slate-500">Critical</span>
                    </div>
                    <p class="text-2xl font-bold text-red-600">{{ overallStats.critical }}</p>
                    <p class="text-xs text-slate-500 mt-1">Below 75% target</p>
                </div>
            </div>

            <!-- CHARTS ROW 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- VP Performance -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center gap-2">
                        <BarChart3 class="w-4 h-4 text-orange-500" /> VP Performance Comparison
                    </h3>
                    <div class="h-64">
                        <v-chart class="h-full w-full" :option="vpPerformanceOption" autoresize />
                    </div>
                </div>

                <!-- Zone Revenue Pie -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center gap-2">
                        <PieChartIcon class="w-4 h-4 text-blue-500" /> Zone-wise Revenue Distribution
                    </h3>
                    <div class="h-64">
                        <v-chart class="h-full w-full" :option="zoneRevenueOption" autoresize />
                    </div>
                </div>

                <!-- Achievement Gauge -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center gap-2">
                        <Target class="w-4 h-4 text-emerald-500" /> Overall Achievement
                    </h3>
                    <div class="h-64 flex items-center justify-center">
                        <v-chart class="h-full w-full" :option="achievementGaugeOption" autoresize />
                    </div>
                </div>
            </div>

            <!-- CHARTS ROW 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Monthly Trend -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center gap-2">
                        <TrendingUp class="w-4 h-4 text-orange-500" /> Monthly Revenue Trend (FY 2025-26)
                    </h3>
                    <div class="h-72">
                        <v-chart class="h-full w-full" :option="monthlyTrendOption" autoresize />
                    </div>
                </div>

                <!-- Treemap -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center gap-2">
                        <Building2 class="w-4 h-4 text-blue-500" /> Revenue Contribution by Zone
                    </h3>
                    <div class="h-72">
                        <v-chart class="h-full w-full" :option="teamTreemapOption" autoresize />
                    </div>
                </div>
            </div>

            <!-- CHARTS ROW 3: Top & Bottom Performers -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Performers -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center gap-2">
                        <Trophy class="w-4 h-4 text-emerald-500" /> Top 5 Performers (Executives)
                    </h3>
                    <div class="h-56">
                        <v-chart class="h-full w-full" :option="topPerformersOption" autoresize />
                    </div>
                </div>

                <!-- At Risk -->
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <h3 class="font-bold text-slate-800 text-sm mb-4 flex items-center gap-2">
                        <AlertTriangle class="w-4 h-4 text-red-500" /> Bottom 5 Performers (Need Attention)
                    </h3>
                    <div class="h-56">
                        <v-chart class="h-full w-full" :option="atRiskOption" autoresize />
                    </div>
                </div>
            </div>

            <!-- HIERARCHICAL TEAM VIEW -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-4 flex items-center justify-between">
                    <h3 class="font-bold text-white text-sm uppercase tracking-wider flex items-center gap-2">
                        <Users class="w-5 h-5 text-orange-400" /> Organizational Hierarchy & Performance
                    </h3>
                    <div class="flex gap-2 text-xs">
                        <span class="px-2 py-1 bg-emerald-500/20 text-emerald-300 rounded">Top Performer</span>
                        <span class="px-2 py-1 bg-blue-500/20 text-blue-300 rounded">On Track</span>
                        <span class="px-2 py-1 bg-amber-500/20 text-amber-300 rounded">At Risk</span>
                        <span class="px-2 py-1 bg-red-500/20 text-red-300 rounded">Critical</span>
                    </div>
                </div>

                <div class="divide-y divide-slate-100">
                    <!-- VP Level -->
                    <div v-for="vp in teamHierarchy" :key="vp.id">
                        <div 
                            @click="toggleVP(vp.id)"
                            class="px-6 py-4 flex items-center justify-between hover:bg-orange-50/50 cursor-pointer transition-colors border-l-4 border-orange-500">
                            <div class="flex items-center gap-4">
                                <button class="p-1 hover:bg-slate-200 rounded text-slate-500">
                                    <component :is="expandedVPs[vp.id] ? ChevronDown : ChevronRight" class="w-5 h-5" />
                                </button>
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                    {{ vp.avatar }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <Crown class="w-4 h-4 text-orange-500" />
                                        <p class="font-bold text-slate-900 text-lg">{{ vp.name }}</p>
                                    </div>
                                    <p class="text-sm text-slate-500">{{ vp.role }} â€¢ {{ vp.region }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-8">
                                <div class="text-right">
                                    <p class="text-xs text-slate-500 uppercase font-bold">Target</p>
                                    <p class="font-bold text-slate-800">₹ {{ vp.target }} Cr</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-500 uppercase font-bold">Achieved</p>
                                    <p class="font-bold text-orange-600">₹ {{ vp.achieved }} Cr</p>
                                </div>
                                <div class="w-32">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="font-bold">{{ vp.pct }}%</span>
                                        <span :class="getTrendColor(vp.trend)" class="font-bold">{{ vp.trend }}</span>
                                    </div>
                                    <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                                        <div :class="getProgressColor(vp.pct)" class="h-full rounded-full transition-all" :style="{ width: Math.min(vp.pct, 100) + '%' }"></div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-500 uppercase font-bold">Team</p>
                                    <p class="font-bold text-slate-800">{{ vp.teamSize }}</p>
                                </div>
                                <span :class="['px-3 py-1 rounded-full text-xs font-bold border', getStatusColor(vp.status)]">
                                    {{ vp.status }}
                                </span>
                            </div>
                        </div>

                        <!-- GEO Level -->
                        <div v-if="expandedVPs[vp.id]" class="bg-slate-50/50">
                            <div v-for="geo in vp.children" :key="geo.id">
                                <div 
                                    @click.stop="toggleGeo(geo.id)"
                                    class="px-6 py-3 pl-16 flex items-center justify-between hover:bg-blue-50/50 cursor-pointer transition-colors border-l-4 border-blue-400">
                                    <div class="flex items-center gap-4">
                                        <button class="p-1 hover:bg-slate-200 rounded text-slate-500">
                                            <component :is="expandedGeos[geo.id] ? ChevronDown : ChevronRight" class="w-4 h-4" />
                                        </button>
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm shadow">
                                            {{ geo.avatar }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <MapPin class="w-3 h-3 text-blue-500" />
                                                <p class="font-bold text-slate-800">{{ geo.name }}</p>
                                            </div>
                                            <p class="text-xs text-slate-500">{{ geo.role }} â€¢ {{ geo.region }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-6">
                                        <div class="text-right">
                                            <p class="text-xs text-slate-500">Target</p>
                                            <p class="font-bold text-slate-700 text-sm">₹ {{ geo.target }} Cr</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs text-slate-500">Achieved</p>
                                            <p class="font-bold text-blue-600 text-sm">₹ {{ geo.achieved }} Cr</p>
                                        </div>
                                        <div class="w-24">
                                            <div class="flex justify-between text-xs mb-1">
                                                <span class="font-bold">{{ geo.pct }}%</span>
                                                <span :class="getTrendColor(geo.trend)" class="font-bold text-[10px]">{{ geo.trend }}</span>
                                            </div>
                                            <div class="h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                                <div :class="getProgressColor(geo.pct)" class="h-full rounded-full" :style="{ width: Math.min(geo.pct, 100) + '%' }"></div>
                                            </div>
                                        </div>
                                        <span :class="['px-2 py-0.5 rounded-full text-[10px] font-bold border', getStatusColor(geo.status)]">
                                            {{ geo.status }}
                                        </span>
                                    </div>
                                </div>

                                <!-- TL Level -->
                                <div v-if="expandedGeos[geo.id]" class="bg-white/50">
                                    <div v-for="tl in geo.children" :key="tl.id">
                                        <div 
                                            @click.stop="toggleTL(tl.id)"
                                            class="px-6 py-2 pl-28 flex items-center justify-between hover:bg-emerald-50/50 cursor-pointer transition-colors border-l-4 border-emerald-400">
                                            <div class="flex items-center gap-3">
                                                <button class="p-1 hover:bg-slate-200 rounded text-slate-500">
                                                    <component :is="expandedTLs[tl.id] ? ChevronDown : ChevronRight" class="w-3 h-3" />
                                                </button>
                                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-bold text-xs shadow">
                                                    {{ tl.avatar }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-slate-700 text-sm">{{ tl.name }}</p>
                                                    <p class="text-[10px] text-slate-500">{{ tl.role }} â€¢ {{ tl.region }} â€¢ {{ tl.teamSize }} members</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-5">
                                                <div class="text-right">
                                                    <p class="font-bold text-slate-600 text-xs">₹ {{ tl.target }} Cr</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="font-bold text-emerald-600 text-xs">₹ {{ tl.achieved }} Cr</p>
                                                </div>
                                                <div class="w-20">
                                                    <div class="h-1 bg-slate-200 rounded-full overflow-hidden">
                                                        <div :class="getProgressColor(tl.pct)" class="h-full rounded-full" :style="{ width: Math.min(tl.pct, 100) + '%' }"></div>
                                                    </div>
                                                    <p class="text-[10px] font-bold text-center mt-0.5">{{ tl.pct }}%</p>
                                                </div>
                                                <span :class="['px-2 py-0.5 rounded text-[10px] font-bold border', getStatusColor(tl.status)]">
                                                    {{ tl.status }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Executive Level -->
                                        <div v-if="expandedTLs[tl.id]" class="bg-slate-50/80">
                                            <div v-for="exec in tl.children" :key="exec.id" 
                                                 class="px-6 py-2 pl-40 flex items-center justify-between hover:bg-slate-100 transition-colors border-l-4 border-slate-300">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                                                    <div>
                                                        <p class="font-medium text-slate-700 text-xs">{{ exec.name }}</p>
                                                        <p class="text-[10px] text-slate-400">{{ exec.schools }} schools assigned</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-4">
                                                    <span class="text-xs text-slate-500">₹ {{ exec.target }} Cr</span>
                                                    <span class="text-xs font-bold text-slate-700">₹ {{ exec.achieved }} Cr</span>
                                                    <div class="w-16">
                                                        <div class="h-1 bg-slate-200 rounded-full overflow-hidden">
                                                            <div :class="getProgressColor(exec.pct)" class="h-full rounded-full" :style="{ width: Math.min(exec.pct, 100) + '%' }"></div>
                                                        </div>
                                                    </div>
                                                    <span class="text-xs font-bold" :class="exec.pct >= 100 ? 'text-emerald-600' : exec.pct >= 85 ? 'text-blue-600' : exec.pct >= 75 ? 'text-amber-600' : 'text-red-600'">
                                                        {{ exec.pct }}%
                                                    </span>
                                                    <span :class="['px-1.5 py-0.5 rounded text-[9px] font-bold', getStatusColor(exec.status)]">
                                                        {{ exec.status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.rupee-symbol {
    font-family: 'Georgia', serif;
}
</style>
