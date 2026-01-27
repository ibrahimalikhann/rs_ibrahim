<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import StatCard from '@/Components/StatCard.vue';
import { Server, Users, AlertCircle, Shield } from 'lucide-vue-next';

const stats = [
    { title: 'System Health', value: '99.9%', change: 'Stable', trend: 'neutral', icon: Server },
    { title: 'Total Users', value: '1,234', change: '+56', trend: 'up', icon: Users },
    { title: 'Error Logs', value: '23', change: '-5', trend: 'up', icon: AlertCircle }, // trend up means good here visually (green) but technically errors going down is good. StatCard logic might need tweak or just pass 'up' for green.
    { title: 'Security Alerts', value: '0', change: 'Safe', trend: 'neutral', icon: Shield },
];
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                System Administration
            </h2>
        </template>

        <div class="space-y-6">
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Admin Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400">System monitoring and user management.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <StatCard v-for="(stat, index) in stats" :key="index" v-bind="stat" />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Logs -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">System Logs</h3>
                        <button class="text-sm text-primary-600 hover:text-primary-700">View All</button>
                    </div>
                    <div class="p-4 space-y-3">
                         <div v-for="i in 4" :key="i" class="flex items-start space-x-3 text-sm">
                            <span class="text-gray-400 font-mono text-xs mt-1">10:4{{ i }} QM</span>
                            <div>
                                <p class="text-gray-900 dark:text-gray-100 font-medium">User Login Attempt</p>
                                <p class="text-gray-500 dark:text-gray-400">IP 192.168.1.{{ i }}0 - Success</p>
                            </div>
                         </div>
                    </div>
                </div>

                <!-- User Management Shortcut -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors text-center">
                            <Users class="h-6 w-6 mx-auto mb-2 text-gray-600 dark:text-gray-300" />
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Manage Users</span>
                        </button>
                        <button class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors text-center">
                            <Shield class="h-6 w-6 mx-auto mb-2 text-gray-600 dark:text-gray-300" />
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Roles & Permissions</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
