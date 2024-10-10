<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const propertyName = ref('');
const totalUnits = ref('');
const city = ref('');
const waterRate = ref('');
const electricityRate = ref('');
const mpesaPaybill = ref('');
const mpesaTillNumber = ref('');
const penaltyPercentage = ref('');
const streetName = ref('');
const paymentInstructions = ref('');
const isSubmitting = ref(false);
const isEditing = ref(false);
const isTableLoading = ref(false);
const properties = ref([]);
const editingIndex = ref(null);

const fetchProperties = async () => {
    isTableLoading.value = true;
    try {
        const response = await axios.get('/properties');
        properties.value = response.data.data;
    } catch (error) {
        console.error('Error fetching properties:', error);
    } finally {
        isTableLoading.value = false;
    }
};

const submitForm = async () => {
    isSubmitting.value = true;

    try {
        const payload = {
            propertyName: propertyName.value,
            totalUnits: totalUnits.value,
            city: city.value,
            waterRate: waterRate.value,
            electricityRate: electricityRate.value,
            mpesaPaybill: mpesaPaybill.value,
            mpesaTillNumber: mpesaTillNumber.value,
            penaltyPercentage: penaltyPercentage.value,
            streetName: streetName.value,
            paymentInstructions: paymentInstructions.value,
        };

        if (isEditing.value) {
            await axios.put(`/properties/${properties.value[editingIndex.value].id}`, payload);
        } else {
            await axios.post('/properties', payload);
        }

        await fetchProperties();
        resetForm();
    } catch (error) {
        console.error('Error submitting form:', error);
    } finally {
        isSubmitting.value = false;
    }
};

const editProperty = (index) => {
    const property = properties.value[index];
    propertyName.value = property.propertyName;
    totalUnits.value = property.totalUnits;
    city.value = property.city;
    waterRate.value = property.waterRate;
    electricityRate.value = property.electricityRate;
    penaltyPercentage.value = property.penaltyPercentage;
    streetName.value = property.streetName;
    paymentInstructions.value = property.paymentInstructions;
    isEditing.value = true;
    editingIndex.value = index;
};

const deleteProperty = async (index) => {
    try {
        await axios.delete(`/properties/${properties.value[index].id}`);
        await fetchProperties();
    } catch (error) {
        console.error('Error deleting property:', error);
    }
};

const resetForm = () => {
    propertyName.value = '';
    totalUnits.value = '';
    city.value = '';
    waterRate.value = '';
    electricityRate.value = '';
    mpesaPaybill.value = '';
    mpesaTillNumber.value = '';
    penaltyPercentage.value = '';
    streetName.value = '';
    paymentInstructions.value = '';
    isEditing.value = false;
    editingIndex.value = null;
};

onMounted(fetchProperties);
</script>

<template>
    <AuthenticatedLayout>
        <app-card :title="isEditing ? 'Edit Property' : 'Add Property'">
            <form @submit.prevent="submitForm" class="space-y-4">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-4">
                    <div>
                        <label for="property_name" class="block">
                            Property Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="propertyName"
                            type="text"
                            id="property_name"
                            placeholder="Property Name ..."
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        />
                    </div>

                    <div>
                        <label for="units" class="block">
                            Total Units <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="totalUnits"
                            type="number"
                            step="1"
                            id="units"
                            placeholder="0"
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        />
                    </div>

                    <div>
                        <label for="city" class="block">
                            City <span class="text-red-500">*</span>
                        </label>
                        <input
                            v-model="city"
                            type="text"
                            id="city"
                            placeholder="City or nearest town ..."
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        />
                    </div>

                    <div>
                        <label for="water_rate" class="block">Water Rate (optional)</label>
                        <input
                            v-model="waterRate"
                            type="number"
                            step="0.01"
                            id="water_rate"
                            placeholder="0 (KES per unit consumed)"
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div>
                        <label for="electricity_rate" class="block">Electricity Rate (optional)</label>
                        <input
                            v-model="electricityRate"
                            type="number"
                            step="0.01"
                            id="electricity_rate"
                            placeholder="0 (KES per unit consumed)"
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div>
                        <label class="block">Rent Payment Penalty (optional)</label>
                        <input
                            v-model="penaltyPercentage"
                            type="number"
                            step="0.01"
                            min="0"
                            id="penalty_amount"
                            placeholder="Percentage Penalty"
                            class="w-full border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                        <div> 
                            <label class="flex items-center">
                                <input type="checkbox" v-model="automaticallyPenalize" class="mr-2" />
                                Automatically penalize tenants upon late payment
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="street_name" class="block">Street Name (optional)</label>
                        <input
                            v-model="streetName"
                            type="text"
                            id="street_name"
                            placeholder="Address / Closest street Name ..."
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        />
                    </div>

                    <div>
                        <label for="payment_instructions" class="block">Payment Instructions (optional)</label>
                        <textarea
                            v-model="paymentInstructions"
                            id="payment_instructions"
                            placeholder="Payment Instructions (optional)"
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="1"
                        ></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <button
                        v-if="isEditing"
                        type="button"
                        class="px-6 py-3 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
                        @click="resetForm"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="px-6 py-3 text-white bg-blue-500 rounded hover:bg-blue-600 disabled:opacity-50"
                        :disabled="isSubmitting"
                    >
                        <span v-if="isSubmitting" class="flex items-center">
                            <svg class="w-4 h-4 mr-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v4m0 8v4m8-8h-4m-8 0H4" />
                            </svg>
                            {{ isEditing ? 'Updating...' : 'Submitting...' }}
                        </span>
                        <span v-else>{{ isEditing ? 'Update' : 'Submit' }}</span>
                    </button>
                </div>
            </form>
        </app-card>

        <app-card title="Manage Properties" v-if="!isTableLoading">
            <template v-if="properties.length > 0">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="py-2 text-left">Property Name</th>
                            <th class="py-2 text-left">Total Units</th>
                            <th class="py-2 text-left">Location</th>
                            <th class="py-2 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(property, index) in properties" :key="property.id" class="border-b">
                            <td class="py-2">{{ property.propertyName }}</td>
                            <td class="py-2">{{ property.totalUnits }}</td>
                            <td class="py-2">{{ property.city }}</td>
                            <td class="py-2">
                                <div class="flex gap-2">
                                    <button
                                        @click="editProperty(index)"
                                        class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        @click="deleteProperty(index)"
                                        class="px-3 py-1 text-white bg-red-500 rounded hover:bg-red-600"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template v-else>
                <p class="text-center py-4">No properties found.</p>
            </template>
        </app-card>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Add your styles here */
</style>
