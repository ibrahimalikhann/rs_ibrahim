<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { 
    Shield,
    Lock,
    Smartphone,
    Key,
    CheckCircle2,
    AlertCircle,
    QrCode,
    Eye,
    EyeOff,
    Copy,
    RefreshCw,
    Clock,
    Globe,
    Database,
    Zap,
    Activity,
    Download
} from 'lucide-vue-next';

// ============================================
// STATE
// ============================================

const activeSecurityTab = ref('overview');
const show2FASetup = ref(false);
const showMobileOtpSetup = ref(false);
const show2FABackupCodes = ref(false);
const copiedCode = ref(null);
const twoFactorEnabled = ref(true);
const mobileOtpEnabled = ref(true);

// ============================================
// SECURITY DATA
// ============================================

const securityStatus = [
    { 
        label: 'Two-Factor Authentication',
        status: 'Active',
        color: 'text-emerald-600 bg-emerald-50',
        icon: Smartphone,
        description: 'Google Authenticator enabled'
    },
    { 
        label: 'Mobile OTP',
        status: 'Active',
        color: 'text-emerald-600 bg-emerald-50',
        icon: Smartphone,
        description: 'SMS verification active'
    },
    { 
        label: 'SSL/TLS Certificate',
        status: 'Valid',
        color: 'text-emerald-600 bg-emerald-50',
        icon: Globe,
        description: 'Expires: 15 Dec 2025'
    },
    { 
        label: 'Password Strength',
        status: 'Strong',
        color: 'text-emerald-600 bg-emerald-50',
        icon: Key,
        description: 'Last changed: 30 days ago'
    }
];

const backupCodes = [
    '5F3K-2M9L-7P1Q',
    '8R6T-4V2W-9X3Y',
    '2B5C-7D9E-1F4G',
    '6H8I-3J2K-5L7M',
    '9N1O-4P6Q-8R2S'
];

const securityLayers = [
    {
        icon: Shield,
        title: 'End-to-End Encryption',
        description: 'All data is encrypted with AES-256 encryption',
        status: 'Active'
    },
    {
        icon: Lock,
        title: 'Session Security',
        description: 'Automatic session timeout after 30 minutes of inactivity',
        status: 'Active'
    },
    {
        icon: Database,
        title: 'Data Backup',
        description: 'Real-time encrypted backups every 6 hours',
        status: 'Active'
    },
    {
        icon: Activity,
        title: 'Login Monitoring',
        description: 'Suspicious login alerts enabled',
        status: 'Active'
    },
    {
        icon: Zap,
        title: 'DDoS Protection',
        description: 'Enterprise-grade DDoS mitigation active',
        status: 'Active'
    },
    {
        icon: Globe,
        title: 'Geo-Blocking',
        description: 'Location-based access control enabled',
        status: 'Active'
    }
];

const loginHistory = [
    { device: 'Chrome on Windows', location: 'New Delhi, India', time: '2 hours ago', status: 'Current Session' },
    { device: 'Safari on iPhone', location: 'New Delhi, India', time: '1 day ago', status: 'Verified' },
    { device: 'Chrome on Windows', location: 'New Delhi, India', time: '3 days ago', status: 'Verified' },
    { device: 'Firefox on Linux', location: 'Bangalore, India', time: '7 days ago', status: 'Verified' },
];

// ============================================
// FUNCTIONS
// ============================================

const copyBackupCode = (code) => {
    navigator.clipboard.writeText(code);
    copiedCode.value = code;
    setTimeout(() => { copiedCode.value = null; }, 2000);
};

const downloadBackupCodes = () => {
    const text = backupCodes.join('\n');
    const blob = new Blob([text], { type: 'text/plain' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'backup-codes.txt';
    a.click();
};

const toggle2FA = () => {
    twoFactorEnabled.value = !twoFactorEnabled.value;
};

const toggleMobileOtp = () => {
    mobileOtpEnabled.value = !mobileOtpEnabled.value;
};

</script>

<template>
    <Head title="Security Settings" />

    <AuthenticatedLayout>
        <div class="max-w-6xl mx-auto space-y-6">

            <!-- PAGE HEADER -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-2">
                    <Shield class="w-8 h-8 text-blue-600" />
                    <h1 class="text-3xl font-bold text-slate-900">Security & Privacy</h1>
                </div>
                <p class="text-slate-600">Manage your account security settings and view security logs</p>
            </div>

            <!-- SECURITY STATUS OVERVIEW -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div v-for="(item, idx) in securityStatus" :key="idx" class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div :class="['p-2 rounded-lg', item.color]">
                            <component :is="item.icon" class="w-5 h-5" />
                        </div>
                        <CheckCircle2 class="w-5 h-5 text-emerald-600" />
                    </div>
                    <h3 class="font-bold text-slate-800 text-sm">{{ item.label }}</h3>
                    <p class="text-xs text-slate-500 mt-1">{{ item.description }}</p>
                    <span class="inline-block mt-3 px-2 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full">{{ item.status }}</span>
                </div>
            </div>

            <!-- MAIN SECURITY MANAGEMENT -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- LEFT COLUMN: 2FA & OTP -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- 2FA Setup Card -->
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <QrCode class="w-5 h-5 text-blue-600" />
                                <div>
                                    <h3 class="font-bold text-slate-800">Two-Factor Authentication (2FA)</h3>
                                    <p class="text-xs text-slate-600 mt-0.5">Google Authenticator</p>
                                </div>
                            </div>
                            <span :class="['px-3 py-1 rounded-full text-xs font-bold', twoFactorEnabled ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600']">
                                {{ twoFactorEnabled ? 'ENABLED' : 'DISABLED' }}
                            </span>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <p class="text-slate-600 text-sm">Two-factor authentication provides an extra layer of security. You'll be required to enter a code from your authenticator app in addition to your password.</p>
                            
                            <div v-if="twoFactorEnabled" class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                                <div class="flex gap-3">
                                    <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" />
                                    <div>
                                        <p class="font-bold text-emerald-900 text-sm">2FA is active on your account</p>
                                        <p class="text-xs text-emerald-700 mt-1">Device: Google Authenticator (Synced)</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button 
                                    @click="show2FASetup = !show2FASetup"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors">
                                    {{ show2FASetup ? 'Hide' : 'View' }} QR Code
                                </button>
                                <button 
                                    @click="toggle2FA"
                                    class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-bold rounded-lg transition-colors">
                                    Disable 2FA
                                </button>
                            </div>

                            <!-- QR CODE SETUP -->
                            <transition name="fade">
                                <div v-if="show2FASetup" class="mt-4 pt-4 border-t border-slate-200">
                                    <div class="bg-slate-50 rounded-lg p-6 flex flex-col items-center">
                                        <p class="text-xs font-bold text-slate-600 uppercase mb-3">Scan with Authenticator App</p>
                                        <div class="w-40 h-40 bg-white border-2 border-slate-300 rounded-lg flex items-center justify-center mb-4">
                                            <QrCode class="w-20 h-20 text-slate-300" />
                                        </div>
                                        <p class="text-[11px] text-slate-600 text-center mb-3">Or enter this code manually:</p>
                                        <div class="bg-white border border-slate-300 rounded px-3 py-2 text-sm font-mono text-slate-800 mb-4 font-bold">JBSWY3DPEBLW64TMMQ======</div>
                                        <button 
                                            @click="show2FABackupCodes = true"
                                            class="text-xs text-blue-600 hover:text-blue-700 font-bold">
                                            View Backup Codes →
                                        </button>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>

                    <!-- MOBILE OTP CARD -->
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <Smartphone class="w-5 h-5 text-green-600" />
                                <div>
                                    <h3 class="font-bold text-slate-800">Mobile OTP Verification</h3>
                                    <p class="text-xs text-slate-600 mt-0.5">SMS-based authentication</p>
                                </div>
                            </div>
                            <span :class="['px-3 py-1 rounded-full text-xs font-bold', mobileOtpEnabled ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600']">
                                {{ mobileOtpEnabled ? 'ENABLED' : 'DISABLED' }}
                            </span>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <p class="text-slate-600 text-sm">Receive one-time passwords via SMS to your registered mobile number for additional security verification.</p>
                            
                            <div v-if="mobileOtpEnabled" class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                                <div class="flex gap-3">
                                    <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" />
                                    <div>
                                        <p class="font-bold text-emerald-900 text-sm">Mobile OTP is active</p>
                                        <p class="text-xs text-emerald-700 mt-1">Registered Phone: +91 98765-XXXXX</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <button 
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg transition-colors">
                                    Edit Phone Number
                                </button>
                                <button 
                                    @click="toggleMobileOtp"
                                    class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-bold rounded-lg transition-colors">
                                    Disable OTP
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: SECURITY LAYERS -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden h-fit">
                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 px-6 py-4 border-b border-slate-200">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <Shield class="w-5 h-5 text-purple-600" /> Active Security Layers
                        </h3>
                    </div>

                    <div class="p-4 space-y-3 max-h-96 overflow-y-auto">
                        <div v-for="(layer, idx) in securityLayers" :key="idx" class="border-b border-slate-100 pb-3 last:border-0 last:pb-0">
                            <div class="flex items-start gap-3">
                                <div class="p-2 rounded-lg bg-blue-50 shrink-0 mt-0.5">
                                    <component :is="layer.icon" class="w-4 h-4 text-blue-600" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-slate-800 text-xs">{{ layer.title }}</p>
                                    <p class="text-[11px] text-slate-600 mt-1 line-clamp-2">{{ layer.description }}</p>
                                </div>
                                <CheckCircle2 class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- BACKUP CODES MODAL -->
            <transition 
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95">
                <div v-if="show2FABackupCodes" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
                    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <Download class="w-5 h-5" /> Backup Codes
                            </h2>
                            <p class="text-orange-100 text-xs mt-1">Save these codes in a secure location</p>
                        </div>

                        <!-- Body -->
                        <div class="p-6 space-y-4">
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 flex gap-3">
                                <AlertCircle class="w-5 h-5 text-red-600 shrink-0 mt-0.5" />
                                <div>
                                    <p class="text-xs font-bold text-red-900">Important!</p>
                                    <p class="text-xs text-red-700 mt-1">Store these codes in a safe place. Each code can only be used once.</p>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div v-for="(code, idx) in backupCodes" :key="idx" class="flex items-center justify-between p-3 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 transition-colors">
                                    <span class="font-mono text-sm font-bold text-slate-700">{{ code }}</span>
                                    <button 
                                        @click="copyBackupCode(code)"
                                        class="p-1 hover:bg-slate-200 rounded transition-colors">
                                        <Copy v-if="copiedCode !== code" class="w-4 h-4 text-slate-500" />
                                        <CheckCircle2 v-else class="w-4 h-4 text-emerald-600" />
                                    </button>
                                </div>
                            </div>

                            <button 
                                @click="downloadBackupCodes"
                                class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-lg transition-colors flex items-center justify-center gap-2">
                                <Download class="w-4 h-4" /> Download as Text
                            </button>
                        </div>

                        <!-- Footer -->
                        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                            <button 
                                @click="show2FABackupCodes = false"
                                class="w-full px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-bold rounded-lg transition-colors">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </transition>

            <!-- LOGIN HISTORY -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-6 py-4 border-b border-slate-200">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <Activity class="w-5 h-5 text-slate-600" /> Recent Login Activity
                    </h3>
                </div>

                <div class="divide-y divide-slate-100">
                    <div v-for="(login, idx) in loginHistory" :key="idx" class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-lg bg-blue-50">
                                <Smartphone class="w-5 h-5 text-blue-600" />
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">{{ login.device }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <MapPin class="w-3 h-3 text-slate-500" />
                                    <span class="text-xs text-slate-600">{{ login.location }}</span>
                                    <span class="text-xs text-slate-400">•</span>
                                    <Clock class="w-3 h-3 text-slate-500" />
                                    <span class="text-xs text-slate-600">{{ login.time }}</span>
                                </div>
                            </div>
                        </div>
                        <span :class="['px-3 py-1 rounded-full text-xs font-bold', login.status === 'Current Session' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700']">
                            {{ login.status }}
                        </span>
                    </div>
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
