<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';

// Props passed from Inertia
const props = defineProps(['utilities']);

const utilityForm = useForm({
    id: null,
    name: '',
    status: false,
    requires_reading: false, // Field for reading requirement
    fee_type: 'monthly', // Default fee type
    price: null, // Field for price
});

// Function to handle form submission
const saveUtility = async () => {
    const url = utilityForm.id ? `/utilities/${utilityForm.id}` : '/utilities';
    const method = utilityForm.id ? 'put' : 'post';

    utilityForm.post(url, {
        method,
        onFinish: () => resetForm(),
    });
};

// Reset form fields
const resetForm = () => {
    utilityForm.reset();
};

// Edit utility
const editUtility = (utility) => {
    utilityForm.setData({ ...utility }); // Set data in the form
};
</script>

<template>
    <Head title="Utilities" />
    <app-layout>
        <div class="max-w-6xl mx-auto py-12">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-4">Manage Utilities</h1>
                <form @submit.prevent="saveUtility">
                    <!-- Utility Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Utility Name</label>
                        <input
                            type="text"
                            id="name"
                            v-model="utilityForm.name"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                            required
                        />
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="inline-flex items-center">
                            <input
                                type="checkbox"
                                id="status"
                                v-model="utilityForm.status"
                                class="form-checkbox h-4 w-4 text-blue-600"
                            />
                            <span class="ml-2 text-gray-700">Active</span>
                        </label>
                    </div>

                    <!-- Requires Reading -->
                    <div class="mb-4">
                        <label for="requires_reading" class="inline-flex items-center">
                            <input
                                type="checkbox"
                                id="requires_reading"
                                v-model="utilityForm.requires_reading"
                                class="form-checkbox h-4 w-4 text-blue-600"
                            />
                            <span class="ml-2 text-gray-700">Requires Current Reading</span>
                        </label>
                    </div>

                    <!-- Fee Type -->
                    <div class="mb-4">
                        <label for="fee_type" class="block text-sm font-medium text-gray-700">Fee Type</label>
                        <select
                            id="fee_type"
                            v-model="utilityForm.fee_type"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                            required
                        >
                            <option value="one_time">One Time</option>
                            <option value="renewable">Renewable</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input
                            type="number"
                            id="price"
                            v-model="utilityForm.price"
                            step="0.01"
                            min="0"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                            required
                        />
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"
                        >
                            {{ utilityForm.id ? 'Update Utility' : 'Add Utility' }}
                        </button>
                    </div>
                </form>

                <!-- Utilities Table -->
                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-4">Utilities List</h2>
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Requires Reading</th>
                                <th class="px-4 py-2 border">Fee Type</th>
                                <th class="px-4 py-2 border">Price</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="utility in props.utilities" :key="utility.id">
                                <td class="px-4 py-2 border">{{ utility.name }}</td>
                                <td class="px-4 py-2 border">{{ utility.status ? 'Active' : 'Inactive' }}</td>
                                <td class="px-4 py-2 border">{{ utility.requires_reading ? 'Yes' : 'No' }}</td>
                                <td class="px-4 py-2 border">{{ utility.fee_type }}</td>
                                <td class="px-4 py-2 border">${{ utility.price.toFixed(2) }}</td>
                                <td class="px-4 py-2 border">
                                    <button
                                        @click="editUtility(utility)"
                                        class="text-blue-500 hover:text-blue-700"
                                    >
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </app-layout>
</template>
