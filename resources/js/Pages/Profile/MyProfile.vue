<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { 
    User, 
    Mail, 
    Phone, 
    MapPin, 
    Briefcase, 
    Calendar, 
    Award, 
    FileText, 
    Download, 
    Shield, 
    CreditCard, 
    Clock, 
    Star,
    CheckCircle,
    Building2,
    Lock
} from 'lucide-vue-next';

// ----------------------------------------------------------------------
// DATA & STATE
// ----------------------------------------------------------------------

const activeTab = ref('Personal');

const tabs = [
    { name: 'Personal', icon: User },
    { name: 'Job Details', icon: Briefcase },
    { name: 'Performance', icon: Award },
    { name: 'Documents', icon: FileText },
];

const employee = {
    name: 'Rahul Sharma',
    id: 'RS-EXEC-1024',
    role: 'Sales Executive',
    region: 'North Zone (NCR)',
    doj: '15th June 2021',
    status: 'Active',
    email: 'rahul.sharma@ratnasagar.com',
    phone: '+91 98765-XXXXX',
    address: 'B-45, Sector 12, Dwarka, New Delhi - 110075',
    emergency: 'Sita Sharma (Mother) - +91 99999-XXXXX',
    manager: 'Suresh Kumar (Team Leader)',
    territory: 'West Delhi & Gurgaon',
    schools: 45,
    lastAppraisal: 'April 2023',
    rating: '4.2',
    managerRemarks: 'Rahul has shown consistent growth. Excellent relationship with school principals. Needs to focus on closing orders faster in Q4.'
};

const stats = [
    { label: 'Attendance', value: '96%', color: 'bg-emerald-50 text-emerald-700 border-emerald-100', icon: CheckCircle },
    { label: 'Leave Bal', value: '12 Days', color: 'bg-blue-50 text-blue-700 border-blue-100', icon: Clock },
    { label: 'Rating', value: '4.2 / 5', color: 'bg-amber-50 text-amber-700 border-amber-100', icon: Star },
    { label: 'Allowances', value: '₹ 12,XXX', color: 'bg-slate-50 text-slate-700 border-slate-200', icon: Lock }, // Masked salary/allowances
];

const documents = [
    { name: 'Offer Letter', date: '15 Jun 2021', size: '1.2 MB' },
    { name: 'Aadhaar Card', date: 'Verified', size: '450 KB' },
    { name: 'PAN Card', date: 'Verified', size: '320 KB' },
    { name: 'Payslip (Dec 2023)', date: '31 Dec 2023', size: '1.1 MB' },
    { name: 'Payslip (Nov 2023)', date: '30 Nov 2023', size: '1.1 MB' },
];

</script>

<template>
    <Head title="My Profile" />

    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto space-y-6">
            
            <!-- 1) PROFILE HEADER CARD -->
            <div class="rounded-2xl bg-[#0B1120] text-white overflow-hidden shadow-lg relative">
                <!-- Background decorative elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-slate-800/30 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
                
                <div class="p-8 flex flex-col md:flex-row items-center md:items-start gap-8 relative z-10">
                    
                    <!-- Avatar -->
                    <div class="relative shrink-0">
                        <div class="h-28 w-28 rounded-full bg-gradient-to-br from-orange-500 to-orange-700 p-1 shadow-2xl">
                            <img 
                                src="https://ui-avatars.com/api/?name=Rahul+Sharma&background=0F172A&color=fff&size=512" 
                                alt="Profile" 
                                class="h-full w-full rounded-full object-cover border-4 border-[#0B1120]" 
                            />
                        </div>
                        <!-- Status Badge -->
                        <div class="absolute bottom-1 right-1 bg-emerald-500 border-[3px] border-[#0B1120] w-6 h-6 rounded-full" title="Active"></div>
                    </div>

                    <!-- Info -->
                    <div class="text-center md:text-left flex-1">
                        <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2">
                            <h1 class="text-3xl font-bold font-display tracking-tight">{{ employee.name }}</h1>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-500/20 text-blue-200 border border-blue-500/30">
                                {{ employee.status }}
                            </span>
                        </div>
                        
                        <p class="text-lg text-slate-300 font-medium mb-4 flex items-center justify-center md:justify-start gap-2">
                             <Briefcase class="w-4 h-4" /> {{ employee.role }} 
                             <span class="text-slate-600 mx-1">•</span> 
                             <span class="text-orange-400">{{ employee.id }}</span>
                        </p>

                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-y-2 gap-x-6 text-sm text-slate-400">
                            <div class="flex items-center gap-2">
                                <MapPin class="w-4 h-4" />
                                {{ employee.region }}
                            </div>
                            <div class="hidden md:block w-px h-4 bg-slate-700"></div>
                            <div class="flex items-center gap-2">
                                <Calendar class="w-4 h-4" />
                                Date of Joining: {{ employee.doj }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 2) QUICK STATUS CARDS -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div v-for="(stat, idx) in stats" :key="idx" 
                    :class="['rounded-xl border p-4 flex flex-col items-center justify-center text-center transition-all hover:shadow-sm', stat.color]">
                    <div class="mb-2 opacity-80">
                        <component :is="stat.icon" class="w-5 h-5" />
                    </div>
                    <span class="text-xs font-bold uppercase tracking-widest opacity-70 mb-1">{{ stat.label }}</span>
                    <span class="text-lg font-bold">{{ stat.value }}</span>
                </div>
            </div>

            <!-- 3) PROFILE TABS WRAPPER -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden min-h-[500px]">
                
                <!-- Tab Headers -->
                <div class="flex border-b border-slate-200 dark:border-slate-700 overflow-x-auto">
                    <button 
                        v-for="tab in tabs" 
                        :key="tab.name"
                        @click="activeTab = tab.name"
                        :class="[
                            'flex-1 flex items-center justify-center gap-2 px-6 py-4 text-sm font-semibold transition-colors min-w-fit whitespace-nowrap',
                            activeTab === tab.name 
                                ? 'text-orange-600 border-b-2 border-orange-600 bg-orange-50/50' 
                                : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'
                        ]"
                    >
                        <component :is="tab.icon" class="w-4 h-4" />
                        {{ tab.name }}
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="p-8">
                    
                    <!-- A) PERSONAL INFORMATION -->
                    <transition name="fade" mode="out-in">
                        <div v-if="activeTab === 'Personal'" class="max-w-3xl">
                             <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                                <User class="w-5 h-5 mr-2 text-slate-400" /> Personal Information
                            </h3>
                            
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-8">
                                <div class="col-span-1">
                                    <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Full Name</dt>
                                    <dd class="text-base text-slate-800 dark:text-slate-200 font-medium border-b border-slate-100 pb-2">{{ employee.name }}</dd>
                                </div>
                                <div class="col-span-1">
                                    <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Email Address</dt>
                                    <dd class="text-base text-slate-800 dark:text-slate-200 font-medium border-b border-slate-100 pb-2">{{ employee.email }}</dd>
                                </div>
                                <div class="col-span-1">
                                    <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Phone Number</dt>
                                    <dd class="text-base text-slate-800 dark:text-slate-200 font-medium border-b border-slate-100 pb-2">{{ employee.phone }}</dd>
                                </div>
                                <div class="col-span-1">
                                    <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Emergency Contact</dt>
                                    <dd class="text-base text-slate-800 dark:text-slate-200 font-medium border-b border-slate-100 pb-2">{{ employee.emergency }}</dd>
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <dt class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Permanent Address</dt>
                                    <dd class="text-base text-slate-800 dark:text-slate-200 font-medium border-b border-slate-100 pb-2">{{ employee.address }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- B) JOB DETAILS -->
                        <div v-else-if="activeTab === 'Job Details'" class="max-w-3xl">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                                <Briefcase class="w-5 h-5 mr-2 text-slate-400" /> Job Configuration
                            </h3>

                            <div class="bg-slate-50 dark:bg-slate-700/30 rounded-xl p-6 border border-slate-100 dark:border-slate-700 mb-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Reporting Manager</p>
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold">SK</div>
                                            <p class="font-bold text-slate-800 dark:text-white">{{ employee.manager }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Department</p>
                                        <p class="font-bold text-slate-800 dark:text-white">Sales & Marketing (Domestic)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="p-5 border border-slate-100 dark:border-slate-700 rounded-xl">
                                    <MapPin class="w-5 h-5 text-orange-500 mb-3" />
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Assigned Territory</p>
                                    <p class="text-lg font-bold text-slate-800 dark:text-white">{{ employee.territory }}</p>
                                </div>
                                <div class="p-5 border border-slate-100 dark:border-slate-700 rounded-xl">
                                    <Building2 class="w-5 h-5 text-blue-500 mb-3" />
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Assigned Schools</p>
                                    <p class="text-lg font-bold text-slate-800 dark:text-white">{{ employee.schools }} Schools</p>
                                </div>
                            </div>
                        </div>

                        <!-- C) PERFORMANCE SNAPSHOT -->
                        <div v-else-if="activeTab === 'Performance'" class="max-w-3xl">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                                <Award class="w-5 h-5 mr-2 text-slate-400" /> Performance Overview
                            </h3>

                            <div class="space-y-6">
                                <!-- Quick Stats -->
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="bg-orange-50 border border-orange-100 p-4 rounded-lg">
                                        <p class="text-xs text-orange-600 font-bold uppercase">Current Rating</p>
                                        <p class="text-2xl font-bold text-orange-800 mt-1">{{ employee.rating }}<span class="text-sm text-orange-600/60">/5.0</span></p>
                                    </div>
                                    <div class="bg-indigo-50 border border-indigo-100 p-4 rounded-lg">
                                        <p class="text-xs text-indigo-600 font-bold uppercase">Last Appraisal</p>
                                        <p class="text-xl font-bold text-indigo-800 mt-1">{{ employee.lastAppraisal }}</p>
                                    </div>
                                </div>

                                <!-- Target Bar -->
                                <div class="p-6 border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-800">
                                    <div class="flex justify-between items-end mb-2">
                                        <span class="font-bold text-sm">Fiscal Year Target Achievement</span>
                                        <span class="font-bold text-emerald-600">62.4%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden">
                                        <div class="bg-emerald-500 h-4 rounded-full" style="width: 62.4%"></div>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-2">Target: ₹ 1.25 Cr | Achieved: ₹ 78.0 Lakhs</p>
                                </div>

                                <!-- Remarks -->
                                <div class="bg-slate-50 dark:bg-slate-700/30 p-6 rounded-xl border border-slate-100 dark:border-slate-700">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Manager's Remarks</p>
                                    <p class="text-slate-600 dark:text-slate-300 italic text-sm leading-relaxed">"{{ employee.managerRemarks }}"</p>
                                </div>
                            </div>
                        </div>

                         <!-- D) DOCUMENTS -->
                        <div v-else-if="activeTab === 'Documents'" class="max-w-4xl">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center">
                                <FileText class="w-5 h-5 mr-2 text-slate-400" /> Digital Records
                            </h3>

                             <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6 flex items-start gap-3">
                                <Shield class="w-5 h-5 text-yellow-600 shrink-0 mt-0.5" />
                                <div>
                                    <p class="text-sm font-bold text-yellow-800">Secure Access</p>
                                    <p class="text-xs text-yellow-700 mt-1">These documents are confidential. Any download is logged for security audits.</p>
                                </div>
                             </div>

                            <div class="space-y-3">
                                <div v-for="(doc, idx) in documents" :key="idx" 
                                     class="flex items-center justify-between p-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:shadow-md transition-shadow group">
                                    
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 bg-slate-100 dark:bg-slate-700 rounded-lg flex items-center justify-center text-slate-500">
                                            <FileText class="w-5 h-5" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 dark:text-white">{{ doc.name }}</p>
                                            <div class="flex items-center gap-3 mt-0.5">
                                                <span class="text-xs text-slate-500">{{ doc.date }}</span>
                                                <span class="text-[10px] bg-slate-100 text-slate-500 px-1.5 rounded">{{ doc.size }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="p-2 text-slate-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors">
                                        <Download class="w-5 h-5" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </transition>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
