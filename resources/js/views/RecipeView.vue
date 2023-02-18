<template>
    <h1 class="page-heading">{{ state.recipe?.name ?? 'Recipe' }}</h1>

    <div v-if="state.isLoading === true" class="loader"></div>
    <div v-else-if="state.error">{{ state.error }}</div>

    <div v-else>
        <div v-if="state.recipe" class="recipe-container">
            <div>
                <div class="image-wrapper">
                    <img v-if="state.recipe.image"
                         class="recipe-image"
                         :src="state.recipe.image"
                         :alt="`${state.recipe.name} image`"
                    />
                </div>
                <div class="recipe-info">
                    <h4>Description:</h4>
                    <p>{{ state.recipe?.description }}</p>
                    <h4>Instructions:</h4>
                    <p>{{ state.recipe?.instructions }}</p>
                    <h4>Ingredients:</h4>
                    <ol>
                        <li v-for="ingredient in state.recipe?.ingredients" :key="ingredient.id">
                            {{ ingredient.name }}: {{ ingredient.amount }}
                        </li>
                    </ol>
                    <h4>Created at:</h4>
                    <p>{{ state.recipe?.created_at }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="button-container">
        <button type="button" @click="router.back()" class="button">Go back</button>
        <div class="button-container">
            <RouterLink :to="route.fullPath +'/edit'">
                <button v-if="state.recipe" class="button">Edit</button>
            </RouterLink>
            <button v-if="state.recipe" @click="deleteRecipe()" class="danger-button">Delete</button>
        </div>
    </div>
</template>

<script setup lang="ts">
import axios from "axios";
import {onMounted, reactive} from "vue";
import {useRoute, useRouter} from "vue-router";
import type {Recipe} from "../types/Recipe";

const url = "http://127.0.0.1:8000/api/v1/recipes";
const config = {
    headers: {
        "Accept": "application/json",
        "Content-Type": "application/json",
    }
};
const route = useRoute();
const router = useRouter();
const id = route.params.id;

const state = reactive({
    isLoading: false,
    recipe: null as Recipe | null,
    error: "",
});

const fetchSingleRecipe = async () => {
    try {
        state.isLoading = true;
        const {data} = await axios.get(`${url}/${id}`, config);
        state.recipe = {
            id: data.data.id,
            name: data.data.name,
            description: data.data.description,
            instructions: data.data.instructions,
            ingredients: data.data.ingredients,
            image: data.data.image,
            created_at: data.data.created_at,
        };
        setTimeout(async () => {
            state.isLoading = false;
        }, 500);
    } catch (error) {
        state.isLoading = false;
        state.error = String(error);
    }
};

const deleteRecipe = async () => {
    try {
        await axios.delete(`${url}/${id}`, config);
        router.back();
    } catch (error) {
        state.error = String(error);
    }
}

onMounted(() => {
    fetchSingleRecipe();
});
</script>

<style scoped lang="scss">
@import '../../css/app.scss';

.recipe-container {
    width: 100%;
    display: flex;
    flex-direction: column;
    row-gap: 1rem;
    column-gap: 0.5rem;
    text-align: justify;
    line-height: 1.4rem;

    p {
        margin-bottom: 1rem;
    }

    ol {
        margin-bottom: 1rem;
        list-style: decimal inside;
    }

    .image-wrapper {
        justify-self: flex-start;
        padding-bottom: 1rem;
        @include for-at-least($breakpoint-md) {
            width: 50%;
            padding-left: 1rem;
            float: right;
        }

        .recipe-image {
            border-radius: 1rem;
            width: 100%;
            height: auto;
        }
    }
}

.button-container {
    display: flex;
    flex-direction: column-reverse;
    flex-wrap: wrap;
    align-items: start;
    justify-content: flex-end;
    gap: 0.5rem;
    @include for-at-least($breakpoint-sm) {
        flex-direction: row;
        align-items: center;
        justify-content: flex-start;
    }
    @include for-at-least($breakpoint-md) {
        justify-content: space-between;
    }
}
</style>
