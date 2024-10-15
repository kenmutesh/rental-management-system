<template>
    <Head title="Create/Edit Property" />

    <app-layout>
        <div class="max-w-6xl mx-auto py-12">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-bold mb-6">{{ isEditing ? 'Edit Property' : 'Create Property' }}</h2>

                <form @submit.prevent="submitForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                        <!-- Property Name -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="propertyName">
                                Property Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.propertyName"
                                type="text"
                                id="propertyName"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Enter property name"
                                required
                            />
                            <div v-if="form.errors?.propertyName" class="text-red-600 text-sm">{{ form.errors.propertyName }}</div>
                        </div>

                        <!-- Total Units -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="totalUnits">
                                Total Units <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.totalUnits"
                                type="number"
                                id="totalUnits"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Enter total units"
                                required
                                min="1"
                            />
                            <div v-if="form.errors?.totalUnits" class="text-red-600 text-sm">{{ form.errors.totalUnits }}</div>
                        </div>

                        <!-- City -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="city">
                                City <span class="text-red-500">*</span>
                            </label>
                            <input
                                v-model="form.city"
                                type="text"
                                id="city"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Enter city"
                                required
                            />
                            <div v-if="form.errors?.city" class="text-red-600 text-sm">{{ form.errors.city }}</div>
                        </div>

                        <!-- Street Name -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="streetName">
                                Street Name
                            </label>
                            <input
                                v-model="form.streetName"
                                type="text"
                                id="streetName"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Enter street name"
                            />
                        </div>

                        <!-- Water Rate -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="waterRate">
                                Water Rate (per unit)
                            </label>
                            <input
                                v-model="form.waterRate"
                                type="number"
                                id="waterRate"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Enter water rate"
                            />
                        </div>

                        <!-- Electricity Rate -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="electricityRate">
                                Electricity Rate (per unit)
                            </label>
                            <input
                                v-model="form.electricityRate"
                                type="number"
                                id="electricityRate"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Enter electricity rate"
                            />
                        </div>

                        <!-- M-Pesa Paybill -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="mpesaPaybill">
                                M-Pesa Paybill
                            </label>
                            <input
                                v-model="form.mpesaPaybill"
                                type="text"
                                id="mpesaPaybill"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Enter M-Pesa paybill number"
                            />
                        </div>

                        <!-- M-Pesa Till Number -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="mpesaTillNumber">
                                M-Pesa Till Number
                            </label>
                            <input
                                v-model="form.mpesaTillNumber"
                                type="text"
                                id="mpesaTillNumber"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Enter M-Pesa till number"
                            />
                        </div>

                        <!-- Penalty Percentage -->
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="penaltyPercentage">
                                Penalty Percentage (%)
                            </label>
                            <input
                                v-model="form.penaltyPercentage"
                                type="number"
                                id="penaltyPercentage"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Enter penalty percentage"
                            />
                        </div>

                        <!-- Payment Instructions -->
                        <div class="col-span-full">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="paymentInstructions">
                                Payment Instructions
                            </label>
                            <textarea
                                v-model="form.paymentInstructions"
                                id="paymentInstructions"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                placeholder="Enter payment instructions"
                            ></textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <button
                            type="submit"
                            class="bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-blue-600"
                            :disabled="isSubmitting"
                        >
                            <span v-if="isSubmitting" class="flex items-center">
                                <svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 100 8v4a8 8 0 01-8-8z"
                                    ></path>
                                </svg>
                                Saving...
                            </span>
                            <span class="flex" v-else>
                                <PlusIcon class="w-5 h-5 mr-2" /> <span>{{ isEditing ? 'Update Property' : 'Create Property' }}</span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </app-layout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { PlusIcon } from '@heroicons/vue/outline';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

const isSubmitting = ref(false);
const isEditing = ref(false);
const form = useForm({
    propertyName: '',
    totalUnits: '',
    city: '',
    waterRate: '',
    electricityRate: '',
    mpesaPaybill: '',
    mpesaTillNumber: '',
    penaltyPercentage: '',
    streetName: '',
    paymentInstructions: '',
    errors: {},
});

onMounted(() => {
    if (props.property) {
        isEditing.value = true;
        form.propertyName = props.property.propertyName;
        form.totalUnits = props.property.totalUnits;
        form.city = props.property.city;
        form.waterRate = props.property.waterRate;
        form.electricityRate = props.property.electricityRate;
        form.mpesaPaybill = props.property.mpesaPaybill;
        form.mpesaTillNumber = props.property.mpesaTillNumber;
        form.penaltyPercentage = props.property.penaltyPercentage;
        form.streetName = props.property.streetName;
        form.paymentInstructions = props.property.paymentInstructions;
    }
});

const submitForm = async () => {
    isSubmitting.value = true;
    form.errors = {};

    try {
        if (isEditing.value) {
            await form.put(route('properties.update', props.property.id));
        } else {
            await form.post(route('properties.store'));
        }
    } catch (error) {
        console.error(error);
        form.errors = error.response.data.errors || {};
    } finally {
        isSubmitting.value = false;
    }
};
</script>

<style scoped>
/* Add any additional styles if needed */
</style>
