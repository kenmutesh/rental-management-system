<script setup>
import { ref, watch, computed } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { PlusIcon, ArrowRightIcon, ArrowLeftIcon } from '@heroicons/vue/outline';

const form = useForm({
    // Personal Information
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    idNumber: '',
    kraPin: '',

    // Employment Information
    employerName: '',
    jobTitle: '',
    monthlyIncome: '',
    employmentLetter: null,
    payslips: [],

    // Rental Information
    property_id: '',
    unit_id: '',
    leaseStartDate: '',
    rentAmount: '',
    moveInDate: new Date().toISOString().split('T')[0],
    proratedDays: 0,
    proratedDiscount: 0,
    proratedType: 'percentage',
    depositDuration: '1',

    // Financial Information
    securityDeposit: '',
    advanceRent: '',
    paymentMethod: 'bank',

    // Documents
    idCopy: null,
    kraPinCopy: null,
    bankStatements: [],
    references: [],

    // Additional Information
    emergencyContactName: '',
    emergencyContactPhone: '',
    notes: ''
});

const currentStep = ref(1);
const totalSteps = 5;

const nextStep = () => {
    if (validateStep(currentStep.value)) {
        currentStep.value++;
    }
};

const prevStep = () => {
    currentStep.value--;
};

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-KE', {
        style: 'currency',
        currency: 'KES'
    }).format(amount);
}

const updateDepositAmount = () => {
    if (form.depositDuration !== 'custom') {
        const rentAmount = form.rentAmount;
        form.securityDeposit = rentAmount * parseInt(form.depositDuration);
    }
};

const validateStep = (step) => {
    let isValid = true;

    if (step === 1) {
        if (!form.firstName) { form.errors.firstName = 'First name is required'; isValid = false; }
        if (!form.lastName) { form.errors.lastName = 'Last name is required'; isValid = false; }
        if (!form.email) { form.errors.email = 'Email is required'; isValid = false; }
        if (!form.phone) { form.errors.phone = 'Phone is required'; isValid = false; }
        if (!form.idNumber) { form.errors.idNumber = 'ID Number is required'; isValid = false; }
    }

    if (step === 2) {
        if (!form.employerName) { form.errors.employerName = 'Employer name is required'; isValid = false; }
        if (!form.monthlyIncome) { form.errors.monthlyIncome = 'Monthly income is required'; isValid = false; }
    }

    if (step === 3) {
        if (!form.property_id) { form.errors.property_id = 'Property is required'; isValid = false; }
        if (!form.unit_id) { form.errors.unit_id = 'Unit is required'; isValid = false; }
        if (!form.leaseStartDate) { form.errors.leaseStartDate = 'Lease start date is required'; isValid = false; }
        if (!form.rentAmount) { form.errors.rentAmount = 'Rent amount is required'; isValid = false; }
    }

    return isValid;
};

const { properties } = usePage().props;
const units = ref([]);

const calculateProratedRent = () => {
    if (!form.unit_id || !form.moveInDate) return;

    const moveInDate = new Date(form.moveInDate);
    const year = moveInDate.getFullYear();
    const month = moveInDate.getMonth();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const dayOfMonth = moveInDate.getDate();

    form.proratedDays = daysInMonth - dayOfMonth + 1; // Including move-in day

    // Recalculate security deposit if needed
    if (form.depositDuration !== 'custom') {
        const selectedUnit = units.value.find(u => u.id === form.unit_id);
        if (selectedUnit) {
            form.securityDeposit = selectedUnit.rentAmount * parseInt(form.depositDuration);
        }
    }
};

const calculateProratedAmount = () => {
    if (form.proratedDays <= 0) return form.rentAmount;

    const dailyRate = form.rentAmount / 30; // Standard 30-day month
    let proratedAmount = dailyRate * form.proratedDays;

    if (form.proratedType === 'percentage' && form.proratedDiscount > 0) {
        proratedAmount *= (1 - (form.proratedDiscount / 100));
    } else if (form.proratedType === 'fixed' && form.proratedDiscount > 0) {
        proratedAmount = Math.max(0, proratedAmount - form.proratedDiscount);
    }

    return Math.round(proratedAmount);
};

const getFirstPaymentAmount = computed(() => {
    const proratedAmount = form.proratedDays > 0 ? calculateProratedAmount() : 0;
    return proratedAmount + parseInt(form.advanceRent || 0) + parseInt(form.securityDeposit || 0);
});

watch(() => form.property_id, (newVal) => {
    if (newVal) {
        const selectedProperty = properties.data.find(p => p.id === newVal);
        units.value = selectedProperty ? selectedProperty.units : [];
        form.unit_id = '';
        if (units.value.length === 1) {
            form.unit_id = units.value[0].id;
            form.rentAmount = units.value[0].rentAmount;
        }
    } else {
        units.value = [];
    }
});

watch(() => form.unit_id, (newVal) => {
    if (newVal) {
        const selectedUnit = units.value.find(u => u.id === newVal);
        if (selectedUnit) {
            form.rentAmount = selectedUnit.rentAmount;
            form.depositDuration = '1'; // Reset to default when unit changes
            form.securityDeposit = selectedUnit.rentAmount * parseInt(form.depositDuration);
            form.advanceRent = selectedUnit.rentAmount;
        }
    }
});

watch(() => [form.unit_id, form.moveInDate], () => {
    calculateProratedRent();
});

watch(() => [form.depositDuration, form.proratedDiscount, form.proratedType], () => {
    calculateProratedRent();
});

const submitForm = () => {
    if (validateStep(currentStep.value)) {
        form.post('/tenants/store', {
            onFinish: () => {
                form.reset();
            },
        });
    }
};

const handleFileUpload = (event, field) => {
    form[field] = event.target.files[0];
};

const handleMultipleFiles = (event, field) => {
    form[field] = Array.from(event.target.files);
};
</script>

<template>
    <Head title="Tenant Application Form" />
    <app-layout>
        <div class="flex justify-center dark:bg-gray-600 items-center min-h-screen p-4 bg-gray-50">
            <div class="bg-white dark:bg-gray-600 shadow-xl rounded-lg w-full max-w-4xl">
                <!-- Progress Steps -->
                <div class="px-6 py-4 border-b border-blue-500">
                    <div class="flex justify-between">
                        <div v-for="step in totalSteps" :key="step" class="flex flex-col items-center">
                            <div
                                :class="{
                                    'bg-blue-600 text-white': currentStep >= step,
                                    'bg-gray-200 text-gray-600': currentStep < step
                                }"
                                class="w-8 h-8 rounded-full flex items-center justify-center font-semibold"
                            >
                                {{ step }}
                            </div>
                            <span class="text-xs mt-1 text-gray-600 dark:text-white">
                                <span v-if="step === 1">Personal</span>
                                <span v-if="step === 2">Employment</span>
                                <span v-if="step === 3">Rental</span>
                                <span v-if="step === 4">Payment</span>
                                <span v-if="step === 5">Review</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <h1 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">Tenant Application Form</h1>

                    <!-- Step 1: Personal Information -->
                    <div v-show="currentStep === 1" class="space-y-6">
                        <h2 class="text-xl font-medium text-gray-800 dark:text-white">Personal Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    v-model="form.firstName"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.firstName" class="text-red-500 text-sm">{{ form.errors.firstName }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    v-model="form.lastName"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.lastName" class="text-red-500 text-sm">{{ form.errors.lastName }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    v-model="form.email"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="tel"
                                    v-model="form.phone"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.phone" class="text-red-500 text-sm">{{ form.errors.phone }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    National ID/Passport Number <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    v-model="form.idNumber"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.idNumber" class="text-red-500 text-sm">{{ form.errors.idNumber }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    KRA PIN (Optional)
                                </label>
                                <input
                                    type="text"
                                    v-model="form.kraPin"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Upload ID Copy (PDF/Image) <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="file"
                                @change="handleFileUpload($event, 'idCopy')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.jpg,.jpeg,.png"
                                required
                            />
                        </div>

                        <div v-if="form.kraPin">
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Upload KRA PIN Certificate (PDF/Image)
                            </label>
                            <input
                                type="file"
                                @change="handleFileUpload($event, 'kraPinCopy')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.jpg,.jpeg,.png"
                            />
                        </div>
                    </div>

                    <!-- Step 2: Employment Information -->
                    <div v-show="currentStep === 2" class="space-y-6">
                        <h2 class="text-xl font-medium text-gray-800 dark:text-white">Employment & Financial Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Employer Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    v-model="form.employerName"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.employerName" class="text-red-500 text-sm">{{ form.errors.employerName }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Job Title <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    v-model="form.jobTitle"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Monthly Income (KSh) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    v-model="form.monthlyIncome"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.monthlyIncome" class="text-red-500 text-sm">{{ form.errors.monthlyIncome }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Upload Employment Letter (PDF/Image) <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="file"
                                @change="handleFileUpload($event, 'employmentLetter')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.jpg,.jpeg,.png"
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Upload Recent Payslips (Last 3 months) <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="file"
                                @change="handleMultipleFiles($event, 'payslips')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.jpg,.jpeg,.png"
                                multiple
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Upload Bank Statements (Last 3 months) <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="file"
                                @change="handleMultipleFiles($event, 'bankStatements')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.jpg,.jpeg,.png"
                                multiple
                                required
                            />
                        </div>
                    </div>

                    <!-- Step 3: Rental Information -->
                    <div v-show="currentStep === 3" class="space-y-6">
                        <h2 class="text-xl font-medium text-gray-800 dark:text-white">Rental Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Property <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.property_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                                    <option value="">Select Property</option>
                                    <option v-for="property in properties.data" :key="property.id" :value="property.id">
                                        {{ property.propertyName }}
                                    </option>
                                </select>
                                <span v-if="form.errors.property_id" class="text-red-500 text-sm">{{ form.errors.property_id }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Unit <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.unit_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                    :disabled="units.length === 0"
                                >
                                    <option disabled value="">Select Unit</option>
                                    <option
                                        v-for="unit in units"
                                        :key="unit.id"
                                        :value="unit.id"
                                        :disabled="unit.status === 'occupied'"
                                    >
                                        {{ unit.name }} - {{ unit.status === 'occupied' ? 'Occupied' : 'KSh ' + unit.rentAmount.toLocaleString() }}
                                    </option>
                                </select>
                                <span v-if="form.errors.unit_id" class="text-red-500 text-sm">{{ form.errors.unit_id }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Lease Start Date <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    v-model="form.leaseStartDate"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.leaseStartDate" class="text-red-500 text-sm">{{ form.errors.leaseStartDate }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Move-in Date <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="date"
                                    v-model="form.moveInDate"
                                    @change="calculateProratedRent"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                    :min="form.leaseStartDate"
                                />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Monthly Rent (KSh) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    v-model="form.rentAmount"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                    :readonly="form.unit_id"
                                />
                                <span v-if="form.errors.rentAmount" class="text-red-500 text-sm">{{ form.errors.rentAmount }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Prorated Rent Type
                                </label>
                                <select
                                    v-model="form.proratedType"
                                    @change="calculateProratedRent"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="percentage">Percentage Discount</option>
                                    <option value="fixed">Fixed Amount</option>
                                </select>
                            </div>

                            <div v-if="form.proratedType === 'percentage'">
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Discount Percentage
                                </label>
                                <input
                                    type="number"
                                    v-model="form.proratedDiscount"
                                    @input="calculateProratedRent"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="E.g. 50 for 50%"
                                    min="0"
                                    max="100"
                                />
                            </div>

                            <div v-if="form.proratedType === 'fixed'">
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Discount Amount (KSh)
                                </label>
                                <input
                                    type="number"
                                    v-model="form.proratedDiscount"
                                    @input="calculateProratedRent"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="E.g. 5000"
                                    min="0"
                                />
                            </div>
                        </div>

                        <!-- Rent Summary -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-medium text-gray-700 mb-2">Rent Summary</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="text-sm text-gray-500">Monthly Rent:</div>
                                <div class="text-right">{{ formatCurrency(form.rentAmount) }}</div>

                                <template v-if="form.proratedDays > 0">
                                    <div class="text-sm text-gray-500">Days Remaining:</div>
                                    <div class="text-right">{{ form.proratedDays }} days</div>

                                    <div class="text-sm text-gray-500">Prorated Amount:</div>
                                    <div class="text-right">{{ formatCurrency(calculateProratedAmount()) }}</div>
                                </template>

                                <div class="font-medium">First Payment Due:</div>
                                <div class="text-right font-medium text-blue-600">
                                    {{ formatCurrency(getFirstPaymentAmount) }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Emergency Contact Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                v-model="form.emergencyContactName"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Emergency Contact Phone <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="tel"
                                v-model="form.emergencyContactPhone"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                required
                            />
                        </div>
                    </div>

                    <!-- Step 4: Payment Information -->
                    <div v-show="currentStep === 4" class="space-y-6">
                        <h2 class="text-xl font-medium text-gray-800 dark:text-white">Payment Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Security Deposit Section with Duration -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Security Deposit Duration <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.depositDuration"
                                    @change="updateDepositAmount"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                                    <option value="1">1 Month</option>
                                    <option value="2">2 Months</option>
                                    <option value="3">3 Months</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Security Deposit (KSh) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    v-model="form.securityDeposit"
                                    :readonly="form.depositDuration !== 'custom'"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <p class="text-xs text-gray-500 mt-1" v-if="form.depositDuration !== 'custom'">
                                    Equivalent to {{ form.depositDuration }} month(s) rent ({{ formatCurrency(form.securityDeposit) }})
                                </p>
                                <p class="text-xs text-gray-500 mt-1" v-else>
                                    Enter custom deposit amount
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Advance Rent (KSh) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    v-model="form.advanceRent"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <p class="text-xs text-gray-500 mt-1">Typically 1 month's rent</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Preferred Payment Method <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.paymentMethod"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                                    <option value="bank">Bank Transfer</option>
                                    <option value="mpesa">M-Pesa</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Upload Reference Letters (Previous Landlords/Employers)
                            </label>
                            <input
                                type="file"
                                @change="handleMultipleFiles($event, 'references')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.jpg,.jpeg,.png"
                                multiple
                            />
                        </div>
                    </div>

                    <!-- Step 5: Review and Submit -->
                    <div v-show="currentStep === 5" class="space-y-6">
                        <h2 class="text-xl font-medium text-gray-800 dark:text-white">Review Your Application</h2>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium text-lg mb-3">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Full Name</p>
                                    <p class="font-medium">{{ form.firstName }} {{ form.lastName }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="font-medium">{{ form.email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Phone</p>
                                    <p class="font-medium">{{ form.phone }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">ID Number</p>
                                    <p class="font-medium">{{ form.idNumber }}</p>
                                </div>
                                <div v-if="form.kraPin">
                                    <p class="text-sm text-gray-500">KRA PIN</p>
                                    <p class="font-medium">{{ form.kraPin }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium text-lg mb-3">Employment Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Employer</p>
                                    <p class="font-medium">{{ form.employerName }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Job Title</p>
                                    <p class="font-medium">{{ form.jobTitle }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Monthly Income</p>
                                    <p class="font-medium">{{ formatCurrency(form.monthlyIncome) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium text-lg mb-3">Rental Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Property</p>
                                    <p class="font-medium">
                                        {{ properties.data.find(p => p.id === form.property_id)?.propertyName || 'Not selected' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Unit</p>
                                    <p class="font-medium">
                                        {{ units.find(u => u.id === form.unit_id)?.name || 'Not selected' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Lease Start Date</p>
                                    <p class="font-medium">{{ form.leaseStartDate }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Move-in Date</p>
                                    <p class="font-medium">{{ form.moveInDate }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Monthly Rent</p>
                                    <p class="font-medium">{{ formatCurrency(form.rentAmount) }}</p>
                                </div>
                                <div v-if="form.proratedDays > 0">
                                    <p class="text-sm text-gray-500">Prorated Rent</p>
                                    <p class="font-medium">{{ formatCurrency(calculateProratedAmount()) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Emergency Contact</p>
                                    <p class="font-medium">{{ form.emergencyContactName }} ({{ form.emergencyContactPhone }})</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-medium text-lg mb-3">Payment Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Security Deposit</p>
                                    <p class="font-medium">{{ formatCurrency(form.securityDeposit) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Advance Rent</p>
                                    <p class="font-medium">{{ formatCurrency(form.advanceRent) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Initial Payment</p>
                                    <p class="font-medium text-blue-600">
                                        {{ formatCurrency(getFirstPaymentAmount) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Payment Method</p>
                                    <p class="font-medium">{{ form.paymentMethod }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">Additional Notes</label>
                            <textarea
                                v-model="form.notes"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                rows="3"
                            ></textarea>
                        </div>

                        <div class="flex items-center">
                            <input
                                id="terms"
                                type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                required
                            />
                            <label for="terms" class="ml-2 block text-sm text-gray-700 dark:text-white">
                                I agree to the terms and conditions of the tenancy agreement
                            </label>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-8">
                        <button
                            v-if="currentStep > 1"
                            @click="prevStep"
                            type="button"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            <ArrowLeftIcon class="w-5 h-5 mr-2" />
                            Previous
                        </button>
                        <div v-else></div> <!-- Empty div for spacing -->

                        <button
                            v-if="currentStep < totalSteps"
                            @click="nextStep"
                            type="button"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Next
                            <ArrowRightIcon class="w-5 h-5 ml-2" />
                        </button>

                        <button
                            v-if="currentStep === totalSteps"
                            @click="submitForm"
                            type="button"
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            :disabled="form.processing"
                        >
                            <PlusIcon class="w-5 h-5 mr-2" />
                            <span v-if="!form.processing">Submit Application</span>
                            <span v-else>Processing...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
