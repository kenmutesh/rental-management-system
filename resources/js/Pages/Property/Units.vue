<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const properties = ref([]);
const selectedProperty = ref(null);
const selectedPropertyView = ref(null);
const unitName = ref('');
const rentAmount = ref('');
const notes = ref('');
const isEditing = ref(false);
const editingUnitId = ref(null);
const isSubmitting = ref(false);
const units = ref([]);
const isTableLoading = ref(false);

// Fetch properties on page load
const fetchProperties = async () => {
    try {
        const response = await axios.get('/properties');
        properties.value = response.data.data;
    } catch (error) {
        console.error('Error fetching properties:', error);
    }
};

// Fetch units based on the selected property (triggered by selecting a property from the menu)
const fetchUnits = async (propertyId) => {
    if (!propertyId) {
        units.value = [];
        return;
    }

    isTableLoading.value = true;
    try {
        const response = await axios.get(`/units/${propertyId}`);

         const fetchedUnits = response.data.data;

        units.value = Array.isArray(fetchedUnits) ? fetchedUnits : [fetchedUnits];

        console.log('Units:', units.value); // Log the units array or single unit
        console.log('Number of units:', units.value.length);

    } catch (error) {
        console.error('Error fetching units:', error);
    } finally {
        isTableLoading.value = false;
    }
};

const submitForm = async () => {
    if (!selectedProperty.value) {
        console.error('Property must be selected');
        return;
    }

    isSubmitting.value = true;
    try {
        const payload = {
            name: unitName.value,
            property_id: selectedProperty.value,
            rentAmount: rentAmount.value,
            notes: notes.value,
        };

        if (isEditing.value) {
            await axios.put(`/units/${editingUnitId.value}`, payload);
        } else {
            await axios.post(`/units`, payload);
        }

        resetForm();
        fetchUnits(selectedProperty.value);
    } catch (error) {
        console.error('Error submitting form:', error);
    } finally {
        isSubmitting.value = false;
    }
};


const resetForm = () => {
    unitName.value = '';
    rentAmount.value = '';
    notes.value = '';
    isEditing.value = false;
    editingUnitId.value = null;
};


const editUnit = (unit) => {
    unitName.value = unit.name;
    rentAmount.value = unit.rentAmount;
    notes.value = unit.notes;
    isEditing.value = true;
    editingUnitId.value = unit.id;
    selectedProperty.value = unit.property_id; // Set property when editing a unit
};

const deleteUnit = async (unitId) => {
    try {
        await axios.delete(`/units/${unitId}`);
        fetchUnits(selectedProperty.value); // Refresh units after deletion
    } catch (error) {
        console.error('Error deleting unit:', error);
    }
};

onMounted(() => {
    fetchProperties(); // Only fetch properties on page load
});
</script>
<template>
    <AuthenticatedLayout>
        <!-- First Card: For Creating or Editing Units -->
        <app-card title="Add or Edit Units">
            <form @submit.prevent="submitForm" class="space-y-4">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-4">
                    <div>
                        <label for="property" class="block">Select Property:</label>
                        <select
                            v-model="selectedProperty"
                            id="property"
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                            <option value="" disabled>Select a property</option>
                            <option v-for="property in properties" :key="property.id" :value="property.id">
                                {{ property.propertyName }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="unit_name" class="block">Unit Name:</label>
                        <input
                            v-model="unitName"
                            type="text"
                            id="unit_name"
                            placeholder="Unit Name"
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        />
                    </div>

                    <div>
                        <label for="rent_amount" class="block">Rent Amount:</label>
                        <input
                            v-model="rentAmount"
                            type="number"
                            id="rent_amount"
                            placeholder="Rent Amount"
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        />
                    </div>

                    <div>
                        <label for="notes" class="block">Notes:</label>
                        <textarea
                            v-model="notes"
                            id="notes"
                            placeholder="Additional Notes"
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="1"
                        ></textarea>
                    </div>
                </div>
                <div class="flex justify-end">
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

        <app-card title="View Units">
            <div class="mb-4">
                <label for="property_view" class="block">Select Property to View Units:</label>
                <select
                    v-model="selectedPropertyView"
                    @change="fetchUnits(selectedPropertyView)"
                    id="property_view"
                    class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
                    <option value="" disabled>Select a property</option>
                    <option v-for="property in properties" :key="property.id" :value="property.id">
                        {{ property.propertyName }}
                    </option>
                </select>
            </div>

            <div v-if="!isTableLoading">
                <template v-if="units.length > 0">
                    <div class="table-container"> <!-- Add this container -->
                        <table class="w-full bg-white table">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="py-2 text-left w-1/4">Unit Name</th>
                                    <th class="py-2 text-left w-1/4">Rent Amount</th>
                                    <th class="py-2 text-left w-1/4 truncate">Notes</th>
                                    <th class="py-2 text-left w-1/4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(unit, index) in units" :key="unit.id" class="border-b">
                                    <td class="py-2">{{ unit.name }}</td>
                                    <td class="py-2">{{ unit.rentAmount }}</td>
                                    <td class="py-2 w-2 truncate">{{ unit.notes }}</td>
                                    <td class="py-2">
                                        <div class="flex gap-2">
                                            <button
                                                @click="editUnit(index)"
                                                class="px-3 py-1 text-white bg-green-500 rounded hover:bg-green-600"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                @click="deleteUnit(unit.id)"
                                                class="px-3 py-1 text-white bg-red-500 rounded hover:bg-red-600"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </template>
                <template v-else>
                    <p class="text-center py-4">No units found for the selected property.</p>
                </template>
            </div>


            <!-- Loading State -->
            <div v-else>
                <p class="text-center py-4">Loading units...</p>
            </div>
        </app-card>
    </AuthenticatedLayout>
</template>

<style scoped>
.table-container {
    overflow-x: auto;
    padding: 5px;
}

.table {
    min-width: 600px;
}
</style>
