<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';

// Props passed from Inertia
const props = defineProps(['utilities']);

const utilityForm = ref({
    id: null,
    name: '',
    status: false,
    type: 'once', // Default type
});

// Function to handle form submission
const saveUtility = async () => {
    const url = utilityForm.value.id ? `/utilities/${utilityForm.value.id}` : '/utilities';
    const method = utilityForm.value.id ? 'put' : 'post';

    try {
        // Use Inertia for form submissions
        await Inertia[method](url, utilityForm.value);
        resetForm();
    } catch (error) {
        console.error('Error saving utility:', error);
        alert('Error saving utility. Please try again.'); // Error feedback
    }
};

// Reset form fields
const resetForm = () => {
    utilityForm.value = { id: null, name: '', status: false, type: 'once' };
};

// Edit utility
const editUtility = (utility) => {
    utilityForm.value = { ...utility }; 
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

                    <!-- Type -->
                    <div class="mb-4">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select
                            id="type"
                            v-model="utilityForm.type"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                            required
                        >
                            <option value="once">Once</option>
                            <option value="recurrent">Recurrent</option>
                        </select>
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
                                <th class="px-4 py-2 border">Type</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="utility in props.utilities" :key="utility.id">
                                <td class="px-4 py-2 border">{{ utility.name }}</td>
                                <td class="px-4 py-2 border">{{ utility.status ? 'Active' : 'Inactive' }}</td>
                                <td class="px-4 py-2 border">{{ utility.type }}</td>
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
