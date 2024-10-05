<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login.post'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

        <div class="login-container">
            <Head title="Login" />
            <div class="svg-section hidden lg:block">
                <img src="@img/login.jpg" alt="Rentals Image" class="w-full h-full object-cover opacity-70" />
            </div>


            <div class="form-section">
                <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="login-form" style="max-width: 400px; margin: 0 auto; text-align: center;">
                    <div style="font-size: 24px; font-weight: bold; margin-bottom: 20px;">LOGIN</div>

                    <div>
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="password" value="Password" />
                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="mt-4 block">
                        <label class="flex items-center justify-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ms-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <div class="mt-4 flex items-center justify-center">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Forgot your password?
                        </Link>
                    </div>

                    <div class="mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Log in
                        </PrimaryButton>
                    </div>

                    <div style="margin-top: 30px; display: flex; justify-content: center;">
                        <a href="#" aria-label="Login with Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-facebook" width="30" height="30" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 108 8c0-4.418-3.582-8-8-8zM6.73 12.308v-4.16H5V6.982h1.731v-1.02c0-1.4.919-2.172 2.142-2.172.601 0 1.117.045 1.266.065v1.467h-.87c-.684 0-.87.388-.87.865v.79h1.738L10.5 8.149H9.369v4.159H6.731z"/>
                            </svg>
                        </a>
                        <a href="#" aria-label="Login with Twitter" style="margin-left: 20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-twitter" width="30" height="30" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.335 0-.14 0-.28-.006-.42A6.695 6.695 0 0016 3.542a6.575 6.575 0 01-1.889.518A3.301 3.301 0 0015.555 2.6a6.574 6.574 0 01-2.085.797 3.286 3.286 0 00-2.397-1.034c-1.825 0-3.304 1.476-3.304 3.292 0 .26.03.513.085.756A9.325 9.325 0 011.114 2.207a3.285 3.285 0 001.019 4.384 3.323 3.323 0 01-1.487-.41v.042a3.287 3.287 0 002.637 3.217 3.203 3.203 0 01-.864.114c-.213 0-.42-.021-.62-.061a3.285 3.285 0 003.065 2.274 6.588 6.588 0 01-4.862 1.36 9.29 9.29 0 005.034 1.475"/>
                            </svg>
                        </a>
                    </div>
                </form>

            </div>
        </div>
</template>

<style scoped>
/* Container for SVG and Login form */
.login-container {
    display: flex;
    flex-direction: row;
    background-color: #1051d5;
    min-height: 100vh;
}

/* SVG section on the right (hidden on mobile) */
.svg-section {
    width: 50%;
    background-color: #f3f4f6;
}

/* Login form section on the left */
.form-section {
    width: 50%;
    border-radius: 20px 0 0 20px;
    background-color: rgb(128, 128, 207);
    padding: 2rem;
    margin: auto;
    height: 99vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* On mobile (small screens), show only the form section */
@media (max-width: 1024px) {
    .login-container {
        flex-direction: column;
    }

    .svg-section {
        display: none; /* Hide SVG section */
    }

    .form-section {
        width: 100%; /* Full width for form on mobile */
        padding: 1.5rem;
    }
}

/* Login form styles */
.login-form {
    width: 100%;
    max-width: 400px; /* Max width for the form */
}
</style>
