<script setup>

const props = defineProps(["status"]);
</script>

<template>
  <span
    class="py-1 px-3 rounded-full capitalize w-full whitespace-nowrap"
    :class="
      props?.status == 'active' || props?.status == 'verified'
        ? 'bg-green-50 text-green-600'
        : 'bg-red-50 text-red-600'
    "
    >{{ props?.status }}</span
  >
</template>