<template>
    <router-link class="recipe-card" :to="`/recipes/${props.id}`">
        <img v-if="props.image"
             class="recipe-image"
             :src="props.image"
             :alt="props.name + ' image'"
        />
        <div class="recipe-info">
            <h2>{{ props.name }}</h2>
            <p v-if="props.description">{{ props.description }}</p>
        </div>
    </router-link>
</template>

<script setup lang="ts">
interface RecipeShort {
    id: number;
    name: string;
    description: string;
    image: string | null;
}

const props = defineProps<RecipeShort>();
</script>

<style scoped lang="scss">
@import '../../css/app.scss';

.recipe-image {
    border-top-left-radius: 0.15rem;
    border-top-right-radius: 0.15rem;
    object-fit: cover;
    max-height: 20rem;
    overflow: hidden;
    @include for-at-least($breakpoint-md) {
        border-top-right-radius: 0;
        border-bottom-left-radius: 0.15rem;
        max-width: 40%;
    }
}

.recipe-info {
    padding: 0.5rem;
    row-gap: 0.2rem;
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
    justify-content: center;

    p {
        max-height: 3em;
        overflow: hidden;
        white-space: normal;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
}
</style>
