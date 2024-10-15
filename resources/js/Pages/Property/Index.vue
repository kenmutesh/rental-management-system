<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { SearchCircleIcon, UserCircleIcon, ClipboardCopyIcon, PlusIcon, OfficeBuildingIcon } from '@heroicons/vue/outline';

// Fetching properties from the Inertia page props
const { properties } = usePage().props;

// State for managing totals and filtered properties
const totalProperties = ref(properties.length);
const totalUnits = ref(properties.reduce((sum, p) => sum + p.totalUnits, 0)); // Changed to totalUnits
const totalVacancies = ref(properties.reduce((sum, p) => sum + p.vacant, 0)); // Ensure you have the correct field for vacancies

// Search functionality
const searchQuery = ref('');
const filteredProperties = computed(() => {
    return properties.filter(property =>
        property.propertyName.toLowerCase().includes(searchQuery.value.toLowerCase()) // Changed to propertyName
    );
});

// Delete property function
const deleteProperty = (id) => {
    Inertia.delete(route('properties.destroy', id), {
        onSuccess: () => {
            totalProperties.value = properties.length;
            totalUnits.value = properties.reduce((sum, p) => sum + p.totalUnits, 0); // Changed to totalUnits
            totalVacancies.value = properties.reduce((sum, p) => sum + p.vacant, 0); // Ensure you have the correct field for vacancies
        }
    });
};

// Redirect to the create and add unit routes
const redirectToCreateProperty = () => {
    Inertia.get(route('properties.create'));
};

const redirectToAddUnit = () => {
    Inertia.get(route('units.create'));
};

</script>

<template>
    <Head title="Property Management" />
    <app-layout>
        <!-- Buttons -->
        <div class="flex justify-between mb-6">
            <Link
                href="/properties/create"
                class="flex items-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600"
            >
                <PlusIcon class="w-5 h-5 mr-2" />
                Create Property
            </Link>
            <Link
                href="/units/create"
                class="flex items-center bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600"
            >
                <PlusIcon class="w-5 h-5 mr-2" />
                Add Unit
            </Link>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="p-4 bg-white shadow rounded-lg flex items-center">
                <OfficeBuildingIcon class="w-10 h-10 text-blue-500 mr-4" />
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Properties</h3>
                    <p class="text-2xl font-bold text-blue-500">{{ totalProperties }}</p>
                </div>
            </div>
            <div class="p-4 bg-white shadow rounded-lg flex items-center">
                <ClipboardCopyIcon class="w-10 h-10 text-blue-500 mr-4" />
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Units</h3>
                    <p class="text-2xl font-bold text-blue-500">{{ totalUnits }}</p>
                </div>
            </div>
            <div class="p-4 bg-white shadow rounded-lg flex items-center">
                <UserCircleIcon class="w-10 h-10 text-blue-500 mr-4" />
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">Total Vacancies</h3>
                    <p class="text-2xl font-bold text-blue-500">{{ totalVacancies }}</p>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="flex items-center mb-4">
            <SearchCircleIcon class="w-5 h-5 text-gray-500 mr-2" />
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Search properties..."
                class="border border-gray-300 rounded-lg py-2 px-4 w-full focus:ring focus:ring-blue-200 focus:outline-none"
            />
        </div>

        <!-- Properties Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">#</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Property Name</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Total Units</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Vacancies</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(property, index) in filteredProperties" :key="property.id" class="border-t">
                        <td class="py-4 px-6 text-sm text-gray-700">{{ index + 1 }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700">{{ property.propertyName }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700">{{ property.totalUnits }}</td> <!-- Changed to totalUnits -->
                        <td class="py-4 px-6 text-sm text-gray-700">{{ property.vacant }}</td> <!-- Ensure this field is correct -->
                        <td class="py-4 px-6">
                            <Link
                                :href="`/properties/edit/${property.id}`"
                                class="text-blue-500 hover:text-blue-700 font-semibold mr-4"
                            >
                                Edit
                            </Link>
                        <button class="text-red-500 hover:text-red-700 font-semibold" @click="deleteProperty(property.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </app-layout>
</template>
