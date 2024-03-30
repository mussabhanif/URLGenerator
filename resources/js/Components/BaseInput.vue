<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    leftIcon: { type: String, default: '' }, // Default left icon
    rightIcon: { type: String, default: '' }, // Default right icon
    iconActions: { type: Array, default: () => [] }, // Default icon actions
    variant: { type: String, default: 'default', validator: v => ['default', 'outline'].includes(v) }, // Default variant
    otherClasses: { type: String },
});

const emit = defineEmits(['update:modelValue', 'rightIconClick', 'leftIconClick']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });


const baseClasses = ' focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-lg shadow-sm w-full h-10 focus:outline-none p-2';
const variantClasses = {
    'default': 'bg-gray-200 border-gray-300',
    'outline': 'border border-gray-300' // Outline variant
};
</script>

<template>
    <div class="relative p-0 border-none">
        <input
            :class="[baseClasses, variantClasses[variant], otherClasses]"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
            v-bind="$attrs"
        />
        <div v-if="leftIcon" class="absolute inset-y-0 left-0 flex items-center pl-3">
            <button @click="emit('leftIconClick')" class="text-gray-400 focus:outline-none" type="button">
                <v-icon :icon="leftIcon" />
            </button>
        </div>
        <div v-if="rightIcon" class="absolute inset-y-0 right-0 flex items-center pr-3">
            <button v-if="rightIcon" @click="emit('rightIconClick')" class="text-gray-400 focus:outline-none" type="button">
                <v-icon :icon="rightIcon" />
            </button>
        </div>
    </div>
</template>
