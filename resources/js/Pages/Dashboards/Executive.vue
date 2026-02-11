<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';
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
    Activity,
    ChevronLeft,
    ChevronRight as ChevronRightIcon
} from 'lucide-vue-next';

// Get user name from page props
const page = usePage();
const userName = computed(() => page.props.auth.user.name);

// Helper function to wrap rupee symbols with CSS class for font styling
const formatRupee = (text) => {
    if (!text) return text;
    return String(text).replace(/₹/g, '<span class="rupee-symbol">₹</span>');
};

// Greeting function based on time of day
const getGreeting = () => {
    const hour = new Date().getHours();
    if (hour < 12) return 'Good Morning';
    if (hour < 17) return 'Good Afternoon';
    return 'Good Evening';
};

// Inspirational Quotes Collection
const quotes = [
    { text: "Success is not final, failure is not fatal: it is the courage to continue that counts.", author: "Winston Churchill" },
    { text: "The only way to do great work is to love what you do.", author: "Steve Jobs" },
    { text: "Don't watch the clock; do what it does. Keep going.", author: "Sam Levenson" },
    { text: "The future depends on what you do today.", author: "Mahatma Gandhi" },
    { text: "Believe you can and you're halfway there.", author: "Theodore Roosevelt" },
    { text: "The harder you work for something, the greater you'll feel when you achieve it.", author: "Anonymous" },
    { text: "Success doesn't just find you. You have to go out and get it.", author: "Anonymous" },
    { text: "Dream bigger. Do bigger.", author: "Anonymous" },
    { text: "Don't stop when you're tired. Stop when you're done.", author: "Anonymous" },
    { text: "Great things never come from comfort zones.", author: "Anonymous" },
    { text: "Success is the sum of small efforts repeated day in and day out.", author: "Robert Collier" },
    { text: "Your limitation—it's only your imagination.", author: "Anonymous" },
    { text: "Push yourself, because no one else is going to do it for you.", author: "Anonymous" },
    { text: "Sometimes later becomes never. Do it now.", author: "Anonymous" },
    { text: "The key to success is to focus on goals, not obstacles.", author: "Anonymous" },
    { text: "Dream it. Wish it. Do it.", author: "Anonymous" },
    { text: "Success doesn't come from what you do occasionally, it comes from what you do consistently.", author: "Anonymous" },
    { text: "The distance between your dreams and reality is called action.", author: "Anonymous" },
    { text: "Work hard in silence, let your success be your noise.", author: "Frank Ocean" },
    { text: "Opportunities don't happen. You create them.", author: "Chris Grosser" },
    { text: "Don't be afraid to give up the good to go for the great.", author: "John D. Rockefeller" },
    { text: "I find that the harder I work, the more luck I seem to have.", author: "Thomas Jefferson" },
    { text: "Success is walking from failure to failure with no loss of enthusiasm.", author: "Winston Churchill" },
    { text: "If you really look closely, most overnight successes took a long time.", author: "Steve Jobs" },
    { text: "The way to get started is to quit talking and begin doing.", author: "Walt Disney" },
    { text: "The successful warrior is the average man, with laser-like focus.", author: "Bruce Lee" },
    { text: "Try not to become a man of success. Rather become a man of value.", author: "Albert Einstein" },
    { text: "It is not the strongest of the species that survives, but the one most responsive to change.", author: "Charles Darwin" },
    { text: "Don't let yesterday take up too much of today.", author: "Will Rogers" },
    { text: "People who are crazy enough to think they can change the world, are the ones who do.", author: "Rob Siltanen" },
    { text: "Knowing is not enough; we must apply. Wishing is not enough; we must do.", author: "Johann Wolfgang Von Goethe" },
    { text: "Whether you think you can or you think you can't, you're right.", author: "Henry Ford" },
    { text: "The two most important days in your life are the day you are born and the day you find out why.", author: "Mark Twain" },
    { text: "Whatever you can do, or dream you can, begin it. Boldness has genius, power and magic in it.", author: "Johann Wolfgang von Goethe" },
    { text: "The best revenge is massive success.", author: "Frank Sinatra" },
    { text: "I have not failed. I've just found 10,000 ways that won't work.", author: "Thomas A. Edison" },
    { text: "A successful man is one who can lay a firm foundation with the bricks others have thrown at him.", author: "David Brinkley" },
    { text: "No one can make you feel inferior without your consent.", author: "Eleanor Roosevelt" },
    { text: "The whole secret of a successful life is to find out what is one's destiny to do, and then do it.", author: "Henry Ford" },
    { text: "If you're not stubborn, you'll give up on experiments too soon.", author: "Jeff Bezos" },
    { text: "Don't be distracted by criticism. Remember: the only taste of success some people get is to take a bite out of you.", author: "Zig Ziglar" },
    { text: "You miss 100% of the shots you don't take.", author: "Wayne Gretzky" },
    { text: "I alone cannot change the world, but I can cast a stone across the water to create many ripples.", author: "Mother Teresa" },
    { text: "What seems to us as bitter trials are often blessings in disguise.", author: "Oscar Wilde" },
    { text: "The meaning of life is to find your gift. The purpose of life is to give it away.", author: "Anonymous" },
    { text: "Strive not to be a success, but rather to be of value.", author: "Albert Einstein" },
    { text: "You are never too old to set another goal or to dream a new dream.", author: "C.S. Lewis" },
    { text: "It does not matter how slowly you go as long as you do not stop.", author: "Confucius" },
    { text: "Everything you've ever wanted is on the other side of fear.", author: "George Addair" },
    { text: "Believe in yourself. You are braver than you think, more talented than you know, and capable of more than you imagine.", author: "Roy T. Bennett" }
];

// Function to get random quote
const getRandomQuote = () => {
    const randomIndex = Math.floor(Math.random() * quotes.length);
    return quotes[randomIndex];
};

// Get a random quote on component load
const dailyQuote = ref(getRandomQuote());

// Celebration Slides Data with Images
const celebrationSlides = [
    {
        id: 1,
        name: 'Diwali',
        emoji: '🪔',
        message: 'Happy Diwali',
        image: 'https://images.squarespace-cdn.com/content/v1/61782ecbf6567d12f08ba3b9/1638221504893-AY6HPC9Q186N6X7GFVZB/unsplash-image-xisPXJqwQkA.jpg',
        gradient: 'from-amber-900/80 via-orange-900/70 to-red-900/80'
    },
    {
        id: 2,
        name: 'Makar Sankranti',
        emoji: '🪁',
        message: 'Happy Makar Sankranti',
        image: 'https://assets.thehansindia.com/h-upload/2020/01/12/253405-sankranthi.webp',
        gradient: 'from-yellow-900/80 via-orange-900/70 to-amber-900/80'
    },
    {
        id: 3,
        name: 'Holi',
        emoji: '🎨',
        message: 'Happy Holi',
        image: 'https://www.fabhotels.com/blog/wp-content/uploads/2019/01/Holi600x400.jpg',
        gradient: 'from-pink-900/80 via-purple-900/70 to-blue-900/80'
    },
    {
        id: 4,
        name: 'Republic Day',
        emoji: '🇮🇳',
        message: 'Happy Republic Day',
        image: 'https://images.unsplash.com/photo-1605729787051-d6f2f9f384d7?w=800',
        gradient: 'from-orange-900/80 via-slate-800/70 to-green-900/80'
    },
    {
        id: 5,
        name: 'New Year',
        emoji: '🎉',
        message: 'Happy New Year',
        image: 'https://images.unsplash.com/photo-1467810563316-b5476525c0f9?w=800',
        gradient: 'from-purple-900/80 via-pink-900/70 to-indigo-900/80'
    }
];

// Carousel State
const currentSlide = ref(0);
let slideInterval = null;

// Auto-slide functionality
const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % celebrationSlides.length;
};

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + celebrationSlides.length) % celebrationSlides.length;
};

const goToSlide = (index) => {
    currentSlide.value = index;
};

// Auto-play slides
onMounted(() => {
    slideInterval = setInterval(() => {
        nextSlide();
    }, 5000); // Change slide every 5 seconds
});

onUnmounted(() => {
    if (slideInterval) {
        clearInterval(slideInterval);
    }
});

// ----------------------------------------------------------------------
// DATA & STATE
// ----------------------------------------------------------------------

const goalData = {
    fyTarget: '₹ 1.5 Cr', // Sales Executive Dashboard
    achievedPercent: 62.4,
    achieved: '₹ 0.94 Cr',
    balance: '₹ 0.56 Cr'
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
        text: '2 orders from Hyderabad Book Depot are pending for approval.', 
        icon: FileText, 
        type: 'alert', 
        action: 'View Orders' 
    },
    { 
        id: 3, 
        text: 'Sampling pending in 5 prestigious schools.', 
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
    { stage: 'Assigned', count: 45, status: 'past', icon: ClipboardList },
    { stage: 'Proposal', count: 18, status: 'current', icon: FileText },
    { stage: 'Order', count: 12, status: 'future', icon: ShoppingCart },
];

// My Schools Data - Board wise breakdown
const mySchoolsData = {
    boards: ['CBSE', 'ICSE', 'STATE BOARD', 'IGCSE'],
    data: [
        { board: 'CBSE', assigned: 10, userSchools: 3, nonUserSchools: 7 },
        { board: 'ICSE', assigned: 20, userSchools: 10, nonUserSchools: 10 },
        { board: 'STATE BOARD', assigned: 90, userSchools: 52, nonUserSchools: 38 },
        { board: 'IGCSE', assigned: 10, userSchools: 5, nonUserSchools: 5 },
    ],
    totals: { assigned: 130, userSchools: 70, nonUserSchools: 60 }
};

// Calculate max value for chart scaling
const maxSchoolValue = computed(() => {
    return Math.max(...mySchoolsData.data.map(d => Math.max(d.assigned, d.userSchools, d.nonUserSchools)), mySchoolsData.totals.assigned);
});
</script>

<template>
    <Head title="Executive Dashboard" />

    <AuthenticatedLayout>
        <div class="space-y-8">
            
            <!-- Greeting Section -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">{{ getGreeting() }}, {{ userName }}!</h1>
                    <div class="mt-2">
                        <p class="text-sm text-slate-600 dark:text-slate-300 italic leading-relaxed">
                            "{{ dailyQuote.text }}"
                        </p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">— {{ dailyQuote.author }}</p>
                    </div>
                </div>
            </div>
            
            <!-- 1) TOP HERO SECTION (Refined) -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#FFEEDE] to-[#FFEEDE] p-8 text-white shadow-lg">
                <div class="absolute right-0 top-0 h-full w-1/3 bg-white/5 skew-x-12 transform"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-widest text-[#015276] opacity-90 mb-1">FY 2025-26 Target</p>
                        <div class="flex items-baseline gap-3">
                            <h2 class="text-4xl font-bold font-display text-[#015276]" v-html="formatRupee(goalData.fyTarget)"></h2>
                            <span class="rounded-full bg-white/20 px-3 py-1 text-sm font-bold backdrop-blur-sm text-[#015276]">
                                62.4% Achieved
                            </span>
                        </div>
                    </div>

                    <!-- Simplified Progress -->
                    <div class="w-full md:w-1/2">
                        <div class="flex justify-between text-xs font-bold text-[#015276] uppercase tracking-widest mb-2">
                            <span>Progress</span>
                            <span v-html="`₹0.56 Cr Remaining`"></span>
                        </div>
                        <div class="h-3 w-full overflow-hidden rounded-full bg-black/20 relative group cursor-pointer">
                            <div class="h-full rounded-full bg-white transition-all duration-1000 ease-out" style="width: 62.4%; background-color: #F36E21;"></div>
                            <!-- Hover Tooltip -->
                            <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white text-xs font-bold px-3 py-2 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                <div class="text-center">
                                    <div>62.4% Achieved</div>
                                    <div class="text-orange-300" v-html="formatRupee(goalData.achieved)"></div>
                                </div>
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 rotate-45 w-2 h-2 bg-slate-800"></div>
                            </div>
                        </div>
                        <div class="mt-2 flex justify-between items-center">
                            <p class="  text-xs font-medium text-[#015276]">
                                ₹0.94 Cr Achieved
                            </p>
                            <p class="text-xs font-medium text-[#015276] flex items-center">
                                <TrendingUp class="w-3 h-3 mr-1 text-[#AC0C13] bg-[#FFEEDE] p-0.5 rounded" /> On track to exceed annual targets
                            </p>
                        </div>
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

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            
                            <!-- ROW 1: THREE CARDS -->
                            <!-- QTY TARGET -->
                            <div class="rounded-2xl bg-[#FFFAF7] p-6 text-white shadow-lg relative overflow-hidden group">
                                <!-- Glow Effect -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
                                
                                <div class="flex justify-between items-start mb-3">
                                    <div class="p-2 rounded-lg bg-[#FFEEDE]">
                                        <Box class="w-5 h-5 text-[#AC0C13]" />
                                    </div>
                                    <div class="h-7 w-7 rounded-full border-2 border-blue-500/30 border-t-blue-500 animate-spin-slow"></div>
                                </div>
                                
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Qty Target</p>
                                <div class="flex items-baseline gap-1 mb-4">
                                    <span class="text-2xl font-bold text-[#015276]">8.5k</span>
                                    <span class="text-sm text-slate-500 font-medium">/ 12.5k</span>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-medium text-slate-400">
                                        <span>Completion</span>
                                        <span>68%</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-700/50 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#ed905a] w-[68%] rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- REVENUE -->
                            <div class="rounded-2xl bg-[#FFFAF7] p-6 text-white shadow-lg relative overflow-hidden group">
                                <!-- Glow Effect -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
                                
                                <div class="flex justify-between items-start mb-3">
                                    <div class="p-2 rounded-lg bg-[#FFEEDE]">
                                        <CircleDollarSign class="w-5 h-5 text-[#AC0C13]" />
                                    </div>
                                    <div class="h-7 w-7 rounded-full border-2 border-purple-500/30 border-r-purple-500 animate-spin-slow"></div>
                                </div>
                                
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Revenue</p>
                                <div class="flex items-baseline gap-1 mb-4">
                                    <span class="text-2xl font-bold text-[#015276]" v-html="formatRupee('₹18.0L')"></span>
                                    <span class="text-sm text-slate-500 font-medium">/ 25.0L</span>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs font-medium text-slate-400">
                                        <span>Collected</span>
                                        <span>72%</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-700/50 rounded-full overflow-hidden">
                                        <div class="h-full bg-[#ed905a] w-[72%] rounded-full"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- PIPELINE VIEW -->
                            <div class="rounded-2xl bg-[#FFFAF7] p-6 text-white shadow-lg relative overflow-hidden group">
                                <!-- Glow Effect -->
                                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500/10 rounded-full blur-3xl -mr-10 -mt-10"></div>
                                
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-2.5 rounded-xl bg-[#FFEEDE]">
                                        <Activity class="w-5 h-5 text-[#AC0C13]" />
                                    </div>
                                    <button class="text-xs font-bold text-blue-600 hover:text-blue-700 transition-colors uppercase tracking-wider">
                                        View Pipeline
                                    </button>
                                </div>
                                
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Pipeline Overview</p>
                                
                                <div class="relative px-2">
                                    <!-- Background Line -->
                                    <div class="absolute top-5 left-8 right-8 h-0.5 bg-slate-200 dark:bg-slate-700"></div>
                                    
                                    <div class="relative flex justify-between">
                                        <div v-for="(step, i) in pipeline" :key="i" class="flex flex-col items-center group/step min-w-[60px]">
                                            <!-- Step Indicator -->
                                            <div :class="[
                                                'relative z-10 flex items-center justify-center rounded-full border-2 transition-all duration-300',
                                                step.status === 'past' ? 'h-10 w-10 border-emerald-500 bg-emerald-500 text-white' :
                                                step.status === 'current' ? 'h-11 w-11 border-[#AC0C13] bg-[#FFEEDE] text-[#AC0C13] shadow-lg ring-4 ring-[#FFEEDE]/50 scale-110' :
                                                'h-10 w-10 border-slate-200 bg-white text-slate-400'
                                            ]">
                                                <component :is="step.icon" v-if="step.status !== 'past'" :class="step.status === 'current' ? 'h-5 w-5' : 'h-4 w-4'" />
                                                <Check v-else class="h-5 w-5 stroke-[3]" />
                                                
                                                <!-- Count Badge for Future Steps -->
                                                <div v-if="step.status === 'future'" class="absolute -top-2 -right-2 bg-slate-100 text-[#015276] text-[10px] font-bold px-1.5 py-0.5 rounded-full border border-white">
                                                    {{ step.count }}
                                                </div>
                                                <div v-if="step.status === 'current'" class="absolute -top-2 -right-2 bg-[#AC0C13] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border border-white">
                                                    {{ step.count }}
                                                </div>
                                            </div>
                                            
                                            <!-- Label -->
                                            <span :class="[
                                                'mt-3 text-[10px] font-bold uppercase tracking-tight text-center transition-colors',
                                                step.status === 'current' ? 'text-[#AC0C13]' : 
                                                step.status === 'past' ? 'text-emerald-600' : 'text-slate-400'
                                            ]">
                                                {{ step.stage }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- ROW 2: LIGHT CARDS -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">
                            
                            <!-- School Base -->
                            <div class="md:col-span-1 rounded-2xl bg-[#FFFAF7] dark:bg-slate-800 p-5 shadow-sm border border-slate-100 dark:border-slate-700">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">School Base</p>
                                        <h4 class="font-bold text-[#015276] dark:text-white">Coverage Status</h4>
                                    </div>
                                    <School class="w-5 h-5 text-[#AC0C13] bg-[#FFEEDE] p-1 rounded" />
                                </div>

                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">85 Active</span>
                                    <span class="text-xs font-bold text-slate-500">71%</span>
                                </div>
                                <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-700 rounded-full mb-4">
                                    <div class="h-full bg-[#ed905a] rounded-full w-[71%]"></div>
                                </div>

                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-500">35 Pending</span>
                                    <span class="text-xs bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-bold">Needs Action</span>
                                </div>
                            </div>

                            <!-- Visit Analysis -->
                            <div class="md:col-span-2 rounded-2xl bg-[#EB6C1A] dark:bg-slate-800 p-5 shadow-sm border border-slate-100 dark:border-slate-700">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <p class="text-[10px] font-bold text-white/80 uppercase tracking-widest">Field Activity</p>
                                        <h4 class="font-bold text-white dark:text-white">Visit Analysis</h4>
                                    </div>
                                    <div class="p-1.5 bg-white/20 rounded">
                                        <MapPin class="w-4 h-4 text-white" />
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                                    <div class="rounded-xl bg-white dark:bg-slate-700/30 p-3 text-center border border-slate-100 dark:border-slate-600">
                                        <div class="text-2xl font-bold text-[#015276]">12</div>
                                        <div class="text-[10px] font-bold uppercase text-[#015276]">Pre-sales Visit</div>
                                    </div>
                                    <div class="rounded-xl bg-white dark:bg-slate-700/30 p-3 text-center border border-slate-100 dark:border-slate-600">
                                        <div class="text-2xl font-bold text-[#015276]">8</div>
                                        <div class="text-[10px] font-bold uppercase text-[#015276]">Post-sales Visit</div>
                                    </div>
                                    <div class="rounded-xl bg-white dark:bg-slate-700/30 p-3 text-center border border-slate-100 dark:border-slate-600">
                                        <div class="text-2xl font-bold text-[#015276]">6</div>
                                        <div class="text-[10px] font-bold uppercase text-[#015276]">Dealer Visit</div>
                                    </div>
                                    <div class="rounded-xl bg-white dark:bg-slate-700/30 p-3 text-center border border-slate-100 dark:border-slate-600">
                                        <div class="text-2xl font-bold text-[#015276]">25</div>
                                        <div class="text-[10px] font-bold uppercase text-[#015276]">General Visit</div>
                                    </div>
                                    <div class="rounded-xl bg-white dark:bg-slate-700/30 p-3 text-center border border-slate-100 dark:border-slate-600">
                                        <div class="text-2xl font-bold text-[#015276]">9</div>
                                        <div class="text-[10px] font-bold uppercase text-[#015276]">Support Visit</div>
                                    </div>
                                </div>
                                <p class="text-center text-[10px] text-white/70 mt-2">Total 60 Visits this month</p>
                            </div>
                        </div>

                         <!-- ROW 3: METRICS -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5 mt-5">
                            <div class="rounded-2xl bg-[#FFFAF7] dark:bg-slate-800 p-5 shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col justify-between">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="p-1 bg-[#FFEEDE] rounded">
                                        <Box class="w-3.5 h-3.5 text-[#AC0C13]" />
                                    </div>
                                    <span class="text-xs font-bold uppercase text-slate-400">Samples</span>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xl font-bold text-[#015276] dark:text-white">64</p>
                                            <p class="text-[10px] text-slate-400 font-medium">Schools</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xl font-bold text-[#015276] dark:text-white">2345</p>
                                            <p class="text-[10px] text-slate-400 font-medium">Quantity</p>
                                        </div>
                                    </div>
                                    
                                    <div class="h-px bg-slate-200 dark:bg-slate-700"></div>
                                    
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-slate-500 font-medium">LY: 53 SCH</span>
                                        <span class="text-slate-500 font-medium">1876 QTY</span>
                                    </div>
                                </div>
                                
                                <span class="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-1 rounded mt-3 w-fit">+14% YoY</span>
                            </div>

                            <div class="rounded-2xl bg-[#FFFAF7] dark:bg-slate-800 p-5 shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col justify-between">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <div class="p-1 bg-[#FFEEDE] rounded">
                                                <Percent class="w-3.5 h-3.5 text-[#AC0C13]" />
                                            </div>
                                            <span class="text-xs font-bold uppercase text-slate-400">Discount</span>
                                        </div>
                                        <div class="space-y-2">
                                            <div>
                                                <p class="text-[10px] text-slate-400 font-semibold">Current</p>
                                                <span class="text-3xl font-bold text-[#015276] dark:text-white">41.5%</span>
                                            </div>
                                            <div>
                                                <p class="text-[10px] text-slate-400 font-semibold">LY Discount</p>
                                                <span class="text-lg font-bold text-slate-600 dark:text-slate-300">35.2%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded">Avg</span>
                                </div>
                                <p class="text-xs text-emerald-600 mt-3 font-bold">+ 6.3% (Increased)</p>
                            </div>

                            <div class="rounded-2xl bg-[#FFFAF7] dark:bg-slate-800 p-5 shadow-sm border border-slate-100 dark:border-slate-700 flex flex-col justify-between">
                                <div class="flex items-center gap-2 mb-3">
                                    <RotateCcw class="w-4 h-4 text-[#AC0C13] bg-[#FFEEDE] p-1 rounded" />
                                    <span class="text-xs font-bold uppercase text-slate-400">Sales Returns (LY)</span>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Units</p>
                                            <p class="text-xl font-bold text-[#015276] dark:text-white">3225</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Value</p>
                                            <p class="text-xl font-bold text-red-500" v-html="formatRupee('₹10.5L')"></p>
                                        </div>
                                    </div>
                                </div>
                                
                                <button class="mt-3 text-xs font-bold text-[#AC0C13] hover:text-[#8a0a0f] transition-colors flex items-center gap-1">
                                    View Breakdown 
                                    <ArrowRight class="w-3 h-3" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 3) TODAY'S ACTIONS -->
                    <div class="grid grid-cols-1 gap-8">
                         <!-- Tasks -->
                        <div class="rounded-2xl border border-slate-100 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
                            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 dark:border-slate-700">
                                <h3 class="flex items-center text-md font-bold text-slate-800 dark:text-white">
                                    <CheckSquare class="mr-2 h-5 w-5 text-[#AC0C13] bg-[#FFEEDE] p-1 rounded" />
                                    Today's Actions
                                </h3>
                                <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">4 Pending</span>
                            </div>
                            
                            <div class="divide-y divide-slate-50 dark:divide-slate-700/50">
                                <div v-for="task in tasks" :key="task.id" 
                                    class="group flex cursor-pointer items-start p-4 hover:bg-slate-50 transition-colors">
                                    
                                    <div class="mt-0.5 relative mr-3 flex h-5 w-5 flex-shrink-0 items-center justify-center rounded border border-slate-300 transition-colors group-hover:border-orange-500">
                                        <Check v-if="task.completed" class="h-3.5 w-3.5 text-[#AC0C13] bg-[#FFEEDE] p-0.5 rounded" />
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
                    </div>
                </div>

                <!-- RIGHT PANEL: UPDATES & INSIGHTS -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        
                        <!-- UPDATES & CELEBRATIONS CAROUSEL SECTION -->
                        <div>
                            <h3 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-[#AC0C13]"></div>
                                Updates & Celebrations
                            </h3>

                            <!-- Celebration Carousel Card -->
                            <div class="relative rounded-2xl overflow-hidden shadow-xl group border border-slate-200/50">
                                <!-- Slides Container -->
                                <div class="relative h-72 bg-slate-900">
                                    <div v-for="(slide, index) in celebrationSlides" :key="slide.id">
                                        <!-- Each Slide -->
                                        <Transition
                                            enter-active-class="transition-all duration-500 ease-out"
                                            enter-from-class="opacity-0 scale-105"
                                            enter-to-class="opacity-100 scale-100"
                                            leave-active-class="transition-all duration-500 ease-in"
                                            leave-from-class="opacity-100 scale-100"
                                            leave-to-class="opacity-0 scale-95"
                                        >
                                            <div v-show="currentSlide === index" class="absolute inset-0">
                                                <!-- Background Image with Blur Effect -->
                                                <div class="absolute inset-0 overflow-hidden">
                                                    <img :src="slide.image" 
                                                         :alt="slide.name" 
                                                         class="w-full h-full object-cover scale-110 blur-[2px]" 
                                                         loading="lazy" />
                                                </div>
                                                
                                                <!-- Dark Gradient Overlay -->
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
                                                
                                                <!-- Decorative Sparkles -->
                                                <div class="absolute inset-0 overflow-hidden pointer-events-none">
                                                    <div class="absolute top-4 left-4 w-1 h-1 bg-yellow-300 rounded-full animate-ping"></div>
                                                    <div class="absolute top-8 right-8 w-1.5 h-1.5 bg-orange-300 rounded-full animate-pulse"></div>
                                                    <div class="absolute bottom-20 left-8 w-1 h-1 bg-yellow-200 rounded-full animate-ping" style="animation-delay: 0.5s"></div>
                                                    <div class="absolute top-16 right-16 w-1 h-1 bg-white/60 rounded-full animate-pulse" style="animation-delay: 1s"></div>
                                                </div>
                                                
                                                <!-- Content -->
                                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center p-5 z-10">
                                                    <!-- Emoji with Glow -->
                                                    <div class="relative mb-3">
                                                        <div class="text-5xl" style="filter: drop-shadow(0 0 20px rgba(255,200,100,0.5));">{{ slide.emoji }}</div>
                                                    </div>
                                                    
                                                    <!-- Greeting -->
                                                    <h4 class="text-2xl font-bold text-white mb-1" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5);">
                                                        {{ slide.message }}
                                                    </h4>
                                                    
                                                    <!-- Personalized Name -->
                                                    <p class="text-lg font-semibold text-amber-300 mb-2" style="text-shadow: 1px 1px 4px rgba(0,0,0,0.5);">
                                                        {{ userName }}!
                                                    </p>
                                                </div>
                                            </div>
                                        </Transition>
                                    </div>
                                </div>

                                <!-- Navigation Arrows -->
                                <button @click="prevSlide" 
                                        class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-black/30 hover:bg-black/50 rounded-full transition-all z-20 opacity-0 group-hover:opacity-100">
                                    <ChevronLeft class="w-4 h-4 text-white" />
                                </button>
                                <button @click="nextSlide" 
                                        class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-black/30 hover:bg-black/50 rounded-full transition-all z-20 opacity-0 group-hover:opacity-100">
                                    <ChevronRightIcon class="w-4 h-4 text-white" />
                                </button>

                                <!-- Progress Bar & Dots -->
                                <div class="absolute bottom-0 left-0 right-0 z-20">
                                    <!-- Progress Bar -->
                                    <div class="h-0.5 bg-white/20">
                                        <div class="h-full bg-gradient-to-r from-amber-400 to-orange-500 transition-all duration-300" 
                                             :style="{ width: `${((currentSlide + 1) / celebrationSlides.length) * 100}%` }"></div>
                                    </div>
                                    
                                    <!-- Dots -->
                                    <div class="flex items-center justify-center gap-1.5 py-2 bg-gradient-to-t from-black/60 to-transparent">
                                        <button v-for="(slide, index) in celebrationSlides" :key="'dot-' + slide.id"
                                                @click="goToSlide(index)"
                                                :class="[
                                                    'transition-all duration-300 rounded-full',
                                                    currentSlide === index 
                                                        ? 'w-5 h-1.5 bg-amber-400' 
                                                        : 'w-1.5 h-1.5 bg-white/40 hover:bg-white/60'
                                                ]">
                                        </button>
                                    </div>
                                </div>

                                <!-- Festival Name Tag -->
                                <div class="absolute top-3 right-3 z-20">
                                    <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-white bg-black/40 backdrop-blur-sm rounded-md border border-white/10">
                                        {{ celebrationSlides[currentSlide].name }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- MY INSIGHTS SECTION -->
                        <div>
                            <h3 class="text-base font-bold text-[#000000] dark:text-[#000000] mb-4 flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-[#000000] animate-pulse"></div>
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
                                            <component :is="insight.icon" class="h-4 w-4 text-[#AC0C13] bg-[#FFEEDE] p-0.5 rounded" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium leading-snug text-slate-700 dark:text-slate-300">
                                                {{ insight.text }}
                                            </p>
                                            <button v-if="insight.action" class="mt-2 text-xs font-bold text-slate-500 hover:text-indigo-600 uppercase flex items-center gap-1">
                                                {{ insight.action }} <ChevronRight class="w-3 h-3 text-[#AC0C13] bg-[#FFEEDE] p-0.5 rounded" />
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

            <!-- MY SCHOOLS FULL WIDTH CHART SECTION -->
            <div class="rounded-2xl border border-slate-100 bg-white p-4 sm:p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="mb-6 flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                    <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 dark:text-white">
                        <School class="h-6 w-6 text-[#AC0C13]" />
                        My Schools
                    </h3>
                    <div class="flex w-full flex-col gap-4 md:w-auto md:flex-row md:items-center">
                        <!-- Legend -->
                        <div class="flex flex-wrap gap-x-4 gap-y-2">
                            <div class="flex items-center gap-1.5">
                                <div class="h-3 w-3 rounded-sm bg-[#4472C4]"></div>
                                <span class="text-[11px] font-medium text-slate-600">Assigned</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="h-3 w-3 rounded-sm bg-[#ED7D31]"></div>
                                <span class="text-[11px] font-medium text-slate-600">User</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="h-3 w-3 rounded-sm bg-[#A5A5A5]"></div>
                                <span class="text-[11px] font-medium text-slate-600">Non-User</span>
                            </div>
                        </div>
                        <span class="cursor-pointer text-xs font-bold text-blue-600 hover:underline">View All</span>
                    </div>
                </div>

                <div class="overflow-x-auto pb-4">
                    <div class="min-w-[650px]">

                <!-- Vertical Bar Chart Container -->
                <div class="flex">
                    <!-- Y-Axis Labels -->
                    <div class="flex flex-col justify-between pr-3 text-right" style="height: 260px;">
                        <span class="text-[10px] font-medium text-slate-400">140</span>
                        <span class="text-[10px] font-medium text-slate-400">120</span>
                        <span class="text-[10px] font-medium text-slate-400">100</span>
                        <span class="text-[10px] font-medium text-slate-400">80</span>
                        <span class="text-[10px] font-medium text-slate-400">60</span>
                        <span class="text-[10px] font-medium text-slate-400">40</span>
                        <span class="text-[10px] font-medium text-slate-400">20</span>
                        <span class="text-[10px] font-medium text-slate-400">0</span>
                    </div>

                    <!-- Chart Area -->
                    <div class="flex-1 relative">
                        <!-- Grid Lines -->
                        <div class="absolute inset-0 flex flex-col justify-between pointer-events-none" style="height: 260px;">
                            <div class="border-b border-slate-100"></div>
                            <div class="border-b border-slate-100"></div>
                            <div class="border-b border-slate-100"></div>
                            <div class="border-b border-slate-100"></div>
                            <div class="border-b border-slate-100"></div>
                            <div class="border-b border-slate-100"></div>
                            <div class="border-b border-slate-100"></div>
                            <div class="border-b border-slate-200"></div>
                        </div>

                        <!-- Bars Container -->
                        <div class="flex items-end justify-around gap-4 relative z-10 px-4" style="height: 260px;">
                            <!-- CBSE Group -->
                            <div class="flex flex-col items-center flex-1">
                                <div class="flex items-end gap-2 h-full w-full justify-center">
                                    <div class="w-7 bg-[#4472C4] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 18px; min-height: 18px;"></div>
                                    <div class="w-7 bg-[#ED7D31] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 5px; min-height: 5px;"></div>
                                    <div class="w-7 bg-[#A5A5A5] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 13px; min-height: 13px;"></div>
                                </div>
                            </div>

                            <!-- ICSE Group -->
                            <div class="flex flex-col items-center flex-1">
                                <div class="flex items-end gap-2 h-full w-full justify-center">
                                    <div class="w-7 bg-[#4472C4] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 36px; min-height: 36px;"></div>
                                    <div class="w-7 bg-[#ED7D31] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 18px; min-height: 18px;"></div>
                                    <div class="w-7 bg-[#A5A5A5] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 18px; min-height: 18px;"></div>
                                </div>
                            </div>

                            <!-- STATE BOARD Group -->
                            <div class="flex flex-col items-center flex-1">
                                <div class="flex items-end gap-2 h-full w-full justify-center">
                                    <div class="w-7 bg-[#4472C4] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 164px; min-height: 164px;"></div>
                                    <div class="w-7 bg-[#ED7D31] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 95px; min-height: 95px;"></div>
                                    <div class="w-7 bg-[#A5A5A5] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 69px; min-height: 69px;"></div>
                                </div>
                            </div>

                            <!-- IGCSE Group -->
                            <div class="flex flex-col items-center flex-1">
                                <div class="flex items-end gap-2 h-full w-full justify-center">
                                    <div class="w-7 bg-[#4472C4] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 18px; min-height: 18px;"></div>
                                    <div class="w-7 bg-[#ED7D31] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 9px; min-height: 9px;"></div>
                                    <div class="w-7 bg-[#A5A5A5] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 9px; min-height: 9px;"></div>
                                </div>
                            </div>

                            <!-- TOTAL Group -->
                            <div class="flex flex-col items-center flex-1">
                                <div class="flex items-end gap-2 h-full w-full justify-center">
                                    <div class="w-7 bg-[#4472C4] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 237px; min-height: 237px;"></div>
                                    <div class="w-7 bg-[#ED7D31] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 128px; min-height: 128px;"></div>
                                    <div class="w-7 bg-[#A5A5A5] rounded-t-sm cursor-pointer hover:opacity-80" style="height: 109px; min-height: 109px;"></div>
                                </div>
                            </div>
                        </div>

                                <!-- X-Axis Labels -->
                                <div class="mt-3 flex justify-around border-t border-slate-200 pt-3">
                                    <span class="text-[11px] font-bold uppercase text-slate-600">CBSE</span>
                                    <span class="text-[11px] font-bold uppercase text-slate-600">ICSE</span>
                                    <span class="text-[11px] font-bold uppercase text-slate-600">State Board</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table Below Chart -->
                <div class="mt-6 overflow-x-auto">
                    <table class="w-full text-[11px]">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-2 px-3 font-bold text-slate-500"></th>
                                <th class="text-center py-2 px-3 font-bold text-slate-600">CBSE</th>
                                <th class="text-center py-2 px-3 font-bold text-slate-600">ICSE</th>
                                <th class="text-center py-2 px-3 font-bold text-slate-600">STATE BOARD</th>
                                <th class="text-center py-2 px-3 font-bold text-slate-600">IGCSE</th>
                                <th class="text-center py-2 px-3 font-bold text-slate-700 bg-slate-50">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-slate-100">
                                <td class="py-2 px-3 font-medium text-slate-600 flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-sm bg-[#4472C4]"></div>
                                    Assigned Schools
                                </td>
                                <td class="text-center py-2 px-3 text-slate-700">10</td>
                                <td class="text-center py-2 px-3 text-slate-700">20</td>
                                <td class="text-center py-2 px-3 text-slate-700">90</td>
                                <td class="text-center py-2 px-3 text-slate-700">10</td>
                                <td class="text-center py-2 px-3 font-bold text-slate-800 bg-slate-50">130</td>
                            </tr>
                            <tr class="border-b border-slate-100">
                                <td class="py-2 px-3 font-medium text-slate-600 flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-sm bg-[#ED7D31]"></div>
                                    User Schools
                                </td>
                                <td class="text-center py-2 px-3 text-slate-700">3</td>
                                <td class="text-center py-2 px-3 text-slate-700">10</td>
                                <td class="text-center py-2 px-3 text-slate-700">52</td>
                                <td class="text-center py-2 px-3 text-slate-700">5</td>
                                <td class="text-center py-2 px-3 font-bold text-slate-800 bg-slate-50">70</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-3 font-medium text-slate-600 flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-sm bg-[#A5A5A5]"></div>
                                    Non-User Schools
                                </td>
                                <td class="text-center py-2 px-3 text-slate-700">7</td>
                                <td class="text-center py-2 px-3 text-slate-700">10</td>
                                <td class="text-center py-2 px-3 text-slate-700">38</td>
                                <td class="text-center py-2 px-3 text-slate-700">5</td>
                                <td class="text-center py-2 px-3 font-bold text-slate-800 bg-slate-50">60</td>
                            </tr>
                        </tbody>
                    </table>
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
