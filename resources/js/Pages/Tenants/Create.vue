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
    id_number: '',
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
    lease_start_date: '',
    rentAmount: '',
    depositDuration: '1',

    // Financial Information
    securityDeposit: '',
    advanceRent: '',
    paymentMethod: 'bank',
    applyDiscount: false,
    discountType: 'percentage',
    discountValue: 0,

    // Documents
    idCopy: null,
    kraPinCopy: null,
    bankStatements: [],
    references: [],

    // Additional Information
    emergency_contact_name: '',
    emergency_contact_phone: '',
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
        const rentAmount = parseFloat(form.rentAmount) || 0;
        form.securityDeposit = rentAmount * parseInt(form.depositDuration);
    }
};

const validateStep = (step) => {
    // Clear previous errors
    form.clearErrors();

    let isValid = true;

    if (step === 1) {
        if (!form.firstName.trim()) { form.setError('firstName', 'First name is required'); isValid = false; }
        if (!form.lastName.trim()) { form.setError('lastName', 'Last name is required'); isValid = false; }
        if (!form.email.trim()) { form.setError('email', 'Email is required'); isValid = false; }
        if (!form.phone.trim()) { form.setError('phone', 'Phone is required'); isValid = false; }
        if (!form.id_number.trim()) { form.setError('id_number', 'ID Number is required'); isValid = false; }
        if (!form.idCopy) { form.setError('idCopy', 'ID copy is required'); isValid = false; }
    }

    if (step === 2) {
        if (!form.employerName.trim()) { form.setError('employerName', 'Employer name is required'); isValid = false; }
        if (!form.jobTitle.trim()) { form.setError('jobTitle', 'Job title is required'); isValid = false; }
        if (!form.monthlyIncome) { form.setError('monthlyIncome', 'Monthly income is required'); isValid = false; }
    }

    if (step === 3) {
        if (!form.property_id) { form.setError('property_id', 'Property is required'); isValid = false; }
        if (!form.unit_id) { form.setError('unit_id', 'Unit is required'); isValid = false; }
        if (!form.lease_start_date) { form.setError('lease_start_date', 'Lease start date is required'); isValid = false; }
        if (!form.rentAmount) { form.setError('rentAmount', 'Rent amount is required'); isValid = false; }
        if (!form.emergency_contact_name.trim()) { form.setError('emergency_contact_name', 'Emergency contact name is required'); isValid = false; }
        if (!form.emergency_contact_phone.trim()) { form.setError('emergency_contact_phone', 'Emergency contact phone is required'); isValid = false; }
    }

    if (step === 4) {
        if (!form.securityDeposit) { form.setError('securityDeposit', 'Security deposit is required'); isValid = false; }
        if (!form.advanceRent) { form.setError('advanceRent', 'Advance rent is required'); isValid = false; }
        if (!form.paymentMethod) { form.setError('paymentMethod', 'Payment method is required'); isValid = false; }
    }

    if (step === 5) {
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox.checked) {
            form.setError('terms', 'You must agree to the terms and conditions');
            isValid = false;
        }
    }

    return isValid;
};

const { properties } = usePage().props;
const units = ref([]);

const calculateDiscountedAmount = () => {
    if (!form.applyDiscount) return parseFloat(form.rentAmount) || 0;

    const rent = parseFloat(form.rentAmount) || 0;
    const discount = parseFloat(form.discountValue) || 0;

    if (form.discountType === 'percentage') {
        return rent * (1 - (discount / 100));
    } else {
        return Math.max(0, rent - discount);
    }
};

const calculateTotalPayment = () => {
    const rentAmount = parseFloat(form.rentAmount) || 0;
    const deposit = parseFloat(form.securityDeposit) || 0;

    // Apply discount only to rent amount
    const discountedRent = form.applyDiscount ? calculateDiscountedAmount() : rentAmount;

    // Advance rent is always equal to monthly rent (without discount)
    form.advanceRent = rentAmount;

    // Total is (monthly rent - discount) + security deposit
    return discountedRent + deposit;
};

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
            form.depositDuration = '1';
            updateDepositAmount();
            form.advanceRent = selectedUnit.rentAmount;
        }
    }
});

watch(() => [form.rentAmount, form.depositDuration], () => {
    updateDepositAmount();
});

const submitForm = () => {
    if (!validateStep(currentStep.value)) return;

    form.post('/tenants/store', {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            currentStep.value = 1;
        },
        onError: () => {
            // Scroll to the first error if any
            const firstError = Object.keys(form.errors)[0];
            if (firstError) {
                const element = document.querySelector(`[name="${firstError}"]`);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        }
    });
};

const handleFileUpload = (event, field) => {
    form[field] = event.target.files[0];
    // Clear error when file is selected
    if (field === 'idCopy' && form.errors.idCopy) {
        form.clearErrors('idCopy');
    }
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
                                    @input="form.clearErrors('firstName')"
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
                                    @input="form.clearErrors('lastName')"
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
                                    @input="form.clearErrors('email')"
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
                                    @input="form.clearErrors('phone')"
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
                                    v-model="form.id_number"
                                    @input="form.clearErrors('id_number')"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.id_number" class="text-red-500 text-sm">{{ form.errors.id_number }}</span>
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
                            <span v-if="form.errors.idCopy" class="text-red-500 text-sm">{{ form.errors.idCopy }}</span>
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
                                    @input="form.clearErrors('employerName')"
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
                                    @input="form.clearErrors('jobTitle')"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.jobTitle" class="text-red-500 text-sm">{{ form.errors.jobTitle }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Monthly Income (KSh) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    v-model="form.monthlyIncome"
                                    @input="form.clearErrors('monthlyIncome')"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.monthlyIncome" class="text-red-500 text-sm">{{ form.errors.monthlyIncome }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Upload Employment Letter (PDF/Image)
                            </label>
                            <input
                                type="file"
                                @change="handleFileUpload($event, 'employmentLetter')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.jpg,.jpeg,.png"
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Upload Recent Payslips (Last 3 months)
                            </label>
                            <input
                                type="file"
                                @change="handleMultipleFiles($event, 'payslips')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.jpg,.jpeg,.png"
                                multiple
                            />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                Upload Bank Statements (Last 3 months)
                            </label>
                            <input
                                type="file"
                                @change="handleMultipleFiles($event, 'bankStatements')"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                accept=".pdf,.jpg,.jpeg,.png"
                                multiple
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
                                    @change="form.clearErrors('property_id')"
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
                                    @change="form.clearErrors('unit_id')"
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
                                    v-model="form.lease_start_date"
                                    @change="form.clearErrors('lease_start_date')"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.lease_start_date" class="text-red-500 text-sm">{{ form.errors.lease_start_date }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Monthly Rent (KSh) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    v-model="form.rentAmount"
                                    @input="form.clearErrors('rentAmount')"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                    :readonly="form.unit_id"
                                />
                                <span v-if="form.errors.rentAmount" class="text-red-500 text-sm">{{ form.errors.rentAmount }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Emergency Contact Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    v-model="form.emergency_contact_name"
                                    @input="form.clearErrors('emergency_contact_name')"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.emergency_contact_name" class="text-red-500 text-sm">{{ form.errors.emergency_contact_name }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Emergency Contact Phone <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="tel"
                                    v-model="form.emergency_contact_phone"
                                    @input="form.clearErrors('emergency_contact_phone')"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <span v-if="form.errors.emergency_contact_phone" class="text-red-500 text-sm">{{ form.errors.emergency_contact_phone }}</span>
                            </div>
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
                                    @input="form.clearErrors('securityDeposit')"
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
                                <span v-if="form.errors.securityDeposit" class="text-red-500 text-sm">{{ form.errors.securityDeposit }}</span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Advance Rent (KSh) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    v-model="form.advanceRent"
                                    @input="form.clearErrors('advanceRent')"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                />
                                <p class="text-xs text-gray-500 mt-1">Typically 1 month's rent</p>
                                <span v-if="form.errors.advanceRent" class="text-red-500 text-sm">{{ form.errors.advanceRent }}</span>
                            </div>

                            <!-- Discount Approval Section -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Apply Discount
                                </label>
                                <div class="flex items-center mt-2 space-x-4">
                                    <label class="inline-flex items-center">
                                        <input
                                            type="radio"
                                            v-model="form.applyDiscount"
                                            :value="true"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                        />
                                        <span class="ml-2 text-sm text-gray-700 dark:text-white">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input
                                            type="radio"
                                            v-model="form.applyDiscount"
                                            :value="false"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                        />
                                        <span class="ml-2 text-sm text-gray-700 dark:text-white">No</span>
                                    </label>
                                </div>
                            </div>

                            <div v-if="form.applyDiscount">
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Discount Type
                                </label>
                                <select
                                    v-model="form.discountType"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                    <option value="percentage">Percentage</option>
                                    <option value="fixed">Fixed Amount</option>
                                </select>
                            </div>

                            <div v-if="form.applyDiscount && form.discountType === 'percentage'">
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Discount Percentage
                                </label>
                                <input
                                    type="number"
                                    v-model="form.discountValue"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="E.g. 10 for 10%"
                                    min="0"
                                    max="100"
                                />
                            </div>

                            <div v-if="form.applyDiscount && form.discountType === 'fixed'">
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Discount Amount (KSh)
                                </label>
                                <input
                                    type="number"
                                    v-model="form.discountValue"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="E.g. 5000"
                                    min="0"
                                />
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-white">
                                    Preferred Payment Method <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.paymentMethod"
                                    @change="form.clearErrors('paymentMethod')"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                                    required
                                >
                                    <option value="bank">Bank Transfer</option>
                                    <option value="mpesa">M-Pesa</option>
                                    <option value="cheque">Cheque</option>
                                    <option value="cash">Cash</option>
                                </select>
                                <span v-if="form.errors.paymentMethod" class="text-red-500 text-sm">{{ form.errors.paymentMethod }}</span>
                            </div>
                        </div>

                        <!-- Payment Summary -->
                        <div class="p-4 bg-gray-50 rounded-lg mt-4">
                            <h3 class="font-medium text-gray-700 mb-2">Payment Summary</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="text-sm text-gray-500">Monthly Rent:</div>
                                <div class="text-right">{{ formatCurrency(form.rentAmount) }}</div>

                                <template v-if="form.applyDiscount">
                                    <div class="text-sm text-gray-500">Discount Applied:</div>
                                    <div class="text-right text-green-600">
                                        <span v-if="form.discountType === 'percentage'">{{ form.discountValue }}%</span>
                                        <span v-else>{{ formatCurrency(form.discountValue) }}</span>
                                    </div>

                                    <div class="text-sm text-gray-500">Discounted Amount:</div>
                                    <div class="text-right">
                                        {{ formatCurrency(calculateDiscountedAmount()) }}
                                    </div>
                                </template>

                                <div class="font-medium">Total Initial Payment:</div>
                                <div class="text-right font-medium text-blue-600">
                                    {{ formatCurrency(calculateTotalPayment()) }}
                                </div>
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
                                    <p class="font-medium">{{ form.id_number }}</p>
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
                                    <p class="font-medium">{{ form.lease_start_date }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Monthly Rent</p>
                                    <p class="font-medium">{{ formatCurrency(form.rentAmount) }}</p>
                                </div>
                                <div v-if="form.applyDiscount">
                                    <p class="text-sm text-gray-500">Discount Applied</p>
                                    <p class="font-medium text-green-600">
                                        <span v-if="form.discountType === 'percentage'">{{ form.discountValue }}%</span>
                                        <span v-else>{{ formatCurrency(form.discountValue) }}</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Emergency Contact</p>
                                    <p class="font-medium">{{ form.emergency_contact_name }} ({{ form.emergency_contact_phone }})</p>
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
                                        {{ formatCurrency(calculateTotalPayment()) }}
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
                            <span v-if="form.errors.terms" class="ml-2 text-red-500 text-sm">{{ form.errors.terms }}</span>
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
