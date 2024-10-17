<script setup>
import { ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';

const { utilities: initialUtilities } = usePage().props; // Fetch initial utilities from props
const utilities = ref(initialUtilities); // Make utilities reactive
const isEditing = ref(false);
const isSubmitting = ref(false);

const form = useForm({
    id: null,
    name: '',
    status: false,
    fee_type: 'monthly',
    price: null,
});

const saveUtility = async () => {
    isSubmitting.value = true;
    form.errors = {};

    try {
        if (isEditing.value) {
            await form.put(route('utilities.update', form.id));
        } else {
            await form.post(route('utilities.store'));
        }
        utilities.value = usePage().props.utilities;
        resetForm(); 
    } catch (error) {
        console.error(error);
        form.errors = error.response.data.errors || {};
    } finally {
        isSubmitting.value = false;
    }
};


const resetForm = () => {
    form.reset();
    isEditing.value = false; // Reset editing state
};

const editUtility = (utility) => {
    form.id = utility.id;
    form.name = utility.name;
    form.status = utility.status ? true : false;
    form.fee_type = utility.fee_type;
    form.price = utility.price;
    isEditing.value = true;
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
                            v-model="form.name"
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
                                v-model="form.status"
                                class="form-checkbox h-4 w-4 text-blue-600"
                            />
                            <span class="ml-2 text-gray-700">Active</span>
                        </label>
                    </div>

                    <!-- Fee Type -->
                    <div class="mb-4">
                        <label for="fee_type" class="block text-sm font-medium text-gray-700">Fee Type</label>
                        <select
                            id="fee_type"
                            v-model="form.fee_type"
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
                            v-model="form.price"
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
                            {{ form.id ? 'Update Utility' : 'Add Utility' }}
                        </button>
                    </div>
                </form>

                <!-- Utilities Table -->
                <div class="mt-8">
                    <h2 class="text-lg font-semibold mb-4">Utilities List</h2>
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">#</th>
                                <th class="px-4 py-2 border">Name</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Fee Type</th>
                                <th class="px-4 py-2 border">Price</th>
                                <th class="px-4 py-2 border">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(utility, index) in utilities.data" :key="utility.id">
                                <td class="px-4 py-2 border">{{ index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ utility.name }}</td>
                                <td class="px-4 py-2 border">{{ utility.status }}</td>
                                <td class="px-4 py-2 border">{{ utility.fee_type }}</td>
                                <td class="px-4 py-2 border">KES {{ utility.price }}</td>
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
