<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { 
    MapPin, Calendar, CheckCircle, Percent, CalendarDays, Star, Wallet, 
    User, Briefcase, TrendingUp, FileText, Download, Upload, Shield, Phone, Mail, Home, Edit3, 
    Clock, AlertTriangle, FileCheck
} from 'lucide-vue-next';

// Tab State
const activeTab = ref('personal');
const isEditing = ref(false);

const saveProfile = () => {
    // In a real app, you would make an Inertia put request here
    isEditing.value = false;
    // Show success toast (simulated)
};

// Dummy User Data
const user = {
    name: 'Amit Sharma',
    id: 'RS-1024',
    role: 'Senior Sales Executive',
    department: 'Sales Department',
    location: 'New Delhi, India',
    doj: '15-Mar-2022',
    email: 'amit.sharma@ratnasagar.com',
    phone: '+91 98765 43210',
    address: 'B-12, Sector 62, Noida, UP',
    emergency_contact: 'Priya Sharma (+91 98989 89898)',
    reporting_manager: 'Rajesh Gupta (Head - North)',
    territory: 'Delhi NCR',
    employment_type: 'Full-Time',
    last_appraisal: '01 April, 2025',
    current_rating: '4.5/5',
    status: 'Active'
};

const stats = [
    { label: 'Attendance', value: '96%', sub: 'Present', icon: CheckCircle, color: 'text-green-600', bg: 'bg-green-50', border: 'border-green-100' },
    { label: 'Hours Worked', value: '78.5', sub: 'This Month', icon: Clock, color: 'text-emerald-600', bg: 'bg-emerald-50', border: 'border-emerald-100' },
    { label: 'Leaves Taken', value: '3', sub: 'Days', icon: Calendar, color: 'text-orange-600', bg: 'bg-orange-50', border: 'border-orange-100' },
    { label: 'Absent', value: '0', sub: 'Days', icon: AlertTriangle, color: 'text-red-500', bg: 'bg-red-50', border: 'border-red-100' },
];

const documents = [
    { name: 'Offer Letter', date: '15-Mar-2022', type: 'PDF' },
    { name: 'Aadhaar Card', date: '15-Mar-2022', type: 'PDF' },
    { name: 'PAN Card', date: '16-Mar-2022', type: 'Image' },
    { name: 'Salary Slip - Mar 2024', date: '01-Apr-2024', type: 'PDF' },
    { name: 'Salary Slip - Feb 2024', date: '01-Mar-2024', type: 'PDF' },
    { name: 'Experience Certificate', date: '01-Mar-2024', type: 'PDF' },
];

// Charts Configuration
const attendanceTrendSeries = [{
    name: "Attendance %",
    data: [92, 95, 96, 94, 98, 96]
}];

const attendanceTrendOptions = {
    chart: { type: 'area', height: 180, toolbar: { show: false }, fontFamily: 'Poppins, sans-serif' },
    colors: ['#06b6d4'], // Cyan-like blue
    fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.2, stops: [0, 90, 100] } },
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth', width: 2 },
    xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], labels: { style: { colors: '#64748b' } } },
    yaxis: { min: 80, max: 100 },
    grid: { borderColor: '#f1f5f9' },
    tooltip: { enabled: true }
};

const hoursWorkedSeries = [{
    name: "Hours",
    data: [160, 155, 170, 168, 175, 160]
}];

const hoursWorkedOptions = {
    chart: { type: 'bar', height: 180, toolbar: { show: false }, fontFamily: 'Poppins, sans-serif' },
    colors: ['#f97316'], // Orange
    plotOptions: { bar: { borderRadius: 4, columnWidth: '40%' } },
    dataLabels: { enabled: false },
    xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], labels: { style: { colors: '#64748b' } } },
    grid: { borderColor: '#f1f5f9' }
};

const attendanceOverviewSeries = [22, 3, 2]; // Present, Sick, Vacation
const attendanceOverviewOptions = {
    chart: { type: 'donut', fontFamily: 'Poppins, sans-serif' },
    labels: ['Present', 'Sick Leave', 'Vacation'],
    colors: ['#22c55e', '#ef4444', '#f59e0b'],
    legend: { position: 'right' },
    dataLabels: { enabled: false },
    plotOptions: { pie: { donut: { size: '65%' } } }
};

</script>

<template>
    <Head title="My Profile" />

    <AuthenticatedLayout>
        <div class="space-y-6 max-w-7xl mx-auto pb-10">
            
            <!-- 1. PROFILE HEADER CARD (Cityscape) -->
            <div class="relative overflow-hidden rounded-2xl shadow-xl group">
                <!-- Background Image -->
                <div class="absolute inset-0 bg-[url('/images/profile_header.png')] bg-cover bg-center"></div>
                <!-- Gradient Overlay (Heavy Blue/Navy) -->
                <div class="absolute inset-0 bg-gradient-to-r from-[#0f172a] via-[#0f172a]/90 to-[#1e3a8a]/40"></div>

                <div class="relative z-10 px-8 py-10 flex flex-col md:flex-row items-center md:items-start justify-between gap-8 text-white">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <!-- Profile Photo -->
                        <div class="relative">
                            <div class="h-28 w-28 rounded-lg ring-4 ring-white/20 shadow-2xl overflow-hidden bg-slate-800">
                                <img 
                                    src="https://futureoflife.org/wp-content/uploads/2020/08/elon_musk_royal_society.jpg" 
                                    alt="Profile" 
                                    class="h-full w-full object-cover"
                                />
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="text-center md:text-left space-y-2">
                            <h1 class="text-3xl font-bold font-display tracking-tight">{{ user.name }}</h1>
                            <p class="text-lg text-slate-200 font-medium">{{ user.role }}</p>
                            
                            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-3 text-sm text-slate-300">
                                <span class="bg-white/10 px-3 py-1 rounded border border-white/10">{{ user.id }}</span>
                                <span class="flex items-center gap-1"><Briefcase class="w-3 h-3" /> {{ user.department }}</span>
                                <span class="flex items-center gap-1"><MapPin class="w-3 h-3" /> {{ user.location }}</span>
                                <span class="flex items-center gap-1"><Calendar class="w-3 h-3 text-brand-400" /> Joined: {{ user.doj }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Header Action -->
                    <button class="bg-white text-[#0f172a] hover:bg-slate-100 px-5 py-2.5 rounded-lg text-sm font-bold shadow-lg shadow-black/20 flex items-center gap-2 transition-all transform hover:-translate-y-0.5">
                        <Download class="w-4 h-4" />
                        Download Attendance (CSV)
                    </button>
                </div>
            </div>

            <!-- 2. QUICK STATS CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div v-for="(stat, index) in stats" :key="index" class="bg-white dark:bg-slate-800 rounded-xl p-5 shadow-card hover:shadow-card-hover border border-slate-100 dark:border-slate-700 transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div :class="[stat.bg, stat.color, 'p-2.5 rounded-lg']">
                            <component :is="stat.icon" class="w-6 h-6" />
                        </div>
                        <span v-if="index === 2" class="text-xs font-bold text-red-500 bg-red-50 border border-red-100 px-2 py-0.5 rounded">Action</span>
                    </div>
                    <div>
                        <p class="text-4xl font-bold text-slate-800 dark:text-white tracking-tight">{{ stat.value }} <span class="text-base font-medium text-slate-400 ml-1">{{ stat.sub }}</span></p>
                        <p class="text-sm font-medium text-slate-500 mt-1 uppercase tracking-wider">{{ stat.label }}</p>
                    </div>
                </div>
            </div>

            <!-- 3. MAIN DASHBOARD CONTENT (TABS) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-card border border-slate-100 dark:border-slate-700 min-h-[600px] flex flex-col">
                
                <!-- Tab Headers -->
                <div class="flex items-center gap-2 px-6 pt-6 border-b border-slate-200 dark:border-slate-700">
                    <button 
                        v-for="tab in ['personal', 'job', 'performance', 'documents']" 
                        :key="tab"
                        @click="activeTab = tab"
                        :class="[
                            'pb-4 px-4 text-sm font-bold border-b-2 transition-all duration-200 capitalize',
                            activeTab === tab 
                                ? 'text-[#0f172a] border-brand-500 dark:text-white' 
                                : 'text-slate-400 border-transparent hover:text-slate-600 hover:border-slate-300'
                        ]"
                    >
                        {{ tab === 'performance' ? 'Attendance & Report' : tab + ' Details' }}
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="p-8 bg-slate-50/50 flex-1">
                    
                    <!-- A) Performance / Attendance Dashboard -->
                    <div v-if="activeTab === 'performance'" class="space-y-6 animate-in fade-in duration-300">
                        
                        <!-- Report Filter Header -->
                        <div class="flex items-center justify-between bg-white p-4 rounded-lg border border-slate-200 shadow-sm">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <FileCheck class="w-5 h-5 text-brand-500" /> Attendance Report
                            </h3>
                            <div class="flex gap-2">
                                <div class="px-3 py-1.5 bg-slate-100 rounded text-sm font-medium text-slate-600 border border-slate-200">01 Apr 2024</div>
                                <div class="px-3 py-1.5 bg-slate-100 rounded text-sm font-medium text-slate-600 border border-slate-200">30 Apr 2024</div>
                            </div>
                        </div>

                        <!-- Charts Row 1 -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Attendance Overview Donut -->
                            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                                <h4 class="text-sm font-bold text-slate-600 mb-4 uppercase tracking-wider">Attendance Overview</h4>
                                <div class="flex items-center justify-center">
                                    <apexchart type="donut" width="320" :options="attendanceOverviewOptions" :series="attendanceOverviewSeries"></apexchart>
                                </div>
                            </div>
                            
                            <!-- Attendance Trend Line -->
                            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm lg:col-span-2">
                                <h4 class="text-sm font-bold text-slate-600 mb-4 uppercase tracking-wider">Attendance Trend (6 Months)</h4>
                                <apexchart type="area" height="250" :options="attendanceTrendOptions" :series="attendanceTrendSeries"></apexchart>
                            </div>
                        </div>

                        <!-- Charts Row 2 -->
                         <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Hours Worked Bar -->
                            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm lg:col-span-2">
                                <h4 class="text-sm font-bold text-slate-600 mb-4 uppercase tracking-wider">Monthly Hours Worked</h4>
                                <div class="flex gap-8">
                                    <div class="flex-1">
                                        <apexchart type="bar" height="200" :options="hoursWorkedOptions" :series="hoursWorkedSeries"></apexchart>
                                    </div>
                                    <div class="w-48 space-y-4 pt-4 border-l border-slate-100 pl-6 hidden md:block">
                                        <div>
                                            <p class="text-xs text-slate-400 mb-1">Total Hours</p>
                                            <p class="text-2xl font-bold text-slate-800">976.00</p>
                                        </div>
                                         <div>
                                            <p class="text-xs text-slate-400 mb-1">Avg. Daily</p>
                                            <p class="text-2xl font-bold text-brand-600">8.6 hrs</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Goals / Targets -->
                            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
                                <h4 class="text-sm font-bold text-slate-600 mb-6 uppercase tracking-wider">Performance Goals</h4>
                                
                                <div class="space-y-6">
                                    <div>
                                        <div class="flex justify-between text-sm font-bold text-slate-700 mb-2">
                                            <span>Sales Target</span>
                                            <span>85%</span>
                                        </div>
                                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-brand-500 rounded-full" style="width: 85%"></div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="flex justify-between text-sm font-bold text-slate-700 mb-2">
                                            <span>Client Meetings</span>
                                            <span>70%</span>
                                        </div>
                                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full" style="width: 70%"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="flex justify-between text-sm font-bold text-slate-700 mb-2">
                                            <span>School Visits</span>
                                            <span>92%</span>
                                        </div>
                                        <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-500 rounded-full" style="width: 92%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- B) Documents -->
                    <div v-if="activeTab === 'documents'" class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-in fade-in duration-300">
                        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 overflow-hidden">
                            <div class="p-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                                <h3 class="font-bold text-slate-700">Important Documents</h3>
                                <button class="text-xs bg-brand-500 text-white px-3 py-1.5 rounded hover:bg-brand-600 transition-colors">
                                    + Upload New
                                </button>
                            </div>
                            <div class="divide-y divide-slate-100">
                                <div v-for="(doc, idx) in documents" :key="idx" class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors group">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center">
                                            <Briefcase v-if="doc.name.includes('Offer')" class="w-5 h-5" />
                                            <Shield v-else-if="doc.name.includes('Aadhaar') || doc.name.includes('PAN')" class="w-5 h-5" />
                                            <Wallet v-else class="w-5 h-5" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ doc.name }}</p>
                                            <p class="text-xs text-slate-400">{{ doc.date }}</p>
                                        </div>
                                    </div>
                                    <button class="flex items-center gap-2 px-3 py-1.5 text-xs font-bold text-brand-600 bg-brand-50 hover:bg-brand-100 rounded transition-colors border border-brand-100">
                                        <Download class="w-3 h-3" /> Download
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews / Side Panel -->
                        <div class="bg-orange-50/50 rounded-xl border border-orange-100 p-6">
                            <h3 class="font-bold text-slate-800 mb-4">Manager Remarks</h3>
                            <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-100 relative">
                                <div class="absolute -top-3 -left-2 bg-brand-500 text-white p-1 rounded-full">
                                    <User class="w-3 h-3" />
                                </div>
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="h-8 w-8 rounded-full bg-slate-200">
                                        <img src="https://ui-avatars.com/api/?name=Rajesh+Gupta&background=0f172a&color=fff" class="rounded-full" />
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-900">Rajesh Gupta</p>
                                        <p class="text-[10px] text-slate-500 uppercase">Head - North</p>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-600 italic leading-relaxed">
                                    "Amit has consistently exceeded his sales targets for the quarter. His proactive approach to client management and dedication to the team's success are commendable."
                                </p>
                                <p class="text-[10px] text-slate-400 mt-2 text-right">01 Apr 2024</p>
                            </div>
                        </div>
                    </div>

                    <!-- C) Personal Info -->
                    <div v-if="activeTab === 'personal'" class="animate-in fade-in duration-300">
                        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                            <!-- Section Header with Edit Toggle -->
                            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-800">Personal Information</h3>
                                    <p class="text-sm text-slate-500 mt-1">Manage your personal details and contact info.</p>
                                </div>
                                <div class="flex gap-3">
                                    <button 
                                        v-if="!isEditing"
                                        @click="isEditing = true"
                                        class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-lg shadow-sm hover:bg-slate-50 hover:text-brand-600 transition-all"
                                    >
                                        <Edit3 class="w-4 h-4" /> Edit Profile
                                    </button>
                                    <div v-else class="flex gap-3">
                                        <button 
                                            @click="isEditing = false"
                                            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-bold rounded-lg hover:bg-slate-50 transition-colors"
                                        >
                                            Cancel
                                        </button>
                                        <button 
                                            @click="saveProfile"
                                            class="flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white font-bold rounded-lg shadow hover:bg-brand-700 transition-colors"
                                        >
                                            <CheckCircle class="w-4 h-4" /> Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Grid -->
                            <div class="p-8">
                                <form @submit.prevent="saveProfile" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-8">
                                    
                                    <!-- Full Name -->
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Full Name</label>
                                        <div v-if="!isEditing" class="text-base font-semibold text-slate-800 p-3 bg-slate-50 rounded-lg border border-transparent">
                                            {{ user.name }}
                                        </div>
                                        <input v-else v-model="user.name" type="text" class="w-full text-base font-semibold text-slate-800 p-3 bg-white rounded-lg border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow" />
                                    </div>

                                    <!-- Email -->
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Email Address</label>
                                        <div class="text-base font-semibold text-slate-800 p-3 bg-slate-50 rounded-lg border border-transparent opacity-75 cursor-not-allowed" title="Contact HR to change email">
                                            {{ user.email }} <span class="text-xs font-normal text-slate-400 ml-2">(Read Only)</span>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Phone Number</label>
                                        <div v-if="!isEditing" class="text-base font-semibold text-slate-800 p-3 bg-slate-50 rounded-lg border border-transparent">
                                            {{ user.phone }}
                                        </div>
                                        <input v-else v-model="user.phone" type="text" class="w-full text-base font-semibold text-slate-800 p-3 bg-white rounded-lg border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow" />
                                    </div>

                                    <!-- Date of Joining -->
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Date of Joining</label>
                                        <div class="text-base font-semibold text-slate-800 p-3 bg-slate-50 rounded-lg border border-transparent">
                                            {{ user.doj }}
                                        </div>
                                    </div>

                                     <!-- Date of Birth (New) -->
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Date of Birth</label>
                                        <div v-if="!isEditing" class="text-base font-semibold text-slate-800 p-3 bg-slate-50 rounded-lg border border-transparent">
                                            12 Aug, 1992
                                        </div>
                                        <input v-else type="text" value="12 Aug, 1992" class="w-full text-base font-semibold text-slate-800 p-3 bg-white rounded-lg border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow" />
                                    </div>

                                    <!-- Gender (New) -->
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Gender</label>
                                        <div v-if="!isEditing" class="text-base font-semibold text-slate-800 p-3 bg-slate-50 rounded-lg border border-transparent">
                                            Male
                                        </div>
                                        <select v-else class="w-full text-base font-semibold text-slate-800 p-3 bg-white rounded-lg border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow">
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>

                                    <!-- Location (Full Width) -->
                                    <div class="space-y-2 md:col-span-2 lg:col-span-3">
                                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Current Residential Address</label>
                                        <div v-if="!isEditing" class="flex items-start gap-3 text-base font-semibold text-slate-800 p-3 bg-slate-50 rounded-lg border border-transparent">
                                            <Home class="w-5 h-5 text-slate-400 mt-0.5 flex-shrink-0" />
                                            {{ user.address }}
                                        </div>
                                         <textarea v-else v-model="user.address" rows="2" class="w-full text-base font-semibold text-slate-800 p-3 bg-white rounded-lg border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-shadow"></textarea>
                                    </div>
                                    
                                    <!-- Emergency Contact (Highlighted) -->
                                    <div class="space-y-2 md:col-span-2 lg:col-span-3 pt-4 border-t border-slate-100 mt-2">
                                        <div class="flex items-center gap-2 mb-2">
                                            <Shield class="w-4 h-4 text-red-500" />
                                            <h4 class="text-sm font-bold text-slate-700">Emergency Contact</h4>
                                        </div>
                                        <div v-if="!isEditing" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="p-4 bg-red-50/50 rounded-lg border border-red-100">
                                                <span class="text-xs text-red-400 font-bold uppercase block mb-1">Name & Relation</span>
                                                <span class="text-slate-800 font-medium">Priya Sharma (Spouse)</span>
                                            </div>
                                             <div class="p-4 bg-red-50/50 rounded-lg border border-red-100">
                                                <span class="text-xs text-red-400 font-bold uppercase block mb-1">Phone Number</span>
                                                <span class="text-slate-800 font-medium">+91 98989 89898</span>
                                            </div>
                                        </div>
                                        <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <input type="text" value="Priya Sharma (Spouse)" class="w-full text-base font-semibold text-slate-800 p-3 bg-white rounded-lg border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none" placeholder="Name & Relation" />
                                            <input type="text" value="+91 98989 89898" class="w-full text-base font-semibold text-slate-800 p-3 bg-white rounded-lg border border-slate-300 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none" placeholder="Phone Number" />
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- D) Job Info -->
                    <div v-if="activeTab === 'job'" class="animate-in fade-in duration-300">
                         <div class="bg-white rounded-xl border border-slate-200 p-8 max-w-4xl mx-auto">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                                <div class="border-b border-slate-100 pb-2">
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Role</label>
                                    <p class="text-lg font-medium text-slate-800">{{ user.role }}</p>
                                </div>
                                <div class="border-b border-slate-100 pb-2">
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Department</label>
                                    <p class="text-lg font-medium text-slate-800">{{ user.department }}</p>
                                </div>
                                <div class="border-b border-slate-100 pb-2">
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Reporting Manager</label>
                                    <p class="text-lg font-medium text-brand-600 cursor-pointer">{{ user.reporting_manager }}</p>
                                </div>
                                <div class="border-b border-slate-100 pb-2">
                                    <label class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-1">Territory</label>
                                    <p class="text-lg font-medium text-slate-800">{{ user.territory }}</p>
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
/* Scoped styles if needed */
</style>
