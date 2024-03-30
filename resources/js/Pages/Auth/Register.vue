<script setup>
import GuestLayout from '@/Layouts/Guest.vue';
import BaseInputError from '@/Components/BaseInputError.vue';
import BaseLabel from '@/Components/BaseLabel.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseInput from '@/Components/BaseInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

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

        <form @submit.prevent="submit">
            <div>
                <BaseLabel for="name" value="Name" />

                <BaseInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <BaseInputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <BaseLabel for="email" value="Email" />

                <BaseInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <BaseInputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <BaseLabel for="password" value="Password" />

                <BaseInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <BaseInputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <BaseLabel for="password_confirmation" value="Confirm Password" />

                <BaseInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <BaseInputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <BaseButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" :is-loading="form.processing">
                    Register
                </BaseButton>
            </div>
        </form>
    </GuestLayout>
</template>
