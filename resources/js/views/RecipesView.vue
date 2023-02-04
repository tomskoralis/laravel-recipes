<template>
    <h1 class="page-heading">Recipes</h1>

    <div v-if="state.isLoading === true" class="loader"></div>
    <div v-else-if="state.isError === true">Error</div>

    <div v-else>
        <p>Page {{ page }}</p>
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
            <div class="button-container">
                <button :disabled="page <= 1" @click="handleFirstPage" class="button">
                    First
                </button>

                <button :disabled="page <= 1" @click="handlePrevPage" class="button">
                    Previous
                </button>

                <button :disabled="page >= meta.pageCount" @click="handleNextPage" class="button">
                    Next
                </button>

                <button :disabled="page >= meta.pageCount" @click="handleLastPage" class="button">
                    Last
                </button>
            </div>
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

const handlePrevPage = () => {
    page.value--;
    fetchData(page.value);
    setQueryNewPage();
};

const handleNextPage = () => {
    page.value++;
    fetchData(page.value);
    setQueryNewPage();
};

const handleFirstPage = () => {
    page.value = 1;
    fetchData(page.value);
    setQueryNewPage();
};

const handleLastPage = () => {
    page.value = meta.value.pageCount;
    fetchData(page.value);
    setQueryNewPage();
};

const setQueryNewPage = () => {
    router.push({
        query: {
            page: page.value,
        },
    });
};
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
    color: black;
    text-decoration: none;
    padding: 0.25rem;
    border: 2px solid #ccc;
    border-radius: 1rem;
    display: flex;
    gap: 0.5rem;
    flex-direction: column;
    transition: ease-in-out 0.2s;
    @include for-at-least($breakpoint-md) {
        max-width: 100%;
        flex-direction: row;
        padding: 1rem;
    }
    @include for-at-least($breakpoint-lg) {
        height: 100%;
    }

    &:hover {
        transform: scale(104%);
    }
}

.button-wrapper {
    margin-top: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
}

.button-container {
    gap: 0.25rem;
    display: flex;
    flex-wrap: wrap;
    @include for-at-least($breakpoint-md) {
        display: inline-grid;
        grid-template-columns: repeat(4, 1fr);
    }
}

.button {
    width: 100%;
    @include for-at-least($breakpoint-sm + 4rem) {
        width: 40%;
    }
    @include for-at-least($breakpoint-md) {
        width: 100%;
    }
}
</style>
