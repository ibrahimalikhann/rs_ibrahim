<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import { 
    Users, 
    UserPlus,
    UserCheck,
    FileText, 
    Calendar,
    Clock,
    TrendingUp,
    Award,
    Target,
    BookOpen,
    Shield,
    AlertCircle,
    CheckCircle,
    XCircle,
    ArrowUpRight,
    ArrowDownRight,
    MoreHorizontal,
    Search,
    Filter,
    Download,
    PlusCircle,
    Briefcase,
    GraduationCap,
    ClipboardCheck,
    IndianRupee,
    DollarSign,
    Percent,
    Star,
    TrendingDown,
    Building2,
    Mail,
    Phone,
    MapPin,
    Eye,
    Edit,
    Trash2,
    ChevronRight,
    Activity,
    BarChart3,
    PieChart,
    Zap
} from 'lucide-vue-next';

// Helper function for rupee formatting
const formatRupee = (text) => {
    if (!text) return text;
    return String(text).replace(/₹/g, '<span class="rupee-symbol">₹</span>');
};

// ========================================
// DATA & STATE
// ========================================

// Overview Stats
const overviewStats = ref([
    { label: 'Total Employees', value: '248', change: '+12', trend: 'up', icon: Users, color: '#3B82F6' },
    { label: 'Active Today', value: '186', change: '75%', trend: 'up', icon: UserCheck, color: '#10B981' },
    { label: 'On Leave', value: '24', change: '-3', trend: 'down', icon: Calendar, color: '#F59E0B' },
    { label: 'Open Positions', value: '8', change: '+2', trend: 'up', icon: Briefcase, color: '#8B5CF6' },
]);

// Recruitment & Hiring Data
const recruitmentData = ref({
    openPositions: 8,
    applicants: 156,
    interviews: 24,
    offers: 5,
    pipeline: [
        { stage: 'Applied', count: 156, color: '#3B82F6' },
        { stage: 'Screening', count: 89, color: '#8B5CF6' },
        { stage: 'Interview', count: 24, color: '#F59E0B' },
        { stage: 'Offer', count: 5, color: '#10B981' },
    ],
    recentJobs: [
        { title: 'Senior Sales Executive', department: 'Sales', location: 'Delhi NCR', applicants: 45, status: 'Active', posted: '2 days ago' },
        { title: 'Content Writer', department: 'Marketing', location: 'Remote', applicants: 32, status: 'Active', posted: '5 days ago' },
        { title: 'Warehouse Manager', department: 'Operations', location: 'Mumbai', applicants: 18, status: 'Active', posted: '1 week ago' },
    ]
});

// Employee Database
const employeeData = ref({
    totalEmployees: 248,
    departments: [
        { name: 'Sales', count: 85, color: '#3B82F6' },
        { name: 'Operations', count: 42, color: '#10B981' },
        { name: 'Marketing', count: 28, color: '#F59E0B' },
        { name: 'Finance', count: 18, color: '#8B5CF6' },
        { name: 'HR', count: 12, color: '#EC4899' },
        { name: 'IT', count: 15, color: '#06B6D4' },
        { name: 'Others', count: 48, color: '#6B7280' },
    ],
    recentEmployees: [
        { name: 'Priya Sharma', role: 'Sales Executive', department: 'Sales', joinDate: 'Jan 15, 2026', status: 'Active', avatar: 'PS' },
        { name: 'Amit Patel', role: 'Marketing Manager', department: 'Marketing', joinDate: 'Jan 10, 2026', status: 'Active', avatar: 'AP' },
        { name: 'Neha Gupta', role: 'HR Coordinator', department: 'HR', joinDate: 'Jan 05, 2026', status: 'Probation', avatar: 'NG' },
    ]
});

// Onboarding Data
const onboardingData = ref({
    newJoiners: 12,
    inProgress: 8,
    completed: 4,
    pending: 3,
    tasks: [
        { employee: 'Priya Sharma', task: 'Document Verification', status: 'Completed', dueDate: 'Jan 20', progress: 100 },
        { employee: 'Amit Patel', task: 'System Access Setup', status: 'In Progress', dueDate: 'Jan 22', progress: 60 },
        { employee: 'Neha Gupta', task: 'Training Module 1', status: 'Pending', dueDate: 'Jan 25', progress: 0 },
    ],
    checklist: [
        { item: 'ID Card Generation', completed: 10, total: 12 },
        { item: 'Bank Account Setup', completed: 8, total: 12 },
        { item: 'System Credentials', completed: 11, total: 12 },
        { item: 'Training Completion', completed: 4, total: 12 },
    ]
});

// Attendance & Leave Data
const attendanceData = ref({
    presentToday: 186,
    absentToday: 38,
    onLeave: 24,
    lateArrivals: 15,
    weeklyTrend: [
        { day: 'Mon', present: 192, absent: 32 },
        { day: 'Tue', present: 188, absent: 36 },
        { day: 'Wed', present: 186, absent: 38 },
        { day: 'Thu', present: 190, absent: 34 },
        { day: 'Fri', present: 178, absent: 46 },
    ],
    leaveRequests: [
        { employee: 'Rahul Verma', type: 'Sick Leave', from: 'Feb 3', to: 'Feb 4', days: 2, status: 'Pending' },
        { employee: 'Sunita Devi', type: 'Casual Leave', from: 'Feb 5', to: 'Feb 5', days: 1, status: 'Approved' },
        { employee: 'Vikram Singh', type: 'Annual Leave', from: 'Feb 10', to: 'Feb 15', days: 6, status: 'Pending' },
    ]
});

// Payroll Data
const payrollData = ref({
    totalPayroll: '₹ 42.5L',
    processed: '₹ 38.2L',
    pending: '₹ 4.3L',
    lastRunDate: 'Jan 31, 2026',
    breakdown: [
        { category: 'Basic Salary', amount: '₹ 28.5L', percentage: 67 },
        { category: 'Allowances', amount: '₹ 8.2L', percentage: 19 },
        { category: 'Bonuses', amount: '₹ 3.8L', percentage: 9 },
        { category: 'Deductions', amount: '₹ 2.0L', percentage: 5 },
    ],
    recentPayslips: [
        { employee: 'Amit Shah', amount: '₹ 85,000', status: 'Paid', date: 'Jan 31' },
        { employee: 'Priya Sharma', amount: '₹ 45,000', status: 'Paid', date: 'Jan 31' },
        { employee: 'Rahul Verma', amount: '₹ 52,000', status: 'Processing', date: 'Jan 31' },
    ]
});

// Performance Management Data
const performanceData = ref({
    averageRating: 4.2,
    reviewsCompleted: 186,
    reviewsPending: 62,
    topPerformers: 28,
    ratings: [
        { level: 'Exceptional', count: 28, color: '#10B981' },
        { level: 'Exceeds', count: 65, color: '#3B82F6' },
        { level: 'Meets', count: 93, color: '#F59E0B' },
        { level: 'Needs Improvement', count: 48, color: '#EF4444' },
        { level: 'Unsatisfactory', count: 14, color: '#6B7280' },
    ],
    upcomingReviews: [
        { employee: 'Sales Team', type: 'Quarterly Review', dueDate: 'Feb 15', status: 'Scheduled' },
        { employee: 'Marketing Team', type: 'Annual Review', dueDate: 'Feb 20', status: 'Scheduled' },
        { employee: 'Operations', type: 'Mid-Year Review', dueDate: 'Feb 28', status: 'Planning' },
    ]
});

// Learning & Development Data
const learningData = ref({
    activePrograms: 12,
    enrolledEmployees: 156,
    completionRate: 78,
    certifications: 45,
    programs: [
        { name: 'Sales Excellence', enrolled: 45, completed: 32, duration: '4 weeks', type: 'Mandatory' },
        { name: 'Leadership Skills', enrolled: 28, completed: 15, duration: '6 weeks', type: 'Optional' },
        { name: 'Product Knowledge', enrolled: 83, completed: 78, duration: '2 weeks', type: 'Mandatory' },
    ],
    skillGaps: [
        { skill: 'Digital Marketing', gap: 35 },
        { skill: 'Data Analysis', gap: 42 },
        { skill: 'Customer Service', gap: 18 },
        { skill: 'Leadership', gap: 28 },
    ]
});

// Compliance & Policies Data
const complianceData = ref({
    totalPolicies: 24,
    acknowledgements: 92,
    pendingAcknowledgements: 8,
    upcomingAudits: 2,
    policies: [
        { name: 'Code of Conduct', category: 'General', lastUpdated: 'Jan 2026', acknowledged: 98 },
        { name: 'Leave Policy', category: 'HR', lastUpdated: 'Dec 2025', acknowledged: 95 },
        { name: 'IT Security Policy', category: 'IT', lastUpdated: 'Jan 2026', acknowledged: 88 },
        { name: 'Anti-Harassment Policy', category: 'Legal', lastUpdated: 'Nov 2025', acknowledged: 96 },
    ],
    complianceStatus: [
        { item: 'Labor Law Compliance', status: 'Compliant', icon: CheckCircle },
        { item: 'Tax Filings', status: 'Compliant', icon: CheckCircle },
        { item: 'Safety Regulations', status: 'Review Needed', icon: AlertCircle },
        { item: 'Data Protection', status: 'Compliant', icon: CheckCircle },
    ]
});

// Active Section for Navigation
const activeSection = ref('overview');

const sections = [
    { id: 'overview', name: 'Overview', icon: BarChart3 },
    { id: 'recruitment', name: 'Recruitment & Hiring', icon: UserPlus },
    { id: 'employees', name: 'Employee Database', icon: Users },
    { id: 'onboarding', name: 'Onboarding', icon: ClipboardCheck },
    { id: 'attendance', name: 'Attendance & Leave', icon: Calendar },
    { id: 'payroll', name: 'Payroll', icon: IndianRupee },
    { id: 'performance', name: 'Performance', icon: Target },
    { id: 'learning', name: 'Learning & Development', icon: GraduationCap },
    { id: 'compliance', name: 'Compliance & Policies', icon: Shield },
];

// Charts will be initialized on mount
onMounted(() => {
    // Initialize any charts if needed
});
</script>

<template>
    <Head title="HR Dashboard" />

    <AuthenticatedLayout>
        <div class="space-y-6">
            
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800 dark:text-white">HR Dashboard</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Manage your workforce effectively</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="px-4 py-2 text-sm font-medium text-[#015276] bg-[#FFFAF7] border border-slate-200 rounded-lg hover:bg-[#FFEEDE] transition-colors flex items-center gap-2">
                        <Download class="w-4 h-4" />
                        Export Report
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-[#AC0C13] rounded-lg hover:bg-[#8a0a0f] transition-colors flex items-center gap-2">
                        <PlusCircle class="w-4 h-4" />
                        Add Employee
                    </button>
                </div>
            </div>

            <!-- Section Navigation Pills -->
            <div class="bg-white dark:bg-slate-800 rounded-xl p-2 shadow-sm border border-slate-100 dark:border-slate-700 overflow-x-auto">
                <div class="flex items-center gap-1 min-w-max">
                    <button 
                        v-for="section in sections" 
                        :key="section.id"
                        @click="activeSection = section.id"
                        :class="[
                            'px-4 py-2 text-sm font-medium rounded-lg transition-all flex items-center gap-2 whitespace-nowrap',
                            activeSection === section.id 
                                ? 'bg-[#FFEEDE] text-[#AC0C13]' 
                                : 'text-slate-600 hover:bg-slate-50 dark:text-slate-400 dark:hover:bg-slate-700'
                        ]"
                    >
                        <component :is="section.icon" class="w-4 h-4" />
                        {{ section.name }}
                    </button>
                </div>
            </div>

            <!-- ================================================== -->
            <!-- OVERVIEW SECTION -->
            <!-- ================================================== -->
            <div v-if="activeSection === 'overview'" class="space-y-6">
                
                <!-- Top KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div v-for="stat in overviewStats" :key="stat.label" 
                         class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div class="absolute top-0 right-0 w-24 h-24 rounded-full blur-3xl -mr-8 -mt-8 opacity-20" :style="{ backgroundColor: stat.color }"></div>
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-2 rounded-lg bg-[#FFEEDE]">
                                <component :is="stat.icon" class="w-5 h-5 text-[#AC0C13]" />
                            </div>
                            <span :class="[
                                'text-xs font-bold px-2 py-1 rounded-full flex items-center gap-1',
                                stat.trend === 'up' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600'
                            ]">
                                <component :is="stat.trend === 'up' ? ArrowUpRight : ArrowDownRight" class="w-3 h-3" />
                                {{ stat.change }}
                            </span>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">{{ stat.label }}</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ stat.value }}</p>
                    </div>
                </div>

                <!-- Quick Stats Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Department Distribution -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#015276]">Department Distribution</h3>
                            <PieChart class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <div class="space-y-3">
                            <div v-for="dept in employeeData.departments" :key="dept.name" class="flex items-center gap-3">
                                <div class="w-3 h-3 rounded-full" :style="{ backgroundColor: dept.color }"></div>
                                <span class="flex-1 text-sm text-slate-600 dark:text-slate-300">{{ dept.name }}</span>
                                <span class="text-sm font-bold text-[#015276]">{{ dept.count }}</span>
                                <div class="w-20 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full" :style="{ width: `${(dept.count / employeeData.totalEmployees) * 100}%`, backgroundColor: dept.color }"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Overview -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#015276]">Today's Attendance</h3>
                            <Clock class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="text-center p-3 bg-green-50 rounded-xl">
                                <p class="text-2xl font-bold text-green-600">{{ attendanceData.presentToday }}</p>
                                <p class="text-xs text-green-600 font-medium">Present</p>
                            </div>
                            <div class="text-center p-3 bg-red-50 rounded-xl">
                                <p class="text-2xl font-bold text-red-600">{{ attendanceData.absentToday }}</p>
                                <p class="text-xs text-red-600 font-medium">Absent</p>
                            </div>
                            <div class="text-center p-3 bg-amber-50 rounded-xl">
                                <p class="text-2xl font-bold text-amber-600">{{ attendanceData.onLeave }}</p>
                                <p class="text-xs text-amber-600 font-medium">On Leave</p>
                            </div>
                            <div class="text-center p-3 bg-blue-50 rounded-xl">
                                <p class="text-2xl font-bold text-blue-600">{{ attendanceData.lateArrivals }}</p>
                                <p class="text-xs text-blue-600 font-medium">Late Arrivals</p>
                            </div>
                        </div>
                        <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#ed905a] rounded-full" :style="{ width: `${(attendanceData.presentToday / 248) * 100}%` }"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2 text-center">{{ Math.round((attendanceData.presentToday / 248) * 100) }}% Attendance Rate</p>
                    </div>

                    <!-- Pending Actions -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#015276]">Pending Actions</h3>
                            <AlertCircle class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-amber-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <Calendar class="w-4 h-4 text-amber-600" />
                                    <span class="text-sm font-medium text-amber-700">Leave Requests</span>
                                </div>
                                <span class="text-lg font-bold text-amber-600">5</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <UserPlus class="w-4 h-4 text-blue-600" />
                                    <span class="text-sm font-medium text-blue-700">Onboarding Tasks</span>
                                </div>
                                <span class="text-lg font-bold text-blue-600">8</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-purple-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <Target class="w-4 h-4 text-purple-600" />
                                    <span class="text-sm font-medium text-purple-700">Performance Reviews</span>
                                </div>
                                <span class="text-lg font-bold text-purple-600">12</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <IndianRupee class="w-4 h-4 text-red-600" />
                                    <span class="text-sm font-medium text-red-700">Payroll Pending</span>
                                </div>
                                <span class="text-lg font-bold text-red-600">3</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & Quick Links -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <!-- Recent Employees -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#015276]">Recent Joiners</h3>
                            <button class="text-sm text-[#AC0C13] font-medium hover:underline flex items-center gap-1">
                                View All <ChevronRight class="w-4 h-4" />
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div v-for="emp in employeeData.recentEmployees" :key="emp.name" 
                                 class="flex items-center gap-4 p-3 bg-white rounded-xl border border-slate-100 hover:shadow-sm transition-shadow">
                                <div class="w-10 h-10 rounded-full bg-[#FFEEDE] flex items-center justify-center text-sm font-bold text-[#AC0C13]">
                                    {{ emp.avatar }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-[#015276]">{{ emp.name }}</p>
                                    <p class="text-xs text-slate-500">{{ emp.role }} • {{ emp.department }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-slate-500">{{ emp.joinDate }}</p>
                                    <span :class="[
                                        'text-xs font-medium px-2 py-0.5 rounded-full',
                                        emp.status === 'Active' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600'
                                    ]">{{ emp.status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Open Positions -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#015276]">Open Positions</h3>
                            <button class="text-sm text-[#AC0C13] font-medium hover:underline flex items-center gap-1">
                                View All <ChevronRight class="w-4 h-4" />
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div v-for="job in recruitmentData.recentJobs" :key="job.title" 
                                 class="flex items-center gap-4 p-3 bg-white rounded-xl border border-slate-100 hover:shadow-sm transition-shadow">
                                <div class="w-10 h-10 rounded-full bg-[#FFEEDE] flex items-center justify-center">
                                    <Briefcase class="w-5 h-5 text-[#AC0C13]" />
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-[#015276]">{{ job.title }}</p>
                                    <p class="text-xs text-slate-500">{{ job.department }} • {{ job.location }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-[#015276]">{{ job.applicants }}</p>
                                    <p class="text-xs text-slate-500">applicants</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================================== -->
            <!-- RECRUITMENT & HIRING SECTION -->
            <!-- ================================================== -->
            <div v-if="activeSection === 'recruitment'" class="space-y-6">
                
                <!-- Recruitment KPIs -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-2 rounded-lg bg-[#FFEEDE]">
                                <Briefcase class="w-5 h-5 text-[#AC0C13]" />
                            </div>
                            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">Active</span>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Open Positions</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ recruitmentData.openPositions }}</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-2 rounded-lg bg-[#FFEEDE]">
                                <Users class="w-5 h-5 text-[#AC0C13]" />
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Applicants</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ recruitmentData.applicants }}</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-2 rounded-lg bg-[#FFEEDE]">
                                <Calendar class="w-5 h-5 text-[#AC0C13]" />
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Interviews Scheduled</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ recruitmentData.interviews }}</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between mb-3">
                            <div class="p-2 rounded-lg bg-[#FFEEDE]">
                                <FileText class="w-5 h-5 text-[#AC0C13]" />
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Offers Extended</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ recruitmentData.offers }}</p>
                    </div>
                </div>

                <!-- Recruitment Pipeline -->
                <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-[#015276] mb-6">Recruitment Pipeline</h3>
                    <div class="flex items-center justify-between gap-4">
                        <div v-for="(stage, index) in recruitmentData.pipeline" :key="stage.stage" class="flex-1 relative">
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto rounded-full flex items-center justify-center text-white font-bold text-xl mb-2" :style="{ backgroundColor: stage.color }">
                                    {{ stage.count }}
                                </div>
                                <p class="text-sm font-medium text-[#015276]">{{ stage.stage }}</p>
                            </div>
                            <div v-if="index < recruitmentData.pipeline.length - 1" class="absolute top-8 left-[60%] w-[80%] h-0.5 bg-slate-200">
                                <div class="absolute right-0 top-1/2 transform -translate-y-1/2">
                                    <ChevronRight class="w-4 h-4 text-slate-400" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Listings -->
                <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-[#015276]">Active Job Postings</h3>
                        <button class="px-4 py-2 text-sm font-medium text-white bg-[#AC0C13] rounded-lg hover:bg-[#8a0a0f] transition-colors flex items-center gap-2">
                            <PlusCircle class="w-4 h-4" />
                            Post New Job
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">
                                    <th class="pb-3 pr-4">Position</th>
                                    <th class="pb-3 pr-4">Department</th>
                                    <th class="pb-3 pr-4">Location</th>
                                    <th class="pb-3 pr-4">Applicants</th>
                                    <th class="pb-3 pr-4">Posted</th>
                                    <th class="pb-3 pr-4">Status</th>
                                    <th class="pb-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr v-for="job in recruitmentData.recentJobs" :key="job.title" class="hover:bg-white/50">
                                    <td class="py-4 pr-4">
                                        <p class="font-medium text-[#015276]">{{ job.title }}</p>
                                    </td>
                                    <td class="py-4 pr-4 text-sm text-slate-600">{{ job.department }}</td>
                                    <td class="py-4 pr-4 text-sm text-slate-600">{{ job.location }}</td>
                                    <td class="py-4 pr-4">
                                        <span class="font-bold text-[#015276]">{{ job.applicants }}</span>
                                    </td>
                                    <td class="py-4 pr-4 text-sm text-slate-500">{{ job.posted }}</td>
                                    <td class="py-4 pr-4">
                                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-green-100 text-green-600">{{ job.status }}</span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-2">
                                            <button class="p-1.5 text-slate-400 hover:text-[#015276] transition-colors">
                                                <Eye class="w-4 h-4" />
                                            </button>
                                            <button class="p-1.5 text-slate-400 hover:text-[#015276] transition-colors">
                                                <Edit class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================================================== -->
            <!-- EMPLOYEE DATABASE SECTION -->
            <!-- ================================================== -->
            <div v-if="activeSection === 'employees'" class="space-y-6">
                
                <!-- Search & Filters -->
                <div class="bg-[#FFFAF7] rounded-2xl p-4 shadow-sm border border-slate-100 flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <Search class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                        <input type="text" placeholder="Search employees..." class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#AC0C13]/20 focus:border-[#AC0C13]" />
                    </div>
                    <div class="flex gap-2">
                        <select class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-[#015276] focus:outline-none focus:ring-2 focus:ring-[#AC0C13]/20">
                            <option>All Departments</option>
                            <option>Sales</option>
                            <option>Marketing</option>
                            <option>Operations</option>
                            <option>Finance</option>
                            <option>HR</option>
                            <option>IT</option>
                        </select>
                        <select class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-[#015276] focus:outline-none focus:ring-2 focus:ring-[#AC0C13]/20">
                            <option>All Status</option>
                            <option>Active</option>
                            <option>Probation</option>
                            <option>On Leave</option>
                            <option>Inactive</option>
                        </select>
                        <button class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm text-[#015276] hover:bg-slate-50 flex items-center gap-2">
                            <Filter class="w-4 h-4" />
                            More Filters
                        </button>
                    </div>
                </div>

                <!-- Employee Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Employees</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ employeeData.totalEmployees }}</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Active</p>
                        <p class="text-3xl font-bold text-green-600">224</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">On Probation</p>
                        <p class="text-3xl font-bold text-amber-600">18</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Departments</p>
                        <p class="text-3xl font-bold text-[#015276]">7</p>
                    </div>
                </div>

                <!-- Employee List -->
                <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-[#015276]">Employee Directory</h3>
                        <div class="flex items-center gap-2">
                            <button class="px-3 py-1.5 text-sm font-medium text-[#015276] bg-white border border-slate-200 rounded-lg hover:bg-slate-50">
                                <Download class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-200">
                                    <th class="pb-3 pr-4">Employee</th>
                                    <th class="pb-3 pr-4">Department</th>
                                    <th class="pb-3 pr-4">Role</th>
                                    <th class="pb-3 pr-4">Join Date</th>
                                    <th class="pb-3 pr-4">Status</th>
                                    <th class="pb-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr v-for="emp in employeeData.recentEmployees" :key="emp.name" class="hover:bg-white/50">
                                    <td class="py-4 pr-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-[#FFEEDE] flex items-center justify-center text-sm font-bold text-[#AC0C13]">
                                                {{ emp.avatar }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-[#015276]">{{ emp.name }}</p>
                                                <p class="text-xs text-slate-500">emp.id@company.com</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 pr-4 text-sm text-slate-600">{{ emp.department }}</td>
                                    <td class="py-4 pr-4 text-sm text-slate-600">{{ emp.role }}</td>
                                    <td class="py-4 pr-4 text-sm text-slate-500">{{ emp.joinDate }}</td>
                                    <td class="py-4 pr-4">
                                        <span :class="[
                                            'text-xs font-medium px-2 py-1 rounded-full',
                                            emp.status === 'Active' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600'
                                        ]">{{ emp.status }}</span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-2">
                                            <button class="p-1.5 text-slate-400 hover:text-[#015276] transition-colors">
                                                <Eye class="w-4 h-4" />
                                            </button>
                                            <button class="p-1.5 text-slate-400 hover:text-[#015276] transition-colors">
                                                <Edit class="w-4 h-4" />
                                            </button>
                                            <button class="p-1.5 text-slate-400 hover:text-red-500 transition-colors">
                                                <Trash2 class="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================================================== -->
            <!-- ONBOARDING SECTION -->
            <!-- ================================================== -->
            <div v-if="activeSection === 'onboarding'" class="space-y-6">
                
                <!-- Onboarding KPIs -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-[#FFEEDE] w-fit mb-3">
                            <UserPlus class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">New Joiners</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ onboardingData.newJoiners }}</p>
                        <p class="text-xs text-slate-500 mt-1">This Month</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-blue-100 w-fit mb-3">
                            <Activity class="w-5 h-5 text-blue-600" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">In Progress</p>
                        <p class="text-3xl font-bold text-blue-600">{{ onboardingData.inProgress }}</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-green-100 w-fit mb-3">
                            <CheckCircle class="w-5 h-5 text-green-600" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Completed</p>
                        <p class="text-3xl font-bold text-green-600">{{ onboardingData.completed }}</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-amber-100 w-fit mb-3">
                            <Clock class="w-5 h-5 text-amber-600" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Pending Tasks</p>
                        <p class="text-3xl font-bold text-amber-600">{{ onboardingData.pending }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Onboarding Tasks -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="font-bold text-[#015276] mb-4">Onboarding Tasks</h3>
                        <div class="space-y-4">
                            <div v-for="task in onboardingData.tasks" :key="task.employee + task.task" class="p-4 bg-white rounded-xl border border-slate-100">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-[#015276]">{{ task.employee }}</p>
                                    <span :class="[
                                        'text-xs font-medium px-2 py-1 rounded-full',
                                        task.status === 'Completed' ? 'bg-green-100 text-green-600' : 
                                        task.status === 'In Progress' ? 'bg-blue-100 text-blue-600' : 'bg-amber-100 text-amber-600'
                                    ]">{{ task.status }}</span>
                                </div>
                                <p class="text-sm text-slate-600 mb-2">{{ task.task }}</p>
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span>Due: {{ task.dueDate }}</span>
                                    <span>{{ task.progress }}%</span>
                                </div>
                                <div class="h-1.5 bg-slate-100 rounded-full mt-2 overflow-hidden">
                                    <div class="h-full bg-[#ed905a] rounded-full transition-all" :style="{ width: `${task.progress}%` }"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Onboarding Checklist -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="font-bold text-[#015276] mb-4">Onboarding Checklist Progress</h3>
                        <div class="space-y-4">
                            <div v-for="item in onboardingData.checklist" :key="item.item" class="p-4 bg-white rounded-xl border border-slate-100">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-[#015276]">{{ item.item }}</p>
                                    <span class="text-sm font-bold text-[#015276]">{{ item.completed }}/{{ item.total }}</span>
                                </div>
                                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#ed905a] rounded-full transition-all" :style="{ width: `${(item.completed / item.total) * 100}%` }"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================================== -->
            <!-- ATTENDANCE & LEAVE SECTION -->
            <!-- ================================================== -->
            <div v-if="activeSection === 'attendance'" class="space-y-6">
                
                <!-- Attendance KPIs -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div class="bg-green-50 rounded-2xl p-6 shadow-sm border border-green-100">
                        <div class="p-2 rounded-lg bg-green-100 w-fit mb-3">
                            <UserCheck class="w-5 h-5 text-green-600" />
                        </div>
                        <p class="text-xs font-bold text-green-600 uppercase tracking-widest mb-1">Present Today</p>
                        <p class="text-3xl font-bold text-green-700">{{ attendanceData.presentToday }}</p>
                    </div>
                    <div class="bg-red-50 rounded-2xl p-6 shadow-sm border border-red-100">
                        <div class="p-2 rounded-lg bg-red-100 w-fit mb-3">
                            <XCircle class="w-5 h-5 text-red-600" />
                        </div>
                        <p class="text-xs font-bold text-red-600 uppercase tracking-widest mb-1">Absent Today</p>
                        <p class="text-3xl font-bold text-red-700">{{ attendanceData.absentToday }}</p>
                    </div>
                    <div class="bg-amber-50 rounded-2xl p-6 shadow-sm border border-amber-100">
                        <div class="p-2 rounded-lg bg-amber-100 w-fit mb-3">
                            <Calendar class="w-5 h-5 text-amber-600" />
                        </div>
                        <p class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-1">On Leave</p>
                        <p class="text-3xl font-bold text-amber-700">{{ attendanceData.onLeave }}</p>
                    </div>
                    <div class="bg-blue-50 rounded-2xl p-6 shadow-sm border border-blue-100">
                        <div class="p-2 rounded-lg bg-blue-100 w-fit mb-3">
                            <Clock class="w-5 h-5 text-blue-600" />
                        </div>
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-1">Late Arrivals</p>
                        <p class="text-3xl font-bold text-blue-700">{{ attendanceData.lateArrivals }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Weekly Trend -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="font-bold text-[#015276] mb-4">Weekly Attendance Trend</h3>
                        <div class="space-y-3">
                            <div v-for="day in attendanceData.weeklyTrend" :key="day.day" class="flex items-center gap-4">
                                <span class="w-10 text-sm font-medium text-slate-600">{{ day.day }}</span>
                                <div class="flex-1 flex items-center gap-2">
                                    <div class="flex-1 h-4 bg-slate-100 rounded-full overflow-hidden flex">
                                        <div class="h-full bg-green-500" :style="{ width: `${(day.present / 224) * 100}%` }"></div>
                                        <div class="h-full bg-red-400" :style="{ width: `${(day.absent / 224) * 100}%` }"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-[#015276] w-12 text-right">{{ day.present }}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-center gap-6 mt-4 pt-4 border-t border-slate-200">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                <span class="text-xs text-slate-600">Present</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <span class="text-xs text-slate-600">Absent</span>
                            </div>
                        </div>
                    </div>

                    <!-- Leave Requests -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#015276]">Pending Leave Requests</h3>
                            <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">3 Pending</span>
                        </div>
                        <div class="space-y-3">
                            <div v-for="leave in attendanceData.leaveRequests" :key="leave.employee + leave.from" class="p-4 bg-white rounded-xl border border-slate-100">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-[#015276]">{{ leave.employee }}</p>
                                    <span :class="[
                                        'text-xs font-medium px-2 py-1 rounded-full',
                                        leave.status === 'Approved' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600'
                                    ]">{{ leave.status }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm text-slate-600">
                                    <span>{{ leave.type }}</span>
                                    <span>{{ leave.from }} - {{ leave.to }} ({{ leave.days }} days)</span>
                                </div>
                                <div v-if="leave.status === 'Pending'" class="flex items-center gap-2 mt-3">
                                    <button class="flex-1 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Approve</button>
                                    <button class="flex-1 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100">Reject</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================================== -->
            <!-- PAYROLL SECTION -->
            <!-- ================================================== -->
            <div v-if="activeSection === 'payroll'" class="space-y-6">
                
                <!-- Payroll KPIs -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-[#FFEEDE] w-fit mb-3">
                            <IndianRupee class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Payroll</p>
                        <p class="text-3xl font-bold text-[#015276]" v-html="formatRupee(payrollData.totalPayroll)"></p>
                    </div>
                    <div class="bg-green-50 rounded-2xl p-6 shadow-sm border border-green-100">
                        <div class="p-2 rounded-lg bg-green-100 w-fit mb-3">
                            <CheckCircle class="w-5 h-5 text-green-600" />
                        </div>
                        <p class="text-xs font-bold text-green-600 uppercase tracking-widest mb-1">Processed</p>
                        <p class="text-3xl font-bold text-green-700" v-html="formatRupee(payrollData.processed)"></p>
                    </div>
                    <div class="bg-amber-50 rounded-2xl p-6 shadow-sm border border-amber-100">
                        <div class="p-2 rounded-lg bg-amber-100 w-fit mb-3">
                            <Clock class="w-5 h-5 text-amber-600" />
                        </div>
                        <p class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-1">Pending</p>
                        <p class="text-3xl font-bold text-amber-700" v-html="formatRupee(payrollData.pending)"></p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-[#FFEEDE] w-fit mb-3">
                            <Calendar class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Last Run</p>
                        <p class="text-xl font-bold text-[#015276]">{{ payrollData.lastRunDate }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Payroll Breakdown -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="font-bold text-[#015276] mb-4">Payroll Breakdown</h3>
                        <div class="space-y-4">
                            <div v-for="item in payrollData.breakdown" :key="item.category" class="p-4 bg-white rounded-xl border border-slate-100">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-[#015276]">{{ item.category }}</p>
                                    <span class="font-bold text-[#015276]" v-html="formatRupee(item.amount)"></span>
                                </div>
                                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#ed905a] rounded-full" :style="{ width: `${item.percentage}%` }"></div>
                                </div>
                                <p class="text-xs text-slate-500 mt-1 text-right">{{ item.percentage }}%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Payslips -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#015276]">Recent Payslips</h3>
                            <button class="px-4 py-2 text-sm font-medium text-white bg-[#AC0C13] rounded-lg hover:bg-[#8a0a0f] transition-colors">
                                Run Payroll
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div v-for="slip in payrollData.recentPayslips" :key="slip.employee" class="p-4 bg-white rounded-xl border border-slate-100 flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-[#015276]">{{ slip.employee }}</p>
                                    <p class="text-xs text-slate-500">{{ slip.date }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-[#015276]" v-html="formatRupee(slip.amount)"></p>
                                    <span :class="[
                                        'text-xs font-medium px-2 py-0.5 rounded-full',
                                        slip.status === 'Paid' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600'
                                    ]">{{ slip.status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================================== -->
            <!-- PERFORMANCE SECTION -->
            <!-- ================================================== -->
            <div v-if="activeSection === 'performance'" class="space-y-6">
                
                <!-- Performance KPIs -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-[#FFEEDE] w-fit mb-3">
                            <Star class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Average Rating</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ performanceData.averageRating }}<span class="text-lg text-slate-400">/5</span></p>
                    </div>
                    <div class="bg-green-50 rounded-2xl p-6 shadow-sm border border-green-100">
                        <div class="p-2 rounded-lg bg-green-100 w-fit mb-3">
                            <CheckCircle class="w-5 h-5 text-green-600" />
                        </div>
                        <p class="text-xs font-bold text-green-600 uppercase tracking-widest mb-1">Reviews Completed</p>
                        <p class="text-3xl font-bold text-green-700">{{ performanceData.reviewsCompleted }}</p>
                    </div>
                    <div class="bg-amber-50 rounded-2xl p-6 shadow-sm border border-amber-100">
                        <div class="p-2 rounded-lg bg-amber-100 w-fit mb-3">
                            <Clock class="w-5 h-5 text-amber-600" />
                        </div>
                        <p class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-1">Reviews Pending</p>
                        <p class="text-3xl font-bold text-amber-700">{{ performanceData.reviewsPending }}</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-[#FFEEDE] w-fit mb-3">
                            <Award class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Top Performers</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ performanceData.topPerformers }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Rating Distribution -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="font-bold text-[#015276] mb-4">Rating Distribution</h3>
                        <div class="space-y-3">
                            <div v-for="rating in performanceData.ratings" :key="rating.level" class="flex items-center gap-3">
                                <span class="w-32 text-sm text-slate-600">{{ rating.level }}</span>
                                <div class="flex-1 h-4 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full" :style="{ width: `${(rating.count / 248) * 100}%`, backgroundColor: rating.color }"></div>
                                </div>
                                <span class="w-10 text-sm font-bold text-[#015276] text-right">{{ rating.count }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Reviews -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="font-bold text-[#015276] mb-4">Upcoming Reviews</h3>
                        <div class="space-y-3">
                            <div v-for="review in performanceData.upcomingReviews" :key="review.employee" class="p-4 bg-white rounded-xl border border-slate-100">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-[#015276]">{{ review.employee }}</p>
                                    <span :class="[
                                        'text-xs font-medium px-2 py-1 rounded-full',
                                        review.status === 'Scheduled' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600'
                                    ]">{{ review.status }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm text-slate-600">
                                    <span>{{ review.type }}</span>
                                    <span>Due: {{ review.dueDate }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================================== -->
            <!-- LEARNING & DEVELOPMENT SECTION -->
            <!-- ================================================== -->
            <div v-if="activeSection === 'learning'" class="space-y-6">
                
                <!-- L&D KPIs -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-[#FFEEDE] w-fit mb-3">
                            <BookOpen class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Active Programs</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ learningData.activePrograms }}</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-[#FFEEDE] w-fit mb-3">
                            <Users class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Enrolled</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ learningData.enrolledEmployees }}</p>
                    </div>
                    <div class="bg-green-50 rounded-2xl p-6 shadow-sm border border-green-100">
                        <div class="p-2 rounded-lg bg-green-100 w-fit mb-3">
                            <Percent class="w-5 h-5 text-green-600" />
                        </div>
                        <p class="text-xs font-bold text-green-600 uppercase tracking-widest mb-1">Completion Rate</p>
                        <p class="text-3xl font-bold text-green-700">{{ learningData.completionRate }}%</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-[#FFEEDE] w-fit mb-3">
                            <Award class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Certifications</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ learningData.certifications }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Training Programs -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#015276]">Training Programs</h3>
                            <button class="px-3 py-1.5 text-sm font-medium text-white bg-[#AC0C13] rounded-lg hover:bg-[#8a0a0f]">
                                Add Program
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div v-for="program in learningData.programs" :key="program.name" class="p-4 bg-white rounded-xl border border-slate-100">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-[#015276]">{{ program.name }}</p>
                                    <span :class="[
                                        'text-xs font-medium px-2 py-1 rounded-full',
                                        program.type === 'Mandatory' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600'
                                    ]">{{ program.type }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                                    <span>{{ program.enrolled }} enrolled</span>
                                    <span>{{ program.completed }} completed</span>
                                </div>
                                <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#ed905a] rounded-full" :style="{ width: `${(program.completed / program.enrolled) * 100}%` }"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Skill Gaps -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="font-bold text-[#015276] mb-4">Skill Gap Analysis</h3>
                        <div class="space-y-4">
                            <div v-for="skill in learningData.skillGaps" :key="skill.skill" class="flex items-center gap-4">
                                <span class="w-32 text-sm text-slate-600">{{ skill.skill }}</span>
                                <div class="flex-1 h-4 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-red-400 rounded-full" :style="{ width: `${skill.gap}%` }"></div>
                                </div>
                                <span class="text-sm font-bold text-red-600">{{ skill.gap }}%</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-4 text-center">Higher percentage indicates larger skill gap</p>
                    </div>
                </div>
            </div>

            <!-- ================================================== -->
            <!-- COMPLIANCE & POLICIES SECTION -->
            <!-- ================================================== -->
            <div v-if="activeSection === 'compliance'" class="space-y-6">
                
                <!-- Compliance KPIs -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-[#FFEEDE] w-fit mb-3">
                            <FileText class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Policies</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ complianceData.totalPolicies }}</p>
                    </div>
                    <div class="bg-green-50 rounded-2xl p-6 shadow-sm border border-green-100">
                        <div class="p-2 rounded-lg bg-green-100 w-fit mb-3">
                            <CheckCircle class="w-5 h-5 text-green-600" />
                        </div>
                        <p class="text-xs font-bold text-green-600 uppercase tracking-widest mb-1">Acknowledged</p>
                        <p class="text-3xl font-bold text-green-700">{{ complianceData.acknowledgements }}%</p>
                    </div>
                    <div class="bg-amber-50 rounded-2xl p-6 shadow-sm border border-amber-100">
                        <div class="p-2 rounded-lg bg-amber-100 w-fit mb-3">
                            <AlertCircle class="w-5 h-5 text-amber-600" />
                        </div>
                        <p class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-1">Pending</p>
                        <p class="text-3xl font-bold text-amber-700">{{ complianceData.pendingAcknowledgements }}%</p>
                    </div>
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="p-2 rounded-lg bg-[#FFEEDE] w-fit mb-3">
                            <Shield class="w-5 h-5 text-[#AC0C13]" />
                        </div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Upcoming Audits</p>
                        <p class="text-3xl font-bold text-[#015276]">{{ complianceData.upcomingAudits }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Policies -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-[#015276]">Company Policies</h3>
                            <button class="px-3 py-1.5 text-sm font-medium text-white bg-[#AC0C13] rounded-lg hover:bg-[#8a0a0f]">
                                Add Policy
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div v-for="policy in complianceData.policies" :key="policy.name" class="p-4 bg-white rounded-xl border border-slate-100">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="font-medium text-[#015276]">{{ policy.name }}</p>
                                    <span class="text-xs font-medium px-2 py-1 rounded-full bg-slate-100 text-slate-600">{{ policy.category }}</span>
                                </div>
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span>Updated: {{ policy.lastUpdated }}</span>
                                    <span class="text-green-600 font-medium">{{ policy.acknowledged }}% acknowledged</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Compliance Status -->
                    <div class="bg-[#FFFAF7] rounded-2xl p-6 shadow-sm border border-slate-100">
                        <h3 class="font-bold text-[#015276] mb-4">Compliance Status</h3>
                        <div class="space-y-3">
                            <div v-for="item in complianceData.complianceStatus" :key="item.item" 
                                 class="p-4 bg-white rounded-xl border border-slate-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <component :is="item.icon" :class="[
                                        'w-5 h-5',
                                        item.status === 'Compliant' ? 'text-green-600' : 'text-amber-600'
                                    ]" />
                                    <span class="font-medium text-[#015276]">{{ item.item }}</span>
                                </div>
                                <span :class="[
                                    'text-xs font-medium px-3 py-1 rounded-full',
                                    item.status === 'Compliant' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600'
                                ]">{{ item.status }}</span>
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
    font-family: 'Arial', sans-serif;
}
</style>
