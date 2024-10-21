<script setup>
import { ref, watch } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { PlusIcon } from '@heroicons/vue/outline';

const form = useForm({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    leaseStartDate: '',
    accountNumber: '',
    notes: '',
    property_id: '',
    unit_id: '',
});

const errors = ref({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    property_id: '',
    unit_id: '',
    leaseStartDate: ''
});


const validateForm = () => {
    errors.value.firstName = form.firstName ? '' : 'First name is required';
    errors.value.lastName = form.lastName ? '' : 'Last name is required';
    errors.value.email = form.email ? '' : 'Email is required';
    errors.value.phone = form.phone ? '' : 'Phone is required';
    errors.value.property_id = form.property_id ? '' : 'Property is required';
    errors.value.unit_id = form.unit_id ? '' : 'Unit is required';
    errors.value.leaseStartDate = form.leaseStartDate ? '' : 'Lease start date is required';


    return Object.values(errors.value).every(error => error === '');
};


const { properties } = usePage().props;

const units = ref([]);

watch(() => form.property_id, (newVal) => {
    if (newVal) {
        const selectedProperty = properties.data.find(p => p.id === newVal);
        units.value = selectedProperty ? selectedProperty.units : [];
        form.unit_id = '';
    } else {
        units.value = [];
    }
});


const submitForm = () => {
    if (!validateForm()) {
        return;
    }

    form.post('/tenants/store', {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Create Tenant" />
    <app-layout>
        <div class="flex justify-center items-center min-h-screen  p-4">
            <div class="bg-white dark:bg-gray-700 shadow-lg rounded-lg w-full max-w-3xl" style="padding: 2rem;">
                <h1 class="text-2xl font-semibold mb-6 text-center text-gray-900 dark:text-gray-100">Create Tenant</h1>

                <form @submit.prevent="submitForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                First Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="firstName"
                                v-model="form.firstName"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                                required
                            />
                            <span v-if="form.errors.firstName" class="text-red-500 text-sm">{{ form.errors.firstName }}</span>
                        </div>

                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Last Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="lastName"
                                v-model="form.lastName"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                                required
                            />
                            <span v-if="form.errors.lastName" class="text-red-500 text-sm">{{ form.errors.lastName }}</span>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                v-model="form.email"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                                required
                            />
                            <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Phone <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="tel"
                                id="phone"
                                v-model="form.phone"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                                required
                            />
                            <span v-if="form.errors.phone" class="text-red-500 text-sm">{{ form.errors.phone }}</span>
                        </div>

                        <div>
                            <label for="property" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Property <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="property"
                                v-model="form.property_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                                required
                            >
                                <option value="">Select Property</option>
                                <option v-for="property in properties.data" :key="property.id" :value="property.id">
                                    {{ property.propertyName }}
                                </option>
                            </select>
                            <span v-if="form.errors.property_id" class="text-red-500 text-sm">{{ form.errors.property_id }}</span>
                        </div>

                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Unit <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="unit"
                                v-model="form.unit_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                                required
                                :disabled="units.length === 0"
                            >
                                <option disabled value="">Select Unit</option>
                                <option
                                    v-for="unit in units"
                                    :key="unit.id"
                                    :value="unit.id"
                                    :disabled="unit.status === 'occupied'"
                                >
                                    {{ unit.name }} - {{ unit.status === 'occupied' ? 'occupied' : unit.rentAmount }}
                                </option>
                            </select>

                            <span v-if="form.errors.unit_id" class="text-red-500 text-sm">{{ form.errors.unit_id }}</span>
                        </div>

                        <div>
                            <label for="leaseStartDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Lease Start Date <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="date"
                                id="leaseStartDate"
                                v-model="form.leaseStartDate"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                                required
                            />
                            <span v-if="form.errors.leaseStartDate" class="text-red-500 text-sm">{{ form.errors.leaseStartDate }}</span>
                        </div>

                        <div>
                            <label for="account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Account Number <span class="text-gray-500">(optional)</span>
                            </label>
                            <input
                                type="text"
                                id="account_number"
                                v-model="form.accountNumber"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                                min="1"
                                max="31"
                            />
                            <span v-if="form.errors.accountNumber" class="text-red-500 text-sm">{{ form.errors.accountNumber }}</span>
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                        <textarea
                            id="notes"
                            v-model="form.notes"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
                            rows="3"
                        ></textarea>
                        <span v-if="form.errors.notes" class="text-red-500 text-sm">{{ form.errors.notes }}</span>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button
                            type="submit"
                            class="flex justify-between px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out dark:bg-blue-700 dark:hover:bg-blue-800"
                            :disabled="form.processing"
                        >
                            <PlusIcon class="w-5 h-5 mr-2" />
                            <span v-if="!form.processing">Submit</span>
                            <span v-else>Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </app-layout>
</template>
