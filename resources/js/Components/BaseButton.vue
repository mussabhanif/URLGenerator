<script setup>
import { computed, ref } from "vue";
const variantClasses = {
  primary:
    "bg-primary text-white hover:bg-primarydarken focus:bg-primarydarken active:bg-primarydarken",
  secondary:
    "bg-secondary text-gray-800 hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-200",
  danger: "bg-red-500 text-white hover:bg-red-600 focus:bg-red-600 active:bg-red-600",
  success:
    "bg-green-500 text-white hover:bg-green-600 focus:bg-green-600 active:bg-green-600",
};
const props = defineProps({
  type: {
    type: String,
    default: "submit",
  },
  variant: {
    type: String,
    default: "primary",
    // validator: (v) => Object.keys(variantClasses.value).includes(v),
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  isLoading: {
    type: Boolean,
    default: false,
  },
  title: String,
  iconAttrs: Object,
  leftIcon: String,
  rightIcon: String,
});
const computedClasses = computed(() => {
  return [variantClasses[props.variant]] ?? "primary";
});
</script>
<template>
  <button
    :class="[computedClasses, { 'opacity-60 cursor-not-allowed': disabled }]"
    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none transition ease-in-out duration-150"
    :type="type"
    :style="{ color: variant === 'secondary' ? '' : 'white !important' }"
    :disabled="disabled"
    v-ripple
    @click="$emit('click')"
  >
    <v-icon v-if="leftIcon" v-bind="iconAttrs" :icon="leftIcon" class="mr-2" />
    <span v-if="title">{{ title }}</span>
    <span v-else>
      <slot />
    </span>
    <v-icon v-if="rightIcon" v-bind="iconAttrs" :icon="rightIcon" class="ml-2" />
    <v-progress-circular
      :size="16"
      :width="1"
      indeterminate
      color="white"
      v-if="isLoading"
      class="ml-2"
    ></v-progress-circular>
  </button>
</template>
<style>
.cursor-not-allowed {
  cursor: not-allowed;
}
</style>
