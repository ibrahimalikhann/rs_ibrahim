<script setup>
import { ref, computed } from 'vue';
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
    ChevronDown,
    ChevronRight,
    LogOut,
    Calendar,
    CircleDot,
    PieChart,
    TrendingUp,
    School,
    BarChart3,
    User
} from 'lucide-vue-next';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import CommandPalette from '@/Components/CommandPalette.vue';

const sidebarOpen = ref(false);
const showCommandPalette = ref(false);

const openGroups = ref({
    'Team': true, 
    'Pre-Sales': false,
    'Sales': false,
    'Post Sales': false,
    'Support': false
});

const toggleGroup = (group) => {
    // Accordion behavior: Close others if opening a new one
    if (!openGroups.value[group]) {
        Object.keys(openGroups.value).forEach(key => {
            openGroups.value[key] = false;
        });
    }
    openGroups.value[group] = !openGroups.value[group];
};

const userRole = computed(() => page.props.auth.user.role || 'user');

const dashboardRoute = computed(() => {
    const role = userRole.value;
    if (role === 'admin') return route('dashboard.admin');
    if (role === 'vp') return route('dashboard.vp');
    if (role === 'geo-head') return route('dashboard.geo-head');
    if (role === 'team-leader') return route('dashboard.team-leader');
    if (role === 'executive') return route('dashboard.executive');
    return route('dashboard');
});

// Sidebar Configuration based on Ratna Sagar requirements
const navigation = computed(() => [
    { name: 'Overview', href: dashboardRoute.value, icon: LayoutDashboard, current: true },
    
    // Group: Team Management
    { 
        name: 'Team', 
        icon: Users,
        isGroup: true,
        children: [
            { name: 'Team Overview', href: '#', icon: PieChart },
            { name: 'Exec Performance', href: '#', icon: BarChart3 },
            { name: 'Assigned Schools', href: '#', icon: School },
            { name: 'Pending Actions', href: '#', icon: AlertCircle },
        ]
    },

    // Group: Pre-Sales
    { 
        name: 'Pre-Sales', 
        icon: Briefcase,
        isGroup: true,
        children: [
            { name: 'CRM', href: '#', icon: Users },
            { name: 'Survey', href: '#', icon: ClipboardList },
            { name: 'Specimen', href: '#', icon: BookOpen },
        ]
    },

    // Group: Sales
    { 
        name: 'Sales', 
        icon: ShoppingCart,
        isGroup: true,
        children: [
            { name: 'Sales Order', href: '#', icon: FileText },
        ]
    },

    // Group: Post Sales
    { 
        name: 'Post Sales', 
        icon: Truck,
        isGroup: true,
        children: [
            { name: 'Sales Return', href: '#', icon: RotateCcw },
        ]
    },

    // Group: Support
    { 
        name: 'Support', 
        icon: LifeBuoy,
        isGroup: true,
        children: [
            { name: 'Case / Service Desk', href: route('service-desk'), icon: Briefcase }, 
            { name: 'Raised Issues', href: '#', icon: AlertCircle },
        ]
    },

    // Group: Profile
    { 
        name: 'Profile', 
        icon: User,
        isGroup: true,
        children: [
            { name: 'My Profile', href: route('my-profile'), icon: User },
        ]
    },
]);

const toggleSidebar = () => (sidebarOpen.value = !sidebarOpen.value);
const page = usePage();
const userName = computed(() => page.props.auth.user.name);
const isActive = (href) => {
    if (href === '#') return false; 
    try {
        const url = new URL(href);
        return page.url === url.pathname || page.url.startsWith(url.pathname);
    } catch (e) {
        return false;
    }
};

const currentDate = new Date().toLocaleDateString('en-IN', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

const consoleLabel = computed(() => {
    if (route().current('dashboard.executive')) return 'Executive Console';
    if (route().current('dashboard.team-leader')) return 'Team Leader Console';
    if (route().current('dashboard.geo-head')) return 'Geo Head Console';
    if (route().current('dashboard.vp')) return 'VP Console';
    if (route().current('dashboard.admin')) return 'Admin Console';
    return 'Ratna Sagar Console';
});
</script>

<template>
    <div class="bg-slate-100 dark:bg-slate-900 min-h-screen font-sans text-slate-900 dark:text-slate-100 flex">
        <!-- Command Palette -->
        <CommandPalette v-model="showCommandPalette" />

        <!-- Mobile Sidebar Backdrop -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 lg:hidden backdrop-blur-sm transition-opacity"></div>

        <!-- Sidebar - High Contrast & Fixed Footer -->
        <aside :class="[
            'fixed inset-y-0 left-0 z-30 w-72 transform bg-gradient-to-b from-[#0f172a] to-[#1e293b] dark:from-slate-950 dark:to-slate-900 border-r border-slate-700 transition-transform duration-300 lg:static lg:translate-x-0 shadow-xl flex flex-col',
            sidebarOpen ? 'translate-x-0' : '-translate-x-full'
        ]">
            <!-- Brand Logo (Fixed Top) -->
            <div class="flex-shrink-0 flex h-[5rem] items-center px-6 border-b border-slate-700/50 bg-transparent">
                <img src="/images/newlogo.png" alt="Ratna Sagar" class="h-11 w-auto object-contain brightness-0 invert" />
            </div>
            
            <!-- Scrollable Navigation (Flex-1) -->
            <nav class="flex-1 px-4 space-y-2 overflow-y-auto custom-scrollbar pt-6 pb-6">
                <template v-for="item in navigation" :key="item.name">
                    <!-- Single Item -->
                    <div v-if="!item.isGroup" class="mb-3">
                         <Link :href="item.href"
                            :class="[
                                isActive(item.href)
                                    ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-lg shadow-orange-900/20' 
                                    : 'text-slate-300 hover:bg-white/5 hover:text-white',
                                'group flex items-center px-4 py-3 text-[1rem] font-medium rounded-lg transition-all duration-200'
                            ]">
                            <component :is="item.icon" 
                                :class="[
                                    isActive(item.href)
                                        ? 'text-white'
                                        : 'text-slate-300 group-hover:text-white',
                                    'mr-3 h-[1.35rem] w-[1.35rem] flex-shrink-0 transition-colors'
                                ]" 
                            aria-hidden="true" />
                            {{ item.name }}
                        </Link>
                    </div>

                    <!-- Group Configuration -->
                    <div v-else class="py-2">
                        <button 
                            @click="toggleGroup(item.name)"
                            class="w-full flex items-center justify-between px-4 py-3 text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-white transition-colors border-l-2 border-transparent hover:border-slate-500 bg-slate-800/20 rounded-r-lg"
                        >
                            <div class="flex items-center gap-2">
                                {{ item.name }}
                            </div>
                            <component :is="openGroups[item.name] ? ChevronDown : ChevronRight" class="h-4 w-4 opacity-80" />
                        </button>

                        <div v-show="openGroups[item.name]" class="mt-2 space-y-1 pl-2">
                            <Link v-for="child in item.children" :key="child.name" :href="child.href"
                                :class="[
                                    'group flex items-center pl-3 pr-3 py-2.5 text-[0.95rem] font-medium rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-all border border-transparent hover:border-slate-700'
                                ]">
                                <component :is="child.icon" class="h-4 w-4 mr-3 text-slate-400 group-hover:text-brand-400 transition-colors" />
                                {{ child.name }}
                            </Link>
                        </div>
                    </div>
                </template>
            </nav>
            
            <!-- User Profile Fixed Bottom -->
            <div class="flex-shrink-0 w-full p-5 border-t border-slate-700 bg-transparent z-10">
                <div class="flex items-center p-3 rounded-xl bg-slate-800/50 border border-slate-700">
                    <div class="relative flex-shrink-0">
                        <img class="h-10 w-10 rounded-full ring-2 ring-slate-500" :src="'https://ui-avatars.com/api/?name=' + userName + '&background=e2e8f0&color=0f172a'" alt="" />
                        <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-500 ring-2 ring-[#0f172a]"></span>
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-[0.95rem] font-bold text-white truncate">{{ userName }}</p>
                        <p class="text-xs font-medium text-slate-400 truncate">Team Leader</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative bg-slate-50 dark:bg-slate-900">
            
            <!-- Top Navbar - Taller & Cleaner -->
            <header class="h-[5rem] bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-10 flex items-center justify-between px-8 shadow-sm">
                 <div class="flex items-center gap-5">
                    <button @click="toggleSidebar" type="button" class="lg:hidden -ml-2 p-2 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none">
                        <Menu class="h-7 w-7" />
                    </button>
                    <!-- Date greeting in header -->
                    <div class="hidden md:flex flex-col">
                        <div class="flex items-center text-[0.95rem] font-medium text-slate-600">
                            <Calendar class="w-4 h-4 mr-2 text-brand-600" />
                            {{ currentDate }}
                        </div>
                    </div>
                     <!-- Context Badge -->
                    <div class="hidden md:flex items-center gap-2 px-3 py-1 bg-slate-50 rounded-full border border-slate-200">
                        <div class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></div>
                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">{{ consoleLabel }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Global Search Trigger -->
                    <div class="relative hidden sm:block group cursor-pointer" @click="showCommandPalette = true">
                         <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                            <Search class="h-5 w-5 text-slate-400 group-hover:text-brand-600 transition-colors" />
                        </div>
                        <div class="h-10 w-64 bg-slate-100 hover:bg-slate-200/70 rounded-lg flex items-center px-10 text-[0.9rem] font-medium text-slate-600 transition-colors ring-1 ring-transparent focus:ring-brand-500">
                            Quick search...
                        </div>
                        <div class="absolute inset-y-0 right-2 flex items-center">
                            <span class="text-xs font-bold text-slate-500 bg-white px-1.5 py-0.5 rounded border border-slate-200 shadow-sm">⌘K</span>
                        </div>
                    </div>

                    <!-- Bell -->
                    <button class="relative p-2 text-slate-500 hover:text-brand-600 transition-colors rounded-lg hover:bg-slate-100">
                        <span class="absolute top-2.5 right-2.5 flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-brand-600 border-2 border-white"></span>
                        </span>
                        <Bell class="h-6 w-6" />
                    </button>
                    
                    <div class="h-8 w-px bg-slate-200 mx-1"></div>

                    <!-- User Dropdown (Logout) -->
                    <div class="relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button class="flex items-center gap-2 p-1 pl-2 pr-1 rounded-full border border-slate-200 hover:border-slate-300 transition-colors bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold border border-brand-200 uppercase">
                                        {{ userName.charAt(0) }}
                                    </div>
                                    <ChevronDown class="w-4 h-4 text-slate-400" />
                                </button>
                            </template>

                            <template #content>
                                <div class="px-4 py-3 border-b border-slate-100">
                                    <p class="text-sm font-bold text-slate-900">{{ userName }}</p>
                                    <p class="text-xs text-slate-500 truncate">user@ratnasagar.com</p>
                                </div>
                                
                                <DropdownLink :href="route('profile.edit')" class="flex items-center gap-2 text-slate-600 hover:text-brand-600 hover:bg-slate-50">
                                    <User class="w-4 h-4" /> Profile
                                </DropdownLink>

                                <div class="border-t border-slate-100"></div>

                                <form method="POST" @submit.prevent="$inertia.post(route('logout'))">
                                    <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm leading-5 text-red-600 hover:bg-red-50 focus:outline-none transition-colors">
                                        <LogOut class="w-4 h-4" /> Log Out
                                    </button>
                                </form>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto px-6 sm:px-8 py-8 space-y-8">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.05);
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(255, 255, 255, 0.2);
  border-radius: 20px;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
    background-color: rgba(255, 255, 255, 0.3);
}
</style>
