<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <h2 class="text-2xl font-semibold text-center mb-4">Create an account</h2>
        <div class="text-center text-gray-500">
            Or
                <Link :href="route('login')"  class="text-sm text-purple-700 hover:text-purple-600">
                    login with existing account
                </Link>
            </div>

        <form @submit.prevent="submit"  class="w-[400px] mx-auto p-6 my-5">

            <div>
                <InputLabel for="name" value="Name" />
                <TextInput id="name" type="text" class="border-gray-300 focus:border-purple-500 focus:outline-none focus:ring-purple-500 rounded-md w-full" v-model="form.name" required autofocus autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" class="border-gray-300 focus:border-purple-500 focus:outline-none focus:ring-purple-500 rounded-md w-full" v-model="form.email" required autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" class="mt-1 block w-full focus:ring-indigo-700" v-model="form.password" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput id="password_confirmation" type="password" class="border-gray-300 focus:border-purple-500 focus:outline-none focus:ring-purple-500 rounded-md w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

                <PrimaryButton class="mt-5 btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
        </form>
    </GuestLayout>
</template>
