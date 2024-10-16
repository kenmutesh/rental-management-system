<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { AcademicCapIcon, CashIcon, DocumentTextIcon, PlusIcon } from '@heroicons/vue/outline';

const tenantsSummary = ref({
    totalTenants: 100,
    totalBalance: 5000,
    defaultLeases: 5,
});
</script>

<template>
    <Head title="Tenants" />
    <app-layout>
        <div class="flex mb-6">
            <Link
                href="/tenants/create"
                class="flex items-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 ml-auto"
            >
                <PlusIcon class="w-5 h-5 mr-2" />
                Create Tenant
            </Link>
        </div>


        <div class="container mx-auto px-4">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Total Tenants Card -->
                <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
                    <AcademicCapIcon class="h-16 w-16 text-blue-500 mr-2" />
                    <div>
                        <h2 class="text-lg font-semibold">Total Tenants</h2>
                        <p class="text-2xl">{{ tenantsSummary.totalTenants }}</p>
                    </div>
                </div>

                <!-- Total Balance Card -->
                <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
                    <CashIcon class="h-16 w-16 text-green-500 mr-2" />
                    <div>
                        <h2 class="text-lg font-semibold">Total Balance</h2>
                        <p class="text-2xl">KES {{ tenantsSummary.totalBalance }}</p>
                    </div>
                </div>

                <!-- Default Leases Card -->
                <div class="bg-white shadow-md rounded-lg p-4 flex items-center">
                    <DocumentTextIcon class="h-16 w-16 text-yellow-500 mr-2" />
                    <div>
                        <h2 class="text-lg font-semibold">Default Leases</h2>
                        <p class="text-2xl">{{ tenantsSummary.defaultLeases }}</p>
                    </div>
                </div>
            </div>


            <!-- Tenants Table -->
            <div class="bg-white shadow-md rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                           <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lease Expiration</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="tenant in []" :key="tenant.id">
                            <td class="px-6 py-4 whitespace-nowrap">1</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ tenant.name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${{ tenant.balance }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ tenant.lease_expiration }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </app-layout>
</template>
