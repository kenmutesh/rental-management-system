<script setup>
import { ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

const { utilities: initialUtilities, flash } = usePage().props; // Get initial utilities and flash message
const utilities = ref(initialUtilities);
const isEditing = ref(false);
const isSubmitting = ref(false);
const showFlash = ref(flash ? true : false); // Control flash message visibility

// Flash message timeout
if (flash) {
    setTimeout(() => {
        showFlash.value = false;
    }, 3000);
}

const form = useForm({
    id: null,
    name: '',
    status: false,
    fee_type: 'monthly',
    price: null,
});

const saveUtility = async () => {
    isSubmitting.value = true;

    try {
        if (isEditing.value) {
            await form.put(route('utilities.update', form.id), {
                preserveScroll: true,
                onSuccess: () => {
                    // Refresh utilities after successful update
                    utilities.value = usePage().props.utilities;
                    resetForm();
                    showFlash.value = true;
                    setTimeout(() => showFlash.value = false, 3000);
                }
            });
        } else {
            await form.post(route('utilities.store'), {
                preserveScroll: true,
                onSuccess: () => {
                    // Refresh utilities after successful creation
                    utilities.value = usePage().props.utilities;
                    resetForm();
                    showFlash.value = true;
                    setTimeout(() => showFlash.value = false, 3000);
                }
            });
        }
    } finally {
        isSubmitting.value = false;
    }
};

const resetForm = () => {
    form.reset();
    isEditing.value = false;
};

const editUtility = (utility) => {
    form.id = utility.id;
    form.name = utility.name;
    form.status = utility.status;
    form.fee_type = utility.fee_type;
    form.price = utility.price;
    isEditing.value = true;
};

const deleteUtility = async (utility) => {
    if (confirm('Are you sure you want to delete this utility?')) {
        await form.delete(route('utilities.delete', utility.id), {
            preserveScroll: true,
            onSuccess: () => {
                utilities.value = usePage().props.utilities;
                showFlash.value = true;
                setTimeout(() => showFlash.value = false, 3000);
            }
        });
    }
};
</script>
<template>
    <Head title="Utilities" />
    <app-layout>
        <div class="max-w-6xl mx-auto py-12">
            <div v-if="showFlash && $page.props.flash" class="mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ $page.props.flash.message }}</span>
            </div>
            </div>
        <div class="bg-white shadow-md rounded-lg p-6 dark:bg-gray-800">
                <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Manage Utilities</h1>
                <form @submit.prevent="saveUtility">
                    <!-- Utility Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Utility Name</label>
                        <input
                            type="text"
                            id="name"
                            v-model="form.name"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            required
                        />
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="inline-flex items-center">
                            <input
                                type="checkbox"
                                id="status"
                                v-model="form.status"
                                class="form-checkbox h-4 w-4 text-blue-600"
                            />
                            <span class="ml-2 text-gray-700 dark:text-gray-300">Active</span>
                        </label>
                    </div>

                    <!-- Fee Type -->
                    <div class="mb-4">
                        <label for="fee_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fee Type</label>
                        <select
                            id="fee_type"
                            v-model="form.fee_type"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            required
                        >
                            <option value="one_time">One Time</option>
                            <option value="renewable">Renewable</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                        <input
                            type="number"
                            id="price"
                            v-model="form.price"
                            step="0.01"
                            min="0"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                            required
                        />
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600"
                        >
                            {{ form.id ? 'Update Utility' : 'Add Utility' }}
                        </button>
                    </div>
                </form>

                <!-- Utilities Table -->
                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Utilities List</h2>
                    <table class="min-w-full border border-gray-300 dark:border-gray-600">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="px-4 dark:text-gray-100 py-2 border">#</th>
                                <th class="px-4 dark:text-gray-100 py-2 border">Name</th>
                                <th class="px-4 dark:text-gray-100 py-2 border">Status</th>
                                <th class="px-4 dark:text-gray-100 py-2 border">Fee Type</th>
                                <th class="px-4 dark:text-gray-100 py-2 border">Price</th>
                                <th class="px-4 dark:text-gray-100 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(utility, index) in utilities.data" :key="utility.id" class="bg-white dark:bg-gray-800">
                                <td class="px-4 py-2 border dark:text-gray-100 dark:border-gray-600">{{ index + 1 }}</td>
                                <td class="px-4 py-2 border dark:text-gray-100 dark:border-gray-600">{{ utility.name }}</td>
                                <td class="px-4 py-2 border dark:text-gray-100 dark:border-gray-600">{{ utility.status }}</td>
                                <td class="px-4 py-2 border dark:text-gray-100 dark:border-gray-600">{{ utility.fee_type }}</td>
                                <td class="px-4 py-2 border dark:text-gray-100 dark:border-gray-600">KES {{ utility.price }}</td>
                                <td class="px-4 py-2 border dark:text-gray-100 dark:border-gray-600 flex gap-3">
                                    <button
                                        @click="editUtility(utility)"
                                        class="text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-400"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteUtility(utility)"
                                        class="text-red-500 hover:text-red-700 dark:text-red-300 dark:hover:text-red-400"
                                    >
                                        Delete
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
