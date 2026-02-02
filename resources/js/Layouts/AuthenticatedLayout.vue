<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
    LayoutDashboard,
    Users,
    FileText,
    Settings,
    Search,
    Bell,
    Menu,
    X,
    Briefcase,
    ClipboardList,
    BookOpen,
    ShoppingCart,
    Truck,
    RotateCcw,
    LifeBuoy,
    AlertCircle,
    ChevronRight,
    LogOut,
    Calendar,
    PieChart,
    TrendingUp,
    School,
    BarChart3,
    User,
    Shield,
    Phone,
    IndianRupee,
    RefreshCw,
    Headphones,
    UserCircle,
    Building2,
    Target,
    FileCheck,
    HelpCircle,
    Lock,
    Award,
    Users as UsersIcon
} from 'lucide-vue-next';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import CommandPalette from '@/Components/CommandPalette.vue';

const sidebarOpen = ref(false);
const showCommandPalette = ref(false);
const activeHoverMenu = ref(null);
const flyoutPosition = ref({ top: 0 });

const page = usePage();
const userName = computed(() => page.props.auth.user.name);
const userRole = computed(() => page.props.auth.user.role || 'admin');

// Role Display Names
const roleDisplayNames = {
    'admin': 'Super Admin',
    'hr': 'HR Manager',
    'vp': 'Vice President',
    'geo-head': 'Head GEO',
    'team-leader': 'Team Leader',
    'executive': 'Sales Executive'
};

const roleDashboardLabel = computed(() => {
    if (userRole.value === 'admin') return 'Super Admin Dashboard';
    if (userRole.value === 'hr') return 'HR Dashboard';
    if (userRole.value === 'executive') return 'Executive Dashboard';
    return roleDisplayNames[userRole.value] || 'User';
});

const roleProfileLabel = computed(() => roleDisplayNames[userRole.value] || 'User');

const dashboardRoute = computed(() => {
    const role = userRole.value;
    if (role === 'admin') return route('dashboard.admin');
    if (role === 'hr') return route('dashboard.hr');
    if (role === 'vp') return route('dashboard.vp');
    if (role === 'geo-head') return route('dashboard.geo-head');
    if (role === 'team-leader') return route('dashboard.team-leader');
    if (role === 'executive') return route('dashboard.executive');
    return route('dashboard');
});

// Sidebar Navigation with icons for all items
const navigation = computed(() => [
    { 
        name: 'Overview', 
        href: dashboardRoute.value, 
        icon: LayoutDashboard, 
        current: true 
    },
    { 
        name: 'Profile', 
        icon: Shield,
        isGroup: true,
        children: [
            { name: 'My Profile', href: route('my-profile'), icon: UserCircle },
            { name: 'Security', href: route('security'), icon: Lock },
            { name: 'Preferences', href: '#', icon: Settings },
        ]
    },
    { 
        name: 'Pre-Sales', 
        icon: Phone,
        isGroup: true,
        children: [
            { name: 'CRM', href: '#', icon: Building2 },
            { name: 'Survey', href: route('pre-sales.survey'), icon: ClipboardList },
            { name: 'Specimen', href: '#', icon: BookOpen },
            { name: 'Lead Management', href: '#', icon: Target },
        ]
    },
    { 
        name: 'Sales', 
        icon: IndianRupee,
        isGroup: true,
        children: [
            { name: 'Sales Order', href: '#', icon: ShoppingCart },
            { name: 'Quotations', href: '#', icon: FileText },
            { name: 'Invoices', href: '#', icon: FileCheck },
            { name: 'Delivery Tracking', href: '#', icon: Truck },
        ]
    },
    { 
        name: 'Post Sales', 
        icon: RefreshCw,
        isGroup: true,
        children: [
            { name: 'Sales Return', href: '#', icon: RotateCcw },
        ]
    },
    { 
        name: 'Team', 
        icon: Users,
        isGroup: true,
        children: [
            { name: 'Team Overview', href: route('team.overview'), icon: PieChart },
            { name: 'Exec Performance', href: '#', icon: BarChart3 },
            { name: 'Assigned Schools', href: '#', icon: School },
            { name: 'Pending Actions', href: '#', icon: AlertCircle },
        ]
    },
    { 
        name: 'HR', 
        icon: Award,
        isGroup: true,
        visible: userRole.value === 'admin' || userRole.value === 'hr',
        children: [
            { name: 'HR Dashboard', href: route('dashboard.hr'), icon: BarChart3 },
            { name: 'Employees', href: '#', icon: User },
            { name: 'Attendance', href: '#', icon: Calendar },
            { name: 'Payroll', href: '#', icon: IndianRupee },
            { name: 'Leave Management', href: '#', icon: FileText },
        ]
    },
    { 
        name: 'Support', 
        icon: Headphones,
        isGroup: true,
        children: [
            { name: 'Service Desk', href: route('service-desk'), icon: LifeBuoy },
            { name: 'Raised Issues', href: '#', icon: AlertCircle },
            { name: 'Knowledge Base', href: '#', icon: HelpCircle },
        ]
    },
]);

// Flyout Menu Handlers
let hoverTimeout = null;

const handleMenuHover = (item, event) => {
    if (!item.isGroup) return;
    
    clearTimeout(hoverTimeout);
    
    const rect = event.currentTarget.getBoundingClientRect();
    
    flyoutPosition.value = {
        top: rect.top - 75
    };
    
    activeHoverMenu.value = item.name;
};

const handleMenuLeave = () => {
    hoverTimeout = setTimeout(() => {
        activeHoverMenu.value = null;
    }, 150);
};

const handleFlyoutEnter = () => {
    clearTimeout(hoverTimeout);
};

const handleFlyoutLeave = () => {
    activeHoverMenu.value = null;
};

const toggleSidebar = () => (sidebarOpen.value = !sidebarOpen.value);

const isActive = (href) => {
    if (href === '#') return false;
    try {
        const url = new URL(href);
        return page.url === url.pathname || page.url.startsWith(url.pathname);
    } catch (e) {
        return page.url === href || page.url.startsWith(href);
    }
};

const currentDate = new Date().toLocaleDateString('en-IN', { 
    weekday: 'long', 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
});

// Close sidebar on escape
const handleEscape = (e) => {
    if (e.key === 'Escape') {
        sidebarOpen.value = false;
        activeHoverMenu.value = null;
    }
};

onMounted(() => {
    document.addEventListener('keydown', handleEscape);
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleEscape);
    clearTimeout(hoverTimeout);
});
</script>

<template>
    <div class="min-h-screen flex flex-col bg-slate-100">
        <!-- Command Palette -->
        <CommandPalette v-model="showCommandPalette" />

        <!-- ============================================== -->
        <!-- TOP HEADER - Orange Gradient (ICICI Inspired) -->
        <!-- ============================================== -->
        <header class="h-[72px] bg-gradient-to-b from-[#AC0C13] to-[#AC0C13] sticky top-0 z-50 shadow-lg">
            <div class="h-full flex items-center justify-between px-6">
                <!-- Left Section: Logo + Date + Role Badge -->
                <div class="flex items-center gap-6">
                    <!-- Company Logo (Aligned to Sidebar Width) -->
                    <div class="flex items-center w-[264px]">
                        <img 
                            src="/images/newlogo.png" 
                            alt="Ratna Sagar P. Ltd." 
                            class="h-8 w-auto object-contain brightness-0 invert"
                        />
                    </div>

                    <!-- Vertical Divider (Centered with Equal Gap) -->
                    <div class="hidden md:block h-10 w-px bg-white/25"></div>

                    <!-- Date + Role (Compact Stack) -->
                    <div class="hidden md:flex flex-col gap-1 text-white/90">
                        <div class="flex items-center gap-2">
                            <div class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></div>
                            <span class="text-[13px] font-bold text-white/95 uppercase tracking-wide">{{ roleDashboardLabel }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] font-medium leading-tight text-white">{{ currentDate }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right Section: Search + Notifications + Profile -->
                <div class="flex items-center gap-4">
                    <!-- Global Search -->
                    <div 
                        class="hidden sm:flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-xl cursor-pointer transition-all duration-200 border border-white/10 hover:border-white/25 group"
                        @click="showCommandPalette = true"
                    >
                        <Search class="w-5 h-5 text-white/70 group-hover:text-white transition-colors" />
                        <span class="text-[15px] text-white/70 group-hover:text-white/90 font-medium w-32 transition-colors">Quick search...</span>
                        <div class="flex items-center gap-1 ml-2">
                            <kbd class="text-[11px] font-bold text-white/60 bg-white/10 px-1.5 py-0.5 rounded">⌘K</kbd>
                        </div>
                    </div>

                    <!-- Notification Bell -->
                    <button class="relative p-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-200">
                        <span class="absolute top-2 right-2 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-300 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-yellow-400 ring-2 ring-[#E6611D]"></span>
                        </span>
                        <Bell class="w-6 h-6" />
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <Dropdown align="right" width="72">
                            <template #trigger>
                                <button class="flex items-center gap-3 pl-3 pr-2 py-1.5 bg-white/10 hover:bg-white/20 rounded-full transition-all duration-200 border border-white/15 hover:border-white/30">
                                    <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center text-[#E6611D] font-bold text-lg uppercase shadow-inner">
                                        {{ userName.charAt(0) }}
                                    </div>
                                    <ChevronRight class="w-4 h-4 text-white/70 rotate-90" />
                                </button>
                            </template>

                            <template #content>
                                <!-- User Header Section -->
                                <div class="px-6 py-5 bg-gradient-to-br from-orange-500 via-orange-600 to-orange-700 border-b border-orange-400">
                                    <div class="flex items-center gap-4 mb-3">
                                        <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center text-orange-600 font-bold text-2xl uppercase shadow-lg border-2 border-orange-300">
                                            {{ userName.charAt(0) }}
                                        </div>
                                        <div>
                                            <p class="text-lg font-bold text-white">{{ userName }}</p>
                                            <p class="text-sm text-orange-100 mt-0.5">{{ roleProfileLabel }}</p>
                                            <p class="text-xs text-orange-200 mt-2 font-medium">System Admin</p>
                                        </div>
                                    </div>
                                    <div class="h-px bg-orange-400/30"></div>
                                </div>
                                
                                <!-- Menu Items -->
                                <div class="py-3 space-y-1">
                                    <DropdownLink :href="route('my-profile')" class="flex items-center gap-4 px-6 py-3 text-[14px] text-slate-600 hover:text-orange-600 hover:bg-orange-50/80 transition-all duration-200 border-l-4 border-transparent hover:border-orange-500">
                                        <UserCircle class="w-5 h-5" /> 
                                        <div>
                                            <span class="font-semibold block">My Profile</span>
                                            <span class="text-xs text-slate-400">View & edit profile</span>
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink :href="route('security')" class="flex items-center gap-4 px-6 py-3 text-[14px] text-slate-600 hover:text-blue-600 hover:bg-blue-50/80 transition-all duration-200 border-l-4 border-transparent hover:border-blue-500">
                                        <Lock class="w-5 h-5" /> 
                                        <div>
                                            <span class="font-semibold block">Security</span>
                                            <span class="text-xs text-slate-400">2FA, passwords & more</span>
                                        </div>
                                    </DropdownLink>
                                    <DropdownLink href="#" class="flex items-center gap-4 px-6 py-3 text-[14px] text-slate-600 hover:text-slate-900 hover:bg-slate-50/80 transition-all duration-200 border-l-4 border-transparent hover:border-slate-500">
                                        <Settings class="w-5 h-5" /> 
                                        <div>
                                            <span class="font-semibold block">Settings</span>
                                            <span class="text-xs text-slate-400">Preferences & notifications</span>
                                        </div>
                                    </DropdownLink>
                                </div>

                                <div class="border-t border-slate-100"></div>

                                <!-- Log Out Section -->
                                <form method="POST" @submit.prevent="$inertia.post(route('logout'))" class="py-3">
                                    <button type="submit" class="w-full flex items-center gap-4 px-6 py-3 text-[14px] text-red-600 hover:text-white hover:bg-red-600 transition-all duration-200 border-l-4 border-transparent hover:border-red-400 font-semibold rounded-b">
                                        <LogOut class="w-5 h-5" /> 
                                        <div class="text-left">
                                            <span class="block">Log Out</span>
                                            <span class="text-xs font-normal text-red-400">Sign out of your account</span>
                                        </div>
                                    </button>
                                </form>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Layout Container -->
        <div class="flex flex-1">
            <!-- Mobile Sidebar Backdrop -->
            <div 
                v-if="sidebarOpen" 
                @click="sidebarOpen = false" 
                class="fixed inset-0 z-30 bg-black/50 lg:hidden backdrop-blur-sm transition-opacity"
            ></div>

            <!-- ============================================== -->
            <!-- SIDEBAR - Pure White with Flyout Submenus -->
            <!-- ============================================== -->
            <aside 
                :class="[
                    'fixed lg:sticky top-[72px] left-0 z-40 w-[280px] h-[calc(100vh-72px)] bg-white border-r border-slate-200 shadow-lg lg:shadow-sm transition-transform duration-300 flex flex-col',
                    sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
                ]"
            >
                <!-- Close Button (Mobile) -->
                <button 
                    @click="sidebarOpen = false"
                    class="lg:hidden absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"
                >
                    <X class="w-5 h-5" />
                </button>

                <!-- User Profile Card (Top of Sidebar) -->
                <div class="px-4 pt-4 pb-4 border-b border-slate-200">
                    <div class="bg-gradient-to-br from-[#FFEEDE] to-[#FFEEDE] rounded-xl p-4 text-white text-center shadow-md">
                        <!-- Profile Image -->
                        <div class="flex justify-center mb-3">
                            <img 
                                :src="`https://www.corporatephotographerslondon.com/wp-content/uploads/2023/02/LinkedIn_Profile_Photo.jpg`"
                                :alt="userName"
                                class="w-16 h-16 rounded-full object-cover border-4 border-white shadow-lg"
                            />
                        </div>
                        
                        <!-- Name -->
                        <p class="font-bold text-lg text-[#015276]">{{userName}}</p>
                        
                        <!-- Role -->
                        <p class="text-sm text-[#015276]/90 mt-1 font-medium">{{ roleProfileLabel }}</p>
                        
                        <!-- Department/Status -->
                        <div class="mt-3 pt-3 border-t border-gray-300">
                            <div class="flex items-center justify-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-green-300 animate-pulse"></div>
                                <span class="text-xs font-medium text-[#015276]/85">Active</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 overflow-y-auto sidebar-scroll relative">
                    <template v-for="item in navigation" :key="item.name">
                        <!-- Single Item (Overview) -->
                        <div v-if="!item.isGroup && (!item.visible || item.visible)" class="mb-2">
                            <Link 
                                :href="item.href"
                                :class="[
                                    'group flex items-center gap-3 px-4 py-3.5 rounded-xl text-[16px] font-medium transition-all duration-200',
                                    isActive(item.href)
                                        ? 'bg-gradient-to-r from-[#F88313] to-[#E6611D] text-white shadow-md shadow-orange-200'
                                        : 'text-slate-600 hover:bg-orange-50 hover:text-[#E6611D]'
                                ]"
                            >
                                <component 
                                    :is="item.icon" 
                                    :class="[
                                        'w-[22px] h-[22px] flex-shrink-0 transition-colors',
                                        isActive(item.href) ? 'text-white' : 'text-slate-400 group-hover:text-[#E6611D]'
                                    ]" 
                                />
                                <span>{{ item.name }}</span>
                            </Link>
                        </div>

                        <!-- Group Items with Flyout -->
                        <div 
                            v-else-if="item.isGroup && (!item.visible || item.visible)"
                            class="mb-2 relative"
                            @mouseenter="handleMenuHover(item, $event)"
                            @mouseleave="handleMenuLeave"
                        >
                            <button
                                :class="[
                                    'w-full group flex items-center justify-between gap-3 px-4 py-3.5 rounded-xl text-[16px] font-medium transition-all duration-200',
                                    activeHoverMenu === item.name
                                        ? 'bg-orange-50 text-[#E6611D]'
                                        : 'text-slate-600 hover:bg-orange-50 hover:text-[#E6611D]'
                                ]"
                            >
                                <div class="flex items-center gap-3">
                                    <component 
                                        :is="item.icon" 
                                        :class="[
                                            'w-[22px] h-[22px] flex-shrink-0 transition-colors',
                                            activeHoverMenu === item.name 
                                                ? 'text-[#E6611D]' 
                                                : 'text-slate-400 group-hover:text-[#E6611D]'
                                        ]" 
                                    />
                                    <span>{{ item.name }}</span>
                                </div>
                                <ChevronRight 
                                    :class="[
                                        'w-4 h-4 transition-all duration-200',
                                        activeHoverMenu === item.name 
                                            ? 'text-[#E6611D] translate-x-0.5' 
                                            : 'text-slate-400 group-hover:text-[#E6611D]'
                                    ]" 
                                />
                            </button>

                            <!-- Flyout Submenu (WordPress-style) -->
                            <Transition
                                enter-active-class="transition-all duration-200 ease-out"
                                enter-from-class="opacity-0 translate-x-2"
                                enter-to-class="opacity-100 translate-x-0"
                                leave-active-class="transition-all duration-150 ease-in"
                                leave-from-class="opacity-100 translate-x-0"
                                leave-to-class="opacity-0 translate-x-2"
                            >
                                <div
                                    v-if="activeHoverMenu === item.name"
                                    class="fixed left-[280px] z-50 min-w-[240px] bg-white rounded-xl shadow-xl border border-slate-200 py-2 overflow-hidden"
                                    :style="{ top: flyoutPosition.top + 'px' }"
                                    @mouseenter="handleFlyoutEnter"
                                    @mouseleave="handleFlyoutLeave"
                                >
                                    <!-- Flyout Header -->
                                    <div class="px-4 py-2.5 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100 mb-1">
                                        <span class="text-[13px] font-bold text-[#E6611D] uppercase tracking-wide">{{ item.name }}</span>
                                    </div>
                                    
                                    <!-- Flyout Items -->
                                    <Link
                                        v-for="child in item.children"
                                        :key="child.name"
                                        :href="child.href"
                                        class="flex items-center gap-3 px-4 py-3 text-[15px] font-medium text-slate-500 hover:bg-orange-50 hover:text-[#E6611D] transition-colors"
                                    >
                                        <component 
                                            :is="child.icon" 
                                            class="w-5 h-5 text-slate-400 hover:text-[#E6611D]" 
                                        />
                                        <span>{{ child.name }}</span>
                                    </Link>
                                </div>
                            </Transition>
                        </div>
                    </template>
                </nav>

                <!-- Sidebar Footer - Sync Status -->
                <div class="flex-shrink-0 px-4 py-4 border-t border-slate-100 bg-slate-50/50">
                    <div class="flex items-center justify-between text-[13px] text-slate-500">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <span>System Online</span>
                        </div>
                        <span class="text-slate-400">v2.4.1</span>
                    </div>
                </div>
            </aside>

            <!-- Mobile Menu Toggle (Fixed) -->
            <button 
                @click="toggleSidebar" 
                class="lg:hidden fixed bottom-6 left-6 z-50 p-4 bg-gradient-to-b from-[#F88313] to-[#E6611D] text-white rounded-full shadow-lg shadow-orange-300 hover:shadow-xl transition-all duration-200"
            >
                <Menu class="w-6 h-6" />
            </button>

            <!-- ============================================== -->
            <!-- MAIN CONTENT AREA -->
            <!-- ============================================== -->
            <main class="flex-1 min-w-0 overflow-y-auto bg-slate-100">
                <div class="px-6 sm:px-8 py-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Sidebar Custom Scrollbar */
.sidebar-scroll::-webkit-scrollbar {
    width: 6px;
}
.sidebar-scroll::-webkit-scrollbar-track {
    background: transparent;
}
.sidebar-scroll::-webkit-scrollbar-thumb {
    background-color: #e2e8f0;
    border-radius: 20px;
}
.sidebar-scroll:hover::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
}

/* Ensure flyout doesn't clip */
aside {
    overflow: visible;
}
nav {
    overflow-x: visible;
    overflow-y: auto;
}
</style>
