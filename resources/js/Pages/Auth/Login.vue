<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <h2 class="text-2xl font-semibold text-center mb-5">
            Login to your account
        </h2>
        <p class="text-center text-gray-500 mb-6">
            or
            <a :href="route('register')" class="text-sm text-emerald-700 hover:text-emerald-600">create new account</a>
        </p>

        <form @submit.prevent="submit" class="w-[400px] mx-auto p-6 my-16">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email"
                    class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full"
                    v-model="form.email" required autofocus autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4 mb-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password"
                    class="border-gray-300 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 rounded-md w-full"
                    v-model="form.password" required autocomplete="current-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="flex justify-between items-center mb-5">
                <div class="flex items-center">
                    <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" />
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>
                    <Link v-if="canResetPassword" :href="route('password.request')"
                        class="underline text-sm text-gray-600 hover:text-emerald-700">
                    Forgot your password?
                    </Link>
            </div>
            <PrimaryButton class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Log in
            </PrimaryButton>
        </form>
    </GuestLayout>
</template>
