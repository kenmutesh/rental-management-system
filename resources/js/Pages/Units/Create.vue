<script setup>
import { ref, defineProps } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
    unit: Object // Define the properties prop
});

const { properties } = usePage().props;
const unit = ref({
    id: null,
    property_id: '',
    name: '',
    rentAmount: '',
    taxRate: null,
    recurringBills: [],
    notes: '',
});

if (props.unit) {
    Object.assign(unit.value, props.unit.data);
}

// Function to handle form submission
const saveUnit = async () => {
    const url = unit.value.id ? `/units/${unit.value.id}` : '/units';
    const method = unit.value.id ? 'put' : 'post';

    try {
        await axios[method](url, unit.value);
        // Handle success (e.g., redirect or show a success message)
    } catch (error) {
        console.error('Error saving unit:', error);
        // Handle error (e.g., show an error message)
    }
};

</script>

<template>
    <Head title="Create/Edit Unit" />
    <app-layout>
        <div class="max-w-6xl mx-auto py-12">
            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-4">
                    {{ unit.id ? 'Edit Unit' : 'Create Unit' }}
                </h1>
                <form @submit.prevent="saveUnit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4"> <!-- Responsive grid layout -->
                        <!-- Select Property -->
                        <div class="mb-4">
                            <label for="propertyId" class="block text-sm font-medium text-gray-700">Select Property</label>
                            <select
                                id="property"
                                v-model="unit.property_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                                :disabled="unit.id !== null"
                            >
                                <option disabled value="">Select Property</option>
                                <option v-for="property in properties.data" :key="property.id" :value="property.id">
                                    {{ property.propertyName }}
                                </option>
                            </select>
                        </div>

                        <!-- Unit ID/Name -->
                        <div class="mb-4">
                            <label for="unitName" class="block text-sm font-medium text-gray-700">Unit ID/Name</label>
                            <input
                                type="text"
                                id="unitName"
                                :disabled="unit.property_id == ''"
                                v-model="unit.name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                                required
                            />
                        </div>

                        <!-- Rent Amount -->
                        <div class="mb-4">
                            <label for="rentAmount" class="block text-sm font-medium text-gray-700">Rent Amount</label>
                            <input
                                type="number"
                                id="rentAmount"
                                v-model="unit.rentAmount"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                                required
                            />
                        </div>


                        <!-- Tax Rate -->
                        <div class="mb-4">
                            <label for="taxRate" class="block text-sm font-medium text-gray-700">Tax Rate % (optional)</label>
                            <input
                                type="number"
                                id="taxRate"
                                v-model="unit.taxRate"
                                placeholder="e.g. 7.5 for residential or 16 for commercial"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                            />
                            <p class="text-gray-500 text-xs mt-1">
                                Residential units tax rate is usually 7.5%. Commercial units tax rate is usually 16%.
                            </p>
                        </div>

                        <!-- Other Recurring Bills -->
                        <div class="mb-4 col-span-1 md:col-span-2"> <!-- Span across both columns -->
                            <label class="block text-sm font-medium text-gray-700">Other Recurring Bills (optional)</label>
                            <div v-for="(bill, index) in unit.recurringBills" :key="index" class="flex space-x-2 mb-2">
                                <select
                                    v-model="bill.type"
                                    class="block border border-gray-300 rounded-md shadow-sm p-2"
                                    required
                                >
                                    <option value="">Select bill type</option>
                                    <option value="water">Water</option>
                                    <option value="electricity">Electricity</option>
                                    <option value="internet">Internet</option>
                                </select>
                                <input
                                    type="number"
                                    v-model="bill.amount"
                                    placeholder="Amount"
                                    class="block border border-gray-300 rounded-md shadow-sm p-2"
                                    required
                                />
                            </div>
                            <button
                                type="button"
                                @click="unit.recurringBills.push({ type: '', amount: '' })"
                                class="text-blue-500 hover:text-blue-700"
                            >
                                Add Bill
                            </button>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4 col-span-1 md:col-span-2"> <!-- Span across both columns -->
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes (optional)</label>
                            <textarea
                                id="notes"
                                v-model="unit.notes"
                                rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                            ></textarea>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button
                            type="submit"
                            class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600"
                        >
                            {{ unit.id ? 'Update Unit' : 'Create Unit' }}
                        </button>
                    </div>
                </form>
                <div class="mt-4">
                    <Link
                        href="/units"
                        class="text-blue-500 hover:text-blue-700"
                    >
                        Back to Units
                    </Link>
                </div>
            </div>
        </div>
    </app-layout>
</template>
