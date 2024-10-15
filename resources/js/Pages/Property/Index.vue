<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { SearchCircleIcon, UserCircleIcon, ClipboardCopyIcon, PlusIcon, OfficeBuildingIcon } from '@heroicons/vue/outline';

const properties = ref([
    { id: 1, name: "Property 1", units: 10, vacant: 2 },
    { id: 2, name: "Property 2", units: 15, vacant: 3 },
    { id: 3, name: "Property 3", units: 5, vacant: 0 },
]);

const totalProperties = ref(properties.value.length);
const totalUnits = ref(properties.value.reduce((sum, p) => sum + p.units, 0));
const totalVacancies = ref(properties.value.reduce((sum, p) => sum + p.vacant, 0));

const searchQuery = ref('');
const filteredProperties = computed(() => {
    return properties.value.filter(property =>
        property.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const deleteProperty = (id) => {
    properties.value = properties.value.filter(p => p.id !== id);
    totalProperties.value = properties.value.length;
    totalUnits.value = properties.value.reduce((sum, p) => sum + p.units, 0);
    totalVacancies.value = properties.value.reduce((sum, p) => sum + p.vacant, 0);
};

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
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Units</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Vacancies</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(property, index) in filteredProperties" :key="property.id" class="border-t">
                        <td class="py-4 px-6 text-sm text-gray-700">{{ index + 1 }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700">{{ property.name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700">{{ property.units }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700">{{ property.vacant }}</td>
                        <td class="py-4 px-6">
                            <button class="text-blue-500 hover:text-blue-700 font-semibold mr-4">Edit</button>
                            <button class="text-red-500 hover:text-red-700 font-semibold" @click="deleteProperty(property.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </app-layout>
</template>
