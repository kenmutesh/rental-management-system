<script setup>
import { computed, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
// Data
const message = ref('');
const selectedTenants = ref([]);
const tenantSearch = ref('');
const selectedTemplate = ref(null);
const messageTemplate = ref('');
const filteredTenants = ref([]);

const templates = ref([
    { id: 1, content: "Hello, your rent is due." },
    { id: 2, content: "Reminder: Meeting tomorrow at 10 AM." }
]);

let tenantUrl = computed(() => {
   let url = new URL(route("communication.create"));

   if(tenantSearch.value){
        url.searchParams.append("search", tenantSearch.value);
        return url.toString();
   }
});

watch (() => tenantUrl.value, (newValue) => {
    router.visit(newValue, {
        preserveScroll: true,
        preserveState: true,
        replace: true
    })
});

function selectTemplate(template) {
    selectedTemplate.value = template;
    message.value = template.content;
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



function createMessageTemplate() {
    if (messageTemplate.value) {
        templates.value.push({ id: templates.value.length + 1, content: messageTemplate.value });
        messageTemplate.value = ''; // Clear the template input after saving
    }
}

function addOrRemoveTenant(tenant) {
    const index = selectedTenants.value.findIndex(t => t.id === tenant.id);
    if (index === -1) {
        selectedTenants.value.push(tenant);  // Add tenant if not selected
    } else {
        selectedTenants.value.splice(index, 1);  // Remove tenant if already selected
    }
}

function sendBulkMessage() {
    // Send bulk message to all tenants
    axios.post('/api/messages/bulk', {
        message: message.value,
        tenants: selectedTenants.value.map(tenant => tenant.id)
    }).then(response => {
        console.log('Bulk message sent:', response.data);
    }).catch(error => {
        console.error('Error sending bulk message:', error);
    });
}


</script>

<template>
    <app-layout>
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-semibold mb-6">Send Messages</h1>

            <!-- Flex container for two-column layout on large screens -->
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Single Message Section -->
                <div class="flex-1 bg-white shadow rounded-lg p-6 mb-6 lg:mb-0">
                    <h2 class="text-lg font-semibold mb-4">Send Single Message</h2>

                    <!-- Search Tenant Section -->
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
                            @click="addOrRemoveTenant(tenant)"
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

                <!-- Bulk Message Section -->
                <div class="flex-1 bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Send Bulk Message</h2>
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
        </div>
    </app-layout>
</template>
