<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { ref, onMounted } from 'vue';
import {Head, router, usePage} from '@inertiajs/vue3';

const form = useForm();
const dbbackups = ref([]);
const totalBackups = ref(0);

const loadBackups = () => {
    const props = usePage().props;
    console.log("Props Data:", props);

    if (props.backups) {
        dbbackups.value = props.backups;
        totalBackups.value = dbbackups.value.length;
    }

    console.log("Loaded Backups:", dbbackups.value);
};

const submitBackup = () => {
    form.post('/backups/create', {
        preserveScroll: true,
        onSuccess: () => {
            console.log("Backup created successfully!");
            router.reload({ only: ['backups'] });
        },
        onError: (errors) => {
            console.error("Error creating backup:", errors);
        },
    });
};


const restoreBackup = (backupName) => {
    console.log(`Restoring backup: ${backupName}`);
};

const deleteBackup = (backupName) => {
    console.log(`Deleting backup: ${backupName}`);

    dbbackups.value = dbbackups.value.filter((backup) => backup.name !== backupName);
    totalBackups.value = dbbackups.value.length;
};

onMounted(() => {
    loadBackups();
});
</script>

<template>
    <Head title="Backups" />
    <app-layout>
        <div class="container mx-auto px-4 py-6">
            <!-- Hero Section -->
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">Manage Backups</h1>
                <p class="text-gray-500 dark:text-gray-300">View and manage your system backups.</p>
            </div>

            <!-- Total Backups Card -->
            <div class="mb-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Total Backups</h3>
                <p class="mt-2 text-lg font-medium text-blue-600">{{ totalBackups }}</p>
            </div>

            <!-- Create Backup Button -->
            <div class="mb-6 text-right">
                <button
                    @click="submitBackup"
                    :disabled="form.processing"
                    class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-blue-700 dark:hover:bg-blue-800"
                >
                    <span v-if="form.processing">Creating...</span>
                    <span v-else>Create Backup</span>
                </button>
            </div>

            <!-- Backup List Section -->
            <div v-if="dbbackups.length > 0" class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="backup in dbbackups" :key="backup.name" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ backup.name }}</h4>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">{{ backup.date }}</p>
                    <div class="mt-4">
                        <button
                            @click="restoreBackup(backup.name)"
                            class="text-white bg-green-500 hover:bg-green-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-green-700 dark:hover:bg-green-800"
                        >
                            Restore
                        </button>
                        <button
                            @click="deleteBackup(backup.name)"
                            class="ml-2 text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-red-700 dark:hover:bg-red-800"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>

            <!-- No Backups Message -->
            <div v-if="dbbackups.length === 0" class="text-center text-gray-500 dark:text-gray-300">
                <p>No backups available.</p>
            </div>
        </div>
    </app-layout>
</template>
