<script setup>
import { ref, watch } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { PlusIcon } from '@heroicons/vue/outline';

// Form Data
const form = useForm({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    address: '',
    leaseStartDate: '',
    accountNumber: '',
    rentAmount: '',
    paymentDueDate: '',
    notes: '',
    property_id: '', // For property selection
    unit_id: '', // For unit selection
});

// Props passed from server-side (properties)
const props = defineProps(['properties']);

// Units for the selected property
const units = ref([]);

// Watch the selected property and filter units accordingly
watch(() => form.property_id, (newVal) => {
    if (newVal) {
        const selectedProperty = props.properties.find(p => p.id === newVal);
        units.value = selectedProperty ? selectedProperty.units : [];
        form.unit_id = ''; // Reset the unit selection when the property changes
    } else {
        units.value = [];
    }
});

// Function to handle form submission
const submitForm = () => {
    form.post('/tenants', {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Create Tenant" />
    <app-layout>
        <div class="flex justify-center items-center min-h-screen bg-gray-100 p-4">
            <div class="bg-white shadow-lg rounded-lg w-full max-w-3xl" style="padding: 2rem;">
                <h1 class="text-2xl font-semibold mb-6 text-center">Create Tenant</h1>

                <!-- Tenant Form -->
                <form @submit.prevent="submitForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="firstName"
                                v-model="form.firstName"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            />
                            <span v-if="form.errors.firstName" class="text-red-500 text-sm">{{ form.errors.firstName }}</span>
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="lastName"
                                v-model="form.lastName"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            />
                            <span v-if="form.errors.lastName" class="text-red-500 text-sm">{{ form.errors.lastName }}</span>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                v-model="form.email"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            />
                            <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">
                                Phone <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="tel"
                                id="phone"
                                v-model="form.phone"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            />
                            <span v-if="form.errors.phone" class="text-red-500 text-sm">{{ form.errors.phone }}</span>
                        </div>

                        <!-- Property Selection -->
                        <div>
                            <label for="property" class="block text-sm font-medium text-gray-700">
                                Property <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="property"
                                v-model="form.property_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            >
                                <option value="">Select Property</option>
                                <option v-for="property in props.properties" :key="property.id" :value="property.id">
                                    {{ property.propertyName }}
                                </option>
                            </select>
                            <span v-if="form.errors.property_id" class="text-red-500 text-sm">{{ form.errors.property_id }}</span>
                        </div>

                        <!-- Unit Selection -->
                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700">
                                Unit <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="unit"
                                v-model="form.unit_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                                :disabled="units.length === 0"
                            >
                                <option value="">Select Unit</option>
                                <option v-for="unit in units" :key="unit.id" :value="unit.id">
                                    {{ unit.name }}
                                </option>
                            </select>
                            <span v-if="form.errors.unit_id" class="text-red-500 text-sm">{{ form.errors.unit_id }}</span>
                        </div>

                        <!-- Lease Start Date -->
                        <div>
                            <label for="leaseStartDate" class="block text-sm font-medium text-gray-700">
                                Lease Start Date <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="date"
                                id="leaseStartDate"
                                v-model="form.leaseStartDate"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            />
                            <span v-if="form.errors.leaseStartDate" class="text-red-500 text-sm">{{ form.errors.leaseStartDate }}</span>
                        </div>


                        <!-- Payment Due Date -->
                        <div>
                            <label for="account_number" class="block text-sm font-medium text-gray-700">
                                Account Number <span class="text-gray-500">(optional)</span>
                            </label>
                            <input
                                type="text"
                                id="account_number"
                                v-model="form.accountNumber"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                min="1"
                                max="31"
                            />
                            <span v-if="form.errors.accountNumber" class="text-red-500 text-sm">{{ form.errors.accountNumber }}</span>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea
                            id="notes"
                            v-model="form.notes"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                            rows="3"
                        ></textarea>
                        <span v-if="form.errors.notes" class="text-red-500 text-sm">{{ form.errors.notes }}</span>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center mt-6">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out"
                            :disabled="form.processing"
                        >
                            <span v-if="!form.processing">Submit</span>
                            <span v-else>Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </app-layout>
</template>
