<template>
    <div class="input-wrapper">
        <label :for="props.id">{{ props.label }}</label>
        <input :id="props.id" type="text" v-bind="$attrs" :value="inputValue"
               @input="updateValue" :placeholder="props.placeholder"/>
        <p v-if="error" class="error">{{ props.error }}</p>
    </div>
</template>

<script lang="ts">
import {defineComponent} from "vue";

export default defineComponent({
    inheritAttrs: false,
});
</script>

<script lang="ts" setup>

interface Props {
    id: string;
    inputValue: string;
    placeholder?: string;
    label?: string;
    error?: string;
}

interface Emits {
    (e: "update:inputValue", newValue: string): void;
}

const emit = defineEmits<Emits>();

const props = withDefaults(defineProps<Props>(), {
    placeholder: "Input",
});

const updateValue = (e: Event) => {
    emit("update:inputValue", (e.target as HTMLInputElement).value);
};
</script>

<style lang="scss" scoped>

.input-wrapper {
    display: flex;
    flex-direction: column;
    gap: 0.1rem;
    flex-grow: 1;
}

input {
    border: 2px solid #ccc;
    border-radius: 0.5rem;
    padding: 0.25rem 0.5rem;
    &:focus {
        outline: none;
    }
}

.error {
    color: red;
}
</style>
