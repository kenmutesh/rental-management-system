<script setup>
import { ref } from 'vue';

// Data
const message = ref('');
const selectedTenants = ref([]);
const tenantSearch = ref('');
const selectedTemplate = ref(null);
const messageTemplate = ref('');
const filteredTenants = ref([]);

// Predefined tenants and templates
const tenantList = ref([
    { id: 1, name: "John Doe", phone: "123456789" },
    { id: 2, name: "Jane Smith", phone: "987654321" },
    { id: 3, name: "Sam Wilson", phone: "555555555" }
]);

const templates = ref([
    { id: 1, content: "Hello, your rent is due." },
    { id: 2, content: "Reminder: Meeting tomorrow at 10 AM." }
]);

// Methods
function searchTenants() {
    if (tenantSearch.value) {
        filteredTenants.value = tenantList.value.filter(tenant =>
            tenant.name.toLowerCase().includes(tenantSearch.value.toLowerCase()) ||
            tenant.phone.includes(tenantSearch.value)
        );
    } else {
        filteredTenants.value = [];
    }
}

function selectTemplate(template) {
    selectedTemplate.value = template;
    message.value = template.content;  // Fill message field with template content
}

function sendSingleMessage() {
    // Logic to send a message to the selected tenant(s)
    if (selectedTenants.value.length > 0) {
        console.log("Sending message to tenants:", selectedTenants.value);
        console.log("Message content:", message.value);
    } else {
        alert("Please select at least one tenant.");
    }
}

function sendBulkMessage() {
    // Logic to send a bulk message to all selected tenants
    console.log("Sending bulk message to:", selectedTenants.value);
    console.log("Message content:", message.value);
}

function createMessageTemplate() {
    if (messageTemplate.value) {
        templates.value.push({ id: templates.value.length + 1, content: messageTemplate.value });
        messageTemplate.value = ''; // Clear the template input after saving
    }
}
</script>

<template>
    <app-layout>
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-semibold mb-6">Send Messages</h1>

            <!-- Search Tenant Section -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Search Tenant to Send Message</h2>
                <input
                    type="text"
                    v-model="tenantSearch"
                    placeholder="Search by tenant name or phone number"
                    class="block w-full border border-gray-300 rounded-md mb-4"
                    @input="searchTenants"
                />
                <ul v-if="filteredTenants.length > 0" class="mb-4">
                    <li
                        v-for="tenant in filteredTenants"
                        :key="tenant.id"
                        @click="selectedTenants.push(tenant)"
                        class="cursor-pointer p-2 bg-gray-100 mb-2 rounded-md hover:bg-gray-200"
                    >
                        {{ tenant.name }} ({{ tenant.phone }})
                    </li>
                </ul>
                <div v-if="selectedTenants.length > 0">
                    <p class="font-semibold mb-2">Selected Tenants:</p>
                    <ul class="mb-4">
                        <li
                            v-for="tenant in selectedTenants"
                            :key="tenant.id"
                            class="p-2 bg-blue-100 mb-2 rounded-md"
                        >
                            {{ tenant.name }} ({{ tenant.phone }})
                        </li>
                    </ul>
                </div>
                <textarea
                    v-model="message"
                    placeholder="Type your message"
                    class="block w-full border border-gray-300 rounded-md mb-4"
                ></textarea>
                <button
                    @click="sendSingleMessage"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                >
                    Send Message
                </button>
            </div>

            <!-- Create Message Template -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Create Message Template</h2>
                <textarea
                    v-model="messageTemplate"
                    placeholder="Type template message"
                    class="block w-full border border-gray-300 rounded-md mb-4"
                ></textarea>
                <button
                    @click="createMessageTemplate"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600"
                >
                    Save Template
                </button>

                <!-- Display and Select Templates -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold">Select a Template to Autofill Message</h3>
                    <ul class="mt-2">
                        <li
                            v-for="template in templates"
                            :key="template.id"
                            @click="selectTemplate(template)"
                            class="cursor-pointer bg-gray-100 p-2 rounded-md mb-2 hover:bg-gray-200"
                        >
                            {{ template.content }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Send Bulk Message Section -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Send Bulk Message to Selected Tenants</h2>
                <textarea
                    v-model="message"
                    placeholder="Type your message"
                    class="block w-full border border-gray-300 rounded-md mb-4"
                ></textarea>
                <button
                    @click="sendBulkMessage"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                >
                    Send Bulk Message
                </button>
            </div>
        </div>
    </app-layout>
</template>
