<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { 
    LifeBuoy, Monitor, Building, Banknote, Briefcase, 
    Plus, FileText, Paperclip, Search, Filter, 
    CheckCircle, Clock, AlertCircle, XCircle, ChevronRight, MessageSquare, User, Send
} from 'lucide-vue-next';

// State
const activeTab = ref('raise_ticket'); // 'raise_ticket' | 'my_requests'
const selectedTicket = ref(null); // For details view
const selectedCategory = ref(null); // Auto-filled from top cards

// Dummy Categories
const categories = [
    { id: 'hr', name: 'HR Support', desc: 'Leaves, Payroll, Policies', icon: User, color: 'text-pink-600', bg: 'bg-pink-50', border: 'border-pink-100' },
    { id: 'it', name: 'IT Support', desc: 'System Issues, Email, Network', icon: Monitor, color: 'text-blue-600', bg: 'bg-blue-50', border: 'border-blue-100' },
    { id: 'admin', name: 'Admin / Facilities', desc: 'ID Card, Office Requests', icon: Building, color: 'text-purple-600', bg: 'bg-purple-50', border: 'border-purple-100' },
    { id: 'finance', name: 'Finance', desc: 'Reimbursements, Expenses', icon: Banknote, color: 'text-emerald-600', bg: 'bg-emerald-50', border: 'border-emerald-100' },
    { id: 'sales_ops', name: 'Sales Ops', desc: 'Sales Targets, CRM Tools', icon: Briefcase, color: 'text-orange-600', bg: 'bg-orange-50', border: 'border-orange-100' },
];

// Dummy Tickets
const tickets = [
    { id: '#1045', department: 'HR Support', subject: 'Discrepancy in Leave Balance', status: 'Open', date: '2 hrs ago', priority: 'High' },
    { id: '#1033', department: 'IT Support', subject: 'Outlook Email Access Issue', status: 'In Progress', date: 'Yesterday', priority: 'Medium' },
    { id: '#1011', department: 'Finance', subject: 'March Salary Slip Not Received', status: 'Resolved', date: '16 Apr, 2024', priority: 'Low' },
    { id: '#0998', department: 'Admin', subject: 'New ID Card Request', status: 'Rejected', date: '10 Apr, 2024', priority: 'Low' },
    { id: '#0942', department: 'Sales Ops', subject: 'CRM Login Failure', status: 'Resolved', date: '05 Apr, 2024', priority: 'High' },
];

// Ticket Status Styles
const getStatusStyle = (status) => {
    switch(status) {
        case 'Open': return 'bg-orange-100 text-orange-700 border-orange-200';
        case 'In Progress': return 'bg-blue-100 text-blue-700 border-blue-200';
        case 'Resolved': return 'bg-green-100 text-green-700 border-green-200';
        case 'Rejected': return 'bg-red-100 text-red-700 border-red-200';
        default: return 'bg-slate-100 text-slate-700 border-slate-200';
    }
};

// Form
const form = useForm({
    department: '',
    concern_type: '',
    subject: '',
    description: '',
    file: null
});

const selectCategory = (cat) => {
    selectedCategory.value = cat.id;
    form.department = cat.name;
    activeTab.value = 'raise_ticket';
    selectedTicket.value = null; // Clear details view
};

const viewTicket = (ticket) => {
    selectedTicket.value = ticket;
    // Scroll to details or open modal? Given UI rules, let's Replace the bottom section or use a side panel.
    // I'll use a clean in-page view that replaces the table/form area or overlay. 
    // Let's go with an overlay/slide-over effect or just changing the view state.
};

const closeTicket = () => {
    selectedTicket.value = null;
};
</script>

<template>
    <Head title="Service Desk" />

    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto space-y-8 pb-12">
            
            <!-- Header -->
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Service Desk / Employee Care</h1>
                <p class="text-slate-500 mt-1">Raise and track your concerns across all departments in one place.</p>
            </div>

            <!-- 1) Service Desk Overview (Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <button 
                    v-for="cat in categories" 
                    :key="cat.id"
                    @click="selectCategory(cat)"
                    :class="[
                        'flex flex-col items-start p-5 rounded-xl border transition-all duration-200 text-left hover:shadow-md',
                        selectedCategory === cat.id 
                            ? 'bg-white ring-2 ring-brand-500 border-transparent shadow-md' 
                            : 'bg-white border-slate-200 hover:border-brand-300'
                    ]"
                >
                    <div :class="[cat.bg, cat.color, 'p-3 rounded-lg mb-3']">
                        <component :is="cat.icon" class="w-6 h-6" />
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">{{ cat.name }}</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-snug">{{ cat.desc }}</p>
                </button>
            </div>

            <!-- Main Content Area -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden min-h-[500px] relative">
                
                <!-- Ticket Details Overlay (Slide Over) -->
                <div v-if="selectedTicket" class="absolute inset-0 bg-white z-20 flex flex-col animate-in slide-in-from-right duration-300">
                    <!-- Details Header -->
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <button @click="closeTicket" class="p-2 hover:bg-slate-200 rounded-full transition-colors text-slate-500">
                                <ChevronRight class="w-5 h-5 rotate-180" />
                            </button>
                            <div>
                                <h2 class="text-lg font-bold text-slate-800">{{ selectedTicket.subject }}</h2>
                                <div class="flex items-center gap-3 text-xs mt-1">
                                    <span class="font-semibold text-slate-500">Ticket ID: {{ selectedTicket.id }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                    <span :class="['px-2 py-0.5 rounded border text-[10px] font-bold uppercase tracking-wider', getStatusStyle(selectedTicket.status)]">
                                        {{ selectedTicket.status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400">Last updated: {{ selectedTicket.date }}</span>
                        </div>
                    </div>

                    <!-- Details Body -->
                    <div class="flex-1 overflow-y-auto p-6 md:p-8">
                        <div class="max-w-4xl mx-auto space-y-8">
                            <!-- Ticket Info -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Department</label>
                                    <p class="font-medium text-slate-800">{{ selectedTicket.department }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Priority</label>
                                    <p class="font-medium text-slate-800">{{ selectedTicket.priority }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Submitted By</label>
                                    <p class="font-medium text-slate-800">{{ $page.props.auth.user.name }}</p>
                                </div>
                            </div>

                            <hr class="border-slate-100" />

                            <!-- Conversation -->
                            <div class="space-y-6">
                                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                    <MessageSquare class="w-4 h-4 text-brand-500" /> Discussion
                                </h3>
                                
                                <!-- User Message -->
                                <div class="flex gap-4">
                                    <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0 border border-slate-200">
                                        <User class="w-5 h-5 text-slate-400" />
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <div class="flex items-baseline justify-between">
                                            <span class="font-bold text-slate-800">You</span>
                                            <span class="text-xs text-slate-400">Yesterday, 10:30 AM</span>
                                        </div>
                                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl rounded-tl-none text-slate-600 text-sm leading-relaxed">
                                            Hi, I am unable to access my Outlook email since this morning. It keeps asking for a password reset but the link is not working. Please assist.
                                        </div>
                                        <!-- Attachment -->
                                        <div class="flex items-center gap-2 p-2 rounded border border-slate-200 w-fit bg-white cursor-pointer hover:border-brand-300 hover:text-brand-600 transition-colors">
                                            <Paperclip class="w-3 h-3 text-slate-400" />
                                            <span class="text-xs font-medium text-slate-600">screenshot_error.png</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Support Agent -->
                                <div v-if="selectedTicket.status !== 'Open'" class="flex gap-4">
                                    <div class="h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0 border border-blue-100">
                                        <LifeBuoy class="w-5 h-5 text-blue-600" />
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <div class="flex items-baseline justify-between">
                                            <span class="font-bold text-slate-800">IT Support Team</span>
                                            <span class="text-xs text-slate-400">Yesterday, 11:15 AM</span>
                                        </div>
                                        <div class="bg-blue-50/50 border border-blue-100 p-4 rounded-xl rounded-tl-none text-slate-700 text-sm leading-relaxed">
                                            Hello, we are looking into this. It seems like a sync issue with the central server. We have reset your provisional access. Please try logging in with the temporary password sent to your alternate email.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-100" />

                            <!-- Reply Box -->
                            <div v-if="selectedTicket.status !== 'Resolved' && selectedTicket.status !== 'Rejected'">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">Add a Reply</label>
                                <textarea rows="3" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm" placeholder="Type your message here..."></textarea>
                                <div class="mt-2 flex justify-end">
                                    <button class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-brand-700 transition-colors flex items-center gap-2">
                                        <Send class="w-4 h-4" /> Send Reply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="flex items-center gap-6 px-8 border-b border-slate-200 bg-slate-50/30">
                    <button 
                        @click="activeTab = 'raise_ticket'"
                        :class="[
                            'py-4 text-sm font-bold border-b-2 transition-all duration-200 flex items-center gap-2',
                            activeTab === 'raise_ticket' 
                                ? 'text-brand-600 border-brand-500' 
                                : 'text-slate-500 border-transparent hover:text-slate-700 hover:border-slate-300'
                        ]"
                    >
                        <Plus class="w-4 h-4" /> Raise New Ticket
                    </button>
                    <button 
                        @click="activeTab = 'my_requests'"
                        :class="[
                            'py-4 text-sm font-bold border-b-2 transition-all duration-200 flex items-center gap-2',
                            activeTab === 'my_requests' 
                                ? 'text-brand-600 border-brand-500' 
                                : 'text-slate-500 border-transparent hover:text-slate-700 hover:border-slate-300'
                        ]"
                    >
                        <FileText class="w-4 h-4" /> My Requests
                        <span class="bg-slate-200 text-slate-600 text-[10px] px-1.5 py-0.5 rounded-full ml-1">5</span>
                    </button>
                    <button class="py-4 text-sm font-bold border-b-2 border-transparent text-slate-400 hover:text-slate-600 hover:border-slate-300 transition-all ml-auto">
                        Policy & Guidelines
                    </button>
                </div>

                <!-- Tab Content: Raise Ticket -->
                <div v-if="activeTab === 'raise_ticket'" class="p-8 animate-in fade-in duration-300">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        
                        <!-- Main Form Area -->
                        <div class="lg:col-span-2 space-y-8">
                            <form @submit.prevent class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-1.5">
                                        <label class="text-sm font-bold text-slate-700">Department</label>
                                        <select v-model="form.department" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-slate-600 shadow-sm bg-slate-50/50">
                                            <option value="" disabled>Select Department</option>
                                            <option v-for="cat in categories" :key="cat.id" :value="cat.name">{{ cat.name }}</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-sm font-bold text-slate-700">Concern Type</label>
                                        <select v-model="form.concern_type" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-slate-600 shadow-sm bg-slate-50/50">
                                            <option value="" disabled>Select Type</option>
                                            <option>Technical Issue</option>
                                            <option>Access Request</option>
                                            <option>Policy Query</option>
                                            <option>Grievance</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-slate-700">Subject</label>
                                    <input type="text" v-model="form.subject" placeholder="Brief summary of the issue..." class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 placeholder:text-slate-400 shadow-sm bg-slate-50/50" />
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-slate-700">Description</label>
                                    <textarea v-model="form.description" rows="5" placeholder="Please describe your issue in detail. Include error messages or specific dates if applicable." class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 placeholder:text-slate-400 shadow-sm bg-slate-50/50"></textarea>
                                </div>

                                <div class="space-y-1.5">
                                    <label class="text-sm font-bold text-slate-700">Attach File <span class="text-slate-400 font-normal">(Optional)</span></label>
                                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 hover:bg-slate-50 transition-colors text-center cursor-pointer group bg-slate-50/30">
                                        <div class="h-12 w-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100 mx-auto mb-3 group-hover:scale-110 transition-transform">
                                            <Paperclip class="w-5 h-5 text-brand-500" />
                                        </div>
                                        <p class="text-sm font-bold text-slate-600 mb-1">Click to upload or drag and drop</p>
                                        <p class="text-xs text-slate-400">PNG, JPG, PDF up to 5MB</p>
                                    </div>
                                </div>

                                <div class="pt-2 flex items-center justify-start">
                                    <button type="submit" class="w-full md:w-auto bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-lg font-bold shadow-lg shadow-brand-500/30 transition-all flex items-center justify-center gap-2 transform active:scale-95">
                                        <Send class="w-4 h-4" /> Submit Ticket
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Sidebar / Helper Area -->
                        <div class="lg:col-span-1 space-y-6">
                            
                            <!-- Quick Help Box -->
                            <div class="bg-blue-50/50 rounded-xl p-6 border border-blue-100">
                                <h4 class="font-bold text-blue-800 flex items-center gap-2 mb-3">
                                    <LifeBuoy class="w-5 h-5" /> Before you submit...
                                </h4>
                                <ul class="space-y-3 text-sm text-blue-900/80">
                                    <li class="flex items-start gap-2">
                                        <CheckCircle class="w-4 h-4 mt-0.5 text-blue-500 flex-shrink-0" />
                                        <span>Check the <b>Knowledge Base</b> for common solutions.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <CheckCircle class="w-4 h-4 mt-0.5 text-blue-500 flex-shrink-0" />
                                        <span>For <b>Wi-Fi issues</b>, try restarting your device first.</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <CheckCircle class="w-4 h-4 mt-0.5 text-blue-500 flex-shrink-0" />
                                        <span><b>Payroll</b> queries are typically resolved within 24 hours.</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Emergency Contact -->
                            <div class="bg-white rounded-xl p-6 border border-slate-200 shadow-sm">
                                <h4 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                                    <AlertCircle class="w-4 h-4 text-orange-500" /> Urgent Issue?
                                </h4>
                                <p class="text-sm text-slate-500 mb-4">For critical system failures or safety emergencies, please call directly:</p>
                                
                                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-100 mb-2">
                                    <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center shadow-sm text-slate-600">
                                        <Monitor class="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-500 uppercase">IT Emergency</p>
                                        <p class="text-sm font-bold text-slate-800">ext. 1099</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-100">
                                    <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center shadow-sm text-slate-600">
                                        <Building class="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-500 uppercase">Facility Manager</p>
                                        <p class="text-sm font-bold text-slate-800">+91 98765 43210</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Tab Content: My Requests -->
                <div v-if="activeTab === 'my_requests'" class="flex-1 flex flex-col pt-2 animate-in fade-in duration-300">
                    
                    <!-- Filters -->
                    <div class="px-8 py-4 flex items-center justify-between gap-4">
                        <div class="relative w-64">
                            <Search class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" />
                            <input type="text" placeholder="Search tickets..." class="w-full pl-9 pr-4 py-2 rounded-lg border-slate-200 text-sm focus:border-brand-500 focus:ring-brand-500" />
                        </div>
                        <button class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-brand-600 px-3 py-2 rounded hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-200">
                            <Filter class="w-4 h-4" /> Filter Status
                        </button>
                    </div>

                    <!-- Table -->
                    <div class="flex-1 overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Ticket ID</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Department</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-1/3">Subject</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Last Update</th>
                                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr v-for="ticket in tickets" :key="ticket.id" class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-8 py-4 font-bold text-slate-700">{{ ticket.id }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ ticket.department }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ ticket.subject }}</td>
                                    <td class="px-6 py-4">
                                        <span :class="['px-2.5 py-1 rounded border text-[10px] font-bold uppercase tracking-wide', getStatusStyle(ticket.status)]">
                                            {{ ticket.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500">{{ ticket.date }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <button 
                                            @click="viewTicket(ticket)"
                                            class="text-sm font-bold text-brand-600 hover:text-brand-700 hover:underline decoration-2 underline-offset-4 focus:outline-none"
                                        >
                                            View
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination (Static) -->
                    <div class="px-8 py-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                        <span>Showing 1 to 5 of 5 entries</span>
                        <div class="flex gap-2">
                            <button class="px-3 py-1 bg-slate-100 rounded hover:bg-slate-200 disabled:opacity-50" disabled>Previous</button>
                            <button class="px-3 py-1 bg-slate-100 rounded hover:bg-slate-200 disabled:opacity-50" disabled>Next</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
