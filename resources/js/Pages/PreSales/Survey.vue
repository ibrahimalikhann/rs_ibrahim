<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import { 
    Search,
    MapPin,
    Phone,
    Mail,
    Calendar,
    Clock,
    CheckCircle2,
    AlertCircle,
    Play,
    Eye,
    Filter,
    Download,
    RefreshCw,
    Building2,
    Users,
    BookOpen,
    GraduationCap,
    Star,
    ChevronRight,
    ChevronLeft,
    X,
    Camera,
    Upload,
    Navigation,
    Loader2,
    FileText,
    DollarSign,
    Car,
    UtensilsCrossed,
    Fuel,
    Plus,
    Trash2,
    Save,
    Send,
    Award,
    Target,
    TrendingUp,
    School,
    ClipboardList,
    UserCircle,
    Cake,
    Globe,
    Smartphone,
    Home,
    BookMarked,
    Microscope,
    Dumbbell,
    Library,
    Monitor,
    Wifi,
    ShieldCheck,
    Receipt,
    IndianRupee,
    BadgeCheck,
    Sparkles,
    Zap
} from 'lucide-vue-next';

// ============================================
// STATE
// ============================================

const searchQuery = ref('');
const activeFilter = ref('all');
const isLoading = ref(false);
const showSurveyModal = ref(false);
const showViewModal = ref(false);
const showVoucherModal = ref(false);
const currentStep = ref(1);
const totalSteps = 6;
const isRequestingLocation = ref(false);
const locationGranted = ref(false);
const isSubmitting = ref(false);
const selectedSchool = ref(null);
const viewingSurvey = ref(null);

// Survey Form Data
const surveyForm = ref({
    // Step 1: School Basic Info
    schoolName: '',
    schoolAddress: '',
    schoolType: '',
    board: '',
    establishedYear: '',
    totalStudents: '',
    totalTeachers: '',
    website: '',
    
    // Step 2: Principal & Contact
    principalName: '',
    principalPhone: '',
    principalEmail: '',
    coordinatorName: '',
    coordinatorPhone: '',
    schoolAnniversary: '',
    bestTimeToVisit: '',
    
    // Step 3: Infrastructure
    classrooms: '',
    computerLab: false,
    scienceLab: false,
    library: false,
    playground: false,
    smartClasses: '',
    internetConnectivity: '',
    
    // Step 4: Current Books Usage
    currentPublishers: [],
    subjectsUsing: [],
    satisfactionLevel: '',
    annualBookBudget: '',
    decisionMaker: '',
    purchaseCycle: '',
    
    // Step 5: Demand Assessment
    interestedSubjects: [],
    estimatedQuantity: '',
    preferredPriceRange: '',
    sampleRequested: false,
    followUpDate: '',
    competitorStrengths: '',
    
    // Step 6: Additional Info
    additionalNotes: '',
    schoolPhoto: null,
    rating: 5,
    potential: 'medium'
});

// Voucher Form
const voucherForm = ref({
    category: '',
    amount: '',
    purpose: '',
    remarks: ''
});

const voucherList = ref([]);

// ============================================
// FAKE DATA - Schools List
// ============================================

const schools = ref([
    {
        id: 1,
        name: 'Delhi Public School',
        address: 'Sector 24, Dwarka, New Delhi',
        type: 'Private',
        board: 'CBSE',
        students: 2500,
        status: 'completed',
        lastSurvey: '2026-01-15',
        principal: 'Dr. Ramesh Sharma',
        phone: '+91 98765 43210',
        rating: 5,
        potential: 'high',
        surveyData: {
            principalName: 'Dr. Ramesh Sharma',
            principalPhone: '+91 98765 43210',
            schoolAnniversary: '15th March',
            totalStudents: '2500',
            currentPublishers: ['NCERT', 'S. Chand'],
            satisfactionLevel: 'moderate',
            interestedSubjects: ['English', 'Mathematics', 'Science'],
            estimatedQuantity: '5000',
            rating: 5,
            potential: 'high',
            notes: 'Very interested in our English supplementary materials. Principal requested samples for Classes 6-8.',
            vouchers: [
                { category: 'Fuel', amount: 450, purpose: 'Travel to school', remarks: 'Round trip 45km' },
                { category: 'Food', amount: 280, purpose: 'Lunch during visit', remarks: 'Extended meeting' }
            ]
        }
    },
    {
        id: 2,
        name: 'St. Mary\'s Convent School',
        address: 'Civil Lines, New Delhi',
        type: 'Private',
        board: 'ICSE',
        students: 1800,
        status: 'completed',
        lastSurvey: '2026-01-18',
        principal: 'Sr. Margaret Thomas',
        phone: '+91 98765 12345',
        rating: 4,
        potential: 'high',
        surveyData: {
            principalName: 'Sr. Margaret Thomas',
            principalPhone: '+91 98765 12345',
            schoolAnniversary: '8th September',
            totalStudents: '1800',
            currentPublishers: ['Oxford', 'Cambridge'],
            satisfactionLevel: 'satisfied',
            interestedSubjects: ['English Literature', 'Grammar'],
            estimatedQuantity: '3500',
            rating: 4,
            potential: 'high',
            notes: 'Already using premium publishers. May consider switching if pricing is competitive.',
            vouchers: [
                { category: 'Fuel', amount: 320, purpose: 'School visit', remarks: 'One way Metro + Auto' }
            ]
        }
    },
    {
        id: 3,
        name: 'Govt. Senior Secondary School',
        address: 'Rohini Sector 11, New Delhi',
        type: 'Government',
        board: 'CBSE',
        students: 3200,
        status: 'completed',
        lastSurvey: '2026-01-22',
        principal: 'Mr. Vijay Kumar',
        phone: '+91 99887 65432',
        rating: 3,
        potential: 'medium',
        surveyData: {
            principalName: 'Mr. Vijay Kumar',
            principalPhone: '+91 99887 65432',
            schoolAnniversary: '26th January',
            totalStudents: '3200',
            currentPublishers: ['NCERT'],
            satisfactionLevel: 'satisfied',
            interestedSubjects: ['Hindi', 'Social Science'],
            estimatedQuantity: '8000',
            rating: 3,
            potential: 'medium',
            notes: 'Government procurement process. Need to follow up with education department.',
            vouchers: [
                { category: 'Fuel', amount: 280, purpose: 'School survey', remarks: 'Rohini visit' },
                { category: 'Food', amount: 150, purpose: 'Refreshments', remarks: 'Tea with staff' }
            ]
        }
    },
    {
        id: 4,
        name: 'Modern Academy',
        address: 'Mayur Vihar Phase 2, New Delhi',
        type: 'Private',
        board: 'CBSE',
        students: 1200,
        status: 'completed',
        lastSurvey: '2026-01-25',
        principal: 'Mrs. Sunita Agarwal',
        phone: '+91 88776 54321',
        rating: 4,
        potential: 'high',
        surveyData: {
            principalName: 'Mrs. Sunita Agarwal',
            principalPhone: '+91 88776 54321',
            schoolAnniversary: '5th November',
            totalStudents: '1200',
            currentPublishers: ['Ratna Sagar', 'NCERT'],
            satisfactionLevel: 'very_satisfied',
            interestedSubjects: ['Complete Set', 'Workbooks'],
            estimatedQuantity: '2500',
            rating: 4,
            potential: 'high',
            notes: 'Already our customer! Very satisfied. Looking to expand to higher classes.',
            vouchers: [
                { category: 'Fuel', amount: 380, purpose: 'Customer visit', remarks: 'Relationship maintenance' }
            ]
        }
    },
    {
        id: 5,
        name: 'Kendriya Vidyalaya',
        address: 'Andrews Ganj, New Delhi',
        type: 'Government',
        board: 'CBSE',
        students: 2800,
        status: 'pending',
        lastSurvey: null,
        principal: 'Mr. R.K. Singh',
        phone: '+91 99001 23456',
        rating: null,
        potential: null
    },
    {
        id: 6,
        name: 'Ryan International School',
        address: 'Vasant Kunj, New Delhi',
        type: 'Private',
        board: 'CBSE',
        students: 2200,
        status: 'pending',
        lastSurvey: null,
        principal: 'Dr. Manoj Sharma',
        phone: '+91 98123 45678',
        rating: null,
        potential: null
    },
    {
        id: 7,
        name: 'The Heritage School',
        address: 'Vasant Kunj Sector B, New Delhi',
        type: 'Private',
        board: 'ICSE',
        students: 1500,
        status: 'pending',
        lastSurvey: null,
        principal: 'Mrs. Kavita Mehta',
        phone: '+91 99876 54321',
        rating: null,
        potential: null
    },
    {
        id: 8,
        name: 'Springdales School',
        address: 'Pusa Road, New Delhi',
        type: 'Private',
        board: 'CBSE',
        students: 3000,
        status: 'pending',
        lastSurvey: null,
        principal: 'Dr. Ameeta Mulla Wattal',
        phone: '+91 98765 00001',
        rating: null,
        potential: null
    },
    {
        id: 9,
        name: 'Bal Bharati Public School',
        address: 'Pitampura, New Delhi',
        type: 'Private',
        board: 'CBSE',
        students: 2600,
        status: 'in_progress',
        lastSurvey: null,
        principal: 'Mrs. Rekha Sharma',
        phone: '+91 99112 23344',
        rating: null,
        potential: null
    },
    {
        id: 10,
        name: 'Army Public School',
        address: 'Dhaula Kuan, New Delhi',
        type: 'Government',
        board: 'CBSE',
        students: 2100,
        status: 'pending',
        lastSurvey: null,
        principal: 'Col. (Retd.) Suresh Tandon',
        phone: '+91 98765 99999',
        rating: null,
        potential: null
    }
]);

// ============================================
// COMPUTED
// ============================================

const filteredSchools = computed(() => {
    let result = schools.value;
    
    // Filter by status
    if (activeFilter.value !== 'all') {
        result = result.filter(s => s.status === activeFilter.value);
    }
    
    // Filter by search
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase();
        result = result.filter(s => 
            s.name.toLowerCase().includes(query) ||
            s.address.toLowerCase().includes(query) ||
            s.principal.toLowerCase().includes(query)
        );
    }
    
    return result;
});

const surveyStats = computed(() => {
    const completed = schools.value.filter(s => s.status === 'completed').length;
    const pending = schools.value.filter(s => s.status === 'pending').length;
    const inProgress = schools.value.filter(s => s.status === 'in_progress').length;
    const total = schools.value.length;
    
    return { completed, pending, inProgress, total };
});

const stepProgress = computed(() => {
    return (currentStep.value / totalSteps) * 100;
});

// ============================================
// OPTIONS DATA
// ============================================

const schoolTypes = ['Private', 'Government', 'Semi-Government', 'International', 'Aided'];
const boards = ['CBSE', 'ICSE', 'State Board', 'IB', 'Cambridge', 'Other'];
const publishers = ['NCERT', 'S. Chand', 'Oxford', 'Cambridge', 'Pearson', 'Ratna Sagar', 'Arihant', 'Prachi', 'Other'];
const subjects = ['English', 'Hindi', 'Mathematics', 'Science', 'Social Science', 'Sanskrit', 'Computer Science', 'General Knowledge', 'Environmental Studies', 'Art & Craft'];
const satisfactionLevels = [
    { value: 'very_satisfied', label: 'Very Satisfied' },
    { value: 'satisfied', label: 'Satisfied' },
    { value: 'moderate', label: 'Moderate' },
    { value: 'dissatisfied', label: 'Dissatisfied' },
    { value: 'very_dissatisfied', label: 'Very Dissatisfied' }
];
const voucherCategories = [
    { value: 'Fuel', label: 'Fuel / Petrol', icon: Fuel },
    { value: 'Food', label: 'Food & Refreshments', icon: UtensilsCrossed },
    { value: 'Travel', label: 'Travel (Metro/Bus/Auto)', icon: Car },
    { value: 'Parking', label: 'Parking Charges', icon: Car },
    { value: 'Stationery', label: 'Stationery / Printing', icon: FileText },
    { value: 'Other', label: 'Other Expenses', icon: Receipt }
];

// ============================================
// FUNCTIONS
// ============================================

const startSurvey = async (school) => {
    selectedSchool.value = school;
    isLoading.value = true;
    showSurveyModal.value = true;
    currentStep.value = 0;
    
    // Reset form
    surveyForm.value = {
        schoolName: school.name,
        schoolAddress: school.address,
        schoolType: school.type,
        board: school.board,
        establishedYear: '',
        totalStudents: school.students.toString(),
        totalTeachers: '',
        website: '',
        principalName: school.principal,
        principalPhone: school.phone,
        principalEmail: '',
        coordinatorName: '',
        coordinatorPhone: '',
        schoolAnniversary: '',
        bestTimeToVisit: '',
        classrooms: '',
        computerLab: false,
        scienceLab: false,
        library: false,
        playground: false,
        smartClasses: '',
        internetConnectivity: '',
        currentPublishers: [],
        subjectsUsing: [],
        satisfactionLevel: '',
        annualBookBudget: '',
        decisionMaker: '',
        purchaseCycle: '',
        interestedSubjects: [],
        estimatedQuantity: '',
        preferredPriceRange: '',
        sampleRequested: false,
        followUpDate: '',
        competitorStrengths: '',
        additionalNotes: '',
        schoolPhoto: null,
        rating: 5,
        potential: 'medium'
    };
    voucherList.value = [];
    locationGranted.value = false;
    
    // Simulate loading
    await new Promise(resolve => setTimeout(resolve, 1500));
    isLoading.value = false;
};

const requestLocation = async () => {
    isRequestingLocation.value = true;
    
    // Simulate location request
    await new Promise(resolve => setTimeout(resolve, 2000));
    
    locationGranted.value = true;
    isRequestingLocation.value = false;
    currentStep.value = 1;
};

const nextStep = () => {
    if (currentStep.value < totalSteps) {
        currentStep.value++;
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

const openVoucherModal = () => {
    voucherForm.value = { category: '', amount: '', purpose: '', remarks: '' };
    showVoucherModal.value = true;
};

const addVoucher = () => {
    if (voucherForm.value.category && voucherForm.value.amount) {
        voucherList.value.push({ ...voucherForm.value });
        showVoucherModal.value = false;
    }
};

const removeVoucher = (index) => {
    voucherList.value.splice(index, 1);
};

const submitSurvey = async () => {
    isSubmitting.value = true;
    
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 2000));
    
    // Update school status
    const schoolIndex = schools.value.findIndex(s => s.id === selectedSchool.value.id);
    if (schoolIndex !== -1) {
        schools.value[schoolIndex].status = 'completed';
        schools.value[schoolIndex].lastSurvey = new Date().toISOString().split('T')[0];
        schools.value[schoolIndex].rating = surveyForm.value.rating;
        schools.value[schoolIndex].potential = surveyForm.value.potential;
        schools.value[schoolIndex].surveyData = {
            ...surveyForm.value,
            vouchers: [...voucherList.value]
        };
    }
    
    isSubmitting.value = false;
    showSurveyModal.value = false;
    currentStep.value = 1;
};

const viewSurvey = (school) => {
    viewingSurvey.value = school;
    showViewModal.value = true;
};

const closeModal = () => {
    showSurveyModal.value = false;
    showViewModal.value = false;
    currentStep.value = 1;
    locationGranted.value = false;
};

const getStatusColor = (status) => {
    switch(status) {
        case 'completed': return 'bg-emerald-100 text-emerald-700 border-emerald-200';
        case 'pending': return 'bg-amber-100 text-amber-700 border-amber-200';
        case 'in_progress': return 'bg-blue-100 text-blue-700 border-blue-200';
        default: return 'bg-slate-100 text-slate-700 border-slate-200';
    }
};

const getStatusLabel = (status) => {
    switch(status) {
        case 'completed': return 'Completed';
        case 'pending': return 'Pending';
        case 'in_progress': return 'In Progress';
        default: return status;
    }
};

const getPotentialColor = (potential) => {
    switch(potential) {
        case 'high': return 'bg-emerald-500';
        case 'medium': return 'bg-amber-500';
        case 'low': return 'bg-red-500';
        default: return 'bg-slate-400';
    }
};

const formatDate = (dateStr) => {
    if (!dateStr) return '-';
    return new Date(dateStr).toLocaleDateString('en-IN', { 
        day: 'numeric', 
        month: 'short', 
        year: 'numeric' 
    });
};

const totalVoucherAmount = computed(() => {
    return voucherList.value.reduce((sum, v) => sum + parseFloat(v.amount || 0), 0);
});
</script>

<template>
    <Head title="School Survey" />

    <AuthenticatedLayout>
        <div class="max-w-full mx-auto space-y-6">

            <!-- PAGE HEADER -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-lg">
                            <ClipboardList class="w-6 h-6 text-white" />
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900">School Survey</h1>
                            <p class="text-sm text-slate-500">Conduct surveys and gather school information</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 flex items-center gap-2 shadow-sm transition-all">
                        <Download class="w-4 h-4" /> Export
                    </button>
                    <button class="px-4 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl text-sm font-bold text-white hover:from-orange-600 hover:to-orange-700 flex items-center gap-2 shadow-md transition-all">
                        <RefreshCw class="w-4 h-4" /> Sync
                    </button>
                </div>
            </div>

            <!-- STATS CARDS -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-[#FFFAF7] border border-slate-100 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-1.5 bg-[#FFEEDE] rounded">
                            <School class="w-6 h-6 text-[rgb(143,5,7)]" />
                        </div>
                        <span class="text-xs font-bold text-[#015276] uppercase">Total</span>
                    </div>
                    <p class="text-3xl font-bold text-[#015276]">{{ surveyStats.total }}</p>
                    <p class="text-xs text-slate-500 mt-1">Schools Assigned</p>
                </div>
                <div class="bg-[#FFFAF7] border border-slate-100 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-1.5 bg-[#FFEEDE] rounded">
                            <CheckCircle2 class="w-6 h-6 text-[rgb(143,5,7)]" />
                        </div>
                        <span class="text-xs font-bold text-[#015276] uppercase">Done</span>
                    </div>
                    <p class="text-3xl font-bold text-[#015276]">{{ surveyStats.completed }}</p>
                    <p class="text-xs text-slate-500 mt-1">Surveys Completed</p>
                </div>
                <div class="bg-[#FFFAF7] border border-slate-100 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-1.5 bg-[#FFEEDE] rounded">
                            <Clock class="w-6 h-6 text-[rgb(143,5,7)]" />
                        </div>
                        <span class="text-xs font-bold text-[#015276] uppercase">Pending</span>
                    </div>
                    <p class="text-3xl font-bold text-[#015276]">{{ surveyStats.pending }}</p>
                    <p class="text-xs text-slate-500 mt-1">Awaiting Survey</p>
                </div>
                <div class="bg-[#FFFAF7] border border-slate-100 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-1.5 bg-[#FFEEDE] rounded">
                            <Target class="w-6 h-6 text-[rgb(143,5,7)]" />
                        </div>
                        <span class="text-xs font-bold text-[#015276] uppercase">Progress</span>
                    </div>
                    <p class="text-3xl font-bold text-[#015276]">{{ Math.round((surveyStats.completed / surveyStats.total) * 100) }}%</p>
                    <p class="text-xs text-slate-500 mt-1">Completion Rate</p>
                </div>
            </div>

            <!-- SEARCH & FILTERS -->
            <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
                <div class="flex flex-col gap-4">
                    <!-- Search -->
                    <div class="flex-1 relative">
                        <Search class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" />
                        <input 
                            v-model="searchQuery"
                            type="text" 
                            placeholder="Search schools by name, address, or principal..." 
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500"
                        />
                    </div>
                    
                    <!-- Status Filter Pills -->
                    <div class="flex gap-2 flex-wrap">
                        <button 
                            @click="activeFilter = 'all'"
                            :class="[
                                'px-4 py-2.5 rounded-xl text-sm font-medium transition-all',
                                activeFilter === 'all' 
                                    ? 'bg-slate-900 text-white' 
                                    : 'bg-slate-100 text-slate-600 hover:bg-slate-200'
                            ]"
                        >
                            All ({{ surveyStats.total }})
                        </button>
                        <button 
                            @click="activeFilter = 'pending'"
                            :class="[
                                'px-4 py-2.5 rounded-xl text-sm font-medium transition-all',
                                activeFilter === 'pending' 
                                    ? 'bg-amber-500 text-white' 
                                    : 'bg-amber-50 text-amber-700 hover:bg-amber-100'
                            ]"
                        >
                            Pending ({{ surveyStats.pending }})
                        </button>
                        <button 
                            @click="activeFilter = 'completed'"
                            :class="[
                                'px-4 py-2.5 rounded-xl text-sm font-medium transition-all',
                                activeFilter === 'completed' 
                                    ? 'bg-emerald-500 text-white' 
                                    : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100'
                            ]"
                        >
                            Completed ({{ surveyStats.completed }})
                        </button>
                    </div>

                    <!-- Advanced Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <!-- Board Wise Filter -->
                        <div class="bg-[#FFFAF7] rounded-xl p-4 border border-slate-100">
                            <label class="text-xs font-bold uppercase text-[#015276] tracking-widest mb-2 block">Board Wise</label>
                            <select class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-[#015276] font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20">
                                <option>All Boards</option>
                                <option>CBSE</option>
                                <option>ICSE</option>
                                <option>State Board</option>
                            </select>
                        </div>

                        <!-- Size Wise Filter -->
                        <div class="bg-[#FFFAF7] rounded-xl p-4 border border-slate-100">
                            <label class="text-xs font-bold uppercase text-[#015276] tracking-widest mb-2 block">Size Wise</label>
                            <select class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-[#015276] font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20">
                                <option>All Sizes</option>
                                <option>Small (< 500)</option>
                                <option>Medium (500-2000)</option>
                                <option>Large (> 2000)</option>
                            </select>
                        </div>

                        <!-- Potential Wise Filter -->
                        <div class="bg-[#FFFAF7] rounded-xl p-4 border border-slate-100">
                            <label class="text-xs font-bold uppercase text-[#015276] tracking-widest mb-2 block">Potential Wise</label>
                            <select class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-[#015276] font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20">
                                <option>All Potential</option>
                                <option>High</option>
                                <option>Medium</option>
                                <option>Low</option>
                            </select>
                        </div>

                        <!-- Type Wise Filter -->
                        <div class="bg-[#FFFAF7] rounded-xl p-4 border border-slate-100">
                            <label class="text-xs font-bold uppercase text-[#015276] tracking-widest mb-2 block">Type Wise</label>
                            <select class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm text-[#015276] font-medium focus:outline-none focus:ring-2 focus:ring-orange-500/20">
                                <option>All Types</option>
                                <option>Private</option>
                                <option>Government</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SCHOOLS LIST -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <Building2 class="w-5 h-5 text-orange-500" />
                        Schools List
                        <span class="text-sm font-normal text-slate-500">({{ filteredSchools.length }} schools)</span>
                    </h3>
                </div>
                
                <div class="divide-y divide-slate-100">
                    <div 
                        v-for="school in filteredSchools" 
                        :key="school.id"
                        class="p-5 hover:bg-slate-50 transition-colors"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <!-- School Info -->
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg">
                                        {{ school.name.charAt(0) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-lg">{{ school.name }}</h4>
                                        <div class="flex items-center gap-2 text-sm text-slate-500">
                                            <MapPin class="w-4 h-4" />
                                            <span>{{ school.address }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap gap-4 mt-3 text-sm">
                                    <div class="flex items-center gap-1.5 text-slate-600">
                                        <GraduationCap class="w-4 h-4 text-slate-400" />
                                        <span>{{ school.board }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-slate-600">
                                        <Users class="w-4 h-4 text-slate-400" />
                                        <span>{{ school.students.toLocaleString() }} Students</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-slate-600">
                                        <UserCircle class="w-4 h-4 text-slate-400" />
                                        <span>{{ school.principal }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-slate-600">
                                        <Phone class="w-4 h-4 text-slate-400" />
                                        <span>{{ school.phone }}</span>
                                    </div>
                                </div>
                                
                                <!-- Rating & Potential for Completed -->
                                <div v-if="school.status === 'completed'" class="flex items-center gap-4 mt-3">
                                    <div class="flex items-center gap-1">
                                        <Star v-for="i in 5" :key="i" :class="['w-4 h-4', i <= school.rating ? 'text-amber-400 fill-amber-400' : 'text-slate-300']" />
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-medium text-slate-500">Potential:</span>
                                        <span :class="['text-xs font-bold px-2 py-0.5 rounded-full text-white', getPotentialColor(school.potential)]">
                                            {{ school.potential?.toUpperCase() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Status & Actions -->
                            <div class="flex flex-col items-end gap-3">
                                <span :class="['px-3 py-1.5 rounded-lg text-xs font-bold border', getStatusColor(school.status)]">
                                    {{ getStatusLabel(school.status) }}
                                </span>
                                
                                <div v-if="school.lastSurvey" class="text-xs text-slate-500 flex items-center gap-1">
                                    <Calendar class="w-3.5 h-3.5" />
                                    {{ formatDate(school.lastSurvey) }}
                                </div>
                                
                                <div class="flex gap-2">
                                    <button 
                                        v-if="school.status === 'completed'"
                                        @click="viewSurvey(school)"
                                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 rounded-lg text-sm font-medium text-slate-700 flex items-center gap-2 transition-all"
                                    >
                                        <Eye class="w-4 h-4" /> View
                                    </button>
                                    <button 
                                        v-if="school.status !== 'completed'"
                                        @click="startSurvey(school)"
                                        class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-lg text-sm font-bold text-white flex items-center gap-2 shadow-md transition-all"
                                    >
                                        <Play class="w-4 h-4" /> Start Survey
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================== -->
        <!-- SURVEY MODAL -->
        <!-- ============================================== -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-all duration-200 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div 
                    v-if="showSurveyModal" 
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
                    @click.self="closeModal"
                >
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden flex flex-col">
                        
                        <!-- Modal Header -->
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4 text-white flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <ClipboardList class="w-6 h-6" />
                                <div>
                                    <h3 class="font-bold text-lg">School Survey</h3>
                                    <p class="text-sm text-orange-100">{{ selectedSchool?.name }}</p>
                                </div>
                            </div>
                            <button @click="closeModal" class="p-2 hover:bg-white/20 rounded-lg transition-colors">
                                <X class="w-5 h-5" />
                            </button>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div v-if="currentStep > 0" class="px-6 py-3 bg-slate-50 border-b border-slate-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-slate-600">Step {{ currentStep }} of {{ totalSteps }}</span>
                                <span class="text-sm font-bold text-orange-600">{{ Math.round(stepProgress) }}%</span>
                            </div>
                            <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                                <div 
                                    class="h-full bg-gradient-to-r from-orange-500 to-orange-600 transition-all duration-500"
                                    :style="{ width: stepProgress + '%' }"
                                ></div>
                            </div>
                        </div>
                        
                        <!-- Modal Body -->
                        <div class="flex-1 overflow-y-auto p-6">
                            
                            <!-- Loading State -->
                            <div v-if="isLoading" class="flex flex-col items-center justify-center py-16">
                                <div class="relative">
                                    <div class="w-20 h-20 rounded-full border-4 border-orange-100"></div>
                                    <div class="absolute inset-0 w-20 h-20 rounded-full border-4 border-orange-500 border-t-transparent animate-spin"></div>
                                </div>
                                <p class="mt-6 text-lg font-bold text-slate-700">Preparing Survey...</p>
                                <p class="text-sm text-slate-500 mt-2">Loading school information</p>
                            </div>
                            
                            <!-- Location Permission Step -->
                            <div v-else-if="currentStep === 0 && !locationGranted" class="flex flex-col items-center justify-center py-12">
                                <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center mb-6">
                                    <Navigation class="w-12 h-12 text-blue-600" />
                                </div>
                                <h4 class="text-xl font-bold text-slate-800 mb-2">Enable Location Access</h4>
                                <p class="text-slate-500 text-center max-w-sm mb-6">
                                    We need your location to verify survey location and for accurate record keeping.
                                </p>
                                <button 
                                    @click="requestLocation"
                                    :disabled="isRequestingLocation"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-xl text-white font-bold flex items-center gap-2 shadow-lg transition-all disabled:opacity-50"
                                >
                                    <Loader2 v-if="isRequestingLocation" class="w-5 h-5 animate-spin" />
                                    <MapPin v-else class="w-5 h-5" />
                                    {{ isRequestingLocation ? 'Requesting...' : 'Grant Location Permission' }}
                                </button>
                            </div>
                            
                            <!-- Step 1: School Basic Info -->
                            <div v-else-if="currentStep === 1" class="space-y-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center">
                                        <School class="w-5 h-5 text-orange-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">School Information</h4>
                                        <p class="text-sm text-slate-500">Basic details about the school</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">School Name *</label>
                                        <input v-model="surveyForm.schoolName" type="text" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Address *</label>
                                        <input v-model="surveyForm.schoolAddress" type="text" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">School Type *</label>
                                        <select v-model="surveyForm.schoolType" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                                            <option value="">Select Type</option>
                                            <option v-for="type in schoolTypes" :key="type" :value="type">{{ type }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Board *</label>
                                        <select v-model="surveyForm.board" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                                            <option value="">Select Board</option>
                                            <option v-for="b in boards" :key="b" :value="b">{{ b }}</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Established Year</label>
                                        <input v-model="surveyForm.establishedYear" type="number" placeholder="e.g., 1990" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Website</label>
                                        <input v-model="surveyForm.website" type="url" placeholder="https://" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Total Students *</label>
                                        <input v-model="surveyForm.totalStudents" type="number" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Total Teachers</label>
                                        <input v-model="surveyForm.totalTeachers" type="number" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 2: Principal & Contact -->
                            <div v-else-if="currentStep === 2" class="space-y-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                                        <UserCircle class="w-5 h-5 text-blue-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">Principal & Contact Details</h4>
                                        <p class="text-sm text-slate-500">Key contacts at the school</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Principal Name *</label>
                                        <input v-model="surveyForm.principalName" type="text" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Principal Phone *</label>
                                        <input v-model="surveyForm.principalPhone" type="tel" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Principal Email</label>
                                        <input v-model="surveyForm.principalEmail" type="email" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">
                                            <span class="flex items-center gap-2">
                                                <Cake class="w-4 h-4 text-pink-500" />
                                                School Anniversary
                                            </span>
                                        </label>
                                        <input v-model="surveyForm.schoolAnniversary" type="text" placeholder="e.g., 15th March" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Coordinator Name</label>
                                        <input v-model="surveyForm.coordinatorName" type="text" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Coordinator Phone</label>
                                        <input v-model="surveyForm.coordinatorPhone" type="tel" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Best Time to Visit</label>
                                        <input v-model="surveyForm.bestTimeToVisit" type="text" placeholder="e.g., Monday to Friday, 10 AM - 2 PM" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 3: Infrastructure -->
                            <div v-else-if="currentStep === 3" class="space-y-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                        <Building2 class="w-5 h-5 text-emerald-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">Infrastructure Assessment</h4>
                                        <p class="text-sm text-slate-500">School facilities and resources</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Number of Classrooms</label>
                                        <input v-model="surveyForm.classrooms" type="number" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Smart Classes</label>
                                        <input v-model="surveyForm.smartClasses" type="number" placeholder="Number of smart classrooms" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Internet Connectivity</label>
                                        <select v-model="surveyForm.internetConnectivity" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                                            <option value="">Select</option>
                                            <option value="high_speed">High-Speed Fiber</option>
                                            <option value="broadband">Broadband</option>
                                            <option value="basic">Basic Internet</option>
                                            <option value="none">No Internet</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-3">Available Facilities</label>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors" :class="surveyForm.computerLab ? 'border-orange-500 bg-orange-50' : ''">
                                            <input type="checkbox" v-model="surveyForm.computerLab" class="w-5 h-5 rounded border-slate-300 text-orange-500 focus:ring-orange-500" />
                                            <div class="flex items-center gap-2">
                                                <Monitor class="w-5 h-5 text-slate-500" />
                                                <span class="text-sm font-medium text-slate-700">Computer Lab</span>
                                            </div>
                                        </label>
                                        <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors" :class="surveyForm.scienceLab ? 'border-orange-500 bg-orange-50' : ''">
                                            <input type="checkbox" v-model="surveyForm.scienceLab" class="w-5 h-5 rounded border-slate-300 text-orange-500 focus:ring-orange-500" />
                                            <div class="flex items-center gap-2">
                                                <Microscope class="w-5 h-5 text-slate-500" />
                                                <span class="text-sm font-medium text-slate-700">Science Lab</span>
                                            </div>
                                        </label>
                                        <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors" :class="surveyForm.library ? 'border-orange-500 bg-orange-50' : ''">
                                            <input type="checkbox" v-model="surveyForm.library" class="w-5 h-5 rounded border-slate-300 text-orange-500 focus:ring-orange-500" />
                                            <div class="flex items-center gap-2">
                                                <Library class="w-5 h-5 text-slate-500" />
                                                <span class="text-sm font-medium text-slate-700">Library</span>
                                            </div>
                                        </label>
                                        <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors" :class="surveyForm.playground ? 'border-orange-500 bg-orange-50' : ''">
                                            <input type="checkbox" v-model="surveyForm.playground" class="w-5 h-5 rounded border-slate-300 text-orange-500 focus:ring-orange-500" />
                                            <div class="flex items-center gap-2">
                                                <Dumbbell class="w-5 h-5 text-slate-500" />
                                                <span class="text-sm font-medium text-slate-700">Playground</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 4: Current Books Usage -->
                            <div v-else-if="currentStep === 4" class="space-y-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                                        <BookOpen class="w-5 h-5 text-purple-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">Current Books & Publishers</h4>
                                        <p class="text-sm text-slate-500">Understanding current usage patterns</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-3">Current Publishers Used</label>
                                        <div class="flex flex-wrap gap-2">
                                            <label 
                                                v-for="pub in publishers" 
                                                :key="pub"
                                                :class="[
                                                    'px-4 py-2 rounded-xl text-sm font-medium cursor-pointer transition-all border',
                                                    surveyForm.currentPublishers.includes(pub) 
                                                        ? 'bg-purple-500 text-white border-purple-500' 
                                                        : 'bg-white text-slate-600 border-slate-200 hover:border-purple-300'
                                                ]"
                                            >
                                                <input 
                                                    type="checkbox" 
                                                    :value="pub" 
                                                    v-model="surveyForm.currentPublishers" 
                                                    class="sr-only"
                                                />
                                                {{ pub }}
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-3">Subjects Currently Using External Books</label>
                                        <div class="flex flex-wrap gap-2">
                                            <label 
                                                v-for="sub in subjects" 
                                                :key="sub"
                                                :class="[
                                                    'px-4 py-2 rounded-xl text-sm font-medium cursor-pointer transition-all border',
                                                    surveyForm.subjectsUsing.includes(sub) 
                                                        ? 'bg-blue-500 text-white border-blue-500' 
                                                        : 'bg-white text-slate-600 border-slate-200 hover:border-blue-300'
                                                ]"
                                            >
                                                <input 
                                                    type="checkbox" 
                                                    :value="sub" 
                                                    v-model="surveyForm.subjectsUsing" 
                                                    class="sr-only"
                                                />
                                                {{ sub }}
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Satisfaction with Current Publishers</label>
                                            <select v-model="surveyForm.satisfactionLevel" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                                                <option value="">Select Level</option>
                                                <option v-for="level in satisfactionLevels" :key="level.value" :value="level.value">{{ level.label }}</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Annual Book Budget (Approx.)</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 rupee-symbol">₹</span>
                                                <input v-model="surveyForm.annualBookBudget" type="text" placeholder="e.g., 5,00,000" class="w-full pl-8 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Decision Maker</label>
                                            <select v-model="surveyForm.decisionMaker" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                                                <option value="">Select</option>
                                                <option value="principal">Principal</option>
                                                <option value="coordinator">Academic Coordinator</option>
                                                <option value="committee">Book Committee</option>
                                                <option value="management">Management</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Purchase Cycle</label>
                                            <select v-model="surveyForm.purchaseCycle" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                                                <option value="">Select</option>
                                                <option value="march">March (New Session)</option>
                                                <option value="april">April</option>
                                                <option value="june">June (After Summer)</option>
                                                <option value="yearly">Throughout Year</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 5: Demand Assessment -->
                            <div v-else-if="currentStep === 5" class="space-y-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                                        <Target class="w-5 h-5 text-amber-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">Demand Assessment</h4>
                                        <p class="text-sm text-slate-500">Potential business opportunity</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-3">Interested in Our Books (Subjects)</label>
                                        <div class="flex flex-wrap gap-2">
                                            <label 
                                                v-for="sub in subjects" 
                                                :key="sub"
                                                :class="[
                                                    'px-4 py-2 rounded-xl text-sm font-medium cursor-pointer transition-all border',
                                                    surveyForm.interestedSubjects.includes(sub) 
                                                        ? 'bg-amber-500 text-white border-amber-500' 
                                                        : 'bg-white text-slate-600 border-slate-200 hover:border-amber-300'
                                                ]"
                                            >
                                                <input 
                                                    type="checkbox" 
                                                    :value="sub" 
                                                    v-model="surveyForm.interestedSubjects" 
                                                    class="sr-only"
                                                />
                                                {{ sub }}
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Estimated Quantity (Books/Year)</label>
                                            <input v-model="surveyForm.estimatedQuantity" type="text" placeholder="e.g., 5000" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Preferred Price Range</label>
                                            <select v-model="surveyForm.preferredPriceRange" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                                                <option value="">Select</option>
                                                <option value="budget">Budget (Under ₹200)</option>
                                                <option value="mid">Mid-Range (₹200-400)</option>
                                                <option value="premium">Premium (Above ₹400)</option>
                                                <option value="flexible">Flexible</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Follow-up Date</label>
                                            <input v-model="surveyForm.followUpDate" type="date" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                        </div>
                                        <div class="flex items-center">
                                            <label class="flex items-center gap-3 p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors w-full" :class="surveyForm.sampleRequested ? 'border-orange-500 bg-orange-50' : ''">
                                                <input type="checkbox" v-model="surveyForm.sampleRequested" class="w-5 h-5 rounded border-slate-300 text-orange-500 focus:ring-orange-500" />
                                                <div>
                                                    <span class="text-sm font-medium text-slate-700">Sample Requested</span>
                                                    <p class="text-xs text-slate-500">School wants to see samples</p>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Competitor Strengths (What they like about current publisher)</label>
                                        <textarea v-model="surveyForm.competitorStrengths" rows="3" placeholder="e.g., Good content quality, timely delivery..." class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 resize-none"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Step 6: Final & Expenses -->
                            <div v-else-if="currentStep === 6" class="space-y-6">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center">
                                        <Sparkles class="w-5 h-5 text-rose-600" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">Final Assessment & Expenses</h4>
                                        <p class="text-sm text-slate-500">Overall rating and trip expenses</p>
                                    </div>
                                </div>
                                
                                <!-- Rating -->
                                <div class="bg-slate-50 rounded-xl p-5">
                                    <label class="block text-sm font-medium text-slate-700 mb-3">Overall School Rating</label>
                                    <div class="flex items-center gap-2">
                                        <button 
                                            v-for="i in 5" 
                                            :key="i"
                                            @click="surveyForm.rating = i"
                                            class="p-1 transition-transform hover:scale-110"
                                        >
                                            <Star :class="['w-8 h-8', i <= surveyForm.rating ? 'text-amber-400 fill-amber-400' : 'text-slate-300']" />
                                        </button>
                                        <span class="ml-2 text-sm font-medium text-slate-600">{{ surveyForm.rating }}/5</span>
                                    </div>
                                </div>
                                
                                <!-- Potential -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-3">Business Potential</label>
                                    <div class="flex gap-3">
                                        <button 
                                            @click="surveyForm.potential = 'low'"
                                            :class="[
                                                'flex-1 py-3 rounded-xl text-sm font-bold transition-all border-2',
                                                surveyForm.potential === 'low' 
                                                    ? 'bg-red-500 text-white border-red-500' 
                                                    : 'bg-white text-red-500 border-red-200 hover:border-red-400'
                                            ]"
                                        >
                                            Low
                                        </button>
                                        <button 
                                            @click="surveyForm.potential = 'medium'"
                                            :class="[
                                                'flex-1 py-3 rounded-xl text-sm font-bold transition-all border-2',
                                                surveyForm.potential === 'medium' 
                                                    ? 'bg-amber-500 text-white border-amber-500' 
                                                    : 'bg-white text-amber-500 border-amber-200 hover:border-amber-400'
                                            ]"
                                        >
                                            Medium
                                        </button>
                                        <button 
                                            @click="surveyForm.potential = 'high'"
                                            :class="[
                                                'flex-1 py-3 rounded-xl text-sm font-bold transition-all border-2',
                                                surveyForm.potential === 'high' 
                                                    ? 'bg-emerald-500 text-white border-emerald-500' 
                                                    : 'bg-white text-emerald-500 border-emerald-200 hover:border-emerald-400'
                                            ]"
                                        >
                                            High
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Additional Notes -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Additional Notes / Observations</label>
                                    <textarea v-model="surveyForm.additionalNotes" rows="3" placeholder="Any other important observations..." class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 resize-none"></textarea>
                                </div>
                                
                                <!-- Expense Vouchers -->
                                <div class="border-t border-slate-200 pt-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-2">
                                            <Receipt class="w-5 h-5 text-slate-600" />
                                            <h5 class="font-bold text-slate-800">Trip Expenses</h5>
                                        </div>
                                        <button 
                                            @click="openVoucherModal"
                                            class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 rounded-lg text-sm font-medium text-slate-700 flex items-center gap-1.5 transition-colors"
                                        >
                                            <Plus class="w-4 h-4" /> Add Expense
                                        </button>
                                    </div>
                                    
                                    <div v-if="voucherList.length === 0" class="text-center py-8 bg-slate-50 rounded-xl">
                                        <Receipt class="w-10 h-10 text-slate-300 mx-auto mb-2" />
                                        <p class="text-sm text-slate-500">No expenses added yet</p>
                                    </div>
                                    
                                    <div v-else class="space-y-2">
                                        <div 
                                            v-for="(voucher, idx) in voucherList" 
                                            :key="idx"
                                            class="flex items-center justify-between p-3 bg-slate-50 rounded-lg"
                                        >
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center border border-slate-200">
                                                    <component :is="voucherCategories.find(c => c.value === voucher.category)?.icon || Receipt" class="w-5 h-5 text-slate-600" />
                                                </div>
                                                <div>
                                                    <p class="font-medium text-slate-800">{{ voucher.category }}</p>
                                                    <p class="text-xs text-slate-500">{{ voucher.purpose }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <span class="font-bold text-slate-800"><span class="rupee-symbol">₹</span> {{ voucher.amount }}</span>
                                                <button @click="removeVoucher(idx)" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg">
                                                    <Trash2 class="w-4 h-4" />
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-200">
                                            <span class="font-bold text-orange-700">Total Expenses</span>
                                            <span class="font-bold text-orange-700"><span class="rupee-symbol">₹</span> {{ totalVoucherAmount }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div v-if="!isLoading && currentStep > 0" class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                            <button 
                                v-if="currentStep > 1"
                                @click="prevStep"
                                class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50 flex items-center gap-2"
                            >
                                <ChevronLeft class="w-4 h-4" /> Previous
                            </button>
                            <div v-else></div>
                            
                            <button 
                                v-if="currentStep < totalSteps"
                                @click="nextStep"
                                class="px-5 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl text-sm font-bold text-white flex items-center gap-2 shadow-md"
                            >
                                Next <ChevronRight class="w-4 h-4" />
                            </button>
                            <button 
                                v-else
                                @click="submitSurvey"
                                :disabled="isSubmitting"
                                class="px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 rounded-xl text-sm font-bold text-white flex items-center gap-2 shadow-md disabled:opacity-50"
                            >
                                <Loader2 v-if="isSubmitting" class="w-4 h-4 animate-spin" />
                                <Send v-else class="w-4 h-4" />
                                {{ isSubmitting ? 'Submitting...' : 'Submit Survey' }}
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- ============================================== -->
        <!-- VOUCHER MODAL -->
        <!-- ============================================== -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition-all duration-200"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-all duration-150"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div 
                    v-if="showVoucherModal" 
                    class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
                    @click.self="showVoucherModal = false"
                >
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                        <div class="bg-slate-800 px-6 py-4 text-white flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <Receipt class="w-5 h-5" />
                                <h3 class="font-bold">Add Expense</h3>
                            </div>
                            <button @click="showVoucherModal = false" class="p-1.5 hover:bg-white/20 rounded-lg">
                                <X class="w-5 h-5" />
                            </button>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Category *</label>
                                <select v-model="voucherForm.category" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500">
                                    <option value="">Select Category</option>
                                    <option v-for="cat in voucherCategories" :key="cat.value" :value="cat.value">{{ cat.label }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Amount *</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 rupee-symbol">₹</span>
                                    <input v-model="voucherForm.amount" type="number" placeholder="0" class="w-full pl-8 pr-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Purpose *</label>
                                <input v-model="voucherForm.purpose" type="text" placeholder="e.g., Travel to school" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Remarks</label>
                                <textarea v-model="voucherForm.remarks" rows="2" placeholder="Additional details..." class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 resize-none"></textarea>
                            </div>
                        </div>
                        
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex gap-3">
                            <button @click="showVoucherModal = false" class="flex-1 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-50">
                                Cancel
                            </button>
                            <button @click="addVoucher" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl text-sm font-bold text-white hover:from-orange-600 hover:to-orange-700">
                                Add Expense
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

        <!-- ============================================== -->
        <!-- VIEW SURVEY MODAL -->
        <!-- ============================================== -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition-all duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition-all duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div 
                    v-if="showViewModal && viewingSurvey" 
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
                    @click.self="showViewModal = false"
                >
                    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">
                        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-6 py-4 text-white flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <BadgeCheck class="w-6 h-6" />
                                <div>
                                    <h3 class="font-bold text-lg">Survey Details</h3>
                                    <p class="text-sm text-emerald-100">{{ viewingSurvey.name }}</p>
                                </div>
                            </div>
                            <button @click="showViewModal = false" class="p-2 hover:bg-white/20 rounded-lg">
                                <X class="w-5 h-5" />
                            </button>
                        </div>
                        
                        <div class="flex-1 overflow-y-auto p-6 space-y-6">
                            <!-- School Info -->
                            <div class="bg-slate-50 rounded-xl p-5">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                                        {{ viewingSurvey.name.charAt(0) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-lg">{{ viewingSurvey.name }}</h4>
                                        <p class="text-sm text-slate-500">{{ viewingSurvey.address }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div><span class="text-slate-500">Board:</span> <span class="font-medium">{{ viewingSurvey.board }}</span></div>
                                    <div><span class="text-slate-500">Students:</span> <span class="font-medium">{{ viewingSurvey.surveyData?.totalStudents }}</span></div>
                                    <div><span class="text-slate-500">Principal:</span> <span class="font-medium">{{ viewingSurvey.surveyData?.principalName }}</span></div>
                                    <div><span class="text-slate-500">Anniversary:</span> <span class="font-medium">{{ viewingSurvey.surveyData?.schoolAnniversary || '-' }}</span></div>
                                </div>
                            </div>
                            
                            <!-- Rating & Potential -->
                            <div class="flex gap-4">
                                <div class="flex-1 bg-amber-50 rounded-xl p-4 text-center">
                                    <p class="text-xs font-medium text-amber-600 mb-2">Rating</p>
                                    <div class="flex items-center justify-center gap-1">
                                        <Star v-for="i in 5" :key="i" :class="['w-5 h-5', i <= viewingSurvey.rating ? 'text-amber-400 fill-amber-400' : 'text-amber-200']" />
                                    </div>
                                </div>
                                <div class="flex-1 rounded-xl p-4 text-center" :class="viewingSurvey.potential === 'high' ? 'bg-emerald-50' : viewingSurvey.potential === 'medium' ? 'bg-amber-50' : 'bg-red-50'">
                                    <p class="text-xs font-medium mb-2" :class="viewingSurvey.potential === 'high' ? 'text-emerald-600' : viewingSurvey.potential === 'medium' ? 'text-amber-600' : 'text-red-600'">Potential</p>
                                    <p class="text-lg font-bold" :class="viewingSurvey.potential === 'high' ? 'text-emerald-700' : viewingSurvey.potential === 'medium' ? 'text-amber-700' : 'text-red-700'">{{ viewingSurvey.potential?.toUpperCase() }}</p>
                                </div>
                            </div>
                            
                            <!-- Publishers & Subjects -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h5 class="text-sm font-bold text-slate-700 mb-2">Current Publishers</h5>
                                    <div class="flex flex-wrap gap-1.5">
                                        <span v-for="pub in viewingSurvey.surveyData?.currentPublishers" :key="pub" class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-lg">{{ pub }}</span>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="text-sm font-bold text-slate-700 mb-2">Interested Subjects</h5>
                                    <div class="flex flex-wrap gap-1.5">
                                        <span v-for="sub in viewingSurvey.surveyData?.interestedSubjects" :key="sub" class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-medium rounded-lg">{{ sub }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Key Metrics -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-slate-50 rounded-xl p-4">
                                    <p class="text-xs text-slate-500 mb-1">Estimated Quantity</p>
                                    <p class="text-xl font-bold text-slate-800">{{ viewingSurvey.surveyData?.estimatedQuantity || '-' }} books/year</p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-4">
                                    <p class="text-xs text-slate-500 mb-1">Satisfaction Level</p>
                                    <p class="text-xl font-bold text-slate-800 capitalize">{{ viewingSurvey.surveyData?.satisfactionLevel?.replace('_', ' ') || '-' }}</p>
                                </div>
                            </div>
                            
                            <!-- Notes -->
                            <div v-if="viewingSurvey.surveyData?.notes">
                                <h5 class="text-sm font-bold text-slate-700 mb-2">Survey Notes</h5>
                                <p class="text-sm text-slate-600 bg-slate-50 rounded-xl p-4">{{ viewingSurvey.surveyData.notes }}</p>
                            </div>
                            
                            <!-- Expenses -->
                            <div v-if="viewingSurvey.surveyData?.vouchers?.length">
                                <h5 class="text-sm font-bold text-slate-700 mb-2">Trip Expenses</h5>
                                <div class="space-y-2">
                                    <div v-for="(v, i) in viewingSurvey.surveyData.vouchers" :key="i" class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-slate-800">{{ v.category }}</p>
                                            <p class="text-xs text-slate-500">{{ v.purpose }}</p>
                                        </div>
                                        <span class="font-bold text-slate-800"><span class="rupee-symbol">₹</span> {{ v.amount }}</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-200">
                                        <span class="font-bold text-orange-700">Total</span>
                                        <span class="font-bold text-orange-700"><span class="rupee-symbol">₹</span> {{ viewingSurvey.surveyData.vouchers.reduce((s, v) => s + v.amount, 0) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                            <button @click="showViewModal = false" class="w-full px-4 py-2.5 bg-slate-800 rounded-xl text-sm font-bold text-white hover:bg-slate-900">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </Teleport>

    </AuthenticatedLayout>
</template>

<style scoped>
.rupee-symbol {
    font-family: Georgia, 'Times New Roman', serif;
}
</style>
