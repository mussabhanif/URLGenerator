<script setup>
import GuestLayout from '@/Layouts/Guest.vue';
import BaseInputError from '@/Components/BaseInputError.vue';
import BaseLabel from '@/Components/BaseLabel.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseInput from '@/Components/BaseInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

        <form @submit.prevent="submit">
            <div>
                <BaseLabel for="email" value="Email" />

                <BaseInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
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
                <BaseButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Reset Password
                </BaseButton>
            </div>
        </form>
    </GuestLayout>
</template>
