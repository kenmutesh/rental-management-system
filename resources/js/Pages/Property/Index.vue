<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { SearchCircleIcon, UserCircleIcon, ClipboardCopyIcon, PlusIcon, OfficeBuildingIcon } from '@heroicons/vue/outline';

const { properties, vacancies, totalUnits, totalProperties } = usePage().props;

const searchQuery = ref('');
const filteredProperties = computed(() => {
    return properties.data.filter(property =>
        property.propertyName.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

// Delete property function
const deleteProperty = (id) => {
    Inertia.delete(route('properties.destroy', id), {
        onSuccess: () => {
            totalProperties.value = properties.length;
            totalUnits.value = properties.reduce((sum, p) => sum + p.totalUnits, 0);
            totalVacancies.value = properties.reduce((sum, p) => sum + p.vacant, 0);
        }
    });
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
                class="flex items-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800 dark:text-white"
            >
                <PlusIcon class="w-5 h-5 mr-2" />
                Create Property
            </Link>
            <Link
                href="/units/create"
                class="flex items-center bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600 dark:bg-gray-700 dark:hover:bg-gray-800 dark:text-white"
            >
                <PlusIcon class="w-5 h-5 mr-2" />
                Add Unit
            </Link>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="p-4 bg-white shadow rounded-lg flex items-center dark:bg-gray-800">
                <OfficeBuildingIcon class="w-10 h-10 text-blue-500 mr-4" />
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Properties</h3>
                    <p class="text-2xl font-bold text-blue-500">{{ totalProperties }}</p>
                </div>
            </div>
            <div class="p-4 bg-white shadow rounded-lg flex items-center dark:bg-gray-800">
                <ClipboardCopyIcon class="w-10 h-10 text-blue-500 mr-4" />
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Units</h3>
                    <p class="text-2xl font-bold text-blue-500">{{ totalUnits }}</p>
                </div>
            </div>
            <div class="p-4 bg-white shadow rounded-lg flex items-center dark:bg-gray-800">
                <UserCircleIcon class="w-10 h-10 text-blue-500 mr-4" />
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Vacancies</h3>
                    <p class="text-2xl font-bold text-blue-500">{{ vacancies }}</p>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="flex items-center mb-4">
            <SearchCircleIcon class="w-5 h-5 text-gray-500 dark:text-gray-400 mr-2" />
            <input
                v-model="searchQuery"
                type="text"
                placeholder="Search properties..."
                class="border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg py-2 px-4 w-full focus:ring focus:ring-blue-200 focus:outline-none dark:focus:ring-blue-500"
            />
        </div>

        <!-- Properties Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300">#</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Property Name</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Total Units</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Vacancies</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(property, index) in filteredProperties" :key="property.id" class="border-t dark:border-gray-700">
                        <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">{{ index + 1 }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">{{ property.propertyName }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">{{ property.totalUnits }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">{{ property.vacancies }}</td>
                        <td class="py-4 px-6">
                            <Link
                                :href="`/properties/edit/${property.id}`"
                                class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600 font-semibold mr-4"
                            >
                                Edit
                            </Link>
                            <button class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600 font-semibold" @click="deleteProperty(property.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </app-layout>
</template>
