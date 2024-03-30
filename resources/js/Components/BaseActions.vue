<script setup>
import { computed } from "vue";

const emit = defineEmits(["onEdit", "onStatus", "onDelete", "onView"]);

const props = defineProps({
  isEdit: Boolean,
  isDelete: Boolean,
  isView: Boolean,
  isStatus: String,
  isVerify: String,
});

const renderStatusIcon = computed(() =>
  props.isStatus === "active" ? "mdi-account-cancel" : "mdi-account-check"
);

const renderStatusColor = computed(() =>
  props.isStatus === "active" ? "pink" : "green"
);
const renderStatusTitle = computed(() =>
  props.isStatus === "active" ? "Block" : "Un Block"
);

const renderVerifyColor = computed(() =>
  props?.isVerify == "verified" ? "red" : "green"
);
const renderVerifyIcon = computed(() =>
  props?.isVerify == "verified" ? "mdi-cancel" : "mdi-check"
);
const renderVerifyTitle = computed(() =>
  props?.isVerify == "verified" ? "Un Verify" : "Verify"
);
</script>

<template>
  <div class="flex justify-end items-center ml-auto">
    <v-btn
      @click="emit('onEdit')"
      dark
      size="x-small"
      class="ml-1"
      v-if="props.isEdit"
      title="Edit"
    >
      <v-icon size="large" color="green">mdi-pencil</v-icon>
    </v-btn>
    <v-btn
      @click="emit('onStatus')"
      dark
      size="x-small"
      class="ml-1"
      v-if="props.isStatus"
      :title="renderStatusTitle"
    >
      <v-icon size="large" :color="renderStatusColor">{{ renderStatusIcon }}</v-icon>
    </v-btn>
    <v-btn
      @click="emit('onDelete')"
      dark
      size="x-small"
      class="ml-1"
      v-if="props.isDelete"
      title="Delete"
    >
      <v-icon size="large" color="red">mdi-delete</v-icon>
    </v-btn>
    <v-btn
      @click="emit('onView')"
      dark
      size="x-small"
      class="ml-1"
      v-if="props.isView"
      title="View Detail"
    >
      <v-icon size="large" color="blue">mdi-eye</v-icon>
    </v-btn>
    <v-btn
      @click="emit('onVerify')"
      dark
      size="x-small"
      class="ml-1"
      v-if="props.isVerify"
      :title="renderVerifyTitle"
    >
      <v-icon size="large" :color="renderVerifyColor">{{ renderVerifyIcon }}</v-icon>
    </v-btn>
  </div>
</template>