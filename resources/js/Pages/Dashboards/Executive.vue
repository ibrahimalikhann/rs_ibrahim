<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { 
    Users, 
    BookOpen, 
    ShoppingCart, 
    RotateCcw, 
    TrendingUp, 
    MapPin, 
    FileText, 
    ClipboardList,
    CheckSquare,
    Check,
    ArrowRight,
    ChevronRight,
    CircleDollarSign,
    Box,
    Percent,
    ArrowUpRight,
    School,
    Activity
} from 'lucide-vue-next';

// ----------------------------------------------------------------------
// DATA & STATE
// ----------------------------------------------------------------------

const goalData = {
    fyTarget: '₹ 12.5 Cr', // Compressed for cleaner look
    achievedPercent: 62.4,
    balance: '₹ 4.70 Cr'
};

const insights = [
    { 
        id: 1, 
        text: 'You need to visit 3 more schools today to meet weekly target.', 
        icon: MapPin, 
        type: 'warning', 
        action: 'View Map' 
    },
    { 
        id: 2, 
        text: '2 orders from St. Mary’s School are pending corporate approval.', 
        icon: FileText, 
        type: 'alert', 
        action: 'View Orders' 
    },
    { 
        id: 3, 
        text: 'Survey pending in 5 assigned schools (North Zone).', 
        icon: ClipboardList, 
        type: 'info', 
        action: null 
    },
];

const tasks = [
    { id: 1, title: 'Visit St. Xavier’s High School', subtitle: 'Meet Principal regarding math series', time: '10:00 AM', completed: false },
    { id: 2, title: 'Call Mr. Sharma (Distributor)', subtitle: 'Follow up on pending payment', time: '11:30 AM', completed: false },
    { id: 3, title: 'Complete Survey for PPS Karnal', subtitle: 'Upload photos of library infrastructure', time: '02:00 PM', completed: false },
    { id: 4, title: 'Approve Order #ORD-2024-89', subtitle: '2,500 books - Science Stream', time: '04:00 PM', completed: true },
];

const pipeline = [
    { stage: 'Assigned', count: 45, status: 'past' },
    { stage: 'Surveyed', count: 32, status: 'past' },
    { stage: 'Proposal', count: 18, status: 'current' },
    { stage: 'Order', count: 12, status: 'future' },
    { stage: 'Approved', count: 8, status: 'future' },
];
</script>

<template>
    <Head title="Executive Dashboard" />

    <AuthenticatedLayout>
        <div class="space-y-8">
            
            <!-- 1) TOP HERO SECTION (Refined) -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-orange-600 to-orange-500 p-8 text-white shadow-lg">
                <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 transform"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-widest text-orange-100 opacity-90 mb-1">FY 2024-25 Target</p>
                        <div class="flex items-baseline gap-3">
                            <h2 class="text-4xl font-bold font-display">{{ goalData.fyTarget }}</h2>
                            <span class="rounded-full bg-white/20 px-3 py-1 text-sm font-bold backdrop-blur-sm">
                                62.4% Achieved
                            </span>
                        </div>
                    </div>

                    <!-- Simplified Progress -->
                    <div class="w-full md:w-1/2">
                        <div class="flex justify-between text-xs font-bold text-orange-100 uppercase tracking-widest mb-2">
                            <span>Progress</span>
                            <span>Balance: {{ goalData.balance }}</span>
                        </div>
                        <div class="h-3 w-full overflow-hidden rounded-full bg-black/20">
                            <div class="h-full rounded-full bg-white transition-all duration-1000 ease-out" style="width: 62.4%"></div>
                        </div>
                        <p class="mt-2 text-xs font-medium text-orange-50 flex items-center">
                            <TrendingUp class="w-3 h-3 mr-1" /> On track to exceed annual targets
                        </p>
                    </div>
                </div>
            </div>

            <!-- LAYOUT SPLIT: LEFT CONTENT (KPIs + Actions) | RIGHT PANEL (Insights) -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
                
                <!-- LEFT MAIN COLUMN -->
                <div class="lg:col-span-3 space-y-8">
                    
                    <!-- 2) OPERATIONAL BREAKDOWN (MANDATORY NEW STYLE) -->
                    <div>
                        <div class="flex items-center gap-4 mb-5">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Operational Breakdown</h3>
                            <div class="h-px flex-1 bg-slate-200 dark:bg-slate-700"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            
                            <!-- ROW 1: DARK CARDS -->
                            <!-- QTY TARGET -->
                            <div class="rounded-2xl bg-[#0B1120] p-6 text-white shadow-lg relative overflow-hidden group">
                                <!-- Glow Effect -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
                                
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-2 rounded-lg bg-blue-500/20 text-blue-400">
                                        <Box class="w-5 h-5" />
                                    </div>
                                    <div class="h-8 w-8 rounded-full border-2 border-blue-500/30 border-t-blue-500 animate-spin-slow"></div>
                                </div>
                                
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Qty Target</p>
                                <div class="flex items-baseline gap-1 mb-6">
                                    <span class="text-3xl font-bold">8.5k</span>
                                    <span class="text-sm text-slate-500 font-medium">/ 12.5k</span>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-medium text-slate-400">
                                        <span>Completion</span>
                                        <span>68%</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-700/50 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-blue-600 to-blue-400 w-[68%] rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- REVENUE -->
                            <div class="rounded-2xl bg-[#0B1120] p-6 text-white shadow-lg relative overflow-hidden group">
                                <!-- Glow Effect -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
                                
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-2 rounded-lg bg-purple-500/20 text-purple-400">
                                        <CircleDollarSign class="w-5 h-5" />
                                    </div>
                                    <div class="h-8 w-8 rounded-full border-2 border-purple-500/30 border-r-purple-500 animate-spin-slow"></div>
                                </div>
                                
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Revenue</p>
                                <div class="flex items-baseline gap-1 mb-6">
                                    <span class="text-3xl font-bold">₹18.0L</span>
                                    <span class="text-sm text-slate-500 font-medium">/ 25.0L</span>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-medium text-slate-400">
                                        <span>Collected</span>
                                        <span>72%</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-700/50 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-purple-600 to-purple-400 w-[72%] rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- ROW 2: LIGHT CARDS -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
                            
                            <!-- School Base -->
                            <div class="md:col-span-1 rounded-2xl bg-white dark:bg-slate-800 p-5 shadow-sm border border-slate-100 dark:border-slate-700">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">School Base</p>
                                        <h4 class="font-bold text-slate-800 dark:text-white">Coverage Status</h4>
                                    </div>
                                    <School class="w-5 h-5 text-emerald-500" />
                                </div>

                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">85 Active</span>
                                    <span class="text-xs font-bold text-slate-500">71%</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-700 rounded-full mb-4">
                                    <div class="h-full bg-emerald-500 rounded-full w-[71%]"></div>
                                </div>

                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-500">35 Pending</span>
                                    <span class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold">Needs Action</span>
                                </div>
                            </div>

                            <!-- Visit Analysis -->
                            <div class="md:col-span-2 rounded-2xl bg-white dark:bg-slate-800 p-5 shadow-sm border border-slate-100 dark:border-slate-700">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Field Activity</p>
                                        <h4 class="font-bold text-slate-800 dark:text-white">Visit Analysis</h4>
                                    </div>
                                    <div class="p-1.5 bg-blue-50 text-blue-600 rounded">
                                        <MapPin class="w-4 h-4" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="rounded-xl bg-blue-50/50 dark:bg-slate-700/30 p-3 text-center border border-blue-100 dark:border-slate-600">
                                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">15</div>
                                        <div class="text-[10px] font-bold uppercase text-blue-900/60 dark:text-blue-200/60">Senior Visits</div>
                                    </div>
                                    <div class="rounded-xl bg-indigo-50/50 dark:bg-slate-700/30 p-3 text-center border border-indigo-100 dark:border-slate-600">
                                        <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">45</div>
                                        <div class="text-[10px] font-bold uppercase text-indigo-900/60 dark:text-indigo-200/60">General Visits</div>
                                    </div>
                                </div>
                                <p class="text-center text-[10px] text-slate-400 mt-2">Total 60 Visits this month</p>
                            </div>
                        </div>

                         <!-- ROW 3: METRICS -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-5">
                            <div class="rounded-2xl bg-white dark:bg-slate-800 p-5 shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <div class="p-1 bg-purple-100 rounded text-purple-600">
                                                <Box class="w-3.5 h-3.5" />
                                            </div>
                                            <span class="text-xs font-bold uppercase text-slate-400">Samples</span>
                                        </div>
                                        <span class="text-3xl font-bold text-slate-800 dark:text-white">320</span>
                                        <span class="text-xs text-slate-500 ml-1">Given</span>
                                    </div>
                                    <span class="text-[10px] font-bold bg-green-100 text-green-700 px-1.5 py-0.5 rounded">+14% YoY</span>
                                </div>
                                <p class="text-xs text-slate-400 mt-2 font-medium">Last Year: 280</p>
                            </div>

                            <div class="rounded-2xl bg-white dark:bg-slate-800 p-5 shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <div class="p-1 bg-orange-100 rounded text-orange-600">
                                                <Percent class="w-3.5 h-3.5" />
                                            </div>
                                            <span class="text-xs font-bold uppercase text-slate-400">% Discount</span>
                                        </div>
                                        <span class="text-3xl font-bold text-slate-800 dark:text-white">18.5%</span>
                                    </div>
                                    <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded">Avg</span>
                                </div>
                                <p class="text-xs text-emerald-600 mt-2 font-bold">20.1% (Improved)</p>
                            </div>

                            <div class="rounded-2xl bg-white dark:bg-slate-800 p-5 shadow-sm border border-slate-100 dark:border-slate-700">
                                <div class="flex items-center gap-2 mb-3">
                                    <RotateCcw class="w-4 h-4 text-red-500" />
                                    <span class="text-xs font-bold uppercase text-slate-400">Sales Returns (LY)</span>
                                </div>
                                <div class="flex items-end gap-4">
                                     <div>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase">Volume</p>
                                        <p class="text-xl font-bold text-slate-800 dark:text-white">1.2k</p>
                                     </div>
                                     <div class="h-8 w-px bg-slate-100"></div>
                                     <div>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase">Value</p>
                                        <p class="text-xl font-bold text-red-500">₹1.5L</p>
                                     </div>
                                </div>
                                <p class="text-xs font-bold text-brand-600 mt-3 cursor-pointer hover:underline">View Breakdown →</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3) TODAY'S ACTIONS -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                         <!-- Tasks -->
                        <div class="rounded-2xl border border-slate-100 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
                            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 dark:border-slate-700">
                                <h3 class="flex items-center text-md font-bold text-slate-800 dark:text-white">
                                    <CheckSquare class="mr-2 h-5 w-5 text-orange-500" />
                                    Today's Actions
                                </h3>
                                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">4 Pending</span>
                            </div>
                            
                            <div class="divide-y divide-slate-50 dark:divide-slate-700/50">
                                <div v-for="task in tasks" :key="task.id" 
                                    class="group flex cursor-pointer items-start p-4 hover:bg-slate-50 transition-colors">
                                    
                                    <div class="mt-0.5 relative mr-3 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded border border-slate-300 transition-colors group-hover:border-orange-500">
                                        <Check v-if="task.completed" class="h-3.5 w-3.5 text-orange-600" />
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <p :class="['text-sm font-semibold', task.completed ? 'text-slate-400 line-through' : 'text-slate-800 dark:text-white']">
                                            {{ task.title }}
                                        </p>
                                        <p class="truncate text-xs text-slate-500 mt-0.5">{{ task.subtitle }}</p>
                                    </div>
                                    <span class="text-[10px] font-bold bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded ml-2">{{ task.time }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Pipeline Snapshot -->
                        <div class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800 flex flex-col justify-center">
                            <div class="mb-6 flex items-center justify-between">
                                <h3 class="text-md font-bold text-slate-800 dark:text-white">Pipeline View</h3>
                                <span class="text-xs font-bold text-blue-600 cursor-pointer hover:underline">Full Details</span>
                            </div>

                            <div class="relative px-2">
                                <div class="absolute top-3.5 left-4 right-4 h-0.5 bg-slate-100 dark:bg-slate-700"></div>
                                <div class="relative flex justify-between">
                                    <div v-for="(step, i) in pipeline" :key="i" class="flex flex-col items-center group cursor-pointer">
                                        <div :class="[
                                            'relative z-10 flex h-7 w-7 items-center justify-center rounded-full border-2 text-[10px] font-bold transition-all',
                                            step.status === 'past' ? 'border-orange-500 bg-orange-500 text-white' :
                                            step.status === 'current' ? 'h-9 w-9 -mt-1 border-orange-600 bg-white text-orange-600 shadow-lg ring-2 ring-orange-100' :
                                            'border-slate-200 bg-slate-50 text-slate-300'
                                        ]">
                                            <Check v-if="step.status === 'past'" class="h-3.5 w-3.5" />
                                            <span v-else>{{ step.count }}</span>
                                        </div>
                                        <span :class="[
                                            'mt-3 text-[9px] font-bold uppercase tracking-widest',
                                            step.status === 'current' ? 'text-orange-600' : 'text-slate-400'
                                        ]">
                                            {{ step.stage }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT PANEL: INSIGHTS (Mandatory) -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <h3 class="text-base font-bold text-indigo-900 dark:text-indigo-200 mb-4 flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                            My Insights
                        </h3>

                        <div class="space-y-4">
                            <div v-for="insight in insights" :key="insight.id" 
                                class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm transition-all hover:shadow-md hover:border-indigo-100 dark:bg-slate-800 dark:border-slate-700">
                                
                                <div class="flex gap-3">
                                    <div :class="[
                                        'mt-0.5 p-1.5 rounded-lg flex-shrink-0 h-fit',
                                        insight.type === 'warning' ? 'bg-amber-50 text-amber-500' : 
                                        insight.type === 'alert' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-500'
                                    ]">
                                        <component :is="insight.icon" class="h-4 w-4" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium leading-snug text-slate-700 dark:text-slate-300">
                                            {{ insight.text }}
                                        </p>
                                        <button v-if="insight.action" class="mt-2 text-xs font-bold text-slate-500 hover:text-indigo-600 uppercase flex items-center gap-1">
                                            {{ insight.action }} <ChevronRight class="w-3 h-3" />
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- "Updated Just Now" -->
                            <div class="text-center py-2">
                                <span class="text-[10px] font-medium text-slate-400 bg-slate-100 px-3 py-1 rounded-full">Updates every 4 hours</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Simple rotate animation for the operational spinners */
.animate-spin-slow {
    animation: spin 3s linear infinite;
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>
