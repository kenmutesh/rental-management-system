<script setup>
import { ref, defineProps } from 'vue';
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';

const props = defineProps({
    unit: Object,
});

const { properties, utilities } = usePage().props;

const isSubmitting = ref(false);
const isEditing = ref(!!props.unit);

const form = useForm({
    id: props.unit ? props.unit.id : null,
    property_id: props.unit ? props.unit.property_id : '',
    name: props.unit ? props.unit.name : '',
    rentAmount: props.unit ? props.unit.rentAmount : '',
    taxRate: props.unit ? props.unit.taxRate : null,
    recurringBills: props.unit ? props.unit.recurringBills : [],
    notes: props.unit ? props.unit.notes : '',
});

const selectedBillTypes = ref(new Set(props.unit?.recurringBills.map(bill => bill.type) || []));
const newBillType = ref('');

const submitForm = async () => {
    isSubmitting.value = true;
    form.clearErrors();

    try {
        if (isEditing.value) {
            await form.put(route('units.update', form.id));
        } else {
            await form.post(route('units.store'));
        }
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            form.setError(error.response.data.errors);
        } else {
            console.error('An unexpected error occurred:', error);
        }
    } finally {
        isSubmitting.value = false;
    }
};

const addBill = (billType) => {
    const utility = utilities.data.find(u => u.id === billType);
    if (billType && utility && !selectedBillTypes.value.has(billType)) {
        form.recurringBills.push({ type: billType, name: utility.name });
        selectedBillTypes.value.add(billType);
        newBillType.value = '';
    }
};

const removeBill = (index) => {
    const billType = form.recurringBills[index].type;
    form.recurringBills.splice(index, 1);
    selectedBillTypes.value.delete(billType);
};
</script>

<template>
    <Head title="Create/Edit Unit" />
    <app-layout>
        <div class="max-w-6xl mx-auto py-12">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">
                    {{ form.id ? 'Edit Unit' : 'Create Unit' }}
                </h1>
                <form @submit.prevent="submitForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label for="propertyId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Property</label>
                            <select
                                id="property"
                                v-model="form.property_id"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required
                                :disabled="form.id !== null"
                            >
                                <option disabled value="">Select Property</option>
                                <option v-for="property in properties.data" :key="property.id" :value="property.id">
                                    {{ property.propertyName }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="unitName" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unit ID/Name</label>
                            <input
                                type="text"
                                id="unitName"
                                :disabled="form.property_id == ''"
                                v-model="form.name"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required
                            />
                        </div>

                        <div class="mb-4">
                            <label for="rentAmount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rent Amount</label>
                            <input
                                type="number"
                                id="rentAmount"
                                v-model="form.rentAmount"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                                required
                            />
                        </div>

                        <div class="mb-4">
                            <label for="taxRate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tax Rate % (optional)</label>
                            <input
                                type="number"
                                id="taxRate"
                                v-model="form.taxRate"
                                placeholder="e.g. 7.5 for residential or 16 for commercial"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            />
                            <p class="text-gray-500 text-xs mt-1 dark:text-gray-400">
                                Residential units tax rate is usually 7.5%. Commercial units tax rate is usually 16%.
                            </p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Other Recurring Bills (optional)</label>
                            <div v-for="(bill, index) in form.recurringBills" :key="index" class="flex items-center space-x-2 mb-2">
                                <span class="bg-blue-500 text-white text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                                    {{ bill.name }}
                                </span>
                                <button type="button" @click="removeBill(index)" class="text-red-500 hover:text-red-700">
                                    Remove
                                </button>
                            </div>
                            <select
                                v-model="newBillType"
                                @change="addBill(newBillType)"
                                class="block border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            >
                                <option value="">Select bill type</option>
                                <option v-for="utility in utilities.data" :key="utility.id" :value="utility.id">
                                    {{ utility.name }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes (optional)</label>
                            <textarea
                                id="notes"
                                v-model="form.notes"
                                rows="3"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300"
                            ></textarea>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button
                            type="submit"
                            class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700"
                            :disabled="isSubmitting"
                        >
                            {{ form.id ? 'Update Unit' : 'Create Unit' }}
                        </button>
                    </div>
                </form>
                <div class="mt-4">
                    <Link
                        href="/units"
                        class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-500"
                    >
                        Back to Units
                    </Link>
                </div>
            </div>
        </div>
    </app-layout>
</template>
