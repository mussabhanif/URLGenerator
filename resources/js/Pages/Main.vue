<script setup>
import BaseLabel from '@/Components/BaseLabel.vue';
import BaseInput from '@/Components/BaseInput.vue';
import BaseButton from '@/Components/BaseButton.vue';
import BaseInputError from '@/Components/BaseInputError.vue';
import BaseTable from '@/Components/BaseTable.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {useForm, Head} from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';

const toast = useToast()
const props = defineProps(['generated_urls', 'success', 'err']);
const form = useForm({
    url: '',
});
const submit = () => {
    form.post(route('url.generate'), {
        onSuccess: () => {
            form.reset();
            if(props.success) {
                toast.success(props.success)
            }
            if(props.err) {
                toast.error(props.err)
            }
        },
    })
}
const copyUrl = (url) => {
    try {
        navigator.clipboard.writeText(url)
            .then(() => {
                toast.success('URL copied to clipboard');
            })
            .catch((error) => {
                console.error('Error copying to clipboard:', error);
                fallbackCopyTextToClipboard(url);
            });
    } catch (error) {
        console.error('Error accessing clipboard API:', error);
        fallbackCopyTextToClipboard(url);
    }
};

function fallbackCopyTextToClipboard(text) {
    var textArea = document.createElement("textarea");
    textArea.value = text;

    // Make textarea non-editable to avoid flickering
    textArea.setAttribute('readonly', '');

    // Hide textarea from visual display
    textArea.style.position = 'absolute';
    textArea.style.left = '-9999px';

    document.body.appendChild(textArea);
    textArea.select();

    try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Fallback: Copying text command was ' + msg);
        if (successful) {
            toast.success('URL copied to clipboard');
        } else {
            toast.error('Failed to copy URL to clipboard');
        }
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
    }

    document.body.removeChild(textArea);
}
</script>
<template>
    <Head title="Generate your unique URLs"/>
    <div class="max-w-7xl mx-auto mt-8 p-2">
       <div class="flex items-center w-fit mx-auto">
        <ApplicationLogo class="w-20 my-10"/>
        <v-card-title>
            URL Generator
        </v-card-title>
       </div>
      <form @submit.prevent="submit()" class="flex flex-col items-center w-full">
        <div class="mb-4 w-full">
          <BaseLabel for="url">URL</BaseLabel>
          <BaseInput v-model="form.url" id="url" name="url" type="text" />
          <BaseInputError :message="form.errors.url" class="mt-1" />
        </div>
        <BaseButton type="submit" class="whitespace-nowrap h-10" :is-loading="form.processing">Shorten URL</BaseButton>
      </form>
  
      <div class="mt-8">
        <h2 class="text-lg font-bold mb-4">Generated URLs</h2>
        <BaseTable>
        <thead class="bg-secondary">
        <tr>
            <th>Short URL</th>
            <th>Orignal URL</th>
        </tr>
        </thead>
        <tbody>
            <tr v-for="item in generated_urls" :key="item.id">
            <td>
                <span>{{ item.short_url }}</span>
                <v-btn @click="copyUrl(item.short_url)" color="primary" variant="text" stacked>
                    <v-icon icon="mdi-content-copy"/>
                </v-btn>
            </td>
            <td>
                <span>
                    {{ item.original_url }}
                </span>
                <v-btn @click="copyUrl(item.original_url)" color="primary" variant="text" stacked>
                    <v-icon icon="mdi-content-copy"/>
                </v-btn>
            </td>
            </tr>
        </tbody>
        </BaseTable>
      </div>
    </div>
  </template>
  