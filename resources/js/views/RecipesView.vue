<template>
    <h1 class="page-heading">Recipes</h1>

    <div v-if="state.isLoading === true" class="loader"></div>
    <div v-else-if="state.isError === true">Error</div>

    <div v-else>
        <p>Page {{ page }} of {{ meta.pageCount }}</p>
        <p v-if="meta.to > 0">Displaying recipes {{ meta.from }} - {{ meta.to }}</p>
        <p v-else>No recipes found!</p>
        <ul class="recipe-list">
            <li v-for="recipe in state.recipes" :key="recipe.id" class="card-container">
                <RecipeCard
                    :id="recipe.id"
                    :name="recipe.name"
                    :description="recipe.description"
                    :image="recipe.image"
                />
            </li>
        </ul>
        <div class="button-wrapper">
            <ul class="long-button-row">
                <li v-for="i in meta.pageCount">
                    <button class="page-button" @click="handleNewPage(i)" :class="{'current-page': i === page}"
                            v-if="i === 1 || i === meta.pageCount || i >= page - 2 && i <= page + 2">
                        {{ i }}
                    </button>
                    <button class="page-between" @click.prevent
                            v-if="i !== 1 && i === page - 3 || i === page + 3 && i !== meta.pageCount">
                        ...
                    </button>
                </li>

            </ul>

            <ul class="short-button-row">
                <li>
                    <button :disabled="page <= 1" @click="handleNewPage(page - 1)" class="page-button">
                        &#60;
                    </button>
                </li>
                <li>
                    <div class="current-page">
                        {{ page }}
                    </div>
                </li>
                <li>
                    <button :disabled="page >= meta.pageCount" @click="handleNewPage(page + 1)" class="page-button">
                        &#62;
                    </button>
                </li>
            </ul>

        </div>
    </div>
</template>

<script setup lang="ts">
import {onMounted, reactive, ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import axios from "axios";
import RecipeCard from "../components/RecipeCard.vue";
import type {RecipeShort} from "../types/RecipeShort";

const route = useRoute();
const router = useRouter();

const url = ref("http://127.0.0.1:8000/api/v1/recipes");
const config = {
    headers: {
        "Accept": "application/json",
        "Content-Type": "application/json",
    },
};

const state = reactive({
    recipes: [] as RecipeShort[],
    isLoading: false,
    isError: false,
});

const page = ref(Number(route.query.page) || 1);
const meta = ref({
    pageCount: 0,
    from: 0,
    to: 0,
    totalRecipes: 0,
});

onMounted(() => {
    fetchData(page.value);
});

const fetchData = async (page: number) => {
    try {
        state.isLoading = true;
        const {data} = await axios.get(`${url.value}?page=${page}`, config);
        state.recipes = data.data.map((recipe: RecipeShort) => {
            return {
                id: recipe.id,
                name: recipe.name,
                description: recipe.description,
                image: recipe.image,
            };
        });
        meta.value = {
            pageCount: data.meta.last_page,
            from: data.meta.from,
            to: data.meta.to,
            totalRecipes: data.meta.total,
        };
        setTimeout(async () => {
            state.isLoading = false;
        }, 500);
    } catch (error) {
        state.isLoading = false;
        state.isError = true;
        console.log("error", error);
    }
};

const handleNewPage = (newPage: number) => {
    page.value = newPage;
    fetchData(page.value);
    router.push({
        query: {
            page: page.value,
        },
    });
}
</script>

<style scoped lang="scss">
@import '../../css/app.scss';

.recipe-list {
    margin-top: 1rem;
    display: grid;
    gap: 1rem;
    @include for-at-least($breakpoint-lg) {
        grid-template-columns: repeat(2, 1fr);
    }
}

.card-container .recipe-card {
    color: $secondary-background-color;
    text-decoration: none;
    border: 2px solid $border-color;
    border-radius: 0.3rem;
    display: flex;
    gap: 0.5rem;
    flex-direction: column;
    transition: ease-in-out 0.2s;
    @include for-at-least($breakpoint-md) {
        max-width: 100%;
        flex-direction: row;
    }
    @include for-at-least($breakpoint-lg) {
        height: 100%;
    }

    &:hover {
        transform: scale(104%);
    }
}

.button-wrapper {
    width: fit-content;
    margin: 1rem auto 0;
}

.long-button-row {
    display: none;
    flex-direction: row;
    width: fit-content;
    @include for-at-least($breakpoint-md) {
        display: flex;
    }
}

.short-button-row {
    display: flex;
    margin-bottom: 1rem;
    @extend .long-button-row;
    @include for-at-least($breakpoint-md) {
        display: none;
    }
}

.page-button {
    min-width: 2rem;
    height: 1.9rem;
    margin: 0 0.25rem;
    background-color: $background-color;
    border: 2px solid $border-color;
    border-radius: 0.5rem;
    padding: 0.1rem 0.7rem;
    text-align: center;
    font-size: 0.9rem;
    cursor: pointer;
    touch-action: manipulation;
    white-space: nowrap;

    &:hover {
        border: 2px solid $link-hover-color;
    }

    &:disabled {
        border: none;
        cursor: not-allowed;
    }
}

.page-between {
    @extend .page-button;
    cursor: default;

    &:hover {
        border: 2px solid $border-color;
    }
}

.current-page {
    @extend .page-button;
    border: 2px solid $secondary-background-color;

    &:hover {
        border: 2px solid $secondary-background-color;
    }
}
</style>
