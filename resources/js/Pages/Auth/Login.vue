<script setup>
import BaseCheckbox from '@/Components/BaseCheckbox.vue';
import GuestLayout from '@/Layouts/Guest.vue';
import BaseInputError from '@/Components/BaseInputError.vue';
import BaseLabel from '@/Components/BaseLabel.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseInput from '@/Components/BaseInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import {ref} from 'vue'

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
const showPassword = ref(false)
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <BaseLabel for="email" value="Email" />

                <BaseInput
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <BaseInputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <BaseLabel for="password" value="Password" />

                <BaseInput
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    :rightIcon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                    @rightIconClick="showPassword = !showPassword"
                />

                <BaseInputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <BaseCheckbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link>

                <BaseButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </BaseButton>
            </div>
        </form>
    </GuestLayout>
</template>
