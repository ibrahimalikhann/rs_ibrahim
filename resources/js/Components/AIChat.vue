<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { 
    Sparkles, 
    X, 
    Send, 
    Bot, 
    MessageSquare, 
    User, 
    ArrowRight,
    Search,
    HelpCircle,
    LayoutDashboard,
    PieChart
} from 'lucide-vue-next';

const isOpen = ref(false);
const message = ref('');
const messages = ref([
    {
        id: 1,
        type: 'bot',
        content: "Hi there! ðŸ‘‹ I'm your Ratna Sagar AI assistant. How can I help you today?",
        timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    }
]);

const faqs = [
    { text: 'Where is my profile?', icon: User, response: 'You can find your profile by clicking on your name in the top right corner or selecting "My Profile" from the sidebar.' },
    { text: 'How to raise an issue?', icon: HelpCircle, response: 'Go to the "Support" section in the sidebar and select "Service Desk" to raise a new issue.' },
    { text: 'Show Sales stats', icon: PieChart, response: 'Sales statistics are available in the "Sales" section and the "Analytics" dashboard.' },
    { text: 'General Help', icon: Search, response: 'I can help with navigation, finding documents, or explaining system features. Just ask!' }
];

const isTyping = ref(false);
const messagesContainer = ref(null);

const scrollToBottom = async () => {
    await nextTick();
    if (messagesContainer.value) {
        messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight;
    }
};

const toggleChat = () => {
    isOpen.value = !isOpen.value;
    if (isOpen.value) {
        scrollToBottom();
    }
};

const sendMessage = (text) => {
    const input = text || message.value;
    if (!input.trim()) return;

    messages.value.push({
        id: Date.now(),
        type: 'user',
        content: input,
        timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    });

    if (!text) message.value = '';
    scrollToBottom();

    // Mock AI Response logic
    isTyping.value = true;
    scrollToBottom();

    setTimeout(() => {
        isTyping.value = false;
        let response = "I'm processing your request. Could you please provide more details so I can assist you better?";
        
        // Simple mock matching
        const lowerInput = input.toLowerCase();
        const matchedFaq = faqs.find(f => lowerInput.includes(f.text.toLowerCase().split(' ').pop()));
        
        if (matchedFaq) {
            response = matchedFaq.response;
        } else if (lowerInput.includes('hello') || lowerInput.includes('hi')) {
            response = "Hello! I'm Ratna Sagar AI. I can help you navigate the ERP system. What's on your mind?";
        } else if (lowerInput.includes('thank')) {
            response = "You're very welcome! Let me know if you need anything else.";
        } else if (lowerInput.includes('where') && lowerInput.includes('dashboard')) {
            response = "The main dashboard can be accessed by clicking 'Overview' at the top of the sidebar.";
        }

        messages.value.push({
            id: Date.now(),
            type: 'bot',
            content: response,
            timestamp: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        });
        scrollToBottom();
    }, 1500);
};

onMounted(() => {
    // Initial scroll
    scrollToBottom();
});

defineExpose({ toggleChat });
</script>

<template>
    <div class="fixed bottom-6 right-6 z-[100] font-sans">
        <!-- Floating Chat Button (Tawk.to style) -->
        <button 
            @click="toggleChat"
            class="group relative w-16 h-16 bg-gradient-to-br from-[#F88313] to-[#E6611D] rounded-full shadow-2xl flex items-center justify-center text-white transition-all duration-300 hover:scale-110 active:scale-95 z-50 overflow-hidden"
        >
            <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <Transition name="fade-scale" mode="out-in">
                <Sparkles v-if="!isOpen" class="w-8 h-8 drop-shadow-md" />
                <X v-else class="w-8 h-8" />
            </Transition>
            
            <!-- Pulse Effect -->
            <span v-if="!isOpen" class="absolute inset-0 rounded-full bg-orange-400 animate-ping opacity-20 -z-10"></span>
        </button>

        <!-- Chat Window -->
        <Transition name="slide-up">
            <div 
                v-if="isOpen"
                class="absolute bottom-20 right-0 w-[400px] h-[600px] max-h-[calc(100vh-120px)] bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] flex flex-col overflow-hidden border border-slate-100 ring-1 ring-black/5"
            >
                <!-- Header -->
                <div class="p-6 bg-gradient-to-r from-[rgb(143,5,7)] to-[#E6611D] text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30">
                                <Bot class="w-7 h-7" />
                            </div>
                            <div>
                                <h3 class="font-bold text-lg leading-tight">Ratna Sagar AI</h3>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    <span class="text-xs font-medium text-white/80 uppercase tracking-widest">Always Online</span>
                                </div>
                            </div>
                        </div>
                        <button @click="isOpen = false" class="p-2 hover:bg-white/10 rounded-xl transition-colors">
                            <X class="w-5 h-5" />
                        </button>
                    </div>
                    <p class="text-sm text-white/80 font-medium">Empowering your workflow with smart assistance.</p>
                </div>

                <!-- Chat Area -->
                <div 
                    ref="messagesContainer"
                    class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50/50 sidebar-scroll"
                >
                    <div v-for="msg in messages" :key="msg.id" :class="[
                        'flex flex-col max-w-[85%]',
                        msg.type === 'bot' ? 'items-start' : 'items-end ml-auto'
                    ]">
                        <!-- Message Content -->
                        <div 
                            :class="[
                                'px-4 py-3 rounded-2xl text-[15px] leading-relaxed shadow-sm',
                                msg.type === 'bot' 
                                    ? 'bg-white text-slate-700 border border-slate-200 rounded-tl-none' 
                                    : 'bg-gradient-to-r from-[#F88313] to-[#E6611D] text-white rounded-tr-none'
                            ]"
                        >
                            {{ msg.content }}
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 mt-1.5 uppercase tracking-tighter px-1">
                            {{ msg.timestamp }}
                        </span>
                    </div>

                    <!-- Typing Animation -->
                    <div v-if="isTyping" class="flex flex-col items-start max-w-[85%]">
                        <div class="bg-white px-4 py-4 rounded-2xl text-slate-400 border border-slate-200 rounded-tl-none flex gap-1.5 shadow-sm">
                            <div class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce"></div>
                            <div class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce [animation-delay:-0.15s]"></div>
                            <div class="w-1.5 h-1.5 bg-slate-300 rounded-full animate-bounce [animation-delay:-0.3s]"></div>
                        </div>
                    </div>
                </div>

                <!-- FAQs and Input -->
                <div class="p-4 border-t border-slate-100 bg-white">
                    <!-- FAQ Quick Actions -->
                    <div class="flex gap-2 overflow-x-auto pb-4 mb-2 no-scrollbar">
                        <button 
                            v-for="faq in faqs" 
                            :key="faq.text"
                            @click="sendMessage(faq.text)"
                            class="flex-shrink-0 flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-orange-50 text-slate-600 hover:text-orange-600 rounded-full border border-slate-200 hover:border-orange-200 text-sm font-semibold transition-all duration-200"
                        >
                            <component :is="faq.icon" class="w-4 h-4" />
                            {{ faq.text }}
                        </button>
                    </div>

                    <!-- Input Area -->
                    <div class="relative flex items-center gap-2">
                        <div class="relative flex-1 group">
                            <input 
                                v-model="message"
                                @keyup.enter="sendMessage()"
                                type="text" 
                                placeholder="Type your question..."
                                class="w-full pl-5 pr-12 py-3.5 bg-slate-100 hover:bg-slate-200/70 focus:bg-white border-transparent focus:border-orange-500 rounded-2xl text-slate-700 placeholder:text-slate-400 focus:ring-4 focus:ring-orange-500/10 transition-all duration-300 outline-none"
                            />
                            <button 
                                @click="sendMessage()"
                                class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-gradient-to-r from-[#F88313] to-[#E6611D] text-white rounded-xl shadow-lg shadow-orange-200 hover:scale-105 active:scale-95 transition-all duration-200"
                            >
                                <Send class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <p class="text-[11px] text-slate-400 font-medium">Powered by Ratna Sagar GenAI v2.0</p>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.sidebar-scroll::-webkit-scrollbar {
    width: 4px;
}
.sidebar-scroll::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}

.slide-up-enter-active,
.slide-up-leave-active {
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

.slide-up-enter-from,
.slide-up-leave-to {
    opacity: 0;
    transform: translateY(20px) scale(0.95);
}

.fade-scale-enter-active,
.fade-scale-leave-active {
    transition: all 0.2s ease;
}

.fade-scale-enter-from,
.fade-scale-leave-to {
    opacity: 0;
    transform: scale(0.8);
}
</style>
