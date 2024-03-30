<script setup>

const props = defineProps({
  modelValue: String,
});
defineEmits(["update:modelValue"]);
</script>

<template>
  <select
    v-model="props.modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    class="bg-gray-200 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-lg shadow-sm"
  >
    <slot />
  </select>
</template>