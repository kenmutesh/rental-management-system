<script setup>
import { computed, ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const message = ref('');
const selectedTenants = ref([]);
const tenantSearch = ref('');
const selectedTemplate = ref(null);
const messageTemplate = ref('');

const tenants = ref([]);

const templates = ref([
    { id: 1, content: "Hello, your rent is due." },
    { id: 2, content: "Reminder: Meeting tomorrow at 10 AM." }
]);

// Compute tenant search URL
let tenantUrl = computed(() => {
    let url = new URL(route("communication.create"));

    if (tenantSearch.value) {
        url.searchParams.append("search", tenantSearch.value?.toString() || '');
        return url.toString();
    }
    return url.toString();
});

// Watch for URL changes only if there's a search query
watch(() => tenantUrl.value, (newValue) => {
    if (tenantSearch.value) { // Only fetch tenants if there is a search query
        router.visit(newValue, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
            method: 'get',
            onSuccess: (page) => {
                tenants.value = page.props.tenants;
            }
        });
    }
});

function selectTemplate(template) {
    selectedTemplate.value = template;
    message.value = template.content;
}

function addOrRemoveTenant(tenant) {
    const index = selectedTenants.value.findIndex(t => t.id === tenant.id);

    if (index === -1) {
        selectedTenants.value.push(tenant);
        tenantSearch.value = '';
        tenants.value = [tenant];
    } else {
        selectedTenants.value.splice(index, 1);
        if (selectedTenants.value.length === 0) {
            tenants.value = [];
        }
    }
}

function formatPhoneNumber(phone) {
    if (phone.startsWith('0')) {
        phone = '254' + phone.slice(1);
    }
    else if (phone.startsWith('7') || phone.startsWith('1')) {
        phone = '254' + phone;
    }

    if (phone.length !== 12) {
        throw new Error('Phone number must be 12 characters long after formatting.');
    }

    return phone;
}

function sendSingleMessage() {
    if (selectedTenants.value.length < 1) {
        alert("Please select at least one tenant");
    } else if (!message.value) {
        alert("Please enter a message to proceed");
    } else {
        try {
            const formattedTenants = selectedTenants.value.map(tenant => {
                const formattedPhone = formatPhoneNumber(tenant.phone);
                return {
                    user_id: tenant.id,
                    phone: formattedPhone
                };
            });

            // Submit the form using Inertia
            router.post(route('communication.single'), {
                tenants: formattedTenants,
                message: message.value,
            }, {
                onSuccess: () => {
                    selectedTenants.value = [];
                    message.value = '';
                    alert("Message sent successfully!");
                },
                onError: (errors) => {
                    console.error("Error sending message:", errors);
                }
            });

        } catch (error) {
            alert(error.message);
        }
    }
}

// Create a new message template
function createMessageTemplate() {
    if (messageTemplate.value) {
        templates.value.push({ id: templates.value.length + 1, content: messageTemplate.value });
        messageTemplate.value = '';
    }
}

// Send a bulk message to selected tenants
function sendBulkMessage() {
    if (message.value && selectedTenants.value.length > 0) {
        axios.post('/api/messages/bulk', {
            message: message.value,
            tenants: selectedTenants.value.map(tenant => tenant.id)
        }).then(response => {
            console.log('Bulk message sent:', response.data);
        }).catch(error => {
            console.error('Error sending bulk message:', error);
        });
    } else {
        alert('Please select tenants and provide a message.');
    }
}

</script>

<template>
    <app-layout>
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-semibold mb-6">Send Messages</h1>

            <div class="flex flex-col lg:flex-row gap-6">
                <div class="flex-1 bg-white shadow rounded-lg p-6 mb-6 lg:mb-0">
                    <h2 class="text-lg font-semibold mb-4">Send Single Message</h2>

                    <input
                        type="text"
                        v-model="tenantSearch"
                        placeholder="Search by tenant name or phone number"
                        class="block w-full border border-gray-300 rounded-md mb-4"
                        @input="searchTenants"
                    />
                    <ul v-if="tenants.length > 0" class="mb-4">
                        <li
                            v-for="tenant in tenants"
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
